<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Cms\Models\Panels\XotBasePanel;

// --- Services --

class JobBatchPanel extends XotBasePanel {
    /**
     * The model the resource corresponds to.
     */
    public static string $model = 'Modules\Cms\Models\Panels\JobBatchPanel';

    /**
     * The single value that should be used to represent the resource when being displayed.
     */
    public static string $title = 'title';

    /**
     * Get the fields displayed by the resource.
        'value'=>'..',
     */
    public function fields(): array {
        return [
            (object) [
                'type' => 'String',
                'name' => 'id',
                'rules' => 'required',
                'comment' => null,
            ],
            (object) [
                'type' => 'String',
                'name' => 'name',
                'rules' => 'required',
                'comment' => null,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'total_jobs',
                'rules' => 'required',
                'comment' => null,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'pending_jobs',
                'rules' => 'required',
                'comment' => null,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'failed_jobs',
                'rules' => 'required',
                'comment' => null,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'failed_job_ids',
                'rules' => 'required',
                'comment' => null,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'options',
                'comment' => null,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'cancelled_at',
                'comment' => null,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'created_at',
                'rules' => 'required',
                'comment' => null,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'finished_at',
                'comment' => null,
            ],
        ];
    }

    /**
     * Get the tabs available.
     */
    public function tabs(): array {
        $tabs_name = [];

        return $tabs_name;
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function filters(Request $request = null): array {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(): array {
        return [
            new Actions\PruneBatchesAction(),
        ];
    }
}
