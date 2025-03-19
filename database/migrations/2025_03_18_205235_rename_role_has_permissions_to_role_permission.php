<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('role_has_permissions', 'role_permission');
    }

    public function down()
    {
        Schema::rename('role_permission', 'role_has_permissions');
    }

};
