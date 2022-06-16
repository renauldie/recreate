<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'job_type_id' => $row[0], 
            'nik' => $row[1], 
            'name' => $row[2], 
            'gender' => $row[3], 
            'address' => $row[4], 
            'phone_number' => $row[5], 
            // 'image' => $row[6], 
            'date_of_birth' => $row[6],
            'status' => $row[7]
        ]);
    }
}
