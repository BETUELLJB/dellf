<?php

namespace Tests\Feature;

use App\Models\Candidate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class CandidateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_candidate()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'cell1' => '123456789',
            'document_number' => '1234567890',
            'password' => bcrypt('password123'),
        ];

        $response = $this->post(route('candidates.store'), $data);

        $response->assertStatus(302); // Redireciona após sucesso
        $this->assertDatabaseHas('candidates', [
            'email' => 'johndoe@example.com',
        ]);
    }

    /** @test */
    public function it_can_update_a_candidate()
    {
        $candidate = Candidate::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'cell1' => '987654321',
            'document_number' => '9876543210',
            'password' => bcrypt('newpassword123'),
        ];

        $response = $this->put(route('candidates.update', $candidate->id), $data);

        $response->assertStatus(302); // Redireciona após sucesso
        $this->assertDatabaseHas('candidates', [
            'email' => 'janedoe@example.com',
        ]);
    }

    /** @test */
    public function it_can_delete_a_candidate()
    {
        $candidate = Candidate::factory()->create();

        $response = $this->delete(route('candidates.destroy', $candidate->id));

        $response->assertStatus(302); // Redireciona após sucesso
        $this->assertDatabaseMissing('candidates', [
            'id' => $candidate->id,
        ]);
    }

   /** @test */
// public function test_it_handles_transaction_rollback_on_error()
// {
//     $candidateData = [
//         'name' => 'John Doe',
//         'email' => 'johndoe@example.com',
//         'cell1' => '123456789',
//         'document_number' => '987654321',
//     ];

//     // Criar candidato inicial
//     $response = $this->post(route('candidates.store'), $candidateData);
//     $response->assertStatus(302); // Redireciona após criação bem-sucedida

//     $this->assertDatabaseHas('candidates', [
//         'email' => 'johndoe@example.com',
//     ]);

//     // Simular erro durante a atualização
//     try {
//         DB::transaction(function () use ($candidateData) {
//             // Atualizar o candidato com erro intencional
//             $candidateData['email'] = 'invalid-email'; // Email inválido para forçar erro
//             Candidate::find(1)->update($candidateData);

//             throw new \Exception('Erro simulado!'); // Forçar exceção
//         });
//     } catch (\Exception $e) {
//         // Verificar que a transação foi revertida
//         $this->assertDatabaseHas('candidates', [
//             'email' => 'johndoe@example.com',
//         ]);

//         $this->assertDatabaseMissing('candidates', [
//             'email' => 'invalid-email',
//         ]);

//         return; // Finalizar o teste
//     }

//     $this->fail('A transação não foi revertida conforme esperado.');
// }

    
}
