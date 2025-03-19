<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToUserRoleTable extends Migration
{
    /**
     * Execute as transformações da migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_role', function (Blueprint $table) {
            // Adiciona as colunas created_at e updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverter as transformações da migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_role', function (Blueprint $table) {
            // Remove as colunas created_at e updated_at
            $table->dropTimestamps();
        });
    }
}
