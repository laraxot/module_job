<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Illuminate\Support\Facades\Artisan;
use Modules\Job\Events\Executed;
use Modules\Job\Models\Task;
use Spatie\QueueableAction\QueueableAction;

class ExecuteTaskAction
{
    use QueueableAction;

    public function execute(string $task_id): string
    {
        $task = Task::findOrFail($task_id);
        $start = microtime(true);
        try {
            Artisan::call($task->command, $task->compileParameters());
            $output = Artisan::output();
        } catch (\Exception $e) {
            $output = $e->getMessage();
        }
        Executed::dispatch($task, $start, $output);

        return $output;
    }
}
