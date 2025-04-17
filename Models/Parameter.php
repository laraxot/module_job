<?php

declare(strict_types=1);

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\Job\Models\Parameter
 *
 * @property int $id
 * @property int $frequency_id
 * @property string $name
 * @property string $value
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Job\Models\Frequency|null $task
 * @method static \Modules\Job\Database\Factories\ParameterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereFrequencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereValue($value)
 * @mixin IdeHelperParameter
 * @mixin \Eloquent
 */
class Parameter extends BaseModel {
    // protected $table = 'frequency_parameters';

    protected $fillable = [
        'id',
        'name',
        'value',
    ];

    public function task(): BelongsTo {
        return $this->belongsTo(Frequency::class);
    }
}
