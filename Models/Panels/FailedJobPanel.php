<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels;

use Illuminate\Http\Request;
use Modules\Cms\Models\Panels\Actions\ArtisanContainerAction;
use Modules\Cms\Models\Panels\XotBasePanel;

// --- Services --

class FailedJobPanel extends XotBasePanel {
    /**
     * The model the resource corresponds to.
     */
    public static string $model = 'Modules\Xot\Models\FailedJob';

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
                'type' => 'Id',
                'name' => 'id',
                'comment' => null,
            ],

            (object) [
                'type' => 'String',
                'name' => 'uuid',
                'rules' => 'required',
                'comment' => null,
            ],

            (object) [
                'type' => 'Text',
                'name' => 'connection',
                'rules' => 'required',
                'comment' => null,
            ],

            (object) [
                'type' => 'Text',
                'name' => 'queue',
                'rules' => 'required',
                'comment' => null,
            ],

            (object) [
                'type' => 'Text',
                'name' => 'payload',
                'rules' => 'required',
                'comment' => null,
            ],

            (object) [
                'type' => 'Text',
                'name' => 'exception',
                'rules' => 'required',
                'comment' => null,
            ],

            (object) [
                'type' => 'DateDateTime',
                'name' => 'failed_at',
                'rules' => 'required',
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
            // new ArtisanContainerAction('queue:flush'),
            new Actions\DeleteFailedJobsAction(),
            new Actions\ShowFailedJobAction(),
            new Actions\RetryFailedJobAction(),
            new Actions\RetryAllFailedJobAction(),
        ];
    }
}
