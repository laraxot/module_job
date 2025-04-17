<?php

declare(strict_types=1);
/**
 * @see https://gist.github.com/ivanvermeyen/b72061c5d70c61e86875
 * @see https://gist.github.com/BenCavens/810758e74718a981c4cd2d2cf532407e
 */

namespace Modules\Job\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use function Safe\exec;

class WorkerCheck extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'worker:check';

    protected string $filename = 'queue.pid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure that the queue listener is running.';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() {
        if (! $this->isQueueListenerRunning()) {
            $pid = $this->startQueueListener();
            $this->comment('Queue listener is being started. pid['.$pid.']');
            $this->saveQueueListenerPID($pid);
        }

        $this->comment('Queue listener is running.');
    }

    /**
     * Check if the queue listener is running.
     */
    private function isQueueListenerRunning(): bool {
        if (! $pid = $this->getLastQueueListenerPID()) {
            return false;
        }
        $process_cmd = "ps -p $pid -opid=,cmd=";
        $this->comment($process_cmd);
        $output = null;
        $process = exec($process_cmd, $output);
        // $processIsQueueListener = str_contains($process, 'queue:listen'); // 5.1
        if (false == $process) {
            // DISABILITATO PER SBLOCCARE MODULE JOB
            // throw new Exception('['.__LINE__.']['.__FILE__.']');
        }
        if (\is_string($process)) {
            $this->comment($process);

            // $processIsQueueListener = ! empty($process); // 5.6 - see comments
            $processIsQueueListener = str_contains($process, substr(base_path(), 0, 30)); // ..

            return $processIsQueueListener;
        }

        return false;
    }

    /**
     * Get any existing queue listener PID.
     *
     * @return string|bool|null
     */
    private function getLastQueueListenerPID() {
        if (! Storage::disk('cache')->exists($this->filename)) {
            return false;
        }
        $pid = Storage::disk('cache')->get($this->filename);

        return $pid;
    }

    /**
     * Save the queue listener PID to a file.
     *
     * @param string $pid
     *
     * @return void
     */
    private function saveQueueListenerPID($pid) {
        Storage::disk('cache')->put($this->filename, $pid);
        $path = Storage::disk('cache')->path($this->filename);
        $size = Storage::disk('cache')->size($this->filename);
        $this->comment('saved on ['.$path.'] size ['.$size.']');
    }

    /*
     * Start the queue listener.
     *
     * @return string
     * Method Modules\Job\Console\Commands\WorkerCheck::restartQueue() is unused

    private function restartQueue() {
        // $command = 'php-cli ' . base_path() . '/artisan queue:listen --timeout=60 --sleep=5 --tries=3 > /dev/null & echo $!'; // 5.1
        // $command = 'php-cli '.base_path().'/artisan queue:work --timeout=60 --sleep=5 --tries=3 > /dev/null & echo //$!'; // 5.6 - see comments

        $command = ' /usr/local/bin/php '.base_path().'/artisan queue:restart --timeout=60 --sleep=5 --tries=3 > /dev/null & echo $!';
        // $this->comment($command);

        $pid = exec($command);
        $this->comment($pid);

        return (string) $pid;
    }
    */
    /**
     * Start the queue listener.
     *
     * @return string
     */
    private function startQueueListener() {
        // $command = 'php-cli ' . base_path() . '/artisan queue:listen --timeout=60 --sleep=5 --tries=3 > /dev/null & echo $!'; // 5.1
        // $command = 'php-cli '.base_path().'/artisan queue:work --timeout=60 --sleep=5 --tries=3 > /dev/null & echo //$!'; // 5.6 - see comments

        $command = ' /usr/local/bin/php '.base_path().'/artisan queue:work --timeout=60 --sleep=5 --tries=3 > /dev/null & echo $!';
        // $this->comment($command);

        // dd($command);

        $pid = exec($command);
        if (false == $pid) {
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }
        $this->comment($pid);

        return (string) $pid;
    }
}
