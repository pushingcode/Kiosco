<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    //
    protected $table = 'ejercicios';

    protected $dates = [
        'created_at',
        'deleted_at'
      ];
}
