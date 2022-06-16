<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JobType;

class JobTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $items = JobType::all();
        return \view('pages.admin.jobtype.index', [
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $items = JobType::all();
        return response()->json($items);
    }

    public function edit($id)
    {
        $item = JobType::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);

        JobType::create($data);
        return response()->json('ok');
    }

    public function update(Request $request, $id)
    {
        JobType::whereId($id)->update([
            'job_name' => $request->jobName,
        ]);

        return response()->json('ok');
    }

    public function destroy($id)
    {
        $item = JobType::find($id);
        $item->delete();
        return response()->json('ok');
    }


}
