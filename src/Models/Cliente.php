<?php

namespace  Marcelogennaro\AutenticacaoRecargaApi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cliente\Database\Factories\ClienteFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey='id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nome',
        'codigo_conekta',
        'senha_conekta',
    ];

    protected static function newFactory(): ClienteFactory
    {
        //return ClienteFactory::new();
    }



}
