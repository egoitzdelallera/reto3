<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroCivico extends Model
{
    protected $table = 'centros_civicos';

    protected $fillable = 
    [
        'nombre',
        'ubicacion',
        'longitud',
        'latitud',
        'url',
        'telefono',
        'correo'
    ];

    public $timestamps = false;

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_centro_civico');
    }
}
