<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Criteria;
use App\JobType;
use App\Http\Requests\CriteriaRequest;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Criteria::with(['job_type'])->get();
        return \view('pages.admin.criteria.index',[
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobs = JobType::all();
        return view('pages.admin.criteria.create', [
            'jobs' => $jobs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CriteriaRequest $request)
    {
        $data = $request->all();
        Criteria::create($data);

        return \redirect()->route('criteria.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $criteria = Criteria::with('job_type')->findOrFail($id);
        $jobs = JobType::all();
        return view('pages.admin.criteria.edit', [
            'criteria' => $criteria,
            'jobs' => $jobs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CriteriaRequest $request, $id)
    {
        $data = $request->all();

        $criteria = Criteria::findOrFail($id);

        $criteria->update($data);

        return redirect()->route('criteria.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Criteria::findorFail($id);
        $item->delete();
        return redirect()->route('criteria.index');
    }
}
