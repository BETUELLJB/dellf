<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;
    public function definition(): array
    {
        return [
         
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $this->faker->word(),
            'nivel_acesso' => $this->faker->randomElement(['admin', 'gerente', 'operador']),
        ];
    }
}
