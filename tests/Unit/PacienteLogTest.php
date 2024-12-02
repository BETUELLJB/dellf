<?php

namespace Tests\Unit;

use App\Models\Paciente;
use App\Models\Log;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PacienteLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_creation_paciente()
    {
        // Criar um usuário administrador
        $user = User::factory()->create([
            'nivel_acesso' => 'admin',
        ]);

        // Simular login do administrador
        $this->actingAs($user);

        // Dados do paciente a ser criado
        $pacienteData = [
            'nome' => 'Mariana Oliveira',
            'contacto' => '234567890',
            'idade' => 28,
            'sexo' => 'Feminino',
            'estado_medico' => 'Saudável',
            'consultas' => 'Nenhuma',
            'diagnostico' => 'Nenhum',
            'medicamentos' => 'Nenhum',
        ];

        // Enviar a requisição para criar o paciente
        $this->post(route('pacientes.store'), $pacienteData);

        // Recuperar o paciente recém-criado
        $paciente = Paciente::where('nome', 'Mariana Oliveira')->first();
        $this->assertNotNull($paciente);

        // Verificar se o log foi registrado
        $this->assertDatabaseHas('logs', [
            'model' => 'App\\Models\\Paciente',
            'model_id' => $paciente->id,
            'action' => 'create',
            'message' => 'Paciente criado com sucesso.',
        ]);

        // Validar que o log contém os dados corretos
        $log = Log::where('model', 'App\\Models\\Paciente')
            ->where('model_id', $paciente->id)
            ->first();

        $this->assertNotNull($log);
        $this->assertEquals('create', $log->action);
        $this->assertEquals('Paciente criado com sucesso.', $log->message);
        $this->assertEquals($paciente->id, $log->model_id);
        $this->assertEquals('App\\Models\\Paciente', $log->model);
    }
}
