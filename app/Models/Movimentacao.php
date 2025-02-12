<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $fillable = [
        'id_user',
        'id_ativo',
        'observacao',
        'status',
        'local_origem',
        'local_destino',
        'quantidade_mov',
        // 'tipo',
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

    public function ativoLocalOrigem()
    {
        // Relacionando com a tabela 'ativo_local' para o local de origem
        return $this->belongsTo(AtivoLocal::class, 'local_origem', 'id_local');
    }

    public function ativoLocalDestino()
    {
        // Relacionando com a tabela 'ativo_local' para o local de destino
        return $this->belongsTo(AtivoLocal::class, 'local_destino', 'id_local');
    }
}
