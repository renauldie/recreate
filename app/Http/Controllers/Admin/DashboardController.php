<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Period;
use App\IndexRatios;
use App\Employee;
use App\Criteria;
use App\JobType;


class DashboardController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() 
    {
      $items = Period::all();

      $ir_value = IndexRatios::all();

      $employees = Employee::all()->count();
      $periods = Period::all()->count();
      $criterias = Criteria::all()->count();
      $jobtypes = JobType::all()->count();

      return view('pages.admin.dashboard',[
        'items' => $items,
        'ir_value' => $ir_value,
        'criterias' => $criterias,
        'jobtypes' => $jobtypes,
        'periods' => $periods,
        'employee' => $employees
      ]);
    }
}
