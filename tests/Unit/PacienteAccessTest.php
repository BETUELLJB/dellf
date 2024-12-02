<?php

namespace Tests\Unit;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class PacienteAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_restricao_criacao_paciente()
    {
        // Criar um usuário gerente (não admin)
        $user = User::factory()->create([
            'nivel_acesso' => 'gerente', // ou 'operador'
        ]);

        // Simular login com o usuário gerente
        $this->actingAs($user);

        // Tentar criar um paciente
        $response = $this->post(route('pacientes.store'), [
            'nome' => 'Carlos Souza',
            'contacto' => '987654321',
            'idade' => 25,
            'sexo' => 'Masculino',
            'estado_medico' => 'Saudável',
            'consultas' => 'Nenhuma',
            'diagnostico' => 'Nenhum',
            'medicamentos' => 'Nenhum',
        ]);

        // Verificar que o usuário foi redirecionado de volta com erro
        $response->assertRedirect()->assertSessionHas('error', 'Acesso não autorizado!');
    }

    public function test_admin_pode_criar_paciente()
    {
        // Criar um usuário administrador
        $user = User::factory()->create([
            'nivel_acesso' => 'admin',
        ]);

        // Simular login com o usuário administrador
        $this->actingAs($user);

        // Tentar criar um paciente
        $response = $this->post(route('pacientes.store'), [
            'nome' => 'Carlos Souza',
            'contacto' => '987654321',
            'idade' => 25,
            'sexo' => 'Masculino',
            'estado_medico' => 'Saudável',
            'consultas' => 'Nenhuma',
            'diagnostico' => 'Nenhum',
            'medicamentos' => 'Nenhum',
        ]);

        // Verificar que o usuário foi redirecionado com sucesso
        $response->assertRedirect(route('pacientes.index'))
            ->assertSessionHas('success', 'Paciente criado com sucesso!');

        // Recuperar o paciente diretamente do banco de dados
        $paciente = Paciente::where('nome', 'Carlos Souza')->first();

        // Garantir que o paciente foi criado
        $this->assertNotNull($paciente);

        // Verificar os campos do paciente, incluindo desencriptação para os campos encriptados
        $this->assertEquals('Carlos Souza', $paciente->nome);
        $this->assertEquals('987654321', $paciente->contacto);
        $this->assertEquals(25, $paciente->idade);
        $this->assertEquals('Masculino', $paciente->sexo);
        $this->assertEquals('Saudável', $paciente->estado_medico);
        $this->assertEquals('Nenhuma', $paciente->consultas);
        $this->assertEquals('Nenhum', $paciente->diagnostico);
        $this->assertEquals('Nenhum', $paciente->medicamentos);
    }

}
