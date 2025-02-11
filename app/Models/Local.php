<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    // Definir os campos que podem ser preenchidos (mass assignment)
    protected $fillable = [
        'descricao',
        'observacao',
    ];

    protected $table = 'locais';

    // Relacionamento de muitos para muitos com a tabela 'ativos' através da tabela pivô 'ativo_local'
    public function ativos()
    {
        return $this->belongsToMany(Ativo::class, 'ativo_local', 'id_local', 'id_ativo')
            ->withPivot('quantidade');  // Adiciona o campo 'quantidade' da tabela pivô
    }
}
