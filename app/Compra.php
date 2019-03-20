<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compra extends Model
{
    //
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'compras';

    protected $dates = [
        'created_at',
        'deleted_at'
      ];

    protected $cast = [
      'id'      => 'int',
      'payload' => 'array'
    ];

    //guardamos solo el evento delete 01340195161953038912  25942169
    protected static $recordEvents = ['deleted'];
    protected static $logName = 'warning';
}
