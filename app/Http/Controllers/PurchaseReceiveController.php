<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{MaterialReceive, Store, StoreCategory, Unit, MaterialSetup, Purchase, PurchaseItem, Supplier};


class PurchaseReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $alldata = Purchase::orderBy('entry_date','desc')->get();
       // $alldata = PurchaseItem::with('purchaseItems','supplier','material')->orderBy('entry_date','desc')->get();

        return view('raw-store.material-receive.index', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allSupplier = Supplier::all();
        $allMaterial = MaterialSetup::all();
        //$materialSetups = MaterialSetup::with('store','storeCategory','unit')->get();

         $lastPurchase = Purchase::latest('id')->first();

        if ($lastPurchase) {
            $lastNumber = intval(substr($lastPurchase->purchase_no, 4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $purchaseNo = 'PUR-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            

        return view('raw-store.material-receive.create',compact('allSupplier','allMaterial','purchaseNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        if($request->material_setup_id == null){

             $notification = array('message'=>'Sorry! you do not select any material', 'alert-type' => 'error');

            return redirect()->back()->with($notification);
        }
        else{
        DB::beginTransaction();

        try{

             $lastPurchase = Purchase::lockForUpdate()->latest('id')->first();
                if ($lastPurchase) {
                    $lastNumber = intval(substr($lastPurchase->purchase_no, 4));
                    $nextNumber = $lastNumber + 1;
                } else {
                    $nextNumber = 1;
                }

            $autoPurchaseNo = 'PUR-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $purchase = new Purchase();
            $purchase->entry_date   = $request->entry_date;
            $purchase->purchase_no  = $autoPurchaseNo;
            $purchase->total        = $request->total;
            $purchase->user_id      = Auth::user()->id;
            $purchase->created_by   = Auth::user()->user_name;

            $purchase->save();

            $purchaseID = $purchase->id;
            $purchaseDate = $purchase->entry_date;
            $purchaseNO = $purchase->purchase_no;
            $purchaseStatus = $purchase->status;
            $purchaseUserID = $purchase->user_id;
            $purchaseCreatedBy = $purchase->created_by;

            //dd($items);

            if($purchaseID){

                $items = count($request->material_setup_id);

                for($i=0; $i <$items; $i++){

                    $purchase_items = new PurchaseItem();

                    $purchase_items->entry_date  = $purchaseDate;
                    $purchase_items->purchase_no = $purchaseNO;
                    $purchase_items->purchase_id = $purchaseID;
                    $purchase_items->store_id    = $request->store_id[$i];
                    $purchase_items->store_category_id = $request->store_category_id[$i];
                    $purchase_items->supplier_id       = $request->supplier_id[$i];
                    $purchase_items->material_setup_id = $request->material_setup_id[$i];
                    $purchase_items->buying_qty        = $request->buying_qty[$i];
                    $purchase_items->unit_id           = $request->unit_id[$i];
                    $purchase_items->unit_price        = $request->unit_price[$i];
                    $purchase_items->description       = $request->description[$i];
                    $purchase_items->purpose           = $request->purpose[$i];
                    $purchase_items->challan_no        = $request->challan_no[$i];
                    $purchase_items->buying_price      = $request->buying_price[$i];
                    $purchase_items->status            = $purchaseStatus;
                    $purchase_items->user_id           = $purchaseUserID;
                    $purchase_items->created_by        = $purchaseCreatedBy;
                    $purchase_items->save();
                }


            }

            DB::commit();

            $notification = array('message'=>'Purchase Received Successfull', 'alert-type' => 'success');

            return redirect()->back()->with($notification);

        }catch(Exception $e){

            DB::rollBack();

            return redirect()->route('purchase-receive.index')->with('error', $e->getMessage());
        }
        }



    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $purchase = Purchase::findOrfail($id);
        $purchaseItems = PurchaseItem::with('supplier','materialSetup','unit')->where('purchase_id', $id)->get();
        
        //dd($purchaseItems);

        return view('raw-store.material-receive.show', compact('purchase','purchaseItems'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {
        //
        $allSupplier = Supplier::all();
        $allMaterial = MaterialSetup::all();
        $purchase = Purchase::findOrFail($id);
        $purchaseitems = PurchaseItem::with('supplier', 'materialSetup','unit')
        ->where('purchase_id', $id)
        ->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.material-receive.edit',compact('allSupplier','allMaterial','purchase','purchaseitems'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    public function update(Request $request, $id)
    {

    DB::beginTransaction();
    try {
        // 1. Find the purchase
        $purchase = Purchase::findOrFail($id);
        

        // 2. Update main purchase info
        $purchase->entry_date   = $request->entry_date;
        $purchase->purchase_no  = $request->purchase_no;
        $purchase->total        = $request->total;
        $purchase->user_id      = Auth::user()->id;
        $purchase->updated_by   = Auth::user()->user_name;

        $purchase->save();

            
        $purchaseDate = $purchase->entry_date;
        $purchaseID = $purchase->id;
        $purchaseNO = $purchase->purchase_no;
        $purchaseStatus = $purchase->status;
        $purchaseUserID = $purchase->user_id;
        $purchaseUpdatedBy = $purchase->updated_by;


            //if($purchaseID){

            

        // 3. Delete old items (or update them if you need that logic)
        PurchaseItem::where('purchase_id', $purchaseID)->delete();

        // 4. Insert new items
            

        $items = count($request->material_setup_id);

        //dd($items);

            for ($i = 0; $i < $items; $i++) {

                $purchase_items = new PurchaseItem();

                $purchase_items->entry_date  = $purchaseDate;
                $purchase_items->purchase_no = $purchaseNO;
                $purchase_items->purchase_id = $purchaseID;
                $purchase_items->store_id    = $request->store_id[$i];
                $purchase_items->store_category_id = $request->store_category_id[$i];
                $purchase_items->supplier_id       = $request->supplier_id[$i];
                $purchase_items->material_setup_id = $request->material_setup_id[$i];
                $purchase_items->buying_qty        = $request->buying_qty[$i];
                $purchase_items->unit_id           = $request->unit_id[$i];
                $purchase_items->unit_price        = $request->unit_price[$i];
                $purchase_items->description       = $request->description[$i];
                $purchase_items->purpose           = $request->purpose[$i];
                $purchase_items->challan_no        = $request->challan_no[$i];
                $purchase_items->buying_price      = $request->buying_price[$i];
                $purchase_items->status            = $purchaseStatus;
                $purchase_items->user_id           = $purchaseUserID;
                $purchase_items->updated_by        = $purchaseUpdatedBy;
                $purchase_items->save();

            }


        //}

        DB::commit();

        $notification = array('message'=>'Purchase Updated Successfully', 'alert-type' => 'success');
        return redirect()->route('purchase-receive.index')->with($notification);

        
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', $e->getMessage());
    }

}


    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // 1. Find purchase
            $purchase = Purchase::findOrFail($id);

            // 2. Delete related purchase items first
            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            // 3. Delete purchase
            $purchase->delete();

            DB::commit();

            $notification = ['message' => 'Purchase Deleted Successfully', 'alert-type' => 'success'];
            
            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

     public function getMaterialData(Request $request)
     {
        
        $data['materialID'] = MaterialSetup::with('unit')
        ->where('id', $request->material_setup_id)
        ->get(['store_id', 'store_category_id', 'unit_id']);
        
        //$data= MaterialSetup::where('id', $request->material_setup_id)->first()->unit_id;

        return response()->json($data);

    }

    public function purchaseApprove($id){

    // if (!auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
    //     return redirect()->back()->with('error', 'You are not authorized to approve purchases.');
    // }
    //     dd(auth()->user()->getRoleNames());


        DB::beginTransaction();

        try {
            // 1. Find the purchase
            $purchase = Purchase::findOrFail($id);

            // 2. Update purchase status
            $purchase->status = 1; 
            $purchase->approved_by = auth()->id(); 
            $purchase->approved_at = now();
            $purchase->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $alldata = PurchaseItem::where('purchase_id', $purchase->id)->get();


                foreach($alldata as $data){
                    
                    $data->status = 1;
                    $data->save();

                    $material = MaterialSetup::find($data->material_setup_id);

                    if($material){

                        $material->quantity = $material->quantity + $data->buying_qty;

                        $material->save();

                    }

                }

                // dd($data);

                DB::commit();

                $notification = array('message'=>'Purchase Approved Successfully!', 'alert-type' => 'success');
                return redirect()->back()->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
        
        

    }
}
