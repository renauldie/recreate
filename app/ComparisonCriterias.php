<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ComparisonCriterias extends Model
{
    use softDeletes;

    protected $table = 'comparison_criterias';

    protected $fillable = [
        'first_criteria', 'second_criteria', 'value', 'job_type_id'
    ];  

    protected $hidden = [

    ];
}
