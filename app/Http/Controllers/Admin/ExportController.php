<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Period;
use App\EmployeeProcessingData;
use App\Employee;
use App\Criteria;
use App\Exports\SpkResExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function spk(Request $request)
    {
        $period = $request->period;
        $jobid = $request->jobid;
        $filename = 'Hasil SPK PT Madu Baru ' . date('Y-m-d').'.xlsx';
        return Excel::download(new SpkResExport($period, $jobid), $filename);

        // $empdata = Employee::with([
        //     'data_emp' => function ($x) use ($period) {
        //         $x->where('period_id', $period)->orderBy('criteria_id', 'asc');
        //     }, 
        //     'spk_res' => function ($x) use ($period) {
        //        $x->where('period_id', $period)->orderBy('value', 'desc');
        //     }, 
        //     'job_type' , 
        //     'contract' => function ($x) use ($period) {
        //         $x->where('period_id', $period);
        //      }
        // ])
        // ->whereHas('job_type', function ($x) use ($jobid) {
        //     $x->where('id', $jobid);
        // })
        // ->get();

        // $n = Criteria::where('job_type_id', $jobid)->count();

        // return \view('pages.admin.reports.spk', [
        //     'empdata' => $empdata,
        //     'n' => $n,
        //     'jobid' => $jobid
        // ]);
    }
}
