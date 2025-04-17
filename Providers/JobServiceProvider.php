<?php

declare(strict_types=1);

namespace Modules\Job\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schema;
use Modules\Job\Events\Executed;
use Modules\Job\Events\Executing;
use Modules\Job\Models\Task;
use Modules\Xot\Providers\XotBaseServiceProvider;

class JobServiceProvider extends XotBaseServiceProvider {
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $module_name = 'job';

    public function bootCallback(): void {
        $this->registerCommands();
        /*
        $this->app->resolving(Schedule::class, function ($schedule) {
            dddx($schedule);
            //
        });
        */
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            try {
                $this->registerSchedule($schedule);
            } catch (\Illuminate\Database\QueryException $e) {
                echo $e->getMessage();
            }
        });
    }

    public function registerCommands(): void {
        $this->commands(
            [
                \Modules\Job\Console\Commands\WorkerCheck::class,
                \Modules\Job\Console\Commands\ListSchedule::class,
                \Modules\Job\Console\Commands\TestCommand::class,
            ]
        );
    }

    public function registerSchedule(Schedule $schedule): void {
        if (Schema::hasTable('tasks')) {
            $tasks = app(Task::class)
                ->query()
                ->with('frequencies')
                ->where('is_active', true)
                ->get();

            $tasks->each(
                function ($task) use ($schedule) {
                    if (! $task instanceof Task) {
                        throw new \Exception('['.__LINE__.']['.__FILE__.']');
                    }
                    /*
                     * var \Illuminate\Console\Scheduling\Event
                     */
                    $event = $schedule->command($task->command, $task->compileParameters(true));
                    // --- funziona solo con daily per ora
                    $event->{$task->expression}()
                        ->name($task->description)
                        ->timezone($task->timezone)
                        ->before(function () use ($event, $task) {
                            //Access to an undefined property Illuminate\Console\Scheduling\Event::$start.
                            $event->start = microtime(true);
                            Executing::dispatch($task);
                        })
                        ->thenWithOutput(function ($output) use ($event, $task) {
                            Executed::dispatch($task, $event->start ?? microtime(true), $output);
                        });
                    if ($task->dont_overlap) {
                        $event->withoutOverlapping();
                    }
                    if ($task->run_in_maintenance) {
                        $event->evenInMaintenanceMode();
                    }
                    if ($task->run_on_one_server && in_array(config('cache.default'), ['memcached', 'redis', 'database', 'dynamodb'])) {
                        $event->onOneServer();
                    }
                    if ($task->run_in_background) {
                        $event->runInBackground();
                    }
                });
        }
    }
}
