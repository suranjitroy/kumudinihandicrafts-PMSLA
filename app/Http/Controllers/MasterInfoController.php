<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\MasterInfo;
use Illuminate\Http\Request;

class MasterInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masterInfos = MasterInfo::all();

        return view('raw-store.master.index', compact('masterInfos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $master = new MasterInfo();
        $master->name = $request->name;
        $master->phn_no = $request->phn_no;
        $master->save();

        $notification = array('message'=>'Master Information Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterInfo $masterInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterInfo $masterInfo)
    {
       $master = MasterInfo::findOrfail($masterInfo->id);
       $masterInfos = MasterInfo::all();

       return view('raw-store.master.edit', compact('master', 'masterInfos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterInfo $masterInfo)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $master = MasterInfo::findOrfail($masterInfo->id);
        $master->name   = $request->name;
        $master->phn_no = $request->phn_no;
        $master->update();

        $notification = array('message'=>'Master Information Updated Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterInfo $masterInfo)
    {
        $masterInfo->delete($masterInfo->id);

        $notification = array('message'=>'Master Information Deleted Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }
}
