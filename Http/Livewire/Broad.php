<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;
use Modules\Cms\Actions\GetViewAction;
use Modules\Job\Events\PublicEvent;

class Broad extends Component {
    /**
     * @var array<string, string>
     */
    protected $listeners = ['echo:public,PublicEvent' => 'notifyEvent'];

    public function render(): Renderable {
        $view = app(GetViewAction::class)->execute();

        return view($view);
    }

    public function try(): void {
        session()->flash('message', 'try ['.now().']');
        // OrderShipped::dispatch();
        // event(new PublicEvent('test'));
        PublicEvent::dispatch();
    }

    public function notifyEvent(): void {
        session()->flash('message', 'notifyEvent ['.now().']');
        dd('fine');
        // $this->showNewOrderNotification = true;
    }
}
