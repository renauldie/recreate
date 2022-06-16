<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
    use softDeletes;

    protected $table = 'criterias';

    protected $fillable = [
        'criteria_name', 'job_type_id'
    ];

    protected $hidden =[

    ];

    public function job_type()
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'id');
    }
}
