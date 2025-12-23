<?php

namespace App\Http\Controllers;

use App\Models\WorkerInfo;
use Illuminate\Http\Request;

class WorkerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
     {
        $alldata = WorkerInfo::orderBy('id','desc')->get();
        return view('raw-store.worker-info.index', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('raw-store.worker-info.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phn_no' => 'required',
            'address' => 'required'
        ]);

        $worker = new WorkerInfo();
        $worker->name = $request->name;
        $worker->phn_no = $request->phn_no;
        $worker->address = $request->address;
        $worker->nid_no = $request->nid_no;
        $worker->joining_date = $request->joining_date;
        $worker->grade = $request->grade;
        $worker->emargency_phn_no = $request->emargency_phn_no;
        $worker->save();

        $notification = array('message'=>'worker Information Added Successfull', 'alert-type' => 'success');

        return redirect()->route('worker-info.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkerInfo $workerInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkerInfo $workerInfo)
    {
        $worker = WorkerInfo::findOrfail($workerInfo->id);
        $workerInfos = WorkerInfo::all();

        return view('raw-store.worker-info.edit', compact('worker', 'workerInfos'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkerInfo $workerInfo)
    {
        $request->validate([
            'name' => 'required',
            'phn_no' => 'required',
            'address' => 'required'
        ]);

        $worker = WorkerInfo::findOrfail($workerInfo->id);
        $worker->name = $request->name;
        $worker->phn_no = $request->phn_no;
        $worker->address = $request->address;
        $worker->nid_no = $request->nid_no;
        $worker->joining_date = $request->joining_date;
        $worker->grade = $request->grade;
        $worker->emargency_phn_no = $request->emargency_phn_no;
        $worker->update();

        $notification = array('message'=>'worker Information Updated Successfull', 'alert-type' => 'success');

        return redirect()->route('worker-info.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkerInfo $workerInfo)
    {
        $workerInfo->delete($workerInfo->id);

        $notification = array('message'=>'Worker Information Deleted Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }
}
