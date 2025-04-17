<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\Job\Models\FailedJob;

/**
 * Class RetryFailedJobAction.
 */
class RetryAllFailedJobAction extends XotBasePanelAction {
    public bool $onContainer = true;
    public string $icon = '<i class="fas fa-reply"></i>Retry All';

    /**
     * ArtisanAction constructor.
     */
    public function __construct() {
    }

    /**
     * @return mixed|void
     */
    public function handle() {
        $rows = $this->rows->limit(50)->get();
        $rows_count = FailedJob::count();
        echo '<h3>'.$rows_count.' Failed Jobs</h3>';
        foreach ($rows as $job) {
            if (! $job instanceof FailedJob) {
                throw new \Exception('['.__LINE__.']['.__FILE__.']');
            }

            /** @var string $command */
            $command = $job->payload['data']['command'];

            /** @var object $deserialized */
            $deserialized = unserialize($command);

            try {
                if (! \method_exists($deserialized, 'displayName')) {
                    throw new \Exception('method displayName doesn\'t exists');
                }

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

                if (200 === $res['status'] && true === $res['res']) {
                    $job->delete();
                } else {
                    dddx(['Error 1' => $job]);
                }
            } catch (\Exception $e) {
                dddx(['Error 2' => $job]);
            }
        }
        echo '<h3>DONE?? </h3>';

        dddx('qui');
    }
}
