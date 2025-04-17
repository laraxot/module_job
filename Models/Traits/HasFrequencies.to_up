<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Illuminate\Console\Scheduling\ManagesFrequencies;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Modules\Job\Models\Frequency;

trait HasFrequencies
{
    use ManagesFrequencies;

    /**
     * The array of filter callbacks.
     */
    protected array $filters = [];

    /**
     * The array of reject callbacks.
     */
    protected array $rejects = [];

    /**
     * Boot HasFrequencies Trait.
     *
     * @return void
     */
    public static function bootHasFrequencies()
    {
        static::saved(function ($model) {
            $model->afterSave();
        });

        static::deleting(function ($model) {
            $model->beforeDelete();
        });
    }

    /**
     * When task is updated or created, we grab the input. If the type is set to frequency in input we try to either
     * update or create the frequencies included in input else delete the frequency. If the type is not frequency and
     * the task in question has frequencies saved in databased, delete them all.
     */
    public function afterSave(): void
    {
        $input = $this->processData();

        if (isset($input['type'])) {
            if ('frequency' == $input['type']) {
                foreach ($this->frequencies as $frequency) {
                    if (! in_array($frequency->interval, collect($input['frequencies'])->pluck('interval')->toArray())) {
                        $frequency->delete();
                    }
                }

                foreach ($input['frequencies'] as $_frequency) {
                    $this->frequencies()->updateOrCreate(Arr::only($_frequency, ['task_id', 'label', 'interval']));
                }
            } else {
                $this->frequencies->each(function ($frequency) {
                    $frequency->delete();
                });
            }
        }
    }

    /**
     * Task Deleted.
     */
    public function beforeDelete(): void
    {
        $this->frequencies->each(function ($frequency) {
            $frequency->delete();
        });

        $this->results()->delete();
    }

    /**
     * Frequencies Relation.
     */
    public function frequencies(): HasMany
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id')->with('parameters');
    }

    /**
     * Generate a cron expression from frequencies.
     */
    public function getCronExpression(): string
    {
        if (! $this->expression) {
            $this->expression = '* * * * *';

            foreach ($this->frequencies as $frequency) {
                call_user_func_array([$this, $frequency->interval], $frequency->parameters->pluck('value')->toArray());
            }

            $expression = $this->expression;

            $this->expression = null;

            return $expression;
        }

        return $this->expression;
    }

    /**
     * Determine if the filters pass for the event.
     */
    public function filtersPass(Application $app): bool
    {
        foreach ($this->filters as $callback) {
            if (! $app->call($callback)) {
                return false;
            }
        }

        foreach ($this->rejects as $callback) {
            if ($app->call($callback)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Register a callback to further filter the schedule.
     *
     * @return $this
     */
    public function when(\Closure $callback): static
    {
        $this->filters[] = $callback;

        return $this;
    }

    /**
     * Schedule the event to run between start and end time.
     *
     * @param string $startTime
     * @param string $endTime
     *
     * @return $this
     */
    public function between($startTime, $endTime): static
    {
        return $this->when($this->inTimeInterval($startTime, $endTime));
    }

    /**
     * Process input data. If its an import action we must find out if the imported json has frequencies or not and
     * prepare data accordingly.
     *
     * @throws FileNotFoundException
     */
    private function processData(): array
    {
        $data = \request()->all();

        if (! \request()->hasFile('tasks')) {
            return $data;
        }

        $task = collect(\json_decode(\request()->file('tasks')->get()))
            ->filter(function ($task) {
                return $task->id === $this->id;
            })
            ->first();

        if ($task && ($task->frequencies ?? false)) {
            $data['type'] = 'frequency';
            $data['frequencies'] = collect($task->frequencies)->map(
                function ($frequency) {
                    return (array) $frequency;
                })->toArray();
        }

        return $data;
    }
}
