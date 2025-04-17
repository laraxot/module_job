<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\Job\Actions\DummyAction;

/**
 * Class TryJobAction.
 */
class TryJobAction extends XotBasePanelAction {
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
        for ($i = 0; $i < 1000; ++$i) {
            app(DummyAction::class)
                ->onQueue()
                ->execute();
        }
        echo '<h3>added 1000 jobs </h3>';
    }

    // end handle
}
