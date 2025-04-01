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
        'marca_id',
        'tipo_id',
        'user_id',
        'imagem',
        'quantidade_min'
    ];

    protected $table = "ativo";

    // Relacionamento com a tabela marcas
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    // Relacionamento com a tabela tipos
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento de muitos para muitos com a tabela 'locais' através da tabela pivô 'ativo_local'
    public function locais()
    {
        return $this->belongsToMany(Local::class, 'ativo_local', 'ativo_id', 'local_id')
            ->withPivot('quantidade');
    }

    public function movimentacoes()
    {
        return $this->hasMany(Movimentacao::class, 'ativo_id');
    }
}
