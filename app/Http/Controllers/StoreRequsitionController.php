<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\StoreRequsition;
use Illuminate\Support\Facades\DB;
use App\Models\StoreRequsitionItem;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StoreRequsitionNotification;

class StoreRequsitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $alldata = StoreRequsition::orderBy('requsition_date','desc')->get();
       // $alldata = PurchaseItem::with('purchaseItems','supplier','material')->orderBy('entry_date','desc')->get();

        return view('raw-store.store-requsition.index', compact('alldata'));
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

        $lastStoreRequsition = StoreRequsition::latest('id')->first();

        if ($lastStoreRequsition) {
            $lastNumber = intval(substr($lastStoreRequsition->requsition_no, 4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $requsitionNo = 'STR-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            

        return view('raw-store.store-requsition.create',compact('allSection','allMaterial','requsitionNo'));
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

                $lastRequsition = StoreRequsition::lockForUpdate()->latest('id')->first();
                    if ($lastRequsition) {
                        $lastNumber = intval(substr($lastRequsition->requsition_no, 4));
                        $nextNumber = $lastNumber + 1;
                    } else {
                        $nextNumber = 1;
                    }

                $autoRequsitionNo = 'STR-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

                $requsition = new StoreRequsition();
                $requsition->requsition_date = $request->requsition_date;
                $requsition->requsition_no   = $autoRequsitionNo;
                $requsition->section_id      = $request->section_id;
                $requsition->user_id         = Auth::user()->id;
                $requsition->created_by      = Auth::user()->user_name;

                $requsition->save();

                $requsitionID = $requsition->id;
                $requsitionNO = $requsition->requsition_no;
                $requsitionStatus = $requsition->status;
                $requsitionUserID = $requsition->user_id;
                $requsitionCreatedBy = $requsition->created_by;

                //dd($requsitionID);

                //dd($requsition);

                if($requsitionID){

                    $items = count($request->material_setup_id);

                    for($i=0; $i <$items; $i++){

                        //dd($items);

                        $requsition_items = new StoreRequsitionItem();

                        $requsition_items->requsition_no       = $requsitionNO;
                        $requsition_items->store_requsition_id = $requsitionID;
                        $requsition_items->material_setup_id   = $request->material_setup_id[$i];
                        $requsition_items->quantity            = $request->quantity[$i];
                        $requsition_items->unit_id             = $request->unit_id[$i];
                        $requsition_items->status              = $requsitionStatus;
                        $requsition_items->user_id             = $requsitionUserID;
                        $requsition_items->created_by          = $requsitionCreatedBy;
                        $requsition_items->save();
                    }


                }

                DB::commit();

                //$user = User::find(4); // admin user id or your approver user
                $users = User::whereIn('id', [4, 5])->get();

                foreach ($users as $user) {
                    $user->notify(new StoreRequsitionNotification($requsition,'pending'));
                }

                //$user->notify(new StoreRequsitionNotification($requsition,'pending'));

                $notification = array('message'=>'Store Requsition Added Successfull', 'alert-type' => 'success');

                return redirect()->route('store-requsition.index')->with($notification);

            }catch(Exception $e){

                DB::rollBack();

                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StoreRequsition $storeRequsition)
    {
        
        $requsition = StoreRequsition::with('section')->findOrfail($storeRequsition->id);
        $requsitionItems = StoreRequsitionItem::with('materialSetup','unit')->where('store_requsition_id', $requsition->id)->get();
        
        //dd($purchaseItems);

        return view('raw-store.store-requsition.show', compact('requsition','requsitionItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreRequsition $storeRequsition)
    {
       
        $allSection           = Section::all();
        //$sectionID            = Section::findOrFail($section->id);
        $allMaterial          = MaterialSetup::all();
        $requsition           = StoreRequsition::findOrFail($storeRequsition->id);
        $storerequsitionitems = StoreRequsitionItem::with('materialSetup','unit')
        ->where('store_requsition_id', $requsition->id)
        ->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.store-requsition.edit',compact('allSection','allMaterial','requsition','storerequsitionitems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StoreRequsition $storeRequsition)
    {
        
        DB::beginTransaction();

        try {
            // 1. Find the purchase
            $requsition = StoreRequsition::findOrFail($storeRequsition->id);
            

            // 2. Update main purchase info
            $requsition->requsition_date = $request->requsition_date;
            $requsition->requsition_no   = $request->requsition_no;
            $requsition->section_id      = $request->section_id;
            $requsition->user_id         = Auth::user()->id;
            $requsition->updated_by      = Auth::user()->user_name;

            $requsition->save();

            $requsitionID = $requsition->id;
            $requsitionNO = $requsition->requsition_no;
            $requsitionStatus = $requsition->status;
            $requsitionUserID = $requsition->user_id;
            $requsitionUpdatedBy = $requsition->updated_by;


                //if($purchaseID){

                

            // 3. Delete old items (or update them if you need that logic)
                StoreRequsitionItem::where('store_requsition_id', $requsitionID)->delete();

            // 4. Insert new items
                

                if($requsitionID){

                $items = count($request->material_setup_id);

                for($i=0; $i <$items; $i++){

                    //dd($items);

                    $requsition_items = new StoreRequsitionItem();

                    $requsition_items->requsition_no       = $requsitionNO;
                    $requsition_items->store_requsition_id = $requsitionID;
                    $requsition_items->material_setup_id   = $request->material_setup_id[$i];
                    $requsition_items->quantity            = $request->quantity[$i];
                    $requsition_items->unit_id             = $request->unit_id[$i];
                    $requsition_items->status              = $requsitionStatus;
                    $requsition_items->user_id             = $requsitionUserID;
                    $requsition_items->updated_by          = $requsitionUpdatedBy;
                    $requsition_items->save();
                }


            }

            DB::commit();

            $notification = array('message'=>'Store Requsition Updated Successfully', 'alert-type' => 'success');
            return redirect()->route('store-requsition.index')->with($notification);

            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreRequsition $storeRequsition)
    {
        
        DB::beginTransaction();

        try {
            // 1. Find Store Requsition
            $requsition = StoreRequsition::findOrFail($storeRequsition->id);

            // 2. Delete related Store Requsition Items first
            StoreRequsitionItem::where('store_requsition_id', $requsition->id)->delete();

            // 3. Delete Store Requsition
            $requsition->delete();

            DB::commit();

            $notification = ['message' => 'Store Requsition Deleted Successfully', 'alert-type' => 'success'];
            
            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getMaterialDataStoreRequsition(Request $request){
        
        // $data['materialID'] = MaterialSetup::with('unit','purchaseItem')
        // ->where('id', $request->material_setup_id)
        // ->latest();

        $data['materialID'] = MaterialSetup::with([
        'unit',
        'purchaseItem' => function($q) {
         $q->latest('id')->take(1);  // or ->orderBy('entry_date','desc')->take(1)
         }
        ])
        ->where('id', $request->material_setup_id)
        ->first();

        // if ( $data['materialID'] && $data['materialID']->purchaseItem->isEmpty() ) {
        //      $data['materialID']->purchaseItem = collect([[
        //         'entry_date' => null,
        //         'buying_qty' => 0
        //     ]]);
        // }
        //$data = MaterialSetup::with('unit','purchaseItem')
        // ->where('id', $request->material_setup_id)->get(['quantity','unit_id']);

        //dd($data->toArray());
        
        //$data= MaterialSetup::where('id', $request->material_setup_id)->first()->unit_id;

        return response()->json($data['materialID']);

    }

    public function storeRequsitionApprove($id){

        DB::beginTransaction();

        try {
            // 1. Find the purchase
            $requsition = StoreRequsition::findOrFail($id);

            // 2. Update purchase status
            $requsition->status = 1; 
            $requsition->approved_by = auth()->id(); 
            $requsition->approved_at = now();
            $requsition->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $alldata = StoreRequsitionItem::where('store_requsition_id', $requsition->id)->get();

                foreach($alldata as $data){
                    
                    $data->status = 1;
                    $data->save();

                }

                // dd($data);

                DB::commit();

                $users = User::whereIn('id', [1, 4])->get();

                foreach ($users as $user) {
                    $user->notify(new StoreRequsitionNotification($requsition,'approved'));
                }

                $notification = array('message'=>'Purchase Approved Successfully!', 'alert-type' => 'success');
                return redirect()->back()->with($notification);

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }

    }

    public function recommend($id)
    {
        DB::beginTransaction();

        try {
            // 1. Find the store requsition
            $requsition = StoreRequsition::findOrFail($id);

            // 2. Update store requsition status
            $requsition->status = 2; 
            $requsition->approved_by = auth()->id(); 
            $requsition->approved_at = now();
            $requsition->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $alldata = StoreRequsitionItem::where('store_requsition_id', $requsition->id)->get();

            foreach($alldata as $data){
                
            $data->status = 2;
            $data->save();

            }

                // dd($data);

            DB::commit();

            //$user = User::find(1); // admin user id or your approver user
            // $users = User::whereIn('id', [1, 5])->get();
            // $users->notify(new StoreRequsitionNotification($requsition,'recommended'));

            $users = User::whereIn('id', [1, 5])->get();

            foreach ($users as $user) {
            $user->notify(new StoreRequsitionNotification($requsition,'recommended'));
            }

            $notification = array('message'=>'Store Requsition Recommended Successfully!', 'alert-type' => 'success');
            return redirect()->back()->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    public function markasread($id){

        if($id){

            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();

        }

        return back();
    }

    public function count() {
        return auth()->user()->unreadNotifications->count();
    }

    public function nshow() {
        return auth()->user()->unreadNotifications->take(5);
    }
}
