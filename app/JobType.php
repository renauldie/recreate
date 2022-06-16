<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobType extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'job_name'
    ];

    protected $hidden =[

    ];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'job_type_id', 'id');
    }


}
