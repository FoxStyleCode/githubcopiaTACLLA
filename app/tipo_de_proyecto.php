<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_de_proyecto extends Model
{
    protected $table = 'tipo_de_proyectos';

    protected $fillable = ['nombre'];
}
