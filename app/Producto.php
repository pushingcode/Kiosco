<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    //guardamos solo el evento delete
    protected static $recordEvents = ['deleted'];
    protected static $logName = 'warning';

    
    public function categoria()
    {
      return $this->BelongsTo('App\Categoria', 'categorias_id');
    }

    public function unidad()
    {
      return $this->BelongsTo('App\Unidad', 'unidads_id');
    }
}
