<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Cms\Models\Panels\XotBasePanel;
use Modules\Cms\Contracts\RowsContract;

class TaskPanel extends XotBasePanel {
    /**
     * The model the resource corresponds to.
     */
    public static string $model = 'Modules\Job\Models\Task';

    /**
     * The single value that should be used to represent the resource when being displayed.
     */
    public static string $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    /**
     * The relationships that should be eager loaded on index queries.
     */
    public function with(): array {
        return [];
    }

    public function search(): array {
        return [];
    }

    /**
     * on select the option id.
     *
     * quando aggiungi un campo select, è il numero della chiave
     * che viene messo come valore su value="id"
     *
     * @param \Modules\Job\Models\Task $row
     *
     * @return int|string|null
     */
    public function optionId($row) {
        $key = $row->getKey();
        if (null === $key || (! is_string($key) && ! is_int($key))) {
            throw new \Exception('['.__LINE__.']['.class_basename(__CLASS__).']');
        }

        return $key;
    }

    /**
     * on select the option label.
     *
     * @param \Modules\Job\Models\Task $row
     */
    public function optionLabel($row): string {
        return Str::slug($row->command, '-');
    }

    /**
     * index navigation.
     */
    public function indexNav(): ?Renderable {
        return null;
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param RowsContract $query
     *
     * @return RowsContract
     */
    public function indexQuery(array $data, $query) {
        // return $query->where('user_id', $request->user()->id);
        return $query;
    }

    public function notificationFields(): array {
        return [
            (object) [
                'type' => 'Text',
                'name' => 'notification_email_address',
                'comment' => 'not in Doctrine',
                'col_size' => 4,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'notification_phone_number',
                'comment' => 'not in Doctrine',
                'col_size' => 4,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'notification_slack_webhook',
                'comment' => 'not in Doctrine',
                'col_size' => 4,
            ],
        ];
    }

    public function autoCleanupFields(): array {
        return [
            (object) [
                'type' => 'Text',
                'name' => 'auto_cleanup_type',
                'comment' => 'not in Doctrine',
                'col_size' => 3,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'auto_cleanup_num',
                'comment' => 'not in Doctrine',
                'col_size' => 3,
            ],
        ];
    }

    public function commandFields(): array {
        return [
            (object) [
                'type' => 'Text',
                'name' => 'command',
                'comment' => 'not in Doctrine',
                'col_size' => 3,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'parameters',
                'comment' => 'not in Doctrine',
                'col_size' => 4,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'expression',
                'comment' => 'not in Doctrine',
                'col_size' => 3,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'timezone',
                'comment' => 'not in Doctrine',
                'col_size' => 3,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'is_active',
                'comment' => 'not in Doctrine',
                'col_size' => 2,
            ],
        ];
    }

    public function runFields(): array {
        return [
            (object) [
                'type' => 'Integer',
                'name' => 'dont_overlap',
                'comment' => 'not in Doctrine',
                'col_size' => 2,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'run_in_maintenance',
                'comment' => 'not in Doctrine',
                'col_size' => 2,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'run_on_one_server',
                'comment' => 'not in Doctrine',
                'col_size' => 2,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'run_in_background',
                'comment' => 'not in Doctrine',
                'col_size' => 2,
            ],
        ];
    }

    /**
     * Get the fields displayed by the resource.
        'value'=>'..',
     */
    public function fields(): array {
        return [
            (object) [
                'type' => 'Id',
                'name' => 'id',
                'comment' => 'not in Doctrine',
            ],
            (object) [
                'type' => 'Text',
                'name' => 'description',
                'comment' => 'not in Doctrine',
            ],

            (object) [
                'type' => 'Cell',
                'name' => 'Command',
                'fields' => $this->commandFields(),
            ],

            (object) [
                'type' => 'Cell',
                'name' => 'Notification',
                'fields' => $this->notificationFields(),
            ],
            (object) [
                'type' => 'Cell',
                'name' => 'Auto Cleanup',
                'fields' => $this->autoCleanupFields(),
            ],

            (object) [
                'type' => 'Cell',
                'name' => 'run ',
                'fields' => $this->runFields(),
            ],
        ];
    }

    /**
     * Get the tabs available.
     */
    public function tabs(): array {
        $tabs_name = ['results', 'frequencies'];

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
            new Actions\ExecuteTaskPanelAction(),
        ];
    }
}
