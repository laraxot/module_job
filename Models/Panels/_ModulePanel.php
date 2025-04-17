<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels;

use Modules\Cms\Models\Panels\XotBasePanel;

/**
 * Class _ModulePanel.
 */
class _ModulePanel extends XotBasePanel {
    /**
     * Get the actions available for the resource.
     */
    public function actions(): array {
        return [
            // new Actions\XlsImportAction(),
            new Actions\TryJobAction(),
            new Actions\ScheduleManagerAction(),
            new Actions\ScheduleStatusAction(),
            new Actions\TaskAction(),
        ];
    }
}