<?php

namespace App\Http\Controllers;

use App\Models\Bahar;
use Illuminate\Http\Request;

class BaharController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bahars = Bahar::all();

        return view('raw-store.bahar.index', compact('bahars'));
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
            'bahar'=> 'required'
        ]);

        bahar::create([
            'bahar' => $request->bahar
        ]);

        $notification = array('message'=>'bahar Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(Bahar $bahar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bahar $bahar)
    {
        //
       $bahar = Bahar::findOrfail($bahar->id);
       $bahars = Bahar::all();

       return view('raw-store.bahar.edit', compact('bahar', 'bahars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bahar $bahar)
    {

        $request->validate([
            'bahar' => 'required'
        ]);

        $bahar = bahar::find($bahar->id);
        $bahar->bahar = $request->bahar;
        $bahar->update();
        
        $notification = array('message'=>'Bahar Updated Successfull', 'alert-type' => 'success');
        return redirect()->route('bahar.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bahar $bahar)
    {
        //
        $bahar->delete($bahar->id);

        $notification = array('message'=>'bahar Deleted Successfull', 'alert-type' => 'success');

        return redirect()->route('bahar.index')->with($notification);
    }
}

