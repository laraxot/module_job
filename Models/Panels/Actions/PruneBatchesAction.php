<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Illuminate\Support\Facades\Artisan;
use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\Job\Models\JobBatch as JobBatchModel;
use Modules\Xot\Services\ArtisanService;

/**
 * Class PruneBatchesAction.
 */
class PruneBatchesAction extends XotBasePanelAction {
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
        $out = '';
        $cmd = 'queue:prune-batches';
        // $out = ArtisanService::act($cmd);
        Artisan::call($cmd);
        $out .= Artisan::output();

        $res = JobBatchModel::whereRaw('1=1')->delete();

        return $out.'<h3>+Done</h3>';
    }

    // end handle
}
