<?php

namespace App\Helpers;

use App\JobType;
use App\Criteria;
use App\ComparisonCriterias;
use App\ComparisonAlternative;
use App\IndexRatios;
use App\Employee;
use App\Period;
use App\AlternativePriorityVector;
use App\CriteriaPriorityVector;
use App\ContractOptions;
use App\EmployeeContracts;

class Helper
{
    static function getJobType() 
    {
        $query = JobType::query();
        $job_type = $query->orderBy('job_name', 'asc')->get();
        return $job_type;
    }

    static function sumCriteria($id) 
    {
        $query = Criteria::query();
        $criteria = $query->where('job_type_id', '=', $id)->count('id');
        return $criteria;
    }

    //search id by order
    static function getCriteriaId($num, $id)
    {
        $query = Criteria::select('id')->where('job_type_id', '=', $id)->orderBy('id', 'ASC')->get();

        foreach ($query as $q) {
            $res[] = $q->id;
        }

        return $res[$num];
    }

    static function getCompareCriteriaValue($criteria1, $criteria2)
    {
        $value = ComparisonCriterias::where('first_criteria', '=', $criteria1)
        ->where('second_criteria', '=', $criteria2) 
        ->first();

        if ($value) return $value->value;
        else return null;
    }

    static function countCriteriaById($id)
    {
        $query = Criteria::with('job_type')
                ->where('job_type_id', '=', $id)
                ->orderBy('id');
        //total criteria
        $n = $query->count('criteria_name');

        return $n;
    }

    static function getCriteriaName($num, $id)
    {
        $query = Criteria::where('job_type_id', '=', $id)->get();
        
        foreach ($query as $q) {
            $res[] = $q->criteria_name; 
        }
        return $res[$num];
    }

    static function getIndexRatio($count)
    {
        $value = IndexRatios::where('total_criteria', '=', $count)->first();
        return $value->value;
    }

    static function sumEmployeeByJob($id)
    {
        $count = Employee::where('job_type_id', '=', $id)->count();
        return $count;
    }

    static function getEmployeeName($num, $id)
    {
        $query = Employee::where('job_type_id', $id)->get();
        foreach ($query as $q) {
            $res[] = $q->name; 
        }
        return $res[$num];
    }

    static function countAlternativeById($id) 
    {
        $query = Employee::where('job_type_id', $id);

        $n = $query->count('id');

        return $n;
    }

    static function checkAlterCompare($id)
    {
        $activePeriod = Period::where('status', '=', 'ACTIVE')->first();
        $count = ComparisonAlternative::where('job_type_id', $id)
            ->where('period_id', $activePeriod->id)
            ->count();
        
        return $count;
    }

    static function getAlternativeId($num, $id) 
    {
        $query = Employee::select('id')->where('job_type_id', '=', $id)->orderBy('id', 'ASC')->get();

        foreach ($query as $q) {
            $res[] = $q->id;
        }

        return $res[$num];
    }

    static function getAlternativeName($num, $id) 
    {
        $query = Employee::select('name')->where('job_type_id', '=', $id)->orderBy('id', 'ASC')->get();

        foreach ($query as $q) {
            $res[] = $q->name;
        }

        return $res[$num];
    }

    static function getAlternativePV($alternative_id, $criteria_id)
    {
        $activePeriod = Period::where('status', '=', 'ACTIVE')->first();

        $query = AlternativePriorityVector::where('alternative_id', '=', $alternative_id)
            ->where('criteria_id', '=', $criteria_id)
            ->where('period_id', '=', $activePeriod->id)
            ->get();
        
        foreach ($query as $q) {
            $res = $q->value;
        }

        return $res;
    }

    static public function getCriteriaPV($id)
    {
        // $activePeriod = Period::where('status', '=', 'ACTIVE')->first();
        
        $query = CriteriaPriorityVector::where('id', $id)->get();
        
        foreach ($query as $q) {
            $res = $q->value;
        }

        return $res;
    }

    static function empContract($num, $total)
    {
        $percentage = ContractOptions::all();

        $param = ($num * 100) / 10;
        $res = 0;
        foreach ($percentage as $key) {
            if($key->rank_percentage >= $param){
                return $res = $key->contract;
                break;
            }
        }
    }

    static function getStartContract($id)
    {
        $activePeriod = Period::where('status', '=', 'ACTIVE')->first();

        $empContract = EmployeeContracts::query()
            ->where('employee_id', '=', $id)
            ->where('period_id', '=', $activePeriod->id);
            
        $start = $empContract->pluck('start_contract')->first();
        $end = $empContract->pluck('end_contract')->first();

        $data= [
            $start, $end
        ];
        // dd($empContract);
        return $data;
    }

}