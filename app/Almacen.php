<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    //
    protected $table = 'almacens';

    protected $dates = [
        'created_at',
        'deleted_at'
      ];
}
