<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaPriorityVector extends Model
{
    protected $fillable = [
        'criteria_id', 'value'
    ];

    public function criteria()
    {
        return $this->hasOne(Criteria::class, 'id', 'criteria_id');
    }
}
