<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Size;
use App\Models\MasterInfo;
use App\Models\WorkerInfo;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\StoreCategory;
use App\Models\OrderDistribution;
use Illuminate\Support\Facades\DB;
use App\Models\ProductionWorkOrder;
use App\Models\ConsumptionSetupItem;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDistributionItem;
use App\Models\ProductionWorkOrderFabricItem;
use App\Models\ProductionWorkOrderAccessoriesItem;

class OrderDistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
 
        $alldata = ProductionWorkOrder::with('orderProcessing','masterInfo','item')
        ->where('status',1)
        ->whereHas('orderProcessing', function($q){
            $q->where('process_section_id', 1);
        })
        ->orderBy('production_order_no','desc')
        ->get();

        return view('raw-store.order-distribution.index', compact('alldata'));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allProdOrderNo = ProductionWorkOrder::select('id','production_order_no')->where('status' , '=' , 1)->get();

        //dd($allProdOrderNo);

        return view('raw-store.order-distribution.create', compact('allProdOrderNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            DB::beginTransaction();

            try{

                $orderDistribution = new OrderDistribution();
                $orderDistribution->production_work_order_id  = $request->production_work_order_id;
                $orderDistribution->production_order_no   = $request->production_order_no;
                $orderDistribution->user_id         = Auth::user()->id;
                $orderDistribution->created_by      = Auth::user()->user_name;

                $orderDistribution->save();

                $orderDistributionID        = $orderDistribution->id;
                $productionWorkOrderID      = $orderDistribution->production_work_order_id;
                $productionOrderNO          = $orderDistribution->production_order_no;
                $orderDistributionUserID    = $orderDistribution->user_id;
                $orderDistributionCreatedBy = $orderDistribution->created_by;

                //dd($requsitionID);

                //dd($orderDistribution);

                if($orderDistributionID){

                    $items = count($request->size_id);

                    for($i=0; $i <$items; $i++){

                        //dd($items);

                        $orderDistribution_items = new OrderDistributionItem();

                        $orderDistribution_items->production_work_order_id = $productionWorkOrderID;
                        $orderDistribution_items->production_order_no      = $productionOrderNO;
                        $orderDistribution_items->order_distribution_id    = $orderDistributionID;
                        $orderDistribution_items->worker_info_id           = $request->worker_info_id[$i];
                        $orderDistribution_items->bahar_id                 = $request->bahar_id[$i];
                        $orderDistribution_items->size_id                  = $request->size_id[$i];
                        $orderDistribution_items->order_quantity           = $request->order_quantity[$i];
                        $orderDistribution_items->assing_entry_date        = $request->assing_entry_date[$i];
                        $orderDistribution_items->assing_delivery_date     = $request->assing_delivery_date[$i];
                        $orderDistribution_items->assing_quantity          = $request->assing_quantity[$i];
                        $orderDistribution_items->remarks                  = $request->remarks[$i];
                        $orderDistribution_items->user_id                  = $orderDistributionUserID;
                        $orderDistribution_items->created_by               = $orderDistributionCreatedBy;
                        $orderDistribution_items->save();
                        
                    }


                }

                DB::commit();
                
                 dd($orderDistribution_items);

                $notification = array('message'=>'Order Distribution Successfull', 'alert-type' => 'success');

                return redirect()->route('store-requsition.index')->with($notification);

            }catch(Exception $e){

                DB::rollBack();

                return redirect()->back()->with('error', $e->getMessage());
            }
     
    }

    public function stores(Request $request)
    {
        //
            DB::beginTransaction();

            try{

                $orderDistribution = new OrderDistribution();
                $orderDistribution->production_work_order_id  = $request->production_work_order_id;
                $orderDistribution->production_order_no   = $request->production_order_no;
                $orderDistribution->user_id         = Auth::user()->id;
                $orderDistribution->created_by      = Auth::user()->user_name;

                $orderDistribution->save();

                $orderDistributionID        = $orderDistribution->id;
                $productionWorkOrderID      = $orderDistribution->production_work_order_id;
                $productionOrderNO          = $orderDistribution->production_order_no;
                $orderDistributionUserID    = $orderDistribution->user_id;
                $orderDistributionCreatedBy = $orderDistribution->created_by;

                //dd($requsitionID);

                //dd($orderDistribution);

                    $items = count($request->size_id);

                    for($i=0; $i <$items; $i++){

                        //dd($items);

                        $orderDistribution_items = new OrderDistributionItem();

                        $orderDistribution_items->production_work_order_id = $productionWorkOrderID;
                        $orderDistribution_items->production_order_no      = $productionOrderNO;
                        $orderDistribution_items->order_distribution_id    = $orderDistributionID;
                        $orderDistribution_items->worker_info_id           = $request->worker_info_id[$i];
                        $orderDistribution_items->bahar_id                 = $request->bahar_id[$i];
                        $orderDistribution_items->size_id                  = $request->size_id[$i];
                        $orderDistribution_items->order_quantity           = $request->order_quantity[$i];
                        $orderDistribution_items->assing_entry_date        = $request->assing_entry_date[$i];
                        $orderDistribution_items->assing_delivery_date     = $request->assing_delivery_date[$i];
                        $orderDistribution_items->assing_quantity          = $request->assing_quantity[$i];
                        $orderDistribution_items->remarks                  = $request->remarks[$i];
                        $orderDistribution_items->user_id                  = $orderDistributionUserID;
                        $orderDistribution_items->created_by               = $orderDistributionCreatedBy;
                        $orderDistribution_items->save();
                        
                    }

                DB::commit();
                
                //dd($orderDistribution_items);

                $notification = array('message'=>'Order Distribution Successfull', 'alert-type' => 'success');

                return redirect()->route('order-distribution.index')->with($notification);

            }catch(Exception $e){

                DB::rollBack();

                return redirect()->back()->with('error', $e->getMessage());
            }
     
    }

//     public function newstore(Request $request)
// {
//     // Validate input
//     $request->validate([
//         'production_work_order_id' => 'required',
//         'production_order_no'      => 'required',
//         'worker_info_id'           => 'required|array',
//         'bahar_id'                 => 'required|array',
//         'size_id'                  => 'required|array',
//         'order_quantity'           => 'required|array',
//     ]);

//     //dd( $request->all() );

//     DB::beginTransaction();

//     try {

//         // ============================
//         // 1. Save Main Distribution
//         // ============================
//         $orderDistribution = new OrderDistribution();
//         $orderDistribution->production_work_order_id = $request->production_work_order_id;
//         $orderDistribution->production_order_no      = $request->production_order_no;
//         $orderDistribution->user_id                  = Auth::user()->id;
//         $orderDistribution->created_by               = Auth::user()->user_name;
//         $orderDistribution->save();



//         // Get inserted IDs
//         $orderDistributionID        = $orderDistribution->id;
//         //dd($orderDistributionID);
//         $productionWorkOrderID      = $orderDistribution->production_work_order_id;
//         $productionOrderNO          = $orderDistribution->production_order_no;
//         $orderDistributionUserID    = $orderDistribution->user_id;
//         $orderDistributionCreatedBy = $orderDistribution->created_by;


//         // ======================================
//         // 2. Save Distribution ITEMS
//         // ======================================
//         $items = count($request->size_id);

//         for ($i = 0; $i < $items; $i++) {

//             $orderItem = new OrderDistributionItem();
//             $orderItem->production_work_order_id = $productionWorkOrderID;
//             $orderItem->production_order_no      = $productionOrderNO;
//             $orderItem->order_distribution_id    = $orderDistributionID;

//             // Array indexed fields
//             $orderItem->worker_info_id       = $request->worker_info_id[$i];
//             $orderItem->bahar_id             = $request->bahar_id[$i];
//             $orderItem->size_id              = $request->size_id[$i];
//             $orderItem->order_quantity       = $request->order_quantity[$i];
//             $orderItem->assing_entry_date    = $request->assing_entry_date[$i];
//             $orderItem->assing_delivery_date = $request->assing_delivery_date[$i];
//             $orderItem->assing_quantity      = $request->assing_quantity[$i];
//             $orderItem->remarks              = $request->remarks[$i];

//             // Auth info
//             $orderItem->user_id    = $orderDistributionUserID;
//             $orderItem->created_by = $orderDistributionCreatedBy;

//             $orderItem->save();
//         }

//         // All OK — Commit transaction
//         DB::commit();


//         return redirect()
//             ->route('order-distribiution.index')
//             ->with(['message' => 'Order Distribution Successful', 'alert-type' => 'success']);

//     } catch (\Exception $e) {

//         DB::rollBack();
//         return redirect()->back()->with('error', $e->getMessage());
//     }
// }


    /**
     * Display the specified resource.
     */
    public function show(OrderDistribution $orderDistribution)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderDistribution $orderDistribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderDistribution $orderDistribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDistribution $orderDistribution)
    {
        //
    }

    public function getWorkOrderNo(Request $request){
        
        // $data['materialID'] = ProductionWorkOrder::with('masterInfo','item','productionWorkOrderFabricItem')
        // ->where('id', $request->production_work_order_id)
        // ->get(['master_info_id', 'item_id', 'production_work_order_id']);

        $data = ProductionWorkOrder::with('masterInfo','item')
        ->where('id', $request->production_work_order_id)
        ->first();

        
        return response()->json($data);

    }

    public function productionEdit($id)
    {
        $item = ProductionWorkOrderFabricItem::with('item')
        ->where('production_work_order_id', $id)
        ->groupBy('item_id')
        ->select('item_id')
        ->first();

        $fabric = ProductionWorkOrderFabricItem::with('materialSetup')
        ->where('production_work_order_id', $id)
        ->groupBy('material_setup_id')
        ->select('material_setup_id')
        ->first();

        $bahar = ProductionWorkOrderFabricItem::with('bahar')
        ->where('production_work_order_id', $id)
        ->groupBy('bahar_id')
        ->select('bahar_id')
        ->first();

        $workers = WorkerInfo::all();
        
        $productionOrder              = ProductionWorkOrder::with('masterInfo')->findOrFail($id);
        $productionOrderFbaricItems   = ProductionWorkOrderFabricItem::with('materialSetup','unit','bahar','size')
        ->where('production_work_order_id', $id)->get();



        //dd($purchaseitems->toArray());

        return view('raw-store.order-distribution.create',compact('item','fabric','bahar','productionOrder','productionOrderFbaricItems','workers'));
    }

    public function distributionEdit($id)
    {
        $item = ProductionWorkOrderFabricItem::with('item')
        ->where('production_work_order_id', $id)
        ->groupBy('item_id')
        ->select('item_id')
        ->first();

        $fabric = ProductionWorkOrderFabricItem::with('materialSetup')
        ->where('production_work_order_id', $id)
        ->groupBy('material_setup_id')
        ->select('material_setup_id')
        ->first();

        $bahar = ProductionWorkOrderFabricItem::with('bahar')
        ->where('production_work_order_id', $id)
        ->groupBy('bahar_id')
        ->select('bahar_id')
        ->first();

        $workers = WorkerInfo::all();
        
        $productionOrder              = ProductionWorkOrder::with('masterInfo')->findOrFail($id);
        $productionOrderFbaricItems   = ProductionWorkOrderFabricItem::with('materialSetup','unit','bahar','size')
        ->where('production_work_order_id', $id)->get();



        //dd($purchaseitems->toArray());

        return view('raw-store.order-distribution.edit',compact('item','fabric','bahar','productionOrder','productionOrderFbaricItems','workers'));
    }

    public function orderShow($id){
        $distribution = OrderDistribution::with('orderDistributionItem','productionWorkOrder')->findOrfail($id);
        $distributionItems = OrderDistributionItem::where('order_distribution_id', $id)->get();
        
        //dd($purchaseItems);

        return view('raw-store.order-receive.show', compact('distribution','distributionItems'));
    }

    public function receive($id){

        $distribution = OrderDistribution::with('orderDistributionItem','productionWorkOrder')->findOrfail($id);
        $distributionItems = OrderDistributionItem::where('order_distribution_id', $id)->get();
        $orderDistID = OrderDistributionItem::select('order_distribution_id')->where('order_distribution_id', $id)->first();
        $workers = WorkerInfo::all();
        
        return view('raw-store.order-receive.create', compact('distribution','distributionItems','workers','orderDistID'));
    }
}
