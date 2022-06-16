<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\JobType;
use App\Period;
use App\EmployeeProcessingData;
use App\ComparisonAlternative;
use App\AlternativePriorityVector;
use App\EmployeeContracts;
use App\RankResult;
use Illuminate\Support\Str;
use \App\Http\Requests\EmployeeRequest;
use Maatwebsite\Excel\Facades\Excel;

use Session;

use \App\Imports\EmployeeImport;

class EmployeeController extends Controller
{
    public function index() 
    {
        $period = Period::where('status', '=', 'ACTIVE')->first();
        
        if($period == null) {
            $message = 'Tidak ada periode aktif';
            return \view('pages.admin.error.error', [
                'message' => $message,
                'param' => 1
            ]);
        }
        $items = Employee::with(['job_type'])->get();
        return view('pages.admin.employee.index',[
            'items' => $items
        ]);
    }

    public function show($id) 
    {
        $item = Employee::with(['job_type'])->find($id);
        return response()->json($item);
    }

    public function create() 
    {
        $jobs = JobType::all();
        return view('pages.admin.employee.create',[
            'jobs' => $jobs
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        $data['image'] = '-';
        $data = $request->all();
        Employee::create($data);
        return redirect()->route('employee.index');
    }

    public function edit($id)
    {
        $jobs = JobType::all();
        $employee = Employee::with(['job_type'])->findOrFail($id);
        return \view('pages.admin.employee.edit',[
            'jobs' => $jobs,
            'employee' => $employee
        ]);
    }

    public function update(EmployeeRequest $request, $id)
    {
        $data = $request->all();

        $data['image'] = $request->image;

        $employee = Employee::findOrFail($id);
        
        if ($data['image'] != null) {
            $data['image'] = $request->file('image')->store('assets/gallery', 'public');
        } else {
            $data['image'] = $employee->image;
        }

        $employee->update($data);

        return \redirect()->route('employee.index');
    }
    
    public function destroy($id)
    {   
        $period = Period::where('status', 'ACTIVE')->first();
        $item = Employee::findorFail($id);
        $procesdata = EmployeeProcessingData::query()
            ->where('employee_id', $id)
            ->where('period_id', $period->id);
        $getPDId = $procesdata->get();
        
        $pdId = [];
        foreach ($getPDId as $key) {
            $pdId[] = $key->id;
        }

        $ca1 = ComparisonAlternative::whereIn('first_alternative', $pdId)->where('period_id', $period->id);
        $ca2 = ComparisonAlternative::whereIn('second_alternative', $pdId)->where('period_id', $period->id);
        
        $pv = AlternativePriorityVector::where('alternative_id', $id)->where('period_id', $period->id);
        $contract = EmployeeContracts::where('employee_id', $id)->where('period_id', $period->id);
        $rank = RankResult::where('employee_id', $id)->where('period_id', $period->id);
        
        $ca1->delete();
        $ca2->delete();
        $procesdata->delete();
        $pv->delete();
        $contract->delete();
        $rank->delete();
        $item->delete();
        return redirect()->route('employee.index');
    }

    public function import(Request $request) 
	{
		//validation
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		//get excel file
		$file = $request->file('file');
 
		//make file name
		$filename = rand().$file->getClientOriginalName();

        //upload to file employee
		$file->move('file_employee',$filename);

        //Imprt data
		Excel::import(new EmployeeImport, public_path('/file_employee/'.$filename));

        //Notification with flash
		Session::flash('sukses','Data Karyawan Berhasil Diimport!');

        return redirect()->route('employee.index');
    }
}
