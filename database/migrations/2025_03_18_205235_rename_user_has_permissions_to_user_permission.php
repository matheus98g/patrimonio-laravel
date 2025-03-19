<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('user_has_permissions', 'user_permission');
    }

    public function down()
    {
        Schema::rename('user_permission', 'user_has_permissions');
    }

};
