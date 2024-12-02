<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Paciente;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Paciente::class;

    public function definition():array
    {
        return [
            'nome' => $this->faker->name(),
            'idade' => $this->faker->numberBetween(18, 100),
            'sexo' => $this->faker->randomElement(['Masculino', 'Feminino']),
            'contacto' => $this->faker->phoneNumber(),
            'estado_medico'=> $this->faker->word(),
            'consultas'=> $this->faker->word(),
            'diagnostico'=> $this->faker->word(),
            'medicamentos'=> $this->faker->word(),
        ];
    }
}
