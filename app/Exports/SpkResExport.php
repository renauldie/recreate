<?php

namespace App\Exports;

use App\Employee;
use App\Period;
use App\EmployeeProcessingData;
use App\Criteria;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SpkResExport implements FromView
{
    protected $period, $jobid;
    public function __construct($period, $jobid) {
        $this->period = $period;
        $this->jobid = $jobid;
    }

    public function view(): View
    {
        $period = $this->period;
        $jobid = $this->jobid;
        
        $empdata = Employee::with([
            'data_emp' => function ($x) use ($period) {
                $x->where('period_id', $period)->orderBy('criteria_id', 'asc');
            }, 
            'spk_res' => function ($x) use ($period) {
               $x->where('period_id', $period)->orderBy('value', 'desc');
            }, 
            'job_type' , 
            'contract' => function ($x) use ($period) {
                $x->where('period_id', $period);
             }
        ])
        ->whereHas('job_type', function ($x) use ($jobid) {
            $x->where('id', $jobid);
        })
        ->get();

        $n = Criteria::where('job_type_id', $jobid)->count();

        return \view('pages.admin.reports.spk', [
            'empdata' => $empdata,
            'n' => $n,
            'jobid' => $jobid
        ]);
    }
}
