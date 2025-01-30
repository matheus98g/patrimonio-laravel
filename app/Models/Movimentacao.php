<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $fillable = [
        'id_user',
        'id_ativo',
        'descricao',
        'status',
        'origem',
        'destino',
        'qntUso',
        'tipo',
    ];

    protected $table = 'movimentacoes';

    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'id_ativo', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
