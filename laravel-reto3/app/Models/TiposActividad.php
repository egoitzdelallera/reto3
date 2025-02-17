<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposActividad extends Model
{
    protected $table = 'tipos_actividades';

    protected $fillable = 
    [
        'nombre',
        'descripcion',
        'multimedia'
    ];

    public $timestamps = false;

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_tipo_actividad');
    }
}