<?php

namespace App\Http\Controllers;

use App\Models\ArtisanGroup;
use Illuminate\Http\Request;

class ArtisanGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = ArtisanGroup::latest()->get();
        return view('raw-store.artisan-group.index', compact('groups'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'mobile_no'  => 'nullable|string|max:20',
        ]);

        ArtisanGroup::create($request->all());
        
        $notification = array('message'=>'Artisan Group Created Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(ArtisanGroup $artisanGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArtisanGroup $artisanGroup)
    {
        $groups = ArtisanGroup::latest()->get();
        return view('raw-store.artisan-group.edit', compact('artisanGroup', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArtisanGroup $artisanGroup )
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'mobile_no'  => 'nullable|string|max:20',
        ]);

        $artisanGroup->update($request->all());

        $notification = array('message'=>'Artisan Group updated successfully', 'alert-type' => 'success');

        return redirect()->route('artisan-group.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArtisanGroup $artisanGroup)
    {
        $artisanGroup->delete();

        $notification = array('message'=>'Artisan Group deleted successfully', 'alert-type' => 'success');

        return redirect()->route('artisan-group.index')->with($notification);
    }

        
}
