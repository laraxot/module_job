<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\Job\Models\FailedJob;

/**
 * Class RetryFailedJobAction.
 */
class RetryFailedJobAction extends XotBasePanelAction {
    public bool $onItem = true;

    public string $icon = '<i class="fas fa-reply"></i>Retry';

    /**
     * ArtisanAction constructor.
     */
    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function handle() {
        $job = $this->row;
        if (! $job instanceof FailedJob) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        /** @var string $command */
        $command = $job->payload['data']['command'];

        /** @var object $deserialized */
        $deserialized = unserialize($command);

        if (! method_exists($deserialized, 'displayName')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        if (! \method_exists($deserialized, 'parameters')) {
            throw new \Exception('method displayName doesn\'t exists');
        }

        if (! isset($deserialized->parameters()[0])) {
            throw new \Exception('parameter[0] doesn\'t exists');
        }

        $action = app($deserialized->displayName());

        $params = $deserialized->parameters()[0];

        $res = $action->execute($params);

        dddx($res);
        echo '<h3>DONE?? </h3>';
    }
}
