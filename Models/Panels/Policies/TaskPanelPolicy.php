<?php

namespace Modules\Job\Models\Panels\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Cms\Contracts\PanelContract;
use Modules\User\Models\User as User;
use Modules\Job\Models\Panels\Policies\TaskPanelPolicy as Post;

use Modules\Cms\Models\Panels\Policies\XotBasePanelPolicy;
use Modules\Xot\Contracts\UserContract;

class TaskPanelPolicy extends XotBasePanelPolicy
{

    public function executeTaskPanel(UserContract $user, PanelContract $panel): bool
    {
        return true;
    }
}
