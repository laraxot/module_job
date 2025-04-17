<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Policies;

use Modules\Cms\Contracts\PanelContract;
use Modules\Cms\Models\Panels\Policies\XotBasePanelPolicy;
use Modules\Xot\Contracts\UserContract;

class FailedJobPanelPolicy extends XotBasePanelPolicy {
    public function artisanContainer(?UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function showFailedJob(?UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function retryFailedJob(?UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function retryAllFailedJob(?UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function deleteFailedJobs(?UserContract $user, PanelContract $panel): bool {
        return true;
    }
}
