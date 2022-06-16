<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComparisonAlternative extends Model
{
    protected $table = 'comparison_alternatives';

    protected $fillable = [
        'first_alternative', 'second_alternative', 'comparison', 'value', 'job_type_id', 'period_id'
    ];
    
}
