<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessSection;
use App\Models\EmbroideryOrder;
use Illuminate\Support\Facades\Auth;
use App\Models\EmbroideryOrderProcessing;
use App\Models\EmbroideryOrderReceive;

class EmbroideryOrderProcessingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processings = EmbroideryOrderProcessing::latest()->get();
        return view('raw-store.embroidery-process.index', compact('processings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $embOrders = EmbroideryOrderReceive::with('embroideryOrder')->get();
        $processSections = ProcessSection::all();
        return view('raw-store.embroidery-process.create', compact('embOrders','processSections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'entry_date' => 'required',
            'embroidery_order_id' => 'required',
            'process_section_id' => 'required',
            'dispatch_quantity' => 'required|numeric',
        ]);

        EmbroideryOrderProcessing::create([
            'entry_date' => $request->entry_date,
            'embroidery_order_id' => $request->embroidery_order_id,
            'process_section_id' => $request->process_section_id,
            'dispatch_quantity' => $request->dispatch_quantity,
            'remark' => $request->remark,
            'user_id' => Auth::user()->id,
            'created_by' => Auth::user()->user_name
            
        ]);

        //dd($test);

        // return redirect()->route('processing.index')
        //     ->with('success','Data inserted successfully');

        $notification = array('message'=>'Embroidery Order Process Successfull', 'alert-type' => 'success');

        return redirect()->route('embroidery-process.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmbroideryOrderProcessing $embroideryOrderProcessing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $processing = EmbroideryOrderProcessing::findOrFail($id);
        $embOrders = EmbroideryOrderReceive::with('embroideryOrder')->get();
        $processSections = ProcessSection::all();

        return view('raw-store.embroidery-process.edit', compact('processing','embOrders','processSections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'entry_date' => 'required',
            'embroidery_order_id' => 'required',
            'process_section_id' => 'required',
            'dispatch_quantity' => 'required|numeric',
        ]);

        $processing = EmbroideryOrderProcessing::findOrFail($id);

        $processing->update([
            'entry_date' => $request->entry_date,
            'embroidery_order_id' => $request->embroidery_order_id,
            'process_section_id' => $request->process_section_id,
            'dispatch_quantity' => $request->dispatch_quantity,
            'remark' => $request->remark,
            'user_id' => Auth::user()->id,
            'updated_by' => Auth::user()->user_name
        ]);

        // return redirect()->route('processing.index')
        //     ->with('success','Data updated successfully');

        $notification = array('message'=>'Embroidery Order Process Updated Successfull', 'alert-type' => 'success');

        return redirect()->route('embroidery-process.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        EmbroideryOrderProcessing::findOrFail($id)->delete();

        $notification = ['message' => 'Embroidery Order Process Deleted Successfully', 'alert-type' => 'success'];
            
        return redirect()->back()->with($notification);
    }
}
