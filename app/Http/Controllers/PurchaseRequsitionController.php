<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\PurchaseRequsition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRequsitionItem;

class PurchaseRequsitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $alldata = PurchaseRequsition::orderBy('pur_requsition_date','desc')->get();
       // $alldata = PurchaseItem::with('purchaseItems','supplier','material')->orderBy('entry_date','desc')->get();

        return view('raw-store.purchase-requsition.index', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allSection = Section::all();
        $allMaterial = MaterialSetup::all();
        //$materialSetups = MaterialSetup::with('store','storeCategory','unit')->get();

         $lastPurchaseRequsition = PurchaseRequsition::latest('id')->first();

       //dd($lastPurchaseRequsition->pur_requsition_no);

        if ($lastPurchaseRequsition) {
            $lastNumber = intval(substr($lastPurchaseRequsition->pur_requsition_no, 7));
            $nextNumber = $lastNumber + 1;
                          
        } else {
            $nextNumber = 1;
        }

        $purRequsitionNo = 'PURREQ-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            

        return view('raw-store.purchase-requsition.create',compact('allSection','allMaterial','purRequsitionNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->material_setup_id == null){

             $notification = array('message'=>'Sorry! you do not select any material', 'alert-type' => 'error');

            return redirect()->back()->with($notification);
        }
        else{
        DB::beginTransaction();

        try{

             $lastPurchaseRequsition = PurchaseRequsition::lockForUpdate()->latest('id')->first();
             //dd($lastPurchaseRequsition);
                if ($lastPurchaseRequsition) {
                    $lastNumber = intval(substr($lastPurchaseRequsition->pur_requsition_no, 7));
                    $nextNumber = $lastNumber + 1;
                } else {
                    $nextNumber = 1;
                }

            $autoPurRequsitionNo = 'PURREQ-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $purRequsition = new PurchaseRequsition();
            $purRequsition->pur_requsition_date = $request->pur_requsition_date;
            $purRequsition->pur_requsition_no   = $autoPurRequsitionNo;
            $purRequsition->section_id          = $request->section_id;
            $purRequsition->total               = $request->total;
            $purRequsition->user_id             = Auth::user()->id;
            $purRequsition->created_by          = Auth::user()->user_name;

            $purRequsition->save();

            $purRequsitionID = $purRequsition->id;
            $purRequsitionNO = $purRequsition->pur_requsition_no;
            $purRequsitionStatus = $purRequsition->status;
            $purRequsitionUserID = $purRequsition->user_id;
            $purRequsitionCreatedBy = $purRequsition->created_by;

            //dd($requsitionID);

            //dd($requsition);

            if($purRequsitionID){

                $items = count($request->material_setup_id);

                for($i=0; $i <$items; $i++){

                    //dd($items);

                    $purRequsition_items = new PurchaseRequsitionItem();

                    $purRequsition_items->pur_requsition_no       = $purRequsitionNO;
                    $purRequsition_items->purchase_requsition_id  = $purRequsitionID;
                    $purRequsition_items->material_setup_id       = $request->material_setup_id[$i];
                    $purRequsition_items->pur_quantity            = $request->pur_quantity[$i];
                    $purRequsition_items->unit_id                 = $request->unit_id[$i];
                    $purRequsition_items->unit_price              = $request->unit_price[$i];
                    $purRequsition_items->purchase_req_price      = $request->purchase_req_price[$i];
                    $purRequsition_items->status                  = $purRequsitionStatus;
                    $purRequsition_items->user_id                 = $purRequsitionUserID;
                    $purRequsition_items->created_by              = $purRequsitionCreatedBy;
                    $purRequsition_items->save();
                }


            }
            //dd($request->all());
            DB::commit();

            $notification = array('message'=>'Purchase Requsition Added Successfull', 'alert-type' => 'success');

            return redirect()->route('purchase-requsition.index')->with($notification);

        }catch(Exception $e){

            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseRequsition $purchaseRequsition)
    {
        //

        $purRequsition = PurchaseRequsition::with('section')->findOrfail($purchaseRequsition->id);
        $purRequsitionItems = PurchaseRequsitionItem::with('materialSetup','unit')->where('purchase_requsition_id', $purRequsition->id)->get();
        
        //dd($purchaseItems);

        return view('raw-store.purchase-requsition.show', compact('purRequsition','purRequsitionItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseRequsition $purchaseRequsition)
    {
       
        $allSection           = Section::all();
        $allMaterial          = MaterialSetup::all();
        $purRequsition        = PurchaseRequsition::findOrFail($purchaseRequsition->id);
        $purRequsitionItems   = PurchaseRequsitionItem::with('materialSetup','unit')
        ->where('purchase_requsition_id', $purRequsition->id)
        ->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.purchase-requsition.edit',compact('allSection','allMaterial','purRequsition','purRequsitionItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseRequsition $purchaseRequsition)
    {
        
            DB::beginTransaction();

            try {
                // 1. Find the purchase
                $purRequsition = PurchaseRequsition::findOrFail($purchaseRequsition->id);
                

                // 2. Update main purchase info

                $purRequsition->pur_requsition_date = $request->pur_requsition_date;
                $purRequsition->pur_requsition_no   = $request->pur_requsition_no;
                $purRequsition->section_id          = $request->section_id;
                $purRequsition->total               = $request->total;
                $purRequsition->user_id             = Auth::user()->id;
                $purRequsition->updated_by          = Auth::user()->user_name;

                $purRequsition->save();


                $purRequsitionID = $purRequsition->id;
                $purRequsitionNO = $purRequsition->pur_requsition_no;
                $purRequsitionStatus = $purRequsition->status;
                $purRequsitionUserID = $purRequsition->user_id;
                $purRequsitionUpdatedBy = $purRequsition->updated_by;



                if($purRequsitionID){

                    

                // 3. Delete old items (or update them if you need that logic)
                    PurchaseRequsitionItem::where('purchase_requsition_id', $purRequsitionID)->delete();

                // 4. Insert new items
                    

                    //if($purRequsitionID){

                    $items = count($request->material_setup_id);

                    for($i=0; $i <$items; $i++){

                        

                        $purRequsition_items = new PurchaseRequsitionItem();

                        //dd($purRequsition_items);

                        $purRequsition_items->pur_requsition_no       = $purRequsitionNO;
                        $purRequsition_items->purchase_requsition_id  = $purRequsitionID;
                        $purRequsition_items->material_setup_id       = $request->material_setup_id[$i];
                        $purRequsition_items->pur_quantity            = $request->pur_quantity[$i];
                        $purRequsition_items->unit_id                 = $request->unit_id[$i];
                        $purRequsition_items->unit_price              = $request->unit_price[$i];
                        $purRequsition_items->purchase_req_price      = $request->purchase_req_price[$i];
                        $purRequsition_items->status                  = $purRequsitionStatus;
                        $purRequsition_items->user_id                 = $purRequsitionUserID;
                        $purRequsition_items->updated_by              = $purRequsitionUpdatedBy;
                        $purRequsition_items->save();
                    }


                }


                //dd($request->all());

                DB::commit();

                

                $notification = array('message'=>'Purchase Requsition Updated Successfully', 'alert-type' => 'success');
                return redirect()->route('purchase-requsition.index')->with($notification);

                
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseRequsition $purchaseRequsition)
    {
        //
            DB::beginTransaction();

            try {
                // 1. Find Purchase Requsition
                $purRequsition = PurchaseRequsition::findOrFail($purchaseRequsition->id);

                // 2. Delete related Store Requsition Items first
                PurchaseRequsitionItem::where('purchase_requsition_id', $purRequsition->id)->delete();

                // 3. Delete Purchase Requsition Item
                $purRequsition->delete();

                DB::commit();

                $notification = ['message' => 'Purchase Requsition Deleted Successfully', 'alert-type' => 'success'];
                
                return redirect()->back()->with($notification);

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    public function getMaterialDataPurchaseRequsition(Request $request){
        

        $data['materialID'] = MaterialSetup::with([
        'unit',
        'purchaseItem' => function($q) {
         $q->latest('id')->take(1);  // or ->orderBy('entry_date','desc')->take(1)
         }
        ])
        ->where('id', $request->material_setup_id)
        ->first();

      

        return response()->json($data['materialID']);

    }

    public function recommend($id)
    {
        DB::beginTransaction();

        try {
            // 1. Find the store requsition
            $purRequsition = PurchaseRequsition::findOrFail($id);

            

            // 2. Update store requsition status
            $purRequsition->status = 2; 
            $purRequsition->approved_by = auth()->id(); 
            $purRequsition->approved_at = now();
            $purRequsition->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $alldata = PurchaseRequsitionItem::where('purchase_requsition_id', $purRequsition->id)->get();

            foreach($alldata as $data){
            $data->status = 2;
            $data->save();

            }
            // dd($data);

            DB::commit();

            $notification = array('message'=>'Purchase Requsition Recommended Successfully!', 'alert-type' => 'success');
            return redirect()->back()->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }
    public function purchaseRequsitionApprove($id){



        DB::beginTransaction();

        try {
            // 1. Find the purchase
            $purRequsition = PurchaseRequsition::findOrFail($id);

            // 2. Update purchase status
            $purRequsition->status = 1; 
            $purRequsition->approved_by = auth()->id(); 
            $purRequsition->approved_at = now();
            $purRequsition->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $alldata = PurchaseRequsitionItem::where('purchase_requsition_id', $purRequsition->id)->get();


                foreach($alldata as $data){
                    
                    $data->status = 1;
                    $data->save();

                }

                // dd($data);

                DB::commit();

                $notification = array('message'=>'Purchase Requsition Approved Successfully!', 'alert-type' => 'success');
                return redirect()->back()->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
        
        

    }
}
