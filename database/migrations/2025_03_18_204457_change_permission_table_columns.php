<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Atualizando as colunas das tabelas renomeadas
        Schema::table('user_has_permissions', function (Blueprint $table) {
            // Modificando as colunas da tabela 'user_has_permissions'
            $table->renameColumn('model_id', 'user_id');
            $table->renameColumn('model_type', 'user_type');
        });
        
        Schema::table('user_has_roles', function (Blueprint $table) {
            // Modificando as colunas da tabela 'user_has_roles'
            $table->renameColumn('model_id', 'user_id');
            $table->renameColumn('model_type', 'user_type');
        });
    }

    public function down()
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->renameColumn('user_id', 'model_id');
            $table->renameColumn('user_type', 'model_type');
        });

        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->renameColumn('user_id', 'model_id');
            $table->renameColumn('user_type', 'model_type');
        });
    }

};
