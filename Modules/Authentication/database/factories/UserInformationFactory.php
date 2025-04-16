<?php

namespace Modules\Authentication\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserInformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Authentication\Models\UserInformation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'date_of_birth' =>  $this->faker->date(),
            'address' => $this->faker->address(),
            'image' => $this->faker->imageUrl(),
            'user_id' => $this->faker->numberBetween(1, 20)
        ];
    }
}

