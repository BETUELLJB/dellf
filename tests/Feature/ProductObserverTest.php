<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Log;

class ProductObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o rastreamento de criação de um produto.
     */
    public function test_product_creation_logs_changes()
    {
        // Cria um produto
        $product = Product::create([
            'name' => 'Produto Teste',
            'price' => 100,
            'description' => 'Descrição do produto teste',
        ]);

        // Verifica se o log foi criado
        $this->assertDatabaseHas('logs', [
            'model' => Product::class,
            'model_id' => $product->id,
            'action' => 'create',
        ]);
    }

    /**
     * Testa o rastreamento de atualização de um produto.
     */
    public function test_product_update_logs_changes()
    {
        // Cria um produto
        $product = Product::create([
            'name' => 'Produto Teste',
            'price' => 100,
            'description' => 'Descrição do produto teste',
        ]);

        // Atualiza o produto
        $product->update(['price' => 150]);

        // Verifica se o log foi criado
        $this->assertDatabaseHas('logs', [
            'model' => Product::class,
            'model_id' => $product->id,
            'action' => 'update',
        ]);
    }

    /**
     * Testa o rastreamento de exclusão de um produto.
     */
    public function test_product_deletion_logs_changes()
    {
        // Cria um produto
        $product = Product::create([
            'name' => 'Produto Teste',
            'price' => 100,
            'description' => 'Descrição do produto teste',
        ]);

        // Exclui o produto
        $product->delete();

        // Verifica se o log foi criado
        $this->assertDatabaseHas('logs', [
            'model' => Product::class,
            'model_id' => $product->id,
            'action' => 'delete',
        ]);
    }
}
