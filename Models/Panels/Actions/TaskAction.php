<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Modules\Job\Actions\DummyAction;
use Modules\Cms\Actions\GetViewAction;
use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;

/**
 * Class TryJobAction.
 */
class TaskAction extends XotBasePanelAction {
    public bool $onContainer = true; // onlyContainer

    public string $icon = '<i class="fas fa-eye"></i>Try';

    /**
     * ArtisanAction constructor.
     */
    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function handle() {
        /**
         * @phpstan-var view-string
         */
        $view=app(GetViewAction::class)->execute();
        $view_params=[

        ];
        return view($view,$view_params);
    }

    // end handle
}