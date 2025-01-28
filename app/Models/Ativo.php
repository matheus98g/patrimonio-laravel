<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ativo extends Model
{
    protected $fillable = [

        'descricao',
        'quantidade',
        'status',
        'observacao',
        'id_marca',
        'id_tipo',
        'id_user',
    ];
}
