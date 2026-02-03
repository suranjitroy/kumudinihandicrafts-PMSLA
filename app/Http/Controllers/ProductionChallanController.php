<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ChallanHelper;
use App\Models\ProductionChallan;
use Illuminate\Support\Facades\DB;
use App\Models\ProductionWorkOrder;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductionChallanItem;
use App\Notifications\ProductionChallanNotification;

class ProductionChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alldata = ProductionChallan::with('item','workOrder','materialSetup')->orderBy('pro_challan_date','desc')->get();
        // $alldata = PurchaseItem::with('purchaseItems','supplier','material')->orderBy('entry_date','desc')->get();
 
        return view('raw-store.production-challan.index', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $challanNo = ChallanHelper::generateChallanNo();
        $workOrders = ProductionWorkOrder::latest()->get();
        $sizes      = Size::all();

        return view('raw-store.production-challan.create', compact('workOrders', 'sizes','challanNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {

    //     // dd($request->all());
    //     DB::beginTransaction();

    //     try {
    
    //         $challan = ProductionChallan::create([
    //             'pro_challan_date' => $request->pro_challan_date,
    //             'pro_challan_no' => ChallanHelper::generateChallanNo(),
    //             'production_work_order_id' => $request->production_work_order_id,
    //             'item_id' => $request->item_id,
    //             'material_setup_id' => $request->material_setup_id,
    //             'total_quantity' => $request->total_quantity,
    //             'assign_quantity_total' => $request->assign_quantity_total,
    //             'description' => $request->description,
    //             'status' => 0
    //         ]);
    
    //         foreach ($request->sizes as $index => $sizeId) {
    //             ProductionChallanItem::create([
    //                 'pro_challan_no' => $challan->pro_challan_no,
    //                 'production_challan_id' => $challan->id,
    //                 'size_id' => $sizeId,
    //                 'assign_quantity' => $request->assign_quantity[$index],
    //                 'status' => 0
    //             ]);
    //         }
    
    //         DB::commit();
    
    //         return redirect()->back()->with('success', 'Production Challan Created Successfully');
    
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        // dd($request->all());
        if($request->size_id == null){

            $notification = array('message'=>'Sorry! you do not select any size', 'alert-type' => 'error');

            return redirect()->back()->with($notification);
        }
        else{
            
            DB::beginTransaction();

            try{

                $prochallan                           = new ProductionChallan();
                $prochallan->pro_challan_date         = $request->pro_challan_date;
                $prochallan->pro_challan_no           = ChallanHelper::generateChallanNo();
                $prochallan->production_work_order_id = $request->production_work_order_id;
                $prochallan->item_id                  = $request->item_id;
                $prochallan->material_setup_id        = $request->material_setup_id;
                $prochallan->total_quantity           = $request->total_quantity;
                $prochallan->assign_quantity_total    = $request->assign_quantity_total;
                $prochallan->description              = $request->description;
                $prochallan->user_id                  = Auth::user()->id;
                $prochallan->created_by               = Auth::user()->user_name;

                $prochallan->save();

                $prochallanID = $prochallan->id;
                $prochallanNO = $prochallan->pro_challan_no;
                $prochallanStatus = $prochallan->status;
                $prochallanUserID = $prochallan->user_id;
                $prochallanCreatedBy = $prochallan->created_by;

                if($prochallanID){

                    $items = count($request->size_id);

                    for($i=0; $i <$items; $i++){

                        //dd($items);

                        $prochallan_items = new ProductionChallanItem();

                        $prochallan_items->pro_challan_no        = $prochallanNO;
                        $prochallan_items->production_challan_id = $prochallanID;
                        $prochallan_items->size_id               = $request->size_id[$i];
                        $prochallan_items->assign_quantity       = $request->assign_quantity[$i];
                        $prochallan_items->status                = $prochallanStatus;
                        $prochallan_items->user_id               = $prochallanUserID;
                        $prochallan_items->created_by            = $prochallanCreatedBy;
                        $prochallan_items->save();
                    }


                }

                DB::commit();

                //$user = User::find(4); // admin user id or your approver user
                //$users = User::whereIn('id', [4, 5])->get();

                // foreach ($users as $user) {
                //     $user->notify(new StoreRequsitionNotification($prochallan,'pending'));
                // }

                //$user->notify(new StoreRequsitionNotification($prochallan,'pending'));

                $notification = array('message'=>'Production Challan Added Successfull', 'alert-type' => 'success');

                return redirect()->route('production-challan.index')->with($notification);

            }catch(Exception $e){

                DB::rollBack();

                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionChallan $productionChallan)
     {
        
        $productionChallan = ProductionChallan::with('item','workOrder','materialSetup')->findOrfail($productionChallan->id);
        $productionChallanItems = ProductionChallanItem::with('size')
        ->where('production_challan_id', $productionChallan->id)->get();
        
        //dd($purchaseItems);

        return view('raw-store.production-challan.show', compact('productionChallan','productionChallanItems'));
     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionChallan $productionChallan)
    {

        $proWorkOrders = ProductionWorkOrder::all();
        $sizes = Size::all();
        $proChallan = ProductionChallan::with('item','materialSetup')->findOrfail($productionChallan->id);
        $productionChallanItems = ProductionChallanItem::with('size')
        ->where('production_challan_id', $proChallan->id)
        ->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.production-challan.edit',compact('proChallan','productionChallanItems','proWorkOrders','sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionChallan $productionChallan)
    {
  
            DB::beginTransaction();
            try{

                $prochallan                           = ProductionChallan::findOrFail($productionChallan->id);
                $prochallan->pro_challan_date         = $request->pro_challan_date;
                $prochallan->pro_challan_no           = $request->pro_challan_no;
                $prochallan->production_work_order_id = $request->production_work_order_id;
                $prochallan->item_id                  = $request->item_id;
                $prochallan->material_setup_id        = $request->material_setup_id;
                $prochallan->total_quantity           = $request->total_quantity;
                $prochallan->assign_quantity_total    = $request->assign_quantity_total;
                $prochallan->description              = $request->description;
                $prochallan->user_id                  = Auth::user()->id;
                $prochallan->updated_by               = Auth::user()->user_name;

                $prochallan->save();

                $prochallanID = $prochallan->id;
                $prochallanNO = $prochallan->pro_challan_no;
                $prochallanStatus = $prochallan->status;
                $prochallanUserID = $prochallan->user_id;
                $prochallanUpdatedBy = $prochallan->updated_by;

                // 3. Delete old items (or update them if you need that logic)
                ProductionChallanItem::where('production_challan_id', $prochallanID)->delete();

                if($prochallanID){

                    $items = count($request->size_id);

                    for($i=0; $i <$items; $i++){

                        //dd($items);

                        $prochallan_items = new ProductionChallanItem();

                        $prochallan_items->pro_challan_no        = $prochallanNO;
                        $prochallan_items->production_challan_id = $prochallanID;
                        $prochallan_items->size_id               = $request->size_id[$i];
                        $prochallan_items->assign_quantity       = $request->assign_quantity[$i];
                        $prochallan_items->status                = $prochallanStatus;
                        $prochallan_items->user_id               = $prochallanUserID;
                        $prochallan_items->updated_by            = $prochallanUpdatedBy;
                        $prochallan_items->save();
                    }


                }

                DB::commit();

                //$user = User::find(4); // admin user id or your approver user
                //$users = User::whereIn('id', [4, 5])->get();

                // foreach ($users as $user) {
                //     $user->notify(new StoreRequsitionNotification($prochallan,'pending'));
                // }

                //$user->notify(new StoreRequsitionNotification($prochallan,'pending'));

                $notification = array('message'=>'Production Challan Updated Successfull', 'alert-type' => 'success');

                return redirect()->route('production-challan.index')->with($notification);

            }catch(Exception $e){

                DB::rollBack();

                return redirect()->back()->with('error', $e->getMessage());
            }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionChallan $productionChallan)
     {
        
        DB::beginTransaction();

        try {
            // 1. Find Store Requsition
            $prochallan = ProductionChallan::findOrFail($productionChallan->id);

            // 2. Delete related Store Requsition Items first
            ProductionChallanItem::where('production_challan_id', $prochallan->id)->delete();

            // 3. Delete Store Requsition
            $prochallan->delete();

            DB::commit();

            $notification = ['message' => 'Production Challan Deleted Successfully', 'alert-type' => 'success'];
            
            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function getWorkOrder($id)
    {
        $workOrder = ProductionWorkOrder::with('masterInfo', 'item','productionWorkOrderFabricItemID.materialSetup')->findOrFail($id);

        $fabrics = $workOrder->productionWorkOrderFabricItem
        ->unique('material_setup_id')
        ->map(function ($row) {
            return [
                'material_setup_id' => $row->material_setup_id,
                'name' => $row->materialSetup->material_name
            ];
        })
        ->values();


        return response()->json([
            'fabric' => $fabrics,
            'item' => $workOrder->item->name ?? '',
            'item_id' => $workOrder->item_id,
            'total_quantity' => $workOrder->grand_total_quantity,
        ]);
    }

    public function productionChallanApprove($id){

        DB::beginTransaction();

        try {
            // 1. Find the purchase
            $proChallan = ProductionChallan::findOrFail($id);

            // 2. Update purchase status
            $proChallan->status = 1; 
            $proChallan->approved_by = auth()->id(); 
            $proChallan->approved_at = now();
            $proChallan->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $alldata = ProductionChallanItem::where('production_challan_id', $proChallan->id)->get();

                foreach($alldata as $data){
                    
                    $data->status = 1;
                    $data->save();
                    
                }

                // dd($data);

                DB::commit();

                $users = User::whereIn('id', [1, 4])->get();

                foreach ($users as $user) {
                    $user->notify(new ProductionChallanNotification($proChallan,'approved'));
                }

                $notification = array('message'=>'Production Challan Approved Successfully!', 'alert-type' => 'success');
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
            $proChallan = ProductionChallan::findOrFail($id);

            // 2. Update store requsition status
            $proChallan->status = 2; 
            $proChallan->approved_by = auth()->id(); 
            $proChallan->approved_at = now();
            $proChallan->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $alldata = ProductionChallanItem::where('production_challan_id', $proChallan->id)->get();

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
            $user->notify(new ProductionChallanNotification($proChallan,'recommended'));
            }

            $notification = array('message'=>'Production Challan Recommended Successfully!', 'alert-type' => 'success');
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
