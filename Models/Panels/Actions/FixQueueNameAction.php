<?php

declare(strict_types=1);

namespace Modules\Job\Models\Panels\Actions;

use Illuminate\Queue\Jobs\Job;
use Modules\Cms\Models\Panels\Actions\XotBasePanelAction;
use Modules\Job\Models\Job as JobModel;

/**
 * Class ShowFailedJobAction.
 */
class FixQueueNameAction extends XotBasePanelAction {
    public bool $onContainer = true;

    public string $icon = '<i class="fas fa-wrench"></i>Fix Queue Name';

    /**
     * ArtisanAction constructor.
     */
    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function handle() {
        $jobs = JobModel::inRandomOrder()
             ->limit(10000)
             ->get();
        echo '<h3>'.$jobs->count().' Jobs to check</h3>';

        // $job=app(Job::class);
        // dddx([
        // '$job'=>$job,
        // 'job_methods'=>class_methods($job),
        // 'jobs'=>$jobs,
        // ]);
        echo '<table border="1">';
        foreach ($jobs as $job) {
            $job->update(['queue' => 'queue01']);
        }
        echo '</table>';
    }

    // end handle
}
