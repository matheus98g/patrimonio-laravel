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
        Schema::create('locais', function (Blueprint $table) {
            $table->id(); // ID único para o local
            $table->string('nome')->unique(); // Nome do local (ex: "Armazém A")
            $table->string('descricao')->nullable(); // Descrição do local
            $table->timestamps(); // Timestamps para controle de criação e atualização
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locals');
    }
};
