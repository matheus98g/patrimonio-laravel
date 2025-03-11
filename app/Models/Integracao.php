<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integracao extends Model
{
    protected $table = "integracoes";

    protected $fillable = [
        'descricao',
        'access_token',
        'refresh_token',
    ] ;
}
