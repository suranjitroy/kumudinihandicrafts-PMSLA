<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Size;
use App\Models\MasterInfo;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\StoreCategory;
use App\Models\ProductionWorkOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ConsumptionSetupItem;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductionWorkOrderFabricItem;
use App\Models\ProductionWorkOrderAccessoriesItem;

class ProductionWorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alldata = ProductionWorkOrder::with('masterInfo','item')->orderBy('order_entry_date','desc')->get();
        return view('raw-store.production-order.index', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allStoreCategorie = StoreCategory::where('store_id',1)->orderBy('id','desc')->get();
        $allMaster = MasterInfo::orderBy('id','desc')->get();
        //$allItem = Item::all();
        $allItem = ConsumptionSetupItem::select('item_id')
        ->distinct()
        ->get();

        $allFabric = ConsumptionSetupItem::select('material_setup_id')
        ->distinct()
        ->get();

        $allBahar = ConsumptionSetupItem::select('bahar_id')
        ->distinct()
        ->get();

        $allSize = ConsumptionSetupItem::select('size_id')
        ->distinct()
        ->get();

        $allAccessories = MaterialSetup::where('store_category_id',1)->orderBy('id','desc')->get();
        $allSizeAccessories = Size::orderBy('id','desc')->get();

        // $lastProductionOrderNo = ProductionWorkOrder::lockForUpdate()->latest('id')->first();
        //         if ($lastProductionOrderNo) {
        //             $lastNumber = intval(substr($lastProductionOrderNo->production_order_no, 7));
                    
        //             $nextNumber = $lastNumber + 1;
        //             // dd($nextNumber);
        //         } else {
        //             $nextNumber = 1;
        //         }

        // $autoProductionOrderNo = 'PROD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

         $lastProductionOrderNo = ProductionWorkOrder::lockForUpdate()->latest('id')->first();
             //dd($lastproductionOrderNo);
                if ($lastProductionOrderNo) {
                    $lastNumber = intval(substr($lastProductionOrderNo->production_order_no, 7));
                    $nextNumber = $lastNumber + 1;
                } else {
                    $nextNumber = 1;
                }

        $autoProductionOrderNo = 'PROD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('raw-store.production-order.create',compact('allStoreCategorie','allItem','allFabric','allBahar','allSize','allMaster','allAccessories','allSizeAccessories','autoProductionOrderNo'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🛑 যদি Material Select না করে থাকে
        if (!$request->material_setup_id) {
            return redirect()->back()->with([
                'message' => 'Sorry! you did not select any metarial',
                'alert-type' => 'error'
            ]);
        }

        // ✅ User check
        if (!Auth::check()) {
            return redirect()->back()->with([
                'message' => 'User not authenticated',
                'alert-type' => 'error'
            ]);
        }

        Log::debug('Incoming productionOrder Request', $request->all());

        DB::beginTransaction();

        try {
    

             // ✅ Auto Sample Order Number
            $lastProductionOrder = ProductionWorkOrder::lockForUpdate()->latest('id')->first();

            if ($lastProductionOrder) {
                // substr 4 থেকে নিলে SMP-0001 → 0001 ঠিকমতো পাওয়া যায়
                $lastNumber = intval(substr($lastProductionOrder->production_order_no, 7));
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $autoProductionOrderNo = 'PROD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // ✅ Main Order Insert
            $productionOrder = new ProductionWorkOrder();
            $productionOrder->order_entry_date      = $request->order_entry_date;
            $productionOrder->order_delivery_date   = $request->order_delivery_date;
            $productionOrder->production_order_no   = $autoProductionOrderNo;
            $productionOrder->master_info_id        = $request->master_info_id;
            $productionOrder->item_id               = $request->item_id;
            $productionOrder->grand_total_quantity  = $request->grand_total_quantity;
            $productionOrder->grand_total_yeard     = $request->grand_total_yeard;
            $productionOrder->purpose               = $request->purpose;
            $productionOrder->user_id               = Auth::id();
            $productionOrder->created_by            = Auth::user()->user_name ?? Auth::user()->name;
           
            $productionOrder->save();

            $productionOrderID         = $productionOrder->id;
            $productionOrderNO         = $productionOrder->production_order_no;
            $productionOrderItemID     = $productionOrder->item_id;
            $productionOrderStatus     = $productionOrder->status;
            $productionOrderUserID     = $productionOrder->user_id;
            $productionOrderCreatedBy  = $productionOrder->created_by;

            // ✅ Fabric Items Insert
            if ($request->material_setup_id && count($request->material_setup_id) > 0) {
                $totalFabric = count($request->material_setup_id);

                for ($i = 0; $i < $totalFabric; $i++) {
                    // array key missing check
                    if (!isset($request->bahar_id[$i], $request->size_id[$i], $request->order_quantity[$i], $request->unit_yeard[$i], $request->unit_id[$i], $request->total_yeard[$i])) {
                        continue;
                    }

                    $fabricItem                           = new ProductionWorkOrderFabricItem();
                    $fabricItem->production_work_order_id = $productionOrderID;
                    $fabricItem->production_order_no      = $productionOrderNO;
                    $fabricItem->item_id                  = $productionOrderItemID;
                    $fabricItem->material_setup_id        = $request->material_setup_id[$i];
                    $fabricItem->bahar_id                 = $request->bahar_id[$i];
                    $fabricItem->size_id                  = $request->size_id[$i];
                    $fabricItem->unit_yeard               = $request->unit_yeard[$i];
                    $fabricItem->order_quantity           = $request->order_quantity[$i];
                    $fabricItem->unit_id                  = $request->unit_id[$i];
                    $fabricItem->total_yeard              = $request->total_yeard[$i];
                    $fabricItem->status                   = $productionOrderStatus;
                    $fabricItem->user_id                  = $productionOrderUserID;
                    $fabricItem->created_by               = $productionOrderCreatedBy;
                    $fabricItem->save();
                }

                //dd($request->all());
            }

            // ✅ Accessories Items Insert
            if ($request->material_setup_id_ac && count($request->material_setup_id_ac) > 0) {
                $totalAc = count($request->material_setup_id_ac);

                for ($i = 0; $i < $totalAc; $i++) {
                    if (!isset($request->size_id_ac[$i], $request->order_quantity_ac[$i], $request->unit_id_ac[$i])) {
                        continue;
                    }

                    $acItem                           = new ProductionWorkOrderAccessoriesItem();
                    $acItem->production_work_order_id = $productionOrderID;
                    $acItem->production_order_no      = $productionOrderNO;
                    $acItem->item_id                  = $productionOrderItemID;
                    $acItem->material_setup_id        = $request->material_setup_id_ac[$i];
                    $acItem->size_id                  = $request->size_id_ac[$i];
                    $acItem->order_quantity           = $request->order_quantity_ac[$i];
                    $acItem->unit_id                  = $request->unit_id_ac[$i];
                    $acItem->status                   = $productionOrderStatus;
                    $acItem->user_id                  = $productionOrderUserID;
                    $acItem->created_by               = $productionOrderCreatedBy;
                    $acItem->save();
                }
            }

            DB::commit();
        
            return redirect()->route('production-work-order.index')->with([
                'message' => 'Production Order Added Successfully ✅',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Production Order Store Error', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
            return redirect()->back()->with([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionWorkOrder $productionWorkOrder)
    {
        $productionOrder                = ProductionWorkOrder::with('masterInfo','item')->findOrfail($productionWorkOrder->id);
        $ProductionWorkOrderFabricItems = ProductionWorkOrderFabricItem::with('materialSetup','unit','bahar','size')->where('production_work_order_id', $productionOrder->id)->get();
        $item   = ProductionWorkOrderFabricItem::with('item')
        ->where('production_work_order_id', $productionOrder->id)
        ->groupBy('item_id')
        ->select('item_id')
        ->first();

        $fabric = ProductionWorkOrderFabricItem::with('materialSetup')
        ->where('production_work_order_id', $productionOrder->id)
        ->groupBy('material_setup_id')
        ->select('material_setup_id')
        ->first();

        $bahar = ProductionWorkOrderFabricItem::with('bahar')
        ->where('production_work_order_id', $productionOrder->id)
        ->groupBy('bahar_id')
        ->select('bahar_id')
        ->first();

        $productionWorkorderAcItems = ProductionWorkOrderAccessoriesItem::with('materialSetup','unit','size')
        ->where('production_work_order_id', $productionOrder->id)
        ->get();
        
        //dd($purchaseItems);

        return view('raw-store.production-order.show', compact('productionOrder','ProductionWorkOrderFabricItems','productionWorkorderAcItems','item','fabric','bahar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionWorkOrder $productionWorkOrder)
    {
        $allStoreCategorie = StoreCategory::where('store_id',1)->orderBy('id','desc')->get();
        $allMaster = MasterInfo::orderBy('id','desc')->get();
        $allItem = ConsumptionSetupItem::select('item_id')
        ->distinct()
        ->get();
        $allAccessories = MaterialSetup::where('store_category_id',1)->orderBy('id','desc')->get();
        $allSizeAccessories = Size::orderBy('id','desc')->get();
        $productionOrder              = ProductionWorkOrder::findOrFail($productionWorkOrder->id);
        $productionOrderFbaricItems   = ProductionWorkOrderFabricItem::with('materialSetup','unit','bahar','size')
        ->where('production_work_order_id', $productionOrder->id)->get();
        $productionOrderAccItems      = ProductionWorkOrderAccessoriesItem::with('materialSetup','unit','size')
        ->where('production_work_order_id', $productionOrder->id)
        ->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.production-order.edit',compact('allMaster','allItem','allAccessories','allSizeAccessories','productionOrder','productionOrderFbaricItems','productionOrderAccItems','allStoreCategorie'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionWorkOrder $productionWorkOrder)
    {
        
            DB::beginTransaction();

            try {
                // 1. Find the purchase
                $productionOrder = ProductionWorkOrder::findOrFail($productionWorkOrder->id);
                

                // 2. Update Sample Order info

                $productionOrder->order_entry_date      = $request->order_entry_date;
                $productionOrder->order_delivery_date   = $request->order_delivery_date;
                $productionOrder->production_order_no   = $request->production_order_no;
                $productionOrder->master_info_id        = $request->master_info_id;
                $productionOrder->item_id               = $request->item_id;
                $productionOrder->grand_total_quantity  = $request->grand_total_quantity;
                $productionOrder->grand_total_yeard     = $request->grand_total_yeard;
                $productionOrder->purpose               = $request->purpose;
                $productionOrder->user_id               = Auth::id();
                $productionOrder->updated_by            = Auth::user()->user_name ?? Auth::user()->name;
                $productionOrder->save();

                $productionOrderID         = $productionOrder->id;
                $productionOrderNO         = $productionOrder->production_order_no;
                $productionOrderItemID     = $productionOrder->item_id;
                $productionOrderStatus     = $productionOrder->status;
                $productionOrderUserID     = $productionOrder->user_id;
                $productionOrderUpdatedBy  = $productionOrder->updated_by;


                // ✅ Fabric Items Insert
                if ($request->material_setup_id && count($request->material_setup_id) > 0) {

                    ProductionWorkOrderFabricItem::where('production_work_order_id', $productionOrderID)->delete();


                    $totalFabric = count($request->material_setup_id);

                    for ($i = 0; $i < $totalFabric; $i++) {
                        // array key missing check
                        if (!isset($request->bahar_id[$i], $request->size_id[$i], $request->order_quantity[$i], $request->unit_yeard[$i], $request->unit_id[$i], $request->total_yeard[$i])) {
                            continue;
                        }

                        $fabricItem = new ProductionWorkOrderFabricItem();
                        $fabricItem->production_work_order_id = $productionOrderID;
                        $fabricItem->production_order_no      = $productionOrderNO;
                        $fabricItem->item_id                  = $productionOrderItemID;
                        $fabricItem->material_setup_id        = $request->material_setup_id[$i];
                        $fabricItem->bahar_id                 = $request->bahar_id[$i];
                        $fabricItem->size_id                  = $request->size_id[$i];
                        $fabricItem->unit_yeard               = $request->unit_yeard[$i];
                        $fabricItem->order_quantity           = $request->order_quantity[$i];
                        $fabricItem->unit_id                  = $request->unit_id[$i];
                        $fabricItem->total_yeard              = $request->total_yeard[$i];
                        $fabricItem->status                   = $productionOrderStatus;
                        $fabricItem->user_id                  = $productionOrderUserID;
                        $fabricItem->updated_by               = $productionOrderUpdatedBy;
                        $fabricItem->save();
                    }

                }

                 if ($request->material_setup_id_ac && count($request->material_setup_id_ac) > 0) {

                    ProductionWorkOrderAccessoriesItem::where('production_work_order_id', $productionOrderID)->delete();

                    $totalAc = count($request->material_setup_id_ac);

                for ($i = 0; $i < $totalAc; $i++) {
                    if (!isset($request->size_id_ac[$i], $request->order_quantity_ac[$i], $request->unit_id_ac[$i])) {
                        continue;
                    }

                    $acItem = new ProductionWorkOrderAccessoriesItem();
                    $acItem->production_work_order_id = $productionOrderID;
                    $acItem->production_order_no      = $productionOrderNO;
                    $acItem->item_id              = $productionOrderItemID;
                    $acItem->material_setup_id    = $request->material_setup_id_ac[$i];
                    $acItem->size_id              = $request->size_id_ac[$i];
                    $acItem->order_quantity      = $request->order_quantity_ac[$i];
                    $acItem->unit_id              = $request->unit_id_ac[$i];
                    $acItem->status               = $productionOrderStatus;
                    $acItem->user_id              = $productionOrderUserID;
                    $acItem->updated_by           = $productionOrderUpdatedBy;
                    $acItem->save();
                }
            }

                DB::commit();

                $notification = array('message'=>'Production Order Updated Successfully', 'alert-type' => 'success');
                return redirect()->route('production-work-order.index')->with($notification);

                
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Production Order Store Error', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
                 return redirect()->back()->with([
                    'message' => 'Something went wrong: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);

            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionWorkOrder $productionWorkOrder)
    {
        //
            DB::beginTransaction();

            try {
                // 1. Find Purchase Requsition
                $productionOrder = ProductionWorkOrder::findOrFail($productionWorkOrder->id);

                // 2. Delete related Fabric Items first
                ProductionWorkOrderFabricItem::where('production_work_order_id', $productionOrder->id)->delete();

                // 3. Delete related Accessories Items first
                ProductionWorkOrderAccessoriesItem::where('production_work_order_id', $productionOrder->id)->delete();

                // 3. Delete Purchase Requsition Item
                $productionOrder->delete();

                DB::commit();

                $notification = ['message' => 'Production Order Deleted Successfully', 'alert-type' => 'success'];
                
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
            $productionOrder = ProductionWorkOrder::findOrFail($id);

            

            // 2. Update store requsition status
            $productionOrder->status = 2; 
            $productionOrder->approved_by = auth()->id(); 
            $productionOrder->approved_at = now();
            $productionOrder->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $allDataFb = ProductionWorkOrderFabricItem::where('production_work_order_id', $productionOrder->id)->get();

            foreach($allDataFb as $data){  
                    $data->status = 2;
                    $data->save();

                }

            $allDataAc = ProductionWorkOrderAccessoriesItem::where('production_work_order_id', $productionOrder->id)->get();
                
            foreach($allDataAc as $data){  
                    $data->status = 2;
                    $data->save();

                }
            // dd($data);

            DB::commit();

            $notification = array('message'=>'Production Order Recommended Successfully!', 'alert-type' => 'success');
            return redirect()->route('production-work-order.index')->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }
    public function productionOrderApprove($id){

        DB::beginTransaction();

        try {
            // 1. Find the purchase
            $productionOrder = ProductionWorkOrder::findOrFail($id);

            // 2. Update purchase status
            $productionOrder->status = 1; 
            $productionOrder->approved_by = auth()->id(); 
            $productionOrder->approved_at = now();
            $productionOrder->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $allDataFb = ProductionWorkOrderFabricItem::where('production_work_order_id', $productionOrder->id)->get();
                
                foreach($allDataFb as $data){  
                    $data->status = 1;
                    $data->save();

                    $material = MaterialSetup::find($data->material_setup_id);

                    if($material){

                        $material->quantity = $material->quantity - $data->total_yeard;

                        $material->save();

                    }

                }

            $allDataAc = ProductionWorkOrderAccessoriesItem::where('production_work_order_id', $productionOrder->id)->get();
                
                foreach($allDataAc as $data){  

                    $data->status = 1;
                    $data->save();

                    $material = MaterialSetup::find($data->material_setup_id);

                    if($material){

                        $material->quantity = $material->quantity - $data->order_quantity;

                        $material->save();

                    }
                }

                DB::commit();

                $notification = array('message'=>'Production Order Approved Successfully!', 'alert-type' => 'success');
                return redirect()->route('production-work-order.index')->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
        
        

    }
}
