<?php

declare(strict_types=1);

namespace Modules\Job\Models;

use Database\Factories\TotemResultFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Modules\Job\Models\Result
 *
 * @property int $id
 * @property int $task_id
 * @property \Illuminate\Support\Carbon $ran_at
 * @property string $duration
 * @property string $result
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Job\Models\Task|null $task
 * @method static \Illuminate\Database\Eloquent\Builder|Result newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result query()
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereRanAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereUpdatedBy($value)
 * @mixin IdeHelperResult
 * @mixin \Eloquent
 */
class Result extends BaseModel
{
    use HasFactory;

    // protected $table = 'task_results';

    protected $fillable = [
        'duration',
        'result',
    ];

    protected $casts = [
        'ran_at' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function getLastRun(): Builder
    {
        return $this->select('ran_at')
            // ->whereColumn('task_id', TOTEM_TABLE_PREFIX.'tasks.id')
            ->whereColumn('task_id', 'tasks.id')
            ->latest()
            ->limit(1)
            ->getQuery();
    }

    public function getAverageRunTime(): Builder
    {
        return $this->select(DB::raw('avg(duration)'))
            // ->whereColumn('task_id', TOTEM_TABLE_PREFIX.'tasks.id')
            ->whereColumn('task_id', 'tasks.id')
            ->getQuery();
    }

    // /**
    //  * @return TotemResultFactory
    //  */
    // protected static function newFactory(): TotemResultFactory
    // {
    //     return TotemResultFactory::new();
    // }
}
