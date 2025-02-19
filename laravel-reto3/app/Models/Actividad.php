<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'idioma',
        'edad_min',
        'edad_max',
        'id_centro_civico',
        'id_tipo_actividad',
        'id_monitor',
    ];

    public function centroCivico()
    {
        return $this->belongsTo(CentroCivico::class, 'id_centro_civico');
    }

    public function tipoActividad()
    {
        return $this->belongsTo(TiposActividad::class, 'id_tipo_actividad');
    }

    public function monitor()
    {
        return $this->belongsTo(Monitor::class, 'id_monitor');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_actividad');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'actividades_usuarios', 'id_actividad', 'id_usuario');
    }
}