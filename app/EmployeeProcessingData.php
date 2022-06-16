<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeProcessingData extends Model
{
    protected $fillable = [
        'criteria_id', 'value', 'employee_id', 'period_id'
    ];

    protected $hidden = [

    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function data_first()
    {
        return $this->hasMany(EmployeeProcessingData::class, 'id', 'first_alternative');
    }

    public function data_second()
    {
        return $this->hasMany(EmployeeProcessingData::class, 'id', 'second_alternative');
    }
}
