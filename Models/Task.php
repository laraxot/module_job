<?php

declare(strict_types=1);

namespace Modules\Job\Models;

use Carbon\Carbon;
use Cron\CronExpression;
use Database\Factories\TotemTaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Modules\Job\Models\Traits\FrontendSortable;
use Modules\Job\Models\Traits\HasFrequencies;

/**
 * Undocumented class.
 *
 * @property string $name
 * @property string $command
 * @property string $expression
 * @property string $description
 * @property string $timezone
 * @property bool   $dont_overlap
 * @property bool   $run_in_maintenance
 * @property bool   $run_on_one_server
 * @property bool   $run_in_background
 * @property array  $parameters
 */
class Task extends BaseModel {
    use Notifiable;
    use HasFrequencies;
    use FrontendSortable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, string>
     */
    protected $fillable = [
        'id',
        'description',
        'command',
        'parameters',
        'expression',
        'timezone',
        'is_active',
        'dont_overlap',
        'run_in_maintenance',
        'notification_email_address',
        'notification_phone_number',
        'notification_slack_webhook',
        'auto_cleanup_type',
        'auto_cleanup_num',
        'run_on_one_server',
        'run_in_background',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'activated',
        'upcoming',
        'last_result',
        'average_runtime',
    ];

    /**
     * Activated Accessor.
     */
    public function getActivatedAttribute(): bool {
        return $this->is_active ?? true;
    }

    /**
     * Upcoming Accessor.
     *
     * @throws \Exception
     */
    public function getUpcomingAttribute(): string {
        // return CronExpression::factory($this->getCronExpression())->getNextRunDate()->format('Y-m-d H:i:s');
        return 'preso';
    }

    /**
     * Convert a string of command arguments and options to an array.
     *
     * @param bool $console if true will convert arguments to non associative array
     */
    public function compileParameters(bool $console = false): array {
        if ($this->parameters) {
            $regex = '/(?=\S)[^\'"\s]*(?:\'[^\']*\'[^\'"\s]*|"[^"]*"[^\'"\s]*)*/';
            preg_match_all($regex, $this->parameters, $matches, PREG_SET_ORDER, 0);

            $argument_index = 0;

            $duplicate_parameter_index = function (array $carry, array $param, string $trimmed_param) {
                if (! isset($carry[$param[0]])) {
                    $carry[$param[0]] = $trimmed_param;
                } else {
                    if (! is_array($carry[$param[0]])) {
                        $carry[$param[0]] = [$carry[$param[0]]];
                    }
                    $carry[$param[0]][] = $trimmed_param;
                }

                return $carry;
            };

            return collect($matches)->reduce(function ($carry, $parameter) use ($console, &$argument_index, $duplicate_parameter_index) {
                $param = explode('=', $parameter[0], 2);

                if (count($param) > 1) {
                    $trimmed_param = trim(trim($param[1], '"'), "'");
                    if ($console) {
                        if (Str::startsWith($param[0], ['--', '-'])) {
                            $carry = $duplicate_parameter_index($carry, $param, $trimmed_param);
                        } else {
                            $carry[$argument_index++] = $trimmed_param;
                        }

                        return $carry;
                    }

                    return $duplicate_parameter_index($carry, $param, $trimmed_param);
                }

                Str::startsWith($param[0], ['--', '-']) && ! $console ?
                    $carry[$param[0]] = true :
                    $carry[$argument_index++] = $param[0];

                return $carry;
            }, []);
        }

        return [];
    }

    /**
     * Results Relation.
     */
    public function results(): HasMany {
        return $this->hasMany(Result::class, 'task_id', 'id');
    }

    /**
     * Returns the most recent result entry for this task.
     */
    public function getLastResultAttribute(): Result|null {
        return $this->results()->orderBy('id', 'desc')->first();
    }

    public function getAverageRuntimeAttribute(): float {
        return (float) $this->results()->avg('duration');
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail(): string {
        return $this->notification_email_address;
    }

    /**
     * Route notifications for the Nexmo channel.
     */
    public function routeNotificationForNexmo(): string {
        return $this->notification_phone_number;
    }

    /**
     * Route notifications for the Slack channel.
     */
    public function routeNotificationForSlack(): string {
        return $this->notification_slack_webhook;
    }

    /**
     * Attempt to perform clean on task results.
     */
    public function autoCleanup() {
        if ($this->auto_cleanup_num > 0) {
            if ('results' === $this->auto_cleanup_type) {
                $oldest_id = $this->results()
                    ->orderBy('ran_at', 'desc')
                    ->limit($this->auto_cleanup_num)
                    ->get()
                    ->min('id');
                do {
                    $rowsToDelete = $this->results()
                        ->where('id', '<', $oldest_id)
                        ->limit(50)
                        ->getQuery()
                        ->select('id')
                        ->pluck('id');

                    Result::query()
                        ->whereIn('id', $rowsToDelete)
                        ->delete();
                } while ($rowsToDelete->count() > 0);
            } else {
                do {
                    $rowsToDelete = $this->results()
                        ->where('ran_at', '<', Carbon::now()->subDays($this->auto_cleanup_num - 1))
                        ->limit(50)
                        ->getQuery()
                        ->select('id')
                        ->pluck('id');

                    Result::query()
                        ->whereIn('id', $rowsToDelete)
                        ->delete();
                } while ($rowsToDelete->count() > 0);
            }
        }
    }

    // /**
    //  * Create a new factory instance for the model.
    //  *
    //  * @return TotemTaskFactory
    //  */
    // protected static function newFactory(): TotemTaskFactory
    // {
    //     return TotemTaskFactory::new();
    // }
}
