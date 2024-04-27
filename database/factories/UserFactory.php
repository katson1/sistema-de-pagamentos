<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf_cnpj' => $this->faker->unique()->numerify('###########'), 
            'user_type' => $this->faker->randomElement(['common', 'store']),
            'balance' => $this->faker->randomFloat(2, 0, 1000),
            'remember_token' => Str::random(10),
        ];
    }
}
