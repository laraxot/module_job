<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire\Schedule;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

/**
 * Class Schedule\Status.
 */
class Status extends Component {
    public array $form_data = [];
    public string $out = '';
    public string $old_value = '';

    public function mount() {
    }

    public function render(): Renderable {
        $view = 'job::livewire.schedule.status';

        $acts = [
            (object) [
                'name' => 'schedule:clear-cache',
                'label' => 'Delete the cached mutex files created by scheduler',
            ],
            (object) [
                'name' => 'schedule:list',
                'label' => 'List the scheduled commands',
            ],
            (object) [
                'name' => 'schedule:run',
                'label' => 'Run the scheduled commands',
            ],
            (object) [
                'name' => 'schedule:test',
                'label' => 'Run a scheduled command',
            ],
            (object) [
                'name' => 'schedule:work',
                'label' => 'Start the schedule worker',
            ],
            (object) [
                'name' => 'schedule-monitor:sync',
                'label' => 'schedule-monitor:sync',
            ],
            (object) [
                'name' => 'schedule-monitor:list',
                'label' => 'schedule-monitor:list',
            ],
        ];

        $view_params = [
            'view' => $view,
            'acts' => $acts,
        ];

        return view()->make($view, $view_params);
    }

    public function artisan(string $cmd) {
        $this->out .= '<hr/>';
        Artisan::call($cmd);
        $this->out .= Artisan::output();
        $this->out .= '<hr/>';
    }
}
