<?php

declare(strict_types=1);

namespace Modules\Job\Console\Commands;

use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;

class ListSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:schedule-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all scheduled tasks';

    /**
     * @var Schedule
     */
    private $schedule;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        parent::__construct();

        $this->schedule = $schedule;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (count($this->schedule->events()) > 0) {
            $events = collect($this->schedule->events())->map(
                function ($event) {
                    $command = ltrim(strval(strtok(Str::after(strval($event->command), "'artisan'"), ' ')));

                    return [
                        'description' => $event->description ?: 'N/A',
                        'command' => $command,
                        'schedule' => $event->expression,
                        'upcoming' => $this->upcoming($event),
                        'timezone' => $event->timezone ?: config('app.timezone'),
                        'overlaps' => $event->withoutOverlapping ? 'No' : 'Yes',
                        'maintenance' => $event->evenInMaintenanceMode ? 'Yes' : 'No',
                        'one_server' => $event->onOneServer ? 'Yes' : 'No',
                        'in_background' => $event->runInBackground ? 'Yes' : 'No',
                    ];
                });

            $this->table(
                ['Description', 'Command', 'Schedule', 'Upcoming', 'Timezone', 'Overlaps?', 'In Maintenance?', 'One Server?', 'In Background?'],
                $events
            );
        } else {
            $this->info('No Scheduled Commands Found');
        }
    }

    /**
     * Get Upcoming schedule.
     */
    protected function upcoming(Event $event): string
    {
        $date = Carbon::now();

        if ($event->timezone) {
            $date->setTimezone($event->timezone);
        }

        return CronExpression::factory($event->expression)->getNextRunDate($date->toDateTimeString())->format('Y-m-d H:i:s');
    }
}
