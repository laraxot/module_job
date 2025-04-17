<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\Xot\Services\ArtisanService;

/**
 * Class ShowFailedJobAction.
 */
class DeleteFailedJobsAction extends XotBasePanelAction {
    public bool $onContainer = true;

    public string $icon = '<i class="fas fa-dumpster-fire"></i>';

    /**
     * ArtisanAction constructor.
     */
    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function handle() {
        $cmd = 'queue:flush';
        $out = ArtisanService::act($cmd);

        return $out; // .'<h3>+Done</h3>';
    }

    // end handle
}
