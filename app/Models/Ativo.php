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
        'imagem',
        'quantidade_min'
    ];

    // Relacionamento com a tabela marcas
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    // Relacionamento com a tabela tipos
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'id_tipo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relacionamento de muitos para muitos com a tabela 'locais' através da tabela pivô 'ativo_local'
    public function locais()
    {
        return $this->belongsToMany(Local::class, 'ativo_local', 'id_ativo', 'id_local')
            ->withPivot('quantidade');
    }

    public function movimentacoes()
    {
        return $this->hasMany(Movimentacao::class, 'id_ativo');
    }
}
