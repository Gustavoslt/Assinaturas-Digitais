<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'nome',
        'assinante',
        'cpf',
        'num_inscricao',
        'assinatura',
        'status',
        'documento'
    ];
}
