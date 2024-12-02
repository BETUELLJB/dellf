<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loggs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();  // ID do usuário (FK)
            $table->string('user_name')->nullable();            // Nome do usuário
            $table->string('ip_address')->nullable();           // Endereço IP do usuário
            $table->string('model');                           // Nome do modelo afetado
            $table->unsignedBigInteger('model_id')->nullable(); // ID do registro afetado
            $table->string('action');                          // Ação realizada (create, update, delete, etc.)
            $table->json('changes')->nullable();               // Alterações realizadas
            $table->string('status')->default('info');         // Status (success, error, info)
            $table->text('message')->nullable();               // Mensagem descritiva
            $table->timestamps();
            
            // Chave estrangeira opcional
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loggs');
    }
};
