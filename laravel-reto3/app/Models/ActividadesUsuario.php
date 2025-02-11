<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadesUsuario extends Model
{
    protected $table = 'actividades_usuarios';

    protected $fillable = 
    [
        'id_actividad',
        'id_usuario'
    ];

    public $timestamps = false;
}
