<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permission";
    protected $fillable = ['name'];

   public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permission', 'permission_id', 'user_id')
                    ->withTimestamps();
    }
}
