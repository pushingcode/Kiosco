<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Proveedor extends Model
{
    //
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'proveedors';

    protected $dates = [
        'created_at',
        'deleted_at'
      ];

    //guardamos solo el evento delete
    protected static $recordEvents = ['deleted'];
    protected static $logName = 'warning';
}
