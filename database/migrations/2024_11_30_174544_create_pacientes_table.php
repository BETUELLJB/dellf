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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Não será codificado
            $table->string('contacto'); // Codificado
            $table->integer('idade'); // Não será codificado
            $table->string('sexo'); // Não será codificado
            $table->string('estado_medico'); // Codificado
            $table->text('consultas'); // Codificado
            $table->text('diagnostico'); // Codificado
            $table->text('medicamentos'); // Codificado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
