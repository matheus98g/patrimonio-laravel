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
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('ativo_id');
            $table->string('descricao');
            $table->integer('status');
            $table->string('origem');
            $table->string('destino');
            $table->integer('qntUso');
            $table->integer('tipo'); // tipo de movimentação (Adicionar, Realocar, Remover)
            $table->timestamps();
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
