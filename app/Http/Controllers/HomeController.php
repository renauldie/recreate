<?php

namespace App\Http\Controllers;

use App\Employee;
use App\JobType;
use App\Period;
use Illuminate\Http\Request;
use DB;


class HomeController extends Controller
{
    public function index()
    {
        $query = JobType::query();
        $jobs = $query->with(['employee' => function ($x) {
            $x->select('job_type_id', DB::raw('count(*) as total'))
                ->groupBy('job_type_id')
                ->where('status', 'ACTIVE');
        },])
            ->groupBy('id')
            ->orderBy('id', 'ASC')
            ->get();

        return view('pages.home', [
            'jobs' => $jobs,
        ]);
    }

    public function show($id)
    {
        $period = Period::where('status', 'ACTIVE')->first();
        $periodid = $period->id;
        $employee = Employee::with(['contract', 'job_type'])
            ->whereHas('job_type', function ($x) use ($id) {
                $x->where('id', $id);
            })
            ->whereHas('contract', function ($x) use ($periodid) {
                $x->where('period_id', $periodid);
            })
            ->where('status', 'ACTIVE')
            ->get();

        return view('pages.employee', [
            'employee' => $employee
        ]);
    }
}
