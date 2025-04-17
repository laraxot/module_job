<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;

/**
 * Class ShowFailedJobAction.
 */
class ScheduleStatusAction extends XotBasePanelAction {
    public bool $onContainer = false; // onlyContainer

    public bool $onItem = true; // onlyContainer

    public string $icon = '<i class="fas fa-eye"></i>';

    /**
     * @return mixed
     */
    public function handle() {
        return $this->panel->view();
    }

    // end handle
}
