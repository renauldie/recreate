<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Criteria;
use App\ComparisonCriterias;
use App\CriteriaPriorityVector;
use Illuminate\Support\Facades\DB;

class ComparisonCriteraController extends Controller
{
    public function index()
    {
        return view('pages.admin.criteria-comparison.process');
    }

    private function storeCriteria($criteria1 , $criteria2, $value, $id) 
    {
        $id_criteria1 = \App\Helpers\helper::getCriteriaId($criteria1, $id);
        $id_criteria2 = \App\Helpers\helper::getCriteriaId($criteria2, $id);

        $query = ComparisonCriterias::where('first_criteria', '=', $id_criteria1)
        ->where('second_criteria', '=', $id_criteria2)
        ->count();

        $data = [
            'first_criteria' => $id_criteria1,
            'second_criteria' => $id_criteria2,
            'value' => $value,
            'job_type_id' => $id
        ];
        
        if($query == 0) {
            return ComparisonCriterias::create($data);
        } else {
            return ComparisonCriterias::where('first_criteria', '=', $id_criteria1)
                    ->where('second_criteria', '=', $id_criteria2)
                    ->update(['value' => $value]);
        }
    }

    private function storePVCriteria($id, $value)
    {
        $query = CriteriaPriorityVector::where('criteria_id', '=', $id)
                ->first();

        $data = [
            'criteria_id' => $id,
            'value' => $value
        ];
        
        if (!$query) {
            return CriteriaPriorityVector::create($data);
        } else {
            return CriteriaPriorityVector::where('criteria_id', '=', $id)
                        ->update(['value' => $value]);
        }
    }

    function getEignVector($matrixa, $matrixb, $n)
    {
        $eignVector = 0;
        for ($x = 0; $x <= ($n-1) ; $x ++) { 
            $eignVector += ($matrixa[$x] * ($matrixb[$x] / $n));
        }

        return $eignVector;
    }

    function getConstIndex($matrixa, $matrixb, $n)
    {
        $eignVector = $this->getEignVector($matrixa, $matrixb, $n);
        $constIndex = ($eignVector - $n) / ($n - 1);

        return $constIndex;
    }

    function getConstRatio($matrixa, $matrixb, $n)
    {
        $constIndex = $this->getConstIndex($matrixa, $matrixb, $n);
        $constRatio = $constIndex / (\App\Helpers\Helper::getIndexRatio($n));

        return $constRatio;
    }

    public function create(Request $request)
    {
        $id = $request->id;
        $n = \App\Helpers\Helper::sumCriteria($id);

        $matrix = array();
        $param = 0;
        
        for($x=0; $x <= ($n-2) ; $x++){
            for ($y=($x+1); $y <= ($n-1) ; $y++) {
                $param++;
                $choose = 'choose' . $param;
                $value = 'value' . $param;

                $rval = $request->$value;

                if ($request->$choose == 1) {
                    $matrix[$x][$y] = $request->$value;
                    $matrix[$y][$x] = 1/$rval;
                } else {
                    $matrix[$x][$y] = 1/$rval;
                    $matrix[$y][$x] = $request->$value;
                }
                
                $this->storeCriteria($x, $y, $matrix[$x][$y], $id);
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

        // sum criteria column at comparison table
        for ($x=0; $x <= ($n-1) ; $x++) {
            for ($y=0; $y <= ($n-1) ; $y++) {
                $val		= $matrix[$y][$x];
                $countrow[$x] += $val;
            }
        }

        //sum collumn value criteria matrix table 
        //matrix_n is normalized matrix
        for ($x=0; $x <= ($n-1) ; $x++) {
            for ($y=0; $y <= ($n-1) ; $y++) {
                $matrix_n[$x][$y] = $matrix[$x][$y] / $countrow[$y];
                $val	= $matrix_n[$x][$y];
                $countcol[$x] += $val;
            }

            //prioroty value
            $pvalue[$x] = $countrow[$x]/$n;

            $id_criteria = \App\Helpers\Helper::getCriteriaId($x, $id);
            $this->storePVCriteria($id_criteria, \round($pvalue[$x], 5));
        }

        //consistency checking
        $eignVector = $this->getEignVector($countcol, $countrow, $n);
        $constIndex = $this->getConstIndex($countcol, $countrow, $n);
        $constRatio = $this->getConstRatio($countcol, $countrow, $n);

        return view('pages.admin.criteria-comparison.process', [
            'id' => $id,
            'n' => $n,
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

    public function show($id)
    {
        $query = Criteria::with('job_type')
                ->where('job_type_id', '=', $id)
                ->orderBy('id');
        
        $data = $query->get();
        $job = $query->first();
        //total criteria
        $n = $query->count('criteria_name');
        //if exist value at comparison

        return \view('pages.admin.criteria-comparison.index',[
            'data' => $data,
            'job' => $job,
            'n' => $n,
        ]);
    }

    public function update()
    {

    }


}
