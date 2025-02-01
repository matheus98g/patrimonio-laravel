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
        'qntMov',
        'tipo',
    ];

    protected $table = 'movimentacoes';

    // Relacionamento com o modelo Ativo
    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'id_ativo', 'id');
    }

    // Relacionamento com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relacionamento com a tabela AtivoLocal (movimentações associadas a locais específicos)
    public function ativoLocalOrigem()
    {
        return $this->belongsTo(AtivoLocal::class, 'origem', 'id_local'); // Relacionando a origem
    }

    public function ativoLocalDestino()
    {
        return $this->belongsTo(AtivoLocal::class, 'destino', 'id_local'); // Relacionando o destino
    }
}
