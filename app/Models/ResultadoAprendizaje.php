<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultadoAprendizaje extends Model
{
    use HasFactory;

    protected $table = 'resultados_aprendizaje';

    protected $fillable = [
        'id',
        'modulo_formativo_id',
        'codigo',
        'descripcion',
        'peso_porcentaje',
        'orden',
        'created_at',
        'updated_at'
    ];

}
