<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\OrderReceive;
use Illuminate\Http\Request;
use App\Models\OrderReceiveItem;
use App\Models\OrderDistribution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDistributionItem;

class OrderReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $allData = OrderDistribution::with('orderDistributionItem','productionWorkOrder', 'masterInfo')->distinct()->get();

        return view('raw-store.order-receive.index', compact('allData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
 {
        //

        // dd( $request->all() );
            DB::beginTransaction();

            try{

                $orderReceive = new OrderReceive();
                $orderReceive->production_work_order_id  = $request->production_work_order_id;
                $orderReceive->production_order_no       = $request->production_order_no;
                $orderReceive->order_distribution_id     = $request->order_distribution_id;
                $orderReceive->user_id                   = Auth::user()->id;
                $orderReceive->created_by                = Auth::user()->user_name;

                $orderReceive->save();

                $orderReceiveID             = $orderReceive->id;
                $productionWorkOrderID      = $orderReceive->production_work_order_id;
                $productionOrderNO          = $orderReceive->production_order_no;
                $orderDistributionID        = $orderReceive->order_distribution_id;
                $orderReceiveUserID         = $orderReceive->user_id;
                $orderReceiveCreatedBy      = $orderReceive->created_by;

                //dd($requsitionID);

                //dd($orderDistribution);

                    $items = count($request->size_id);

                    for($i=0; $i <$items; $i++){

                        //dd($items);

                        $orderReceive_items = new OrderReceiveItem();

                        $orderReceive_items->production_work_order_id = $productionWorkOrderID;
                        $orderReceive_items->production_order_no      = $productionOrderNO;
                        $orderReceive_items->order_distribution_id    = $orderDistributionID;
                        $orderReceive_items->order_receive_id         = $orderReceiveID;
                        $orderReceive_items->worker_info_id           = $request->worker_info_id[$i];
                        $orderReceive_items->receive_entry_date       = $request->receive_entry_date[$i];
                        $orderReceive_items->receive_quantity         = $request->receive_quantity[$i];
                        $orderReceive_items->remarks                  = $request->remarks[$i];
                        $orderReceive_items->user_id                  = $orderReceiveUserID;
                        $orderReceive_items->created_by               = $orderReceiveCreatedBy;
                        $orderReceive_items->save();
                        
                    }

                DB::commit();
                
                //dd($orderReceive_items);

                $notification = array('message'=>'Order Received Successfull', 'alert-type' => 'success');

                return redirect()->route('order-receive.index')->with($notification);

            }catch(Exception $e){

                DB::rollBack();

                return redirect()->back()->with('error', $e->getMessage());
            }
     
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderReceive $orderReceive)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderReceive $orderReceive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderReceive $orderReceive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderReceive $orderReceive)
    {
        //
    }


}
