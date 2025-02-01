<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    // Definir os campos que podem ser preenchidos (mass assignment)
    protected $fillable = [
        'nome',
        'descricao'
    ];

    // Relacionamento com ativos (um local pode ter muitos ativos).
    public function ativos()
    {
        return $this->hasMany(AtivoLocal::class, 'id_local', 'id');
    }
}
