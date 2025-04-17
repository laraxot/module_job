<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Job\Models\Job;

class JobFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            // 'id' => $this->faker->randomNumber(5, false),
            'queue' => $this->faker->word,
            'payload' => $this->faker->text,
            'attempts' => $this->faker->boolean,
            'reserved_at' => $this->faker->randomNumber(5, false),
            'available_at' => $this->faker->randomNumber(5, false),
            'created_at' => $this->faker->randomNumber(5, false),
        ];
    }
}
