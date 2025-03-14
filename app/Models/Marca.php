<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = [

        'descricao',
        'status',
    ];

    // Relacionamento com ativos
    public function ativos()
    {
        return $this->hasMany(Ativo::class);
    }
}
