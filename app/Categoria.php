<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Categoria extends Model
{
    //
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'categorias';

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
