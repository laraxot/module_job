<?php

declare(strict_types=1);

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Modules\Job\Models\Traits\HasParameters;

/**
 * Modules\Job\Models\Frequency
 *
 * @property int $id
 * @property int $task_id
 * @property string $label
 * @property string $interval
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Job\Models\Parameter> $parameters
 * @property-read int|null $parameters_count
 * @property-read \Modules\Job\Models\Task|null $task
 * @method static \Modules\Job\Database\Factories\FrequencyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereUpdatedBy($value)
 * @mixin IdeHelperFrequency
 * @mixin \Eloquent
 */
class Frequency extends BaseModel
{
    // use HasParameters;

    // protected $table = 'task_frequencies';

    protected $fillable = [
        'id',
        'label',
        'interval',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class);
    }
}
