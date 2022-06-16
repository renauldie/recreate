<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RankResult;
use App\JobType;
use App\Period;
use App\Employee;
use App\EmployeeContracts;
use App\CriteriaPriorityVector;
use Illuminate\Http\Request;
use Session;

class RankResultController extends Controller
{
    public function index() 
    {
        $items = JobType::all();
        return view('pages.admin.ranking.show',[
            'items' => $items
        ]);
    }
    public function show($id)
    {
        $activePeriod = Period::where('status', '=', 'ACTIVE')->first();
        if($activePeriod == null) {
            $message = 'Tidak ada periode aktif';
            return \view('pages.admin.error.error', [
                'message' => $message,
                'param' => 1
            ]);
        }

        $n = \App\Helpers\Helper::countAlternativeById($id);
        $job = JobType::find($id);
        $pvCriteria = CriteriaPriorityVector::selectRaw('criteria_priority_vectors.id, criteria_priority_vectors.value')
        ->join('criterias', 'criterias.id', '=', 'criteria_priority_vectors.criteria_id')
        ->where('criterias.job_type_id', $id);

        $pvcData = $pvCriteria->get();
        
        $countAlternative = \App\Helpers\Helper::countAlternativeById($id);
        $countCriteria = \App\Helpers\Helper::sumCriteria($id);
        $getComparisonAlt = \App\Helpers\Helper::checkAlterCompare($id);
        $value = [];

        $message = 'Tidak ada perhitungan alternatif';
        if ($countAlternative == 0) {
            return \view('pages.admin.error.error', [
                'message' => $message,
                'param' => 2
            ]);
        }

        if($getComparisonAlt == 0){
            return \view('pages.admin.error.error', [
                'message' => $message,
                'param' => 2
            ]);
        }

        //get alternative value
        for ($x=0; $x <=$countAlternative-1 ; $x++) { 
            $value[$x] = 0;

            for ($y=0; $y < $countCriteria-1; $y++) { 
                $alternateId = \App\Helpers\Helper::getAlternativeId($x, $id);
                $criteriaId = \App\Helpers\Helper::getCriteriaId($y, $id);

                $pv_alternative = \App\Helpers\Helper::getAlternativePV($alternateId, $criteriaId);
                $pv_criteria = \App\Helpers\Helper::getCriteriaPV($id);

                $value[$x] += ($pv_alternative * $pv_criteria);
            }
        }

        //create or update ranking
        for ($x=0; $x <= $countAlternative-1 ; $x++) { 
            $alternateId = \App\Helpers\Helper::getAlternativeId($x, $id);

            $query = RankResult::where('employee_id', $alternateId)
                ->where('period_id', $activePeriod->id)
                ->first();

            $data = [
                'employee_id' => $alternateId,
                'value' => $value[$x],
                'period_id' => $activePeriod->id
            ];

            if(!$query) {
                $query = RankResult::updateOrCreate($data);
            } else {
                RankResult::where('employee_id', $alternateId)
                ->where('period_id', $activePeriod->id)
                ->update(['value' => $value[$x]]);
            }        
        }

        $result = RankResult::whereHas(
            'employee', function($x) use ($id) {
                $x->where('job_type_id', '=', $id);
            })
            ->where('period_id', $activePeriod->id)
            ->orderBy('value', 'DESC')
            ->get();

        return view('pages.admin.ranking.index' ,[
            'n' => $n,
            'jobid' => $id,
            'job' => $job,
            'pvCriteria' => $pvcData,
            'value' => $value,
            'result' => $result,
            'totalAlt' => $countAlternative,
            'period' => $activePeriod
        ]);
    }

    public function addContract($empid, $contract)
    {
        $activePeriod = Period::where('status', '=', 'ACTIVE')->first();
        $startcontract = date('Y-m-d');
        $endcontract = date('Y-m-d', strtotime("+$contract month"));

        $query = EmployeeContracts::where('employee_id', $empid)
            ->where('period_id', $activePeriod->id)
            ->first();

        $data = [
            'start_contract' => $startcontract,
            'end_contract' => $endcontract,
            'period_id' => $activePeriod->id,
            'employee_id' => $empid
        ];
        if(!$query) {
            EmployeeContracts::create($data);
        } else {
            EmployeeContracts::where('employee_id', $empid)
            ->where('period_id', $activePeriod->id)
            ->update([
                'start_contract' => $startcontract,
                'end_contract' => $endcontract
            ]);
        }
    }

    public function create(Request $request)
    {
        $n = $request->totalemp;

        for ($x=1; $x <= $n ; $x++) { 
            $empid = 'empid-' . $x;
            $contract = 'contract-' . $x;

            $this->addContract($request->$empid, $request->$contract);
        }

        return redirect()->route('employee.index');
    }
}
