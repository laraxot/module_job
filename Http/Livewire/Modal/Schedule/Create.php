<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire\Modal\Schedule;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Cms\Actions\GetViewAction;
use Modules\Job\Actions\GetTaskCommandsAction;
use Modules\Job\Actions\GetTaskFrequenciesAction;
use Modules\Job\Models\Task;
use Modules\Wire\View\Components\Modal\Modal;
use Symfony\Component\Console\Command\Command;

class Create extends Modal
{
    public array $form_data = [];

    public function mount(Request $request): void
    {
        $this->form_data['type'] = '';
        $this->form_data['timezone'] = config('app.timezone');
        $this->form_data = array_merge($this->form_data, $request->all());
    }

    public function render(): Renderable
    {
        $view = app(GetViewAction::class)->execute();
        $commands = app(GetTaskCommandsAction::class)->execute();
        $command_opts = $commands->map(
            function ($item) {
                if (! $item instanceof Command) {
                    throw new \Exception('['.__LINE__.']['.__FILE__.']');
                }

                return [
                    'id' => $item->getName(),
                    'label' => $item->getName(),
                ];
            }
        )->pluck('label', 'id')
        ->all();
        $frequencies = app(GetTaskFrequenciesAction::class)->execute();
        $frequency_opts = collect($frequencies)->pluck('interval', 'interval')->all();

        $view_params = [
            'view' => $view,
            'task' => new Task(),
            'commands' => $commands,
            'command_opts' => $command_opts,
            'timezones' => timezone_identifiers_list(),
            'frequencies' => $frequencies,
            'frequency_opts' => $frequency_opts,
        ];

        return view($view, $view_params);
    }

    public static function behavior(): array
    {
        return [
            // Close the modal if the escape key is pressed
            'close-on-escape' => false,
            // Close the modal if someone clicks outside the modal
            'close-on-backdrop-click' => false,
            // Trap the users focus inside the modal (e.g. input autofocus and going back and forth between input fields)
            'trap-focus' => true,
            // Remove all unsaved changes once someone closes the modal
            'remove-state-on-close' => false,
        ];
    }

    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
            'size' => 'xl',
        ];
    }

    public function save(): void
    {
        Task::create($this->form_data);
        session()->flash('message', 'Task successfully created. at '.now());
    }
}
