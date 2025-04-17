<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Job\Models\Task;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'command' => 'Modules\Job\Console\Commands\ListSchedule',
            'expression' => '* * * * *',
        ];
    }
}
