<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use Illuminate\Support\Facades\DB;
use App\Models\OtherOrderSheetItem;
use App\Models\OtherOrderSheetTotal;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OtherOrderSheetTotalNotification;

class OtherOrderSheetTotalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alldata = OtherOrderSheetTotal::orderBy('other_order_entry_date_t','desc')->get();
      
        return view('raw-store.other-order-sheet-total.index', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allSection = Section::all();
        $allMaterial = MaterialSetup::all();

        //  $orderNo = OtherOrderSheetTotal::latest('id')->first();

        // dd($orderNo);

        $lastOtherOrderNoTotal = OtherOrderSheetTotal::latest('id')->first();

        if ($lastOtherOrderNoTotal) {
            $lastNumber = intval(substr($lastOtherOrderNoTotal->other_order_no_t, 5));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $otherOrderNoTotal = 'OTHT-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            

        return view('raw-store.other-order-sheet-total.create',compact('allSection','allMaterial','otherOrderNoTotal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'other_order_entry_date_t' => 'required',
            'other_order_no_t' => 'required',
            'section_id' => 'required',
            'material_setup_id' => 'required',
            'quantity' => 'required',
            'unit_id' => 'required',
            'unit_yeard' => 'required',
            'total' => 'required'
        ]);

        $otherordersheet = new OtherOrderSheetTotal();
        $otherordersheet->other_order_entry_date_t = $request->other_order_entry_date_t;
        $otherordersheet->other_order_no_t         = $request->other_order_no_t;
        $otherordersheet->section_id               = $request->section_id;
        $otherordersheet->material_setup_id        = $request->material_setup_id;
        $otherordersheet->quantity                 = $request->quantity;
        $otherordersheet->unit_id                  = $request->unit_id;
        $otherordersheet->unit_yeard               = $request->unit_yeard;
        $otherordersheet->total                    = $request->total;
        $otherordersheet->remarks                  = $request->remarks;
        $otherordersheet->user_id                  = Auth::user()->id;
        $otherordersheet->created_by               = Auth::user()->user_name;
        $otherordersheet->save();

        $notification = array('message'=>'Other Order Added Successfull', 'alert-type' => 'success');

        return redirect()->route('other-order-sheet-total.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(OtherOrderSheetTotal $otherOrderSheetTotal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OtherOrderSheetTotal $otherOrderSheetTotal)
    {
        //
        $allSection                 = Section::all();
        //$sectionID                = Section::findOrFail($section->id);
        $allMaterial                = MaterialSetup::all();
        $otherordersheet           = OtherOrderSheetTotal::with('materialSetup','unit')->findOrFail($otherOrderSheetTotal->id);
        // $otherordersheetitems      = OtherOrderSheetItem::with('materialSetup','unit')
        // ->where('other_order_sheet_id', $otherOrderSheet->id)
        // ->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.other-order-sheet-total.edit',compact('allSection','allMaterial','otherOrderSheetTotal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OtherOrderSheetTotal $otherOrderSheetTotal)
    {
        $request->validate([
            'other_order_entry_date_t' => 'required',
            'other_order_no_t' => 'required',
            'section_id' => 'required',
            'material_setup_id' => 'required',
            'quantity' => 'required',
            'unit_id' => 'required',
            'unit_yeard' => 'required',
            'total' => 'required'
        ]);

        $otherordersheet = OtherOrderSheetTotal::findOrfail($otherOrderSheetTotal->id);
        $otherordersheet->other_order_entry_date_t = $request->other_order_entry_date_t;
        $otherordersheet->other_order_no_t         = $request->other_order_no_t;
        $otherordersheet->section_id               = $request->section_id;
        $otherordersheet->material_setup_id        = $request->material_setup_id;
        $otherordersheet->quantity                 = $request->quantity;
        $otherordersheet->unit_id                  = $request->unit_id;
        $otherordersheet->unit_yeard               = $request->unit_yeard;
        $otherordersheet->total                    = $request->total;
        $otherordersheet->remarks                  = $request->remarks;
        $otherordersheet->user_id                  = Auth::user()->id;
        $otherordersheet->updated_by               = Auth::user()->user_name;
        $otherordersheet->update();

        $notification = array('message'=>'Other Order Added Successfull', 'alert-type' => 'success');

        return redirect()->route('other-order-sheet-total.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OtherOrderSheetTotal $otherOrderSheetTotal)
    {
        try {
            // 1. Find Store Requsition
            $otherordersheet = OtherOrderSheetTotal::findOrFail($otherOrderSheetTotal->id);

            $otherordersheet->delete();


            $notification = ['message' => 'Other Order Deleted Successfully', 'alert-type' => 'success'];
            
            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function recommend($id)
    {

        try {
            // 1. Find the other order sheet
            $otherOrderSheet = OtherOrderSheetTotal::findOrFail($id);

            // 2. Update other order sheet status
            $otherOrderSheet->status = 2; 
            $otherOrderSheet->approved_by = auth()->id(); 
            $otherOrderSheet->approved_at = now();
            $otherOrderSheet->save();

            $users = User::whereIn('id', [1, 5])->get();

            foreach ($users as $user) {
            $user->notify(new OtherOrderSheetTotalNotification($otherOrderSheet,'recommended'));
            }

            $notification = array('message'=>'Other Order Recommended Successfully!', 'alert-type' => 'success');
            return redirect()->back()->with($notification);

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    public function otherOrderApprove($id)
    {
        try {
                // 1. Find the other order sheet
                    $otherOrderSheet = OtherOrderSheetTotal::findOrFail($id);

                    // 2. Update other order sheet status
                    $otherOrderSheet->status = 1; 
                    $otherOrderSheet->approved_by = auth()->id(); 
                    $otherOrderSheet->approved_at = now();
                    $otherOrderSheet->save();

                    $users = User::whereIn('id', [1, 4])->get();

                    foreach ($users as $user) {
                            $user->notify(new OtherOrderSheetTotalNotification($otherOrderSheet,'approved'));
                        }

                    $notification = array('message'=>'Other Order Approved Successfully!', 'alert-type' => 'success');
                        return redirect()->back()->with($notification);

            } catch (\Exception $e) {
                        DB::rollBack();
                        return redirect()->back()->with('error', $e->getMessage());
            }

    }
}
