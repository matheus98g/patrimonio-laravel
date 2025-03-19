<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Remover a coluna 'user_type' da tabela 'model_has_permissions'
        Schema::table('user_has_permissions', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });

        // Remover a coluna 'user_type' da tabela 'user_has_roles'
        Schema::table('user_has_roles', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }

    public function down()
    {
        // Revertendo as alterações em caso de rollback (caso precise)
        Schema::table('user_has_permissions', function (Blueprint $table) {
            $table->string('user_type');
        });

        Schema::table('user_has_roles', function (Blueprint $table) {
            $table->string('user_type');
        });
    }

};
