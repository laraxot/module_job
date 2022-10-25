<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire\Job;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\Job\Actions\DummyAction;
use Modules\Job\Models\FailedJob as FailedJobModel;
use Modules\Job\Models\Job as JobModel;
use Modules\Job\Models\JobBatch as JobBatchModel;

// use Illuminate\Support\Carbon;

/**
 * Class RolePermission.
 */
class Status extends Component {
    public array $form_data = [];
    public string $out = '';
    public string $old_value = '';

    public function mount() {
        Artisan::call('queue:monitor', ['queues' => 'default,queue01,emails']);
        $this->out .= Artisan::output();
        Artisan::call('worker:check');
        $this->out .= Artisan::output();

        $this->out .= '<br/>['.JobModel::count().'] Jobs';
        $this->out .= '<br/>['.FailedJobModel::count().'] Failed Jobs';
        $this->out .= '<br/>['.JobBatchModel::count().'] Job Batch';

        $this->old_value = getenv('QUEUE_CONNECTION');
        $this->form_data['conn'] = getenv('QUEUE_CONNECTION');

        // $env_file=base_path('.env');
        // dddx(getenv(base_path('')));
        // $env_file = getenv('LARAVEL_DIR').'/.env';
        // dddx();
    }

    public function render(): Renderable {
        $view = 'job::livewire.job.status';

        $acts = [
            /*
            (object) [
                'name' => 'batches-table',
                'label' => 'Create a migration for the batches database table',
            ],
            (object) [
                'name' => 'failed-table',
                'label' => ' Create a migration for the failed queue jobs database table',
            ],
            (object) [
                'name' => 'table',
                'label' => 'Create a migration for the queue jobs database table',
            ],
            */
            (object) [
                'name' => 'clear',
                'label' => 'Delete all of the jobs from the specified queue',
            ],
            (object) [
                'name' => 'failed',
                'label' => 'List all of the failed queue jobs',
            ],

            (object) [
                'name' => 'flush',
                'label' => 'Flush all of the failed queue jobs',
            ],
            /* -- VUOLE ID
            (object) [
                'name' => 'forget',
                'label' => 'Delete a failed queue job',
            ],
            */
            /* --- RIMANE APPESO
            (object) [
                'name' => 'listen',
                'label' => 'Listen to a given queue',
            ],
            */
            /*manca parametro
            (object) [
                'name' => 'monitor',
                'label' => 'Monitor the size of the specified queues',
            ],
            */
            (object) [
                'name' => 'prune-batches',
                'label' => 'Prune stale entries from the batches database',
            ],
            (object) [
                'name' => 'prune-failed',
                'label' => ' Prune stale entries from the failed jobs table',
            ],
            (object) [
                'name' => 'restart',
                'label' => 'Restart queue worker daemons after their current job',
            ],
            (object) [
                'name' => 'retry',
                'label' => 'Retry a failed queue job',
            ],
            /*-- vuole parametro
            (object) [
                'name' => 'retry-batch',
                'label' => 'Retry the failed jobs for a batch',
            ],
            */
            /*-- rimane appeso
            (object) [
                'name' => 'work',
                'label' => 'Start processing jobs on the queue as a daemon',
            ],
            */
        ];

        $view_params = [
            'view' => $view,
            'acts' => $acts,
        ];

        return view()->make($view, $view_params);
    }

    public function updatedFormData(string $value, string $key) {
        // dddx([$value,$key,$this->form_data]);
        if ('conn' === $key) {
            // putenv ("QUEUE_CONNECTION=".$value);
            $this->saveEnv();
        }
    }

    public function saveEnv() {
        $env_file = base_path('.env');
        $env_content = File::get($env_file);
        $new_content = Str::replace(
            'QUEUE_CONNECTION='.$this->old_value,
            'QUEUE_CONNECTION='.$this->form_data['conn'],
            $env_content
        );
        putenv('QUEUE_CONNECTION='.$this->form_data['conn']);
        File::put($env_file, $new_content);
        $this->old_value = $this->form_data['conn'];
    }

    public function artisan(string $cmd) {
        $this->out .= '<hr/>';
        Artisan::call('queue:'.$cmd);
        $this->out .= Artisan::output();
        $this->out .= '<hr/>';
    }

    public function dummyAction() {
        for ($i = 0; $i < 1000; ++$i) {
            app(DummyAction::class)
                ->onQueue()
                ->execute();
        }
        session()->flash('message', '1000 dummy Action');
    }
}
=======
=======
>>>>>>> 7563b33 (rebase)
=======
>>>>>>> 1f3605a (rebase)
<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire\Job;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\Job\Actions\DummyAction;
use Modules\Job\Models\FailedJob as FailedJobModel;
use Modules\Job\Models\Job as JobModel;
use Modules\Job\Models\JobBatch as JobBatchModel;

// use Illuminate\Support\Carbon;

/**
 * Class RolePermission.
 */
class Status extends Component {
    public array $form_data = [];
    public string $out = '';
    public string $old_value = '';

    public function mount() {
        Artisan::call('queue:monitor', ['queues' => 'default,queue01,emails']);
        $this->out .= Artisan::output();
        Artisan::call('worker:check');
        $this->out .= Artisan::output();

        $this->out .= '<br/>['.JobModel::count().'] Jobs';
        $this->out .= '<br/>['.FailedJobModel::count().'] Failed Jobs';
        $this->out .= '<br/>['.JobBatchModel::count().'] Job Batch';

        $this->old_value = getenv('QUEUE_CONNECTION');
        $this->form_data['conn'] = getenv('QUEUE_CONNECTION');

        // $env_file=base_path('.env');
        // dddx(getenv(base_path('')));
        // $env_file = getenv('LARAVEL_DIR').'/.env';
        // dddx();
    }

    public function render(): Renderable {
        $view = 'job::livewire.job.status';

        $acts = [
            /*
            (object) [
                'name' => 'batches-table',
                'label' => 'Create a migration for the batches database table',
            ],
            (object) [
                'name' => 'failed-table',
                'label' => ' Create a migration for the failed queue jobs database table',
            ],
            (object) [
                'name' => 'table',
                'label' => 'Create a migration for the queue jobs database table',
            ],
            */
            (object) [
                'name' => 'clear',
                'label' => 'Delete all of the jobs from the specified queue',
            ],
            (object) [
                'name' => 'failed',
                'label' => 'List all of the failed queue jobs',
            ],

            (object) [
                'name' => 'flush',
                'label' => 'Flush all of the failed queue jobs',
            ],
            /* -- VUOLE ID
            (object) [
                'name' => 'forget',
                'label' => 'Delete a failed queue job',
            ],
            */
            /* --- RIMANE APPESO
            (object) [
                'name' => 'listen',
                'label' => 'Listen to a given queue',
            ],
            */
            /*manca parametro
            (object) [
                'name' => 'monitor',
                'label' => 'Monitor the size of the specified queues',
            ],
            */
            (object) [
                'name' => 'prune-batches',
                'label' => 'Prune stale entries from the batches database',
            ],
            (object) [
                'name' => 'prune-failed',
                'label' => ' Prune stale entries from the failed jobs table',
            ],
            (object) [
                'name' => 'restart',
                'label' => 'Restart queue worker daemons after their current job',
            ],
            (object) [
                'name' => 'retry',
                'label' => 'Retry a failed queue job',
            ],
            /*-- vuole parametro
            (object) [
                'name' => 'retry-batch',
                'label' => 'Retry the failed jobs for a batch',
            ],
            */
            /*-- rimane appeso
            (object) [
                'name' => 'work',
                'label' => 'Start processing jobs on the queue as a daemon',
            ],
            */
        ];

        $view_params = [
            'view' => $view,
            'acts' => $acts,
        ];

        return view()->make($view, $view_params);
    }

    public function updatedFormData(string $value, string $key) {
        // dddx([$value,$key,$this->form_data]);
        if ('conn' == $key) {
            // putenv ("QUEUE_CONNECTION=".$value);
            $this->saveEnv();
        }
    }

    public function saveEnv() {
        $env_file = base_path('.env');
        $env_content = File::get($env_file);
        $new_content = Str::replace(
            'QUEUE_CONNECTION='.$this->old_value,
            'QUEUE_CONNECTION='.$this->form_data['conn'],
            $env_content
        );
        putenv('QUEUE_CONNECTION='.$this->form_data['conn']);
        File::put($env_file, $new_content);
        $this->old_value = $this->form_data['conn'];
    }

    public function artisan(string $cmd) {
        $this->out .= '<hr/>';
        Artisan::call('queue:'.$cmd);
        $this->out .= Artisan::output();
        $this->out .= '<hr/>';
    }

    public function dummyAction() {
        for ($i = 0; $i < 1000; ++$i) {
            app(DummyAction::class)
                ->onQueue()
                ->execute();
        }
        session()->flash('message', '1000 dummy Action');
    }
}
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 26a6287 (rebase)
=======
>>>>>>> 7563b33 (rebase)
=======
<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire\Job;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\Job\Actions\DummyAction;
use Modules\Job\Models\FailedJob as FailedJobModel;
use Modules\Job\Models\Job as JobModel;
use Modules\Job\Models\JobBatch as JobBatchModel;

// use Illuminate\Support\Carbon;

/**
 * Class RolePermission.
 */
class Status extends Component {
    public array $form_data = [];
    public string $out = '';
    public string $old_value = '';

    public function mount() {
        Artisan::call('queue:monitor', ['queues' => 'default,queue01,emails']);
        $this->out .= Artisan::output();
        Artisan::call('worker:check');
        $this->out .= Artisan::output();

        $this->out .= '<br/>['.JobModel::count().'] Jobs';
        $this->out .= '<br/>['.FailedJobModel::count().'] Failed Jobs';
        $this->out .= '<br/>['.JobBatchModel::count().'] Job Batch';

        $this->old_value = getenv('QUEUE_CONNECTION');
        $this->form_data['conn'] = getenv('QUEUE_CONNECTION');

        // $env_file=base_path('.env');
        // dddx(getenv(base_path('')));
        // $env_file = getenv('LARAVEL_DIR').'/.env';
        // dddx();
    }

    public function render(): Renderable {
        $view = 'job::livewire.job.status';

        $acts = [
            /*
            (object) [
                'name' => 'batches-table',
                'label' => 'Create a migration for the batches database table',
            ],
            (object) [
                'name' => 'failed-table',
                'label' => ' Create a migration for the failed queue jobs database table',
            ],
            (object) [
                'name' => 'table',
                'label' => 'Create a migration for the queue jobs database table',
            ],
            */
            (object) [
                'name' => 'clear',
                'label' => 'Delete all of the jobs from the specified queue',
            ],
            (object) [
                'name' => 'failed',
                'label' => 'List all of the failed queue jobs',
            ],

            (object) [
                'name' => 'flush',
                'label' => 'Flush all of the failed queue jobs',
            ],
            /* -- VUOLE ID
            (object) [
                'name' => 'forget',
                'label' => 'Delete a failed queue job',
            ],
            */
            /* --- RIMANE APPESO
            (object) [
                'name' => 'listen',
                'label' => 'Listen to a given queue',
            ],
            */
            /*manca parametro
            (object) [
                'name' => 'monitor',
                'label' => 'Monitor the size of the specified queues',
            ],
            */
            (object) [
                'name' => 'prune-batches',
                'label' => 'Prune stale entries from the batches database',
            ],
            (object) [
                'name' => 'prune-failed',
                'label' => ' Prune stale entries from the failed jobs table',
            ],
            (object) [
                'name' => 'restart',
                'label' => 'Restart queue worker daemons after their current job',
            ],
            (object) [
                'name' => 'retry',
                'label' => 'Retry a failed queue job',
            ],
            /*-- vuole parametro
            (object) [
                'name' => 'retry-batch',
                'label' => 'Retry the failed jobs for a batch',
            ],
            */
            /*-- rimane appeso
            (object) [
                'name' => 'work',
                'label' => 'Start processing jobs on the queue as a daemon',
            ],
            */
        ];

        $view_params = [
            'view' => $view,
            'acts' => $acts,
        ];

        return view()->make($view, $view_params);
    }

    public function updatedFormData(string $value, string $key) {
        // dddx([$value,$key,$this->form_data]);
        if ('conn' == $key) {
            // putenv ("QUEUE_CONNECTION=".$value);
            $this->saveEnv();
        }
    }

    public function saveEnv() {
        $env_file = base_path('.env');
        $env_content = File::get($env_file);
        $new_content = Str::replace(
            'QUEUE_CONNECTION='.$this->old_value,
            'QUEUE_CONNECTION='.$this->form_data['conn'],
            $env_content
        );
        putenv('QUEUE_CONNECTION='.$this->form_data['conn']);
        File::put($env_file, $new_content);
        $this->old_value = $this->form_data['conn'];
    }

    public function artisan(string $cmd) {
        $this->out .= '<hr/>';
        Artisan::call('queue:'.$cmd);
        $this->out .= Artisan::output();
        $this->out .= '<hr/>';
    }

    public function dummyAction() {
        for ($i = 0; $i < 1000; ++$i) {
            app(DummyAction::class)
                ->onQueue()
                ->execute();
        }
        session()->flash('message', '1000 dummy Action');
    }
}
>>>>>>> 1f3dc29 (rebase)
=======
>>>>>>> 1f3605a (rebase)
