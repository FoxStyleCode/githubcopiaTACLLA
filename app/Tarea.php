<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = ['nombre_tarea', 'tipo_de_proyecto_id', 'area_id'];
}
