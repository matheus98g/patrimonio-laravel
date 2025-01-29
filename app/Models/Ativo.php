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

    // Relacionamento com a tabela marcas
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    // Relacionamento com a tabela tipos
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
}
