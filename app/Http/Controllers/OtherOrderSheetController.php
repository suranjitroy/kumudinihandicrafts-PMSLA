<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\OtherOrderSheet;

class OtherOrderSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alldata = OtherOrderSheet::orderBy('other_order_entry_date','desc')->get();
      
        return view('raw-store.other-order-sheet.index', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allSection = Section::all();
        $allMaterial = MaterialSetup::all();

        $lastOtherOrderNo = OtherOrderSheet::latest('id')->first();

        if ($lastOtherOrderNo) {
            $lastNumber = intval(substr($lastOtherOrderNo->other_order_no, 4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $otherOrderNo = 'OTH-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            

        return view('raw-store.other-order-sheet.create',compact('allSection','allMaterial','otherOrderNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OtherOrderSheet $otherOrderSheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OtherOrderSheet $otherOrderSheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OtherOrderSheet $otherOrderSheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OtherOrderSheet $otherOrderSheet)
    {
        //
    }
}
