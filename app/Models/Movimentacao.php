<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $fillable = [
        'user_id',
        'ativo_id',
        'descricao',
        'status',
        'origem',
        'destino',
        'qntUso',
        'tipo',
    ];

    protected $table = 'movimentacoes';
}
