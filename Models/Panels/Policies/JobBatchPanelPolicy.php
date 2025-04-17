<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Policies;

use Modules\Cms\Contracts\PanelContract;
use Modules\Cms\Models\Panels\Policies\XotBasePanelPolicy;
use Modules\Xot\Contracts\UserContract;

class JobBatchPanelPolicy extends XotBasePanelPolicy {
    /**
     * Undocumented function.
     */
    public function pruneBatches(?UserContract $user, PanelContract $panel): bool {
        return true;
    }
}
