<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $table = 'configs';

    protected $dates = [
        'created_at',
        'deleted_at'
      ];
}
