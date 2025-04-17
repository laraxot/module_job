<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Modules\Cms\Actions\GetViewAction;
use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\Job\Actions\ExecuteTaskAction;

/**
 * Class ExecuteTaskPanelAction.
 */
class ExecuteTaskPanelAction extends XotBasePanelAction
{
    public bool $onItem = true;

    public string $icon = '<i class="fa-solid fa-play"></i>';

    /**
     * ArtisanAction constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var string $model_key
         */
        $model_key = $this->row->getKey();
        $task_id = strval($model_key);
        $res = app(ExecuteTaskAction::class)->execute((string) $task_id);
        $view = app(GetViewAction::class)->execute();
        $view_params = [
            'res' => $res,
        ];

        return view($view, $view_params);
    }
}
