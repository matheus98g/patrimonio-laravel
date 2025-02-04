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

    // Relacionamento com ativos locais (um local pode ter muitos ativos locais)
    public function ativosLocais()
    {
        return $this->hasMany(AtivoLocal::class, 'id_local', 'id');
    }
}
