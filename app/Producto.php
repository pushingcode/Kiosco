<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    //
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'productos';

    protected $dates = [
        'created_at',
        'deleted_at'
      ];
      //guardamos los campos para el log
    protected static $logAtrributes = ['*'];
}
