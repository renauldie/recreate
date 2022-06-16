<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlternativePriorityVector extends Model
{
    protected $table = 'alternative_priority_vectors';

    protected $fillable = [
        'alternative_id', 'criteria_id', 'period_id', 'value'
    ];
}
