<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'start_date', 'end_date', 'status'
    ];

    protected $hidden =[

    ];

}
