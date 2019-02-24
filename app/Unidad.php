<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidad extends Model
{
    //
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'unidads';

    protected $dates = [
        'created_at',
        'deleted_at'
      ];
      //guardamos los campos para el log
    protected static $logAtrributes = ['*'];

    public function productos()
    {
        return $this->hasMany('App\Producto');
    }
}
