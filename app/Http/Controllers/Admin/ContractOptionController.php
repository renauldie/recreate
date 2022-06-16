<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ContractOptions;
use App\Http\Requests\ContractOptionRequest;


class ContractOptionController extends Controller
{
    public function index()
    {
        $items = ContractOptions::all();
        $percentage = ContractOptions::sum('rank_percentage');

        return \view('pages.admin.contract-option.index', [
            'items' => $items,
            'perc' => $percentage,
        ]);
    }

    public function create() {
        $percentage = ContractOptions::sum('rank_percentage');
        return view('pages.admin.contract-option.create', [
            'perc' => $percentage
        ]);
    }

    public function store(ContractOptionRequest $request)
    {
        $data = $request->all();
        // dd($data['rank_percentage']);
        $current = ContractOptions::sum('rank_percentage');
        if($current + $data['rank_percentage'] <= 100) {
            ContractOptions::create($data);
            return redirect()->route('contract-option.index');
        }else {
            return 'error';
        }
    }

    public function destroy($id)
    {
        $item = ContractOptions::findorFail($id);
        $item->delete();
        return redirect()->route('contract-option.index');
    }
}
