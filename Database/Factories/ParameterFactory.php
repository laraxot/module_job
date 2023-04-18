<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Modules\Job\Models\Parameter;

class ParameterFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Modules\Job\Models\Parameter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {


        return [
            'id' => $this->faker->randomNumber,
            'name' => $this->faker->name,
            'value' => $this->faker->word
        ];
    }
}
