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
        Schema::create('ativos_locais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ativo')->constrained('ativos')->onDelete('cascade');
            $table->string('localizacao');
            $table->integer('quantidade')->default(0)->check('quantidade >= 0');
            $table->timestamps();

            // Índice para melhorar performance nas consultas
            $table->unique(['id_ativo', 'localizacao']);  // Garantir que cada ativo só tenha um registro por local

            // Índice para facilitar consultas por ativo
            $table->index('id_ativo');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes');
    }
};
