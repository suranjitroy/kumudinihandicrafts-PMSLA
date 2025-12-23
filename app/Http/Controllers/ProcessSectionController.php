<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessSection;
use Illuminate\Support\Facades\Auth;

class ProcessSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processSections = ProcessSection::all();

        return view('raw-store.process-section.index', compact('processSections'));
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

        $processSection = new ProcessSection();
        $processSection->name = $request->name;
        $processSection->user_id  = Auth::user()->id;
        $processSection->created_by = Auth::user()->user_name;
        $processSection->save();

        $notification = array('message'=>'Process Section Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProcessSection $processSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProcessSection $processSection)
    {
        $processSection = ProcessSection::findOrfail($processSection->id);
        $processSections = ProcessSection::all();

       return view('raw-store.process-section.edit', compact('processSection', 'processSections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProcessSection $processSection)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $processSection = ProcessSection::find($processSection->id);
        $processSection->name = $request->name;
        $processSection->user_id  = Auth::user()->id;
        $processSection->updated_by = Auth::user()->user_name;
        $processSection->update();
        
        $notification = array('message'=>'Process Section Update Successfull', 'alert-type' => 'success');
        return redirect()->route('process-section.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProcessSection $processSection)
    {
        $processSection->delete($processSection->id);

        $notification = array('message'=>'Process Section Delete Successfull', 'alert-type' => 'success');

        return redirect()->route('process-section.index')->with($notification);
    }
}
