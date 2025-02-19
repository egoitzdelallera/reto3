<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $table = 'monitores';

    protected $fillable = 
    [
        'nombre',
        'apellido',
        'foto',
    ];

    public $timestamps = false;

    public function centroCivico()
    {
        return $this->belongsTo(CentroCivico::class, 'id_centro_civico');
    }
}
