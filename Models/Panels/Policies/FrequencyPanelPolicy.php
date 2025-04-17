<?php
namespace Modules\Job\Models\Panels\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User as User;
use Modules\Job\Models\Panels\Policies\FrequencyPanelPolicy as Post; 

use Modules\Cms\Models\Panels\Policies\XotBasePanelPolicy;

class FrequencyPanelPolicy extends XotBasePanelPolicy {
}
