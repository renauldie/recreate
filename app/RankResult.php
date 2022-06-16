<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RankResult extends Model
{
    protected $table = 'rank_results';

    protected $fillable = [
        'employee_id', 'value', 'period_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
