<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PeriodRequest;
use Illuminate\Support\Facades\DB;


use \App\Period;
use \App\AlternativePriorityVector;
use \App\ComparisonAlternative;
use \App\EmployeeContracts;
use \App\EmployeeProcessingData;

class PeriodController extends Controller
{
    public function store(Request $request) 
    {
        DB::table('periods')->update(['status' => 'DEACTIVE']);
        Period::create([
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'status' => $request->status,
        ]);
        return response()->json('ok');
    }

    public function index() 
    {
        $periods = Period::all();
        return response()->json($periods);
    }

    public function destroy($id) 
    {
        $item = Period::findOrFail($id);
        $item->delete();
        return response()->json('ok');
    }

    public function show($id) 
    {   
        $item = Period::find($id);
        return response()->json($item);
    }

    public function update(Request $request, $id) 
    {
        $data = $request->all();
        // dd($data['status']);
        if($data['status'] == 'ACTIVE') {
            // Period::update(['status' => 'DEACTIVE']);
            DB::table('periods')->update(['status' => 'DEACTIVE']);
        }
        
        Period::whereId($id)->update([
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'status' => $request->status,
        ]);

        return response()->json('ok');
    }
}
