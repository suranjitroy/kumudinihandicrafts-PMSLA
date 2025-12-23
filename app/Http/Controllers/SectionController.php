<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sections = Section::all();

        return view('raw-store.section.index', compact('sections'));
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

        $section = new Section();
        $section->name = $request->name;
        $section->save();

        $notification = array('message'=>'Section Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
       
       $section = Section::findOrfail($section->id);
       $sections = Section::all();

       return view('raw-store.section.edit', compact('section', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
         $request->validate([
            'name' => 'required'
        ]);

        $section = Section::findOrfail($section->id);
        $section->name = $request->name;
        $section->update();

        $notification = array('message'=>'Section Updated Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete($section->id);

        $notification = array('message'=>'Section Deleted Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }
}
