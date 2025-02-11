<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = 
    [
        'dia',
        'hora_inicio',
        'hora_fin',
        'id_actividad'
    ];

    public $timestamps = false;

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }
}
