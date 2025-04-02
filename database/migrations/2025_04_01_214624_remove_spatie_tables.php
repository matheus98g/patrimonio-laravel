
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSpatieTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('user_permission');
        Schema::dropIfExists('role');
        Schema::dropIfExists('permission');
    }

    public function down()
    {
        // Deixe vazio ou recrie as tabelas, caso precise reverter
    }
}