<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeContracts extends Model
{
    protected $table = 'employee_contracts';

    protected $fillable = [
        'period_id', 'employee_id', 'start_contract', 'end_contract'
    ];
}
