<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EmployeeProcessingData;
use App\Employee;
use App\JobType;
use App\Period;
use App\Criteria;
use App\ComparisonAlternative;
use App\AlternativePriorityVector;
use App\Http\Controllers\Admin\ComparisonCriteriaController;

class EmployeeProcessDataController extends Controller
{
    public function index()
    {

    }

    public function show($id) 
    {
        $period = Period::where('status' , '=', 'ACTIVE')->first();
        if($period == null) {
            $message = 'Tidak ada periode aktif';
            return \view('pages.admin.error.error', [
                'message' => $message,
                'param' => 1
            ]);
        }
        $jobtype = JobType::whereId($id)->first();
        
        $query = Employee::whereHas('job_type', function($query) use ($id) {
            $query->where('id', $id);
        });
        $employees = $query->orderBy('id', 'ASC')->get();
        $n = $query->count('id');
        $countemp = $query->count();
        
        $resemp = [];
        $num = 1;
        foreach ($employees as $emp) {
            $resemp[] = $num++;
        }

        $cquery = Criteria::where('job_type_id', '=', $id)->orderBy('id', 'ASC');
        $criterias = $cquery->get();
        $cn = $cquery->count('id');

        $get = EmployeeProcessingData::with('period', 'employee')
        ->whereHas('period', function ($q) {
            $q->where('status', 'ACTIVE');
        })
        ->whereHas('employee', function ($q) use ($id){
            $q->where('job_type_id', $id);
        })
        ->get();
        
        $his = 0;
        $res = [];
        for ($x=0; $x < $n ; $x++) { 
            for ($y=0; $y < $cn ; $y++) { 
                if (isset($get[$his]->value)) {
                    $res[$x][$y] = $get[$his]->value;
                    $his++;
                }
            }
        }

        return \view('pages.admin.employee-processing-data.index', [
            'employees' => $employees,
            'countemp' => $countemp,
            'resemp' => $resemp,
            'n' => $n,
            'cn' => $cn,
            'job_type' => $jobtype,
            'period' => $period,
            'criterias' => $criterias,
            'res' => $res
        ]);
    }

    public function storePVAlternative($ida, $idc, $periodid, $value)
    {
        // $period = Period::where('status', 'ACTIVE')->first();
        $query = AlternativePriorityVector::where('alternative_id', $ida)
            ->where('criteria_id', $idc)
            // ->where('period_id', $period->id)
            ->where('period_id', $periodid)
            ->first();

        $data = [
            'criteria_id' => $idc,
            'alternative_id' => $ida,
            // 'period_id' => $period->id,
            'period_id' => $periodid,
            'value' => $value
        ];

        if(!$query) {
            return AlternativePriorityVector::create($data);
        } else {
            return AlternativePriorityVector::where('alternative_id', $ida)
            ->where('criteria_id', $idc)
            // ->where('period_id', $period->id)
            ->where('period_id', $periodid)
            ->update(['value' => $value]);
        }
    }

    public function throwAlternative(Request $request)
    {
        $param = $request->param;
        $jobid = $request->job_id;
        $sumCriteria = \App\Helpers\Helper::sumCriteria($jobid);

        if ($sumCriteria > $param && $param > 0) {
            return $this->alternativeProcess($param, $jobid);
        } else {                
            return \redirect()->route('ranking.show', $jobid);
        }
    }

    public function alternativeProcess($param, $jobid)
    {
        $n = \App\Helpers\Helper::sumEmployeeByJob($jobid);
        $criteria_id = \App\Helpers\Helper::getCriteriaId($param, $jobid);
        $cname = Criteria::select('criteria_name')->where('id', $criteria_id)->first();
        $period = Period::where('status' , '=', 'ACTIVE')->first();

        $query = Employee::with(['job_type', 'data_emp' => function ($q) use ($criteria_id) {
            $q->where('criteria_id', $criteria_id);
        }])
            ->where('job_type_id', '=', $jobid)
            ->orderBy('id');
        
        $data = $query->get();

        $matrix = array();
        $num = 0;

        for($x=0; $x <= ($n-2) ; $x++){
            for ($y=($x+1); $y <= ($n-1) ; $y++) {
                $value = $data[$x]->data_emp[0]->value/$data[$y]->data_emp[0]->value;

                // echo '<pre>';
                // echo '0 ' . $data[$x]->name . ' - 0 ' . $data[$y]->name . ' = ' . $data[$x]->data_emp[0]->value . ' ' . $data[$y]->data_emp[0]->value . ' => '. \round($value, 5);
                // echo '</pre>';
                if($data[$x]->data_emp[0]->value >= $data[$y]->data_emp[0]->value) {
                    $matrix[$x][$y] = $value;
                    $matrix[$y][$x] = 1/$value;
                } else if($data[$x]->data_emp[0]->value <= $data[$y]->data_emp[0]->value) {
                    $matrix[$x][$y] = 1/$value;
                    $matrix[$y][$x] = $value;
                } else if($data[$x]->data_emp[0]->value == $data[$y]->data_emp[0]->value) {
                    $matrix[$y][$x] = 1;
                }

                $first = $data[$x]->data_emp[0]->id;
                $second = $data[$y]->data_emp[0]->id;
                $compare = $criteria_id;

                $this->storeAlternative($first, $second, $jobid, $matrix[$x][$y], $period->id, $compare);
            }
        }

        //diagonal side
        for ($i = 0; $i <= ($n-1); $i++) {
            $matrix[$i][$i] = 1;
        }

        //initialization to column and row
        $countrow = array();
        $countcol = array();
        for ($i=0; $i <= ($n-1); $i++) {
            $countrow[$i] = 0;
            $countcol[$i] = 0;
        }

        // sum alternative column at comparison table
        for ($x=0; $x <= ($n-1) ; $x++) {
            for ($y=0; $y <= ($n-1) ; $y++) {
                $val		= $matrix[$y][$x];
                $countrow[$x] += $val;
            }
        }

        //sum collumn value alternative matrix table 
        //matrix_n is normalized matrix
        for ($x=0; $x <= ($n-1) ; $x++) {
            for ($y=0; $y <= ($n-1) ; $y++) {
                $matrix_n[$x][$y] = $matrix[$x][$y] / $countrow[$y];
                $val	= $matrix_n[$x][$y];
                $countcol[$x] += $val;
            }

            //prioroty value
            $pvalue[$x] = $countrow[$x]/$n;

            $alternative_id = \App\Helpers\Helper::getAlternativeId($x, $jobid);
            $this->storePVAlternative($alternative_id, $criteria_id, $period->id, \round($pvalue[$x], 5));
        }

        $comcc = new ComparisonCriteraController();
        //consistency checking
        $eignVector = $comcc->getEignVector($countcol, $countrow, $n);
        $constIndex = $comcc->getConstIndex($countcol, $countrow, $n);
        $constRatio = $comcc->getConstRatio($countcol, $countrow, $n);

        return view('pages.admin.alternative-comparison.index', [
            'n' => $n,
            'param' => $param,
            'cname' => $cname,
            'jobid' => $jobid,
            'matrix' => $matrix,
            'matrix_n' => $matrix_n,
            'countrow' => $countrow,
            'countcol' => $countcol,
            'pvalue' => $pvalue,
            'eign_vector' => $eignVector,
            'const_index' => $constIndex,
            'const_ratio' => $constRatio
        ]);
    }

    public function create(Request $request) 
    {
        $jobid = $request->job_id;
        $n = \App\Helpers\Helper::sumEmployeeByJob($jobid);
        $cn = \App\Helpers\Helper::countCriteriaById($jobid);

        //input employee attributes data

        for ($x = 0; $x < $n; $x++){
            $emp_id = 'emp_id' . $x;
            if($x == $n){
                break;
            }

            for ($y = 0; $y < ($cn); $y++){
                $value = 'attr' . $x . $y;
                $criteria_id = \App\Helpers\Helper::getCriteriaId($y, $jobid);
                $data = [   
                    'criteria_id' => $criteria_id,
                    'employee_id' => $request->$emp_id,
                    'period_id' => $request->period_id,
                    'value' => $request->$value,
                ];

                $check = EmployeeProcessingData::where('employee_id', '=', $request->$emp_id)
                        ->where('period_id', '=', $request->period_id)
                        ->where('criteria_id', '=', $criteria_id)
                        ->first();

                if($check) {
                    EmployeeProcessingData::where('employee_id', '=', $request->$emp_id)
                        ->where('period_id', '=', $request->period_id)
                        ->where('criteria_id', '=', $criteria_id)
                        ->update(['value' => $request->$value]);
                } else {
                    EmployeeProcessingData::create($data);
                }
            }
        }

        $param = 0;
        return $this->alternativeProcess($param, $jobid);
    }

    public function storeAlternative($first, $second, $jobid, $value, $period, $compare) 
    {   
        $query = ComparisonAlternative::where('first_alternative', '=', $first)
        ->where('second_alternative', '=', $second)
        ->where('job_type_id', '=', $jobid)
        ->where('comparison', '=', $compare)
        ->where('period_id', $period)
        ->count();

        $data = [
            'first_alternative' => $first,
            'second_alternative' => $second,
            'job_type_id' => $jobid,
            'value' => $value,
            'period_id' => $period,
            'comparison' => $compare
        ];
        
        if($query == 0) {
            return ComparisonAlternative::create($data);
        } else {
            return ComparisonAlternative::where('first_alternative', '=', $first)
            ->where('second_alternative', '=', $second)
            ->where('period_id', $period)
            ->where('job_type_id', $jobid)
            ->where('comparison', '=', $compare)
            ->update(['value' => $value]);
        }
    }

    public function process(Request $request) 
    {
        return 'hello';
    }




}
