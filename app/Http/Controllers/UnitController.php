<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();

        return view('raw-store.unit.index', compact('units'));
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

        $unit = new Unit;

        $unit->name = $request->name;

        $unit->save();

        $notification = array('message'=>'Unit Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
        $unit = Unit::findOrfail($unit->id);
        $units = Unit::all();

        return view('raw-store.unit.edit', compact('unit','units'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $unit = Unit::findOrfail($unit->id);

        $unit->name = $request->name;

        $unit->save();

        $notification = array('message'=>'Unit Updated Successfull', 'alert-type' => 'success');

        return redirect()->route('unit.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete($unit->id);

        $notification = array('message'=>'Unit Updated Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }
}
