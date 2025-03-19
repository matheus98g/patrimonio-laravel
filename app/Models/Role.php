<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "role";
    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id')
                    ->withTimestamps();
    }
}