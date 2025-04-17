<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Job\Models\JobBatch;

class JobBatchFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = JobBatch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'id' => $this->faker->word,
            'name' => $this->faker->name,
            'total_jobs' => $this->faker->randomNumber(5, false),
            'pending_jobs' => $this->faker->randomNumber(5, false),
            'failed_jobs' => $this->faker->randomNumber(5, false),
            'failed_job_ids' => $this->faker->text,
            'options' => $this->faker->text,
            'cancelled_at' => $this->faker->randomNumber(5, false),
            'created_at' => $this->faker->randomNumber(5, false),
            'finished_at' => $this->faker->randomNumber(5, false),
        ];
    }
}
