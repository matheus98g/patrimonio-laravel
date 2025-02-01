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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ativo_locals');
    }
};
