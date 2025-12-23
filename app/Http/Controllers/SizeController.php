<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sizes = Size::all();

        return view('raw-store.size.index', compact('sizes'));
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
        //
        $request->validate([
            'size' => 'required',
            'status' => 'required|in:0,1'
        ]);

        Size::create([
            'size' => $request->size,
            'status' => $request->status,
        ]);

        $notification = array('message'=>'Size Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        //
       $size = Size::findOrfail($size->id);
       $sizes = Size::all();

       return view('raw-store.size.edit', compact('size', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {

        $request->validate([
            'size' => 'required',
            'status' => 'required|in:0,1'
        ]);

        $size = Size::find($size->id);
        $size->size = $request->size;
        $size->status = $request->status;
        $size->update();
        
        $notification = array('message'=>'Size Updated Successfull', 'alert-type' => 'success');
        return redirect()->route('size.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(size $size)
    {
        //
        $size->delete($size->id);

        $notification = array('message'=>'Size Deleted Successfull', 'alert-type' => 'success');

        return redirect()->route('size.index')->with($notification);
    }
}
