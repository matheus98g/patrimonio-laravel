<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ativo extends Model
{
    protected $fillable = [
        'descricao',
        'quantidade_total',
        'quantidade_uso',
        'quantidade_disp',
        'status',
        'observacao',
        'id_marca',
        'id_tipo',
        'id_user',
        'id_local',
        'imagem'
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

    // Relacionamento com ativos_locais (tabela intermediária)
    public function ativosLocais()
    {
        return $this->hasMany(AtivoLocal::class, 'id_ativo', 'id');
    }

    // Obter todos os locais onde o ativo está presente (caso use a tabela intermediária)
    public function locais()
    {
        return $this->belongsToMany(Local::class, 'ativo_local', 'id_ativo', 'id_local')
            ->withPivot('quantidade') // Inclui a quantidade de cada ativo em cada local
            ->withTimestamps();
    }
}
