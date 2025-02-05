<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtivoLocal extends Model
{
    use HasFactory;

    // Definir o nome da tabela caso não seja o plural do nome do model
    protected $table = 'ativo_local';

    // Definir os campos que podem ser preenchidos via atribuição em massa
    protected $fillable = [
        'id_ativo',
        'id_local',
        'quantidade',
    ];

    // Relacionamento com o modelo Ativo
    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'id_ativo');
    }

    // Relacionamento com o modelo Local (muitos ativos podem estar em vários locais)
    public function local()
    {
        return $this->belongsTo(Local::class, 'id_local');
    }

    // Relacionamento com movimentações (caso o AtivoLocal seja relacionado com movimentações)
    public function movimentacoes()
    {
        return $this->hasMany(Movimentacao::class, 'id_ativo_local');
    }
}
