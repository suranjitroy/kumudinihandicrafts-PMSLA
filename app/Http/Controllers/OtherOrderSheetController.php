<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\OtherOrderSheet;
use Illuminate\Support\Facades\DB;
use App\Models\OtherOrderSheetItem;
use App\Notifications\OtherOrderSheetNotification;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'other_order_entry_date' => 'required',
            'other_order_no' => 'required',
            'section_id' => 'required',
            'material_setup_id' => 'required',
            'quantity' => 'required',
            'unit_id' => 'required'
        ]);

        $otherordersheet = new OtherOrderSheet();
        $otherordersheet->other_order_entry_date = $request->other_order_entry_date;
        $otherordersheet->other_order_no         = $request->other_order_no;
        $otherordersheet->section_id             = $request->section_id;
        $otherordersheet->material_setup_id      = $request->material_setup_id;
        $otherordersheet->quantity               = $request->quantity;
        $otherordersheet->unit_id                = $request->unit_id;
        $otherordersheet->remarks                = $request->remarks;
        $otherordersheet->user_id                = Auth::user()->id;
        $otherordersheet->created_by             = Auth::user()->user_name;
        $otherordersheet->save();

        $notification = array('message'=>'Other Order Added Successfull', 'alert-type' => 'success');

        return redirect()->route('other-order-sheet.index')->with($notification);
     }
    // { 
    //     if($request->material_setup_id == null){

    //          $notification = array('message'=>'Sorry! you do not select any material', 'alert-type' => 'error');

    //         return redirect()->back()->with($notification);
    //     }
    //     else{
    //         DB::beginTransaction();

    //         try{

    //             $otherOrderNo = OtherOrderSheet::lockForUpdate()->latest('id')->first();
    //                 if ($otherOrderNo) {
    //                     $lastNumber = intval(substr($otherOrderNo->other_order_no, 4));
    //                     $nextNumber = $lastNumber + 1;
    //                 } else {
    //                     $nextNumber = 1;
    //                 }

    //             $autoOtherOrderNo = 'OTH-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    //             $otherordersheet = new OtherOrderSheet();
    //             $otherordersheet->other_order_entry_date = $request->other_order_entry_date;
    //             $otherordersheet->other_order_no   = $autoOtherOrderNo;
    //             $otherordersheet->section_id      = $request->section_id;
    //             $otherordersheet->user_id         = Auth::user()->id;
    //             $otherordersheet->created_by      = Auth::user()->user_name;

    //             $otherordersheet->save();

    //             $otherordersheetID = $otherordersheet->id;
    //             $otherordersheetNO = $otherordersheet->other_order_no;
    //             $otherordersheetStatus = $otherordersheet->status;
    //             $otherordersheetUserID = $otherordersheet->user_id;
    //             $otherordersheetCreatedBy = $otherordersheet->created_by;

    //             //dd($otherordersheetID);

    //             //dd($otherordersheet);

    //             if($otherordersheetID){

    //                 $items = count($request->material_setup_id);

    //                 for($i=0; $i <$items; $i++){

    //                     //dd($items);

    //                     $otherordersheet_items = new OtherOrderSheetItem();

    //                     $otherordersheet_items->other_order_no        = $otherordersheetNO;
    //                     $otherordersheet_items->other_order_sheet_id  = $otherordersheetID;
    //                     $otherordersheet_items->material_setup_id     = $request->material_setup_id[$i];
    //                     $otherordersheet_items->quantity              = $request->quantity[$i];
    //                     $otherordersheet_items->unit_id               = $request->unit_id[$i];
    //                     $otherordersheet_items->status                = $otherordersheetStatus;
    //                     $otherordersheet_items->user_id               = $otherordersheetUserID;
    //                     $otherordersheet_items->created_by            = $otherordersheetCreatedBy;
    //                     $otherordersheet_items->save();
    //                 }


    //             }

    //             DB::commit();

    //             //$user = User::find(4); // admin user id or your approver user
    //             $users = User::whereIn('id', [4, 5])->get();

    //             foreach ($users as $user) {
    //                 $user->notify(new OtherOrderSheetNotification($otherordersheet,'pending'));
    //             }

    //             $user->notify(new OtherordersheetNotification($otherordersheet,'pending'));

    //             $notification = array('message'=>'Store Otherordersheet Added Successfull', 'alert-type' => 'success');

    //             return redirect()->route('other-order-sheet.index')->with($notification);

    //         }catch(Exception $e){

    //             DB::rollBack();

    //             return redirect()->back()->with('error', $e->getMessage());
    //         }
    //     }
    // }


    /**
     * Display the specified resource.
     */
    public function show(OtherOrderSheet $otherOrderSheet)
    {
        $otherOrderSheet = OtherOrderSheet::with('section','materialSetup','unit')->findOrfail($otherOrderSheet->id);
       
        return view('raw-store.other-order-sheet.show', compact('otherOrderSheet','otherOrderSheetItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OtherOrderSheet $otherOrderSheet)
    {
        //
        $allSection                 = Section::all();
        //$sectionID                = Section::findOrFail($section->id);
        $allMaterial                = MaterialSetup::all();
        $otherordersheet           = OtherOrderSheet::with('materialSetup','unit')->findOrFail($otherOrderSheet->id);
        // $otherordersheetitems      = OtherOrderSheetItem::with('materialSetup','unit')
        // ->where('other_order_sheet_id', $otherOrderSheet->id)
        // ->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.other-order-sheet.edit',compact('allSection','allMaterial','otherordersheet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OtherOrderSheet $otherOrderSheet)
     {
        $request->validate([
            'other_order_entry_date' => 'required',
            'other_order_no' => 'required',
            'section_id' => 'required',
            'material_setup_id' => 'required',
            'quantity' => 'required',
            'unit_id' => 'required'
        ]);

        $otherordersheet = OtherOrderSheet::findOrfail($otherOrderSheet->id);
        $otherordersheet->other_order_entry_date = $request->other_order_entry_date;
        $otherordersheet->other_order_no         = $request->other_order_no;
        $otherordersheet->section_id             = $request->section_id;
        $otherordersheet->material_setup_id      = $request->material_setup_id;
        $otherordersheet->quantity               = $request->quantity;
        $otherordersheet->unit_id                = $request->unit_id;
        $otherordersheet->remarks                = $request->remarks;
        $otherordersheet->user_id                = Auth::user()->id;
        $otherordersheet->updated_by              = Auth::user()->user_name;
        $otherordersheet->update();

        $notification = array('message'=>'Other Order Updated Successfull', 'alert-type' => 'success');

        return redirect()->route('other-order-sheet.index')->with($notification);
    }
    // {
    //     DB::beginTransaction();

    //     try {
    //         // 1. Find the purchase
    //         $otherordersheet = OtherOrderSheet::findOrFail($otherOrderSheet->id);
        
    //         // 2. Update main purchase info
    //         $otherordersheet->other_order_entry_date = $request->other_order_entry_date;
    //         $otherordersheet->other_order_no   = $request->other_order_no;
    //         $otherordersheet->section_id      = $request->section_id;
    //         $otherordersheet->user_id         = Auth::user()->id;
    //         $otherordersheet->updated_by      = Auth::user()->user_name;

    //         $otherordersheet->save();

    //         $otherordersheetID = $otherordersheet->id;
    //         $otherordersheetNO = $otherordersheet->other_order_no;
    //         $otherordersheetStatus = $otherordersheet->status;
    //         $otherordersheetUserID = $otherordersheet->user_id;
    //         $otherordersheetUpdatedBy = $otherordersheet->updated_by;


    //             //if($purchaseID){

                

    //         // 3. Delete old items (or update them if you need that logic)
    //             OtherOrderSheetItem::where('other_order_sheet_id', $otherordersheetID)->delete();

    //         // 4. Insert new items
  

    //            // if($otherordersheetID){

                   

    //             $items = count($request->material_setup_id);

    //             for($i=0; $i <$items; $i++){

    //                 //dd($items);

    //                 $otherordersheet_items = new OtherOrderSheetItem();

    //                 $otherordersheet_items->other_order_no        = $otherordersheetNO;
    //                 $otherordersheet_items->other_order_sheet_id  = $otherordersheetID;
    //                 $otherordersheet_items->material_setup_id     = $request->material_setup_id[$i];
    //                 $otherordersheet_items->quantity              = $request->quantity[$i];
    //                 $otherordersheet_items->unit_id               = $request->unit_id[$i];
    //                 $otherordersheet_items->status                = $otherordersheetStatus;
    //                 $otherordersheet_items->user_id               = $otherordersheetUserID;
    //                 $otherordersheet_items->updated_by            = $otherordersheetUpdatedBy;
    //                 $otherordersheet_items->save();
    //             }

    //        // }

    //         DB::commit();

    //         $notification = array('message'=>'Other Order Updated Successfully', 'alert-type' => 'success');
    //         return redirect()->route('other-order-sheet.index')->with($notification);

            
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OtherOrderSheet $otherOrderSheet)
    {

        try {
            // 1. Find Store Requsition
            $otherordersheet = OtherOrderSheet::findOrFail($otherOrderSheet->id);

            $otherordersheet->delete();


            $notification = ['message' => 'Other Order Deleted Successfully', 'alert-type' => 'success'];
            
            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    //  public function nshow() {
    //     return auth()->user()->unreadNotifications->take(5);
    // }

    public function recommend($id)
    {

        try {
            // 1. Find the other order sheet
            $otherOrderSheet = OtherOrderSheet::findOrFail($id);

            // 2. Update other order sheet status
            $otherOrderSheet->status = 2; 
            $otherOrderSheet->approved_by = auth()->id(); 
            $otherOrderSheet->approved_at = now();
            $otherOrderSheet->save();

            $users = User::whereIn('id', [1, 5])->get();

            foreach ($users as $user) {
            $user->notify(new OtherOrderSheetNotification($otherOrderSheet,'recommended'));
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
                    $otherOrderSheet = OtherOrderSheet::findOrFail($id);

                    // 2. Update other order sheet status
                    $otherOrderSheet->status = 1; 
                    $otherOrderSheet->approved_by = auth()->id(); 
                    $otherOrderSheet->approved_at = now();
                    $otherOrderSheet->save();

                    $users = User::whereIn('id', [1, 4])->get();

                    foreach ($users as $user) {
                            $user->notify(new OtherOrderSheetNotification($otherOrderSheet,'approved'));
                        }

                    $notification = array('message'=>'Other Order Approved Successfully!', 'alert-type' => 'success');
                        return redirect()->back()->with($notification);

            } catch (\Exception $e) {
                        DB::rollBack();
                        return redirect()->back()->with('error', $e->getMessage());
            }

    }
}
