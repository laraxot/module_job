<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Illuminate\Support\Facades\Artisan;
use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\UI\Services\ThemeService;

/**
 * Class ShowFailedJobAction.
 */
class ScheduleManagerAction extends XotBasePanelAction {
    public bool $onContainer = true; // onlyContainer

    public bool $onItem = false; // onlyItem

    public string $icon = '<i class="fas fa-eye"></i>';

    /**
     * ArtisanAction constructor.
     */
    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function handle() {
        $out = '';
        $cmd = 'schedule:list';
        Artisan::call($cmd);
        $out .= Artisan::output();

        /**
         * @phpstan-var view-string
         */
        //$view = ThemeService::getView();
$view = $this->panel->getView();
        $view_params = ['view' => $view, 'out' => $out];

        return view($view, $view_params);
    }

    // end handle
}
