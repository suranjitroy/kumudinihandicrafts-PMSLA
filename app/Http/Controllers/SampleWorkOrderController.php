<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Item;
use App\Models\Size;
use App\Models\MasterInfo;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\StoreCategory;
use App\Models\SampleWorkOrder;
use App\Models\ConsumptionSetup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ConsumptionSetupItem;
use Illuminate\Support\Facades\Auth;
use App\Models\SampleWorkOrderFabricItem;
use App\Models\SampleWorkOrderAccessoriesItem;

class SampleWorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $alldata = SampleWorkOrder::with('masterInfo','item')->orderBy('order_entry_date','desc')->get();
       // $alldata = PurchaseItem::with('purchaseItems','supplier','material')->orderBy('entry_date','desc')->get();

        return view('raw-store.sample-order.index', compact('alldata'));
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

        $lastSampleOrderNo = SampleWorkOrder::lockForUpdate()->latest('id')->first();
             //dd($lastSampleOrderNo);
                if ($lastSampleOrderNo) {
                    $lastNumber = intval(substr($lastSampleOrderNo->sample_order_no, 6));
                    $nextNumber = $lastNumber + 1;
                } else {
                    $nextNumber = 1;
                }

        $autoSampleOrderNo = 'SMP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('raw-store.sample-order.create',compact('allStoreCategorie','allItem','allFabric','allBahar','allSize','allMaster','allAccessories','allSizeAccessories','autoSampleOrderNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     if($request->material_setup_id == null){

    //          $notification = array('message'=>'Sorry! you do not select any material', 'alert-type' => 'error');

    //         return redirect()->back()->with($notification);
    //     }
    //     else{
    //     Log::debug('Incoming SampleOrder Request', $request->all());
    //     DB::beginTransaction();

    //     try{

    //          $lastSampleOrderNo = SampleWorkOrder::lockForUpdate()->latest('id')->first();
            
    //             if ($lastSampleOrderNo) {
    //                 $lastNumber = intval(substr($lastSampleOrderNo->sample_order_no, 7));
    //                 $nextNumber = $lastNumber + 1;
    //             } else {
    //                 $nextNumber = 1;
    //             }

    //         $autoSampleOrderNo = 'SMP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    //         $sampleOrder = new SampleWorkOrder();
    //         $sampleOrder->order_entry_date    = $request->order_entry_date;
    //         $sampleOrder->sample_order_no     = $autoSampleOrderNo;
    //         $sampleOrder->master_info_id      = $request->master_info_id;
    //         $sampleOrder->item_id             = $request->item_id;
    //         $sampleOrder->grand_total_quantity = $request->grand_total_quantity;
    //         $sampleOrder->grand_total_yeard   = $request->grand_total_yeard;
    //         $sampleOrder->purpose             = $request->purpose;
    //         $sampleOrder->user_id             = Auth::user()->id;
    //         $sampleOrder->created_by          = Auth::user()->user_name;

    //         $sampleOrder->save();

    //         $sampleOrderID = $sampleOrder->id;
    //         $sampleOrderNO = $sampleOrder->sample_order_no;
    //         $sampleOrderItemID = $sampleOrder->item_id;
    //         $sampleOrderStatus = $sampleOrder->status;
    //         $sampleOrderUserID = $sampleOrder->user_id;
    //         $sampleOrderCreatedBy = $sampleOrder->created_by;



    //         if($sampleOrderID && $request->material_setup_id){

    //             $items = count($request->material_setup_id);

    //             for($i=0; $i <$items; $i++){



    //                 $sampleOrderFb_items = new SampleWorkOrderFabricItem();

    //                 $sampleOrderFb_items->sample_work_order_id    = $sampleOrderID;
    //                 $sampleOrderFb_items->sample_order_no         = $sampleOrderNO;
    //                 $sampleOrderFb_items->item_id                 = $sampleOrderItemID;
    //                 $sampleOrderFb_items->material_setup_id       = $request->material_setup_id[$i];
    //                 $sampleOrderFb_items->bahar_id                = $request->bahar_id[$i];
    //                 $sampleOrderFb_items->size_id                 = $request->size_id[$i];
    //                 $sampleOrderFb_items->sample_quantity         = $request->sample_quantity[$i];
    //                 $sampleOrderFb_items->unit_yeard              = $request->unit_yeard[$i];
    //                 $sampleOrderFb_items->unit_id                 = $request->unit_id[$i];
    //                 $sampleOrderFb_items->total_yeard             = $request->total_yeard[$i];
    //                 $sampleOrderFb_items->status                  = $sampleOrderStatus;
    //                 $sampleOrderFb_items->user_id                 = $sampleOrderUserID;
    //                 $sampleOrderFb_items->created_by              = $sampleOrderCreatedBy;
    //                 $sampleOrderFb_items->save();
    //             }

                
    //         }

    //         //dd($request->all());


    //         if($sampleOrderID && $request->material_setup_id_ac){

    //             $itemsAc = count($request->material_setup_id_ac);

    //             for($i=0; $i <$itemsAc; $i++){


    //                 $sampleOrderAc_items = new SampleWorkOrderAccessoriesItem();

    //                 $sampleOrderAc_items->sample_work_order_id    = $sampleOrderID;
    //                 $sampleOrderAc_items->sample_order_no         = $sampleOrderNO;
    //                 $sampleOrderAc_items->item_id                 = $sampleOrderItemID;
    //                 $sampleOrderAc_items->material_setup_id       = $request->material_setup_id_ac[$i];
    //                 $sampleOrderAc_items->size_id                 = $request->size_id_ac[$i];
    //                 $sampleOrderAc_items->sample_quantity         = $request->sample_quantity_ac[$i];
    //                 $sampleOrderAc_items->unit_id                 = $request->unit_id_ac[$i];
    //                 $sampleOrderAc_items->status                  = $sampleOrderStatus;
    //                 $sampleOrderAc_items->user_id                 = $sampleOrderUserID;
    //                 $sampleOrderAc_items->created_by              = $sampleOrderCreatedBy;
    //                 $sampleOrderAc_items->save();
    //             }

                
    //         }
            

            
    //         DB::commit();

    //         $notification = array('message'=>'Sample Order Added Successfull', 'alert-type' => 'success');

    //         return redirect()->back()->with($notification);

    //     }catch(Exception $e){

    //         DB::rollBack();

    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    //     }
    // }

    public function store(Request $request)
    {
        // 🛑 যদি Material Select না করে থাকে
        if (!$request->material_setup_id) {
            return redirect()->back()->with([
                'message' => 'Sorry! you did not select any material',
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

        Log::debug('Incoming SampleOrder Request', $request->all());

        DB::beginTransaction();

        try {
            // ✅ Auto Sample Order Number
            $lastSampleOrder = SampleWorkOrder::lockForUpdate()->latest('id')->first();

            if ($lastSampleOrder) {
                // substr 4 থেকে নিলে SMP-0001 → 0001 ঠিকমতো পাওয়া যায়
                $lastNumber = intval(substr($lastSampleOrder->sample_order_no, 7));
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $autoSampleOrderNo = 'SMP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // ✅ Main Order Insert
            $sampleOrder = new SampleWorkOrder();
            $sampleOrder->order_entry_date      = $request->order_entry_date;
            $sampleOrder->sample_order_no       = $autoSampleOrderNo;
            $sampleOrder->master_info_id        = $request->master_info_id;
            $sampleOrder->item_id               = $request->item_id;
            $sampleOrder->grand_total_quantity  = $request->grand_total_quantity;
            $sampleOrder->grand_total_yeard     = $request->grand_total_yeard;
            $sampleOrder->purpose               = $request->purpose;
            $sampleOrder->user_id               = Auth::id();
            $sampleOrder->created_by            = Auth::user()->user_name ?? Auth::user()->name;
            $sampleOrder->save();

            $sampleOrderID         = $sampleOrder->id;
            $sampleOrderNO         = $sampleOrder->sample_order_no;
            $sampleOrderItemID     = $sampleOrder->item_id;
            $sampleOrderStatus     = $sampleOrder->status;
            $sampleOrderUserID     = $sampleOrder->user_id;
            $sampleOrderCreatedBy  = $sampleOrder->created_by;

            // ✅ Fabric Items Insert
            if ($request->material_setup_id && count($request->material_setup_id) > 0) {
                $totalFabric = count($request->material_setup_id);

                for ($i = 0; $i < $totalFabric; $i++) {
                    // array key missing check
                    if (!isset($request->bahar_id[$i], $request->size_id[$i], $request->sample_quantity[$i], $request->unit_yeard[$i], $request->unit_id[$i], $request->total_yeard[$i])) {
                        continue;
                    }

                    $fabricItem = new SampleWorkOrderFabricItem();
                    $fabricItem->sample_work_order_id = $sampleOrderID;
                    $fabricItem->sample_order_no      = $sampleOrderNO;
                    $fabricItem->item_id              = $sampleOrderItemID;
                    $fabricItem->material_setup_id    = $request->material_setup_id[$i];
                    $fabricItem->bahar_id             = $request->bahar_id[$i];
                    $fabricItem->size_id             = $request->size_id[$i];
                    $fabricItem->unit_yeard          = $request->unit_yeard[$i];
                    $fabricItem->sample_quantity     = $request->sample_quantity[$i];
                    $fabricItem->unit_id             = $request->unit_id[$i];
                    $fabricItem->total_yeard         = $request->total_yeard[$i];
                    $fabricItem->status              = $sampleOrderStatus;
                    $fabricItem->user_id             = $sampleOrderUserID;
                    $fabricItem->created_by          = $sampleOrderCreatedBy;
                    $fabricItem->save();
                }

                //dd($request->all());
            }

            // ✅ Accessories Items Insert
            if ($request->material_setup_id_ac && count($request->material_setup_id_ac) > 0) {
                $totalAc = count($request->material_setup_id_ac);

                for ($i = 0; $i < $totalAc; $i++) {
                    if (!isset($request->size_id_ac[$i], $request->sample_quantity_ac[$i], $request->unit_id_ac[$i])) {
                        continue;
                    }

                    $acItem = new SampleWorkOrderAccessoriesItem();
                    $acItem->sample_work_order_id = $sampleOrderID;
                    $acItem->sample_order_no      = $sampleOrderNO;
                    $acItem->item_id              = $sampleOrderItemID;
                    $acItem->material_setup_id    = $request->material_setup_id_ac[$i];
                    $acItem->size_id              = $request->size_id_ac[$i];
                    $acItem->sample_quantity      = $request->sample_quantity_ac[$i];
                    $acItem->unit_id              = $request->unit_id_ac[$i];
                    $acItem->status               = $sampleOrderStatus;
                    $acItem->user_id              = $sampleOrderUserID;
                    $acItem->created_by           = $sampleOrderCreatedBy;
                    $acItem->save();
                }
            }

            DB::commit();

            return redirect()->route('sample-work-order.index')->with([
                'message' => 'Sample Order Added Successfully ✅',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Sample Order Store Error', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
            return redirect()->back()->with([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SampleWorkOrder $sampleWorkOrder)
    {
        $sampleOrder                = SampleWorkOrder::with('masterInfo','item')->findOrfail($sampleWorkOrder->id);
        $sampleWorkorderFabricItems = SampleWorkOrderFabricItem::with('materialSetup','unit','bahar','size')->where('sample_work_order_id', $sampleOrder->id)->get();
        $item   = SampleWorkOrderFabricItem::with('item')
        ->where('sample_work_order_id', $sampleOrder->id)
        ->groupBy('item_id')
        ->select('item_id')
        ->first();

        $fabric = SampleWorkOrderFabricItem::with('materialSetup')
        ->where('sample_work_order_id', $sampleOrder->id)
        ->groupBy('material_setup_id')
        ->select('material_setup_id')
        ->first();

        $bahar = SampleWorkOrderFabricItem::with('bahar')
        ->where('sample_work_order_id', $sampleOrder->id)
        ->groupBy('bahar_id')
        ->select('bahar_id')
        ->first();

        $sampleWorkorderAcItems = SampleWorkOrderAccessoriesItem::with('materialSetup','unit','size')
        ->where('sample_work_order_id', $sampleOrder->id)
        ->get();
        
        //dd($purchaseItems);

        return view('raw-store.sample-order.show', compact('sampleOrder','sampleWorkorderFabricItems','sampleWorkorderAcItems','item','fabric','bahar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SampleWorkOrder $sampleWorkOrder)
    {
        $allStoreCategorie = StoreCategory::where('store_id',1)->orderBy('id','desc')->get();
        $allMaster = MasterInfo::orderBy('id','desc')->get();
        $allItem = ConsumptionSetupItem::select('item_id')
        ->distinct()
        ->get();
        $allAccessories = MaterialSetup::where('store_category_id',1)->orderBy('id','desc')->get();
        $allSizeAccessories = Size::orderBy('id','desc')->get();
        $sampleOrder              = SampleWorkOrder::findOrFail($sampleWorkOrder->id);
        $sampleOrderFbaricItems   = SampleWorkOrderFabricItem::with('materialSetup','unit','bahar','size')
        ->where('sample_work_order_id', $sampleOrder->id)->get();
        $sampleOrderAccItems      = SampleWorkOrderAccessoriesItem::with('materialSetup','unit','size')
        ->where('sample_work_order_id', $sampleOrder->id)
        ->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.sample-order.edit',compact('allMaster','allItem','allAccessories','allSizeAccessories','sampleOrder','sampleOrderFbaricItems','sampleOrderAccItems','allStoreCategorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SampleWorkOrder $sampleWorkOrder)
    {
        
            DB::beginTransaction();

            try {
                // 1. Find the purchase
                $sampleOrder = SampleWorkOrder::findOrFail($sampleWorkOrder->id);
                

                // 2. Update Sample Order info

                $sampleOrder->order_entry_date      = $request->order_entry_date;
                $sampleOrder->sample_order_no       = $request->sample_order_no;
                $sampleOrder->master_info_id        = $request->master_info_id;
                $sampleOrder->item_id               = $request->item_id;
                $sampleOrder->grand_total_quantity  = $request->grand_total_quantity;
                $sampleOrder->grand_total_yeard     = $request->grand_total_yeard;
                $sampleOrder->purpose               = $request->purpose;
                $sampleOrder->user_id               = Auth::id();
                $sampleOrder->updated_by            = Auth::user()->user_name ?? Auth::user()->name;
                $sampleOrder->save();

                $sampleOrderID         = $sampleOrder->id;
                $sampleOrderNO         = $sampleOrder->sample_order_no;
                $sampleOrderItemID     = $sampleOrder->item_id;
                $sampleOrderStatus     = $sampleOrder->status;
                $sampleOrderUserID     = $sampleOrder->user_id;
                $sampleOrderUpdatedBy  = $sampleOrder->updated_by;



                // if($sampleOrderID){

                    

                //     // 3. Delete old items (or update them if you need that logic)
                //         SampleWorkOrderFabricItem::where('sample_work_order_id', $sampleOrderID)->delete();

                //     // 4. Insert new items
                        

                //     //if($purRequsitionID){

                //     $items = count($request->material_setup_id);

                //     for($i=0; $i <$items; $i++){

                        

                //         $purRequsition_items = new PurchaseRequsitionItem();

                //         //dd($purRequsition_items);

                //         $purRequsition_items->pur_requsition_no       = $purRequsitionNO;
                //         $purRequsition_items->purchase_requsition_id  = $purRequsitionID;
                //         $purRequsition_items->material_setup_id       = $request->material_setup_id[$i];
                //         $purRequsition_items->pur_quantity            = $request->pur_quantity[$i];
                //         $purRequsition_items->unit_id                 = $request->unit_id[$i];
                //         $purRequsition_items->unit_price              = $request->unit_price[$i];
                //         $purRequsition_items->purchase_req_price      = $request->purchase_req_price[$i];
                //         $purRequsition_items->status                  = $purRequsitionStatus;
                //         $purRequsition_items->user_id                 = $purRequsitionUserID;
                //         $purRequsition_items->updated_by              = $purRequsitionUpdatedBy;
                //         $purRequsition_items->save();
                //     }


                // }

                // ✅ Fabric Items Insert
                if ($request->material_setup_id && count($request->material_setup_id) > 0) {

                    SampleWorkOrderFabricItem::where('sample_work_order_id', $sampleOrderID)->delete();


                    $totalFabric = count($request->material_setup_id);

                    for ($i = 0; $i < $totalFabric; $i++) {
                        // array key missing check
                        if (!isset($request->bahar_id[$i], $request->size_id[$i], $request->sample_quantity[$i], $request->unit_yeard[$i], $request->unit_id[$i], $request->total_yeard[$i])) {
                            continue;
                        }

                        $fabricItem = new SampleWorkOrderFabricItem();
                        $fabricItem->sample_work_order_id = $sampleOrderID;
                        $fabricItem->sample_order_no      = $sampleOrderNO;
                        $fabricItem->item_id              = $sampleOrderItemID;
                        $fabricItem->material_setup_id    = $request->material_setup_id[$i];
                        $fabricItem->bahar_id             = $request->bahar_id[$i];
                        $fabricItem->size_id             = $request->size_id[$i];
                        $fabricItem->unit_yeard          = $request->unit_yeard[$i];
                        $fabricItem->sample_quantity     = $request->sample_quantity[$i];
                        $fabricItem->unit_id             = $request->unit_id[$i];
                        $fabricItem->total_yeard         = $request->total_yeard[$i];
                        $fabricItem->status              = $sampleOrderStatus;
                        $fabricItem->user_id             = $sampleOrderUserID;
                        $fabricItem->updated_by          = $sampleOrderUpdatedBy;
                        $fabricItem->save();
                    }

                    //dd($request->all());
                }

                 if ($request->material_setup_id_ac && count($request->material_setup_id_ac) > 0) {

                    SampleWorkOrderAccessoriesItem::where('sample_work_order_id', $sampleOrderID)->delete();

                    $totalAc = count($request->material_setup_id_ac);

                for ($i = 0; $i < $totalAc; $i++) {
                    if (!isset($request->size_id_ac[$i], $request->sample_quantity_ac[$i], $request->unit_id_ac[$i])) {
                        continue;
                    }

                    $acItem = new SampleWorkOrderAccessoriesItem();
                    $acItem->sample_work_order_id = $sampleOrderID;
                    $acItem->sample_order_no      = $sampleOrderNO;
                    $acItem->item_id              = $sampleOrderItemID;
                    $acItem->material_setup_id    = $request->material_setup_id_ac[$i];
                    $acItem->size_id              = $request->size_id_ac[$i];
                    $acItem->sample_quantity      = $request->sample_quantity_ac[$i];
                    $acItem->unit_id              = $request->unit_id_ac[$i];
                    $acItem->status               = $sampleOrderStatus;
                    $acItem->user_id              = $sampleOrderUserID;
                    $acItem->updated_by           = $sampleOrderUpdatedBy;
                    $acItem->save();
                }
            }

                //dd($request->all());

                DB::commit();

                $notification = array('message'=>'Sample Order Updated Successfully', 'alert-type' => 'success');
                return redirect()->route('sample-work-order.index')->with($notification);

                
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Sample Order Store Error', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
                 return redirect()->back()->with([
                    'message' => 'Something went wrong: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SampleWorkOrder $sampleWorkOrder)
    {
        //
            DB::beginTransaction();

            try {
                // 1. Find Purchase Requsition
                $sampleOrder = SampleWorkOrder::findOrFail($sampleWorkOrder->id);

                // 2. Delete related Fabric Items first
                SampleWorkOrderFabricItem::where('sample_work_order_id', $sampleOrder->id)->delete();

                // 3. Delete related Accessories Items first
                SampleWorkOrderAccessoriesItem::where('sample_work_order_id', $sampleOrder->id)->delete();

                // 3. Delete Purchase Requsition Item
                $sampleOrder->delete();

                DB::commit();

                $notification = ['message' => 'Sample Order Deleted Successfully', 'alert-type' => 'success'];
                
                return redirect()->back()->with($notification);

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    public function getMaterials($item_id)
    {
        $materials = ConsumptionSetupItem::with('materialSetup')
            ->where('item_id', $item_id)
            ->select('material_setup_id')
            ->distinct()
            ->get();

        return response()->json($materials);
    }

    public function getBahars($material_setup_id)
    {
        $bahars = ConsumptionSetupItem::with('bahar')
            ->where('material_setup_id', $material_setup_id)
            ->select('bahar_id')
            ->distinct()
            ->get();

        return response()->json($bahars);
    }

    public function getSizes($bahar_id, $material_setup_id)
    {

        $sizes = ConsumptionSetupItem::with('size')
            ->where('bahar_id', $bahar_id)
            ->where('material_setup_id', $material_setup_id)
            ->select('size_id')
            ->distinct()
            ->get();

           //dd($sizes);

        return response()->json($sizes);
    }

    public function getConsumptionQty(Request $request)
    {
        
        $data = ConsumptionSetupItem::with('unit')
            ->where('item_id', $request->item_id)
            ->where('material_setup_id', $request->material_setup_id)
            ->where('bahar_id', $request->bahar_id)
            ->where('size_id', $request->size_id)
            ->first(); 

            if ($data) {
            return response()->json([
                'consumption_qty' => $data->consumption_qty,
                'unit_id' => $data->unit_id,
                'name' => $data->unit->name ?? ''
            ]);
        } else {
            return response()->json([
                'consumption_qty' => 0,
                'unit_id' => '',
                'name' => ''
            ]);
        }


    }
    public function getUnitIdUnitName(Request $request)
    {
        
        $data = MaterialSetup::with('unit')
            ->where('id', $request->id)
            ->first(); 

            if ($data) {
            return response()->json([
                'unit_id' => $data->unit_id,
                'name' => $data->unit->name ?? ''
            ]);
        } else {
            return response()->json([
                'unit_id' => '',
                'name' => ''
            ]);
        }


    }
    public function recommend($id)
    {
        DB::beginTransaction();

        try {
            // 1. Find the store requsition
            $sampleOrder = SampleWorkOrder::findOrFail($id);

            

            // 2. Update store requsition status
            $sampleOrder->status = 2; 
            $sampleOrder->approved_by = auth()->id(); 
            $sampleOrder->approved_at = now();
            $sampleOrder->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $allDataFb = SampleWorkOrderFabricItem::where('sample_work_order_id', $sampleOrder->id)->get();

                foreach($allDataFb as $data){  
                    $data->status = 2;
                    $data->save();

                }

            $allDataAc = SampleWorkOrderAccessoriesItem::where('sample_work_order_id', $sampleOrder->id)->get();
                
                foreach($allDataAc as $data){  
                    $data->status = 2;
                    $data->save();

                }
            // dd($data);

            DB::commit();

            $notification = array('message'=>'Sample Order Recommended Successfully!', 'alert-type' => 'success');
            return redirect()->route('sample-work-order.index')->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }
    public function sampleOrderApprove($id){

        DB::beginTransaction();

        try {
            // 1. Find the purchase
            $sampleOrder = SampleWorkOrder::findOrFail($id);

            // 2. Update purchase status
            $sampleOrder->status = 1; 
            $sampleOrder->approved_by = auth()->id(); 
            $sampleOrder->approved_at = now();
            $sampleOrder->save();

            // 3. Update all related purchase items status
        // PurchaseItem::where('purchase_id', $purchase->id)->update(['status' => $purchase->status]);

            $allDataFb = SampleWorkOrderFabricItem::where('sample_work_order_id', $sampleOrder->id)->get();
                
                foreach($allDataFb as $data){  
                    $data->status = 1;
                    $data->save();

                    $material = MaterialSetup::find($data->material_setup_id);

                    if($material){

                        $material->quantity = $material->quantity - $data->total_yeard;

                        $material->save();

                    }

                }

            $allDataAc = SampleWorkOrderAccessoriesItem::where('sample_work_order_id', $sampleOrder->id)->get();
                
                foreach($allDataAc as $data){  
                    $data->status = 1;
                    $data->save();

                    $material = MaterialSetup::find($data->material_setup_id);

                    if($material){

                        $material->quantity = $material->quantity - $data->sample_quantity;

                        $material->save();

                    }

                }

                DB::commit();

                $notification = array('message'=>'Sample Order Approved Successfully!', 'alert-type' => 'success');
                return redirect()->route('sample-work-order.index')->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
        
        

    }



}
