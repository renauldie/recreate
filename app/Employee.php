<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $table = 'employees';
    protected $fillable =[
        'job_type_id', 'nik', 'name', 'gender',
        'address', 'phone_number', 'image', 'date_of_birth',
        'status'
    ];

    protected $hidden =[

    ];

    
    public function job_type()
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'id');
    }

    public function data_emp()
    {
        return $this->hasMany(EmployeeProcessingData::class, 'employee_id', 'id');
    }

    public function spk_res()
    {
        return $this->hasMany(RankResult::class, 'employee_id', 'id');
    }

    public function contract()
    {
        return $this->hasMany(EmployeeContracts::class, 'employee_id', 'id');
    }
}
