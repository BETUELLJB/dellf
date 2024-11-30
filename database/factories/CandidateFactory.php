<?php

namespace Database\Factories;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CandidateFactory extends Factory
{
    protected $model = Candidate::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'cell1' => $this->faker->phoneNumber(),
            'document_number' => $this->faker->unique()->numerify('##########'),
            'password' => bcrypt('password'), // Use uma senha padrão para testes
        ];
    }
}
