<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderProcessing;
use App\Models\ProcessSection;
use Illuminate\Support\Facades\DB;
use App\Models\ProductionWorkOrder;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderProcessingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //$alldata = ProductionWorkOrder::with('masterInfo','item')->orderBy('order_entry_date','desc')->get();

        // $alldata = DB::table('production_work_orders')
        // ->join('order_processings', 'production_work_orders.id', '=', 'order_processings.production_work_order_id')
        
        // ->select('production_work_orders.*', 'order_processings.status as processing')
        // ->get();
        $alldata = ProductionWorkOrder::with('orderProcessing','processSection','masterInfo','item')
        //->where('status',1)
        ->orderBy('production_order_no','desc')
        ->get();
        return view('raw-store.order-processing.index', compact('alldata'));
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
      
        $request->validate([
        'production_work_order_id' => 'required',
        'status' => 'required'
        ]);

        $orderProcessing = new OrderProcessing();
        $orderProcessing->production_work_order_id = $request->production_work_order_id;
        $orderProcessing->status = $request->status;
        $orderProcessing->created_by = Auth::user()->user_name ?? Auth::user()->name;;
        $orderProcessing->save();

        $notification = array('message'=>'Order Assign Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProcessing $orderProcessing)
    {
        //
    }

    public function orderShow($id)
    {

        $productionOrder = ProductionWorkOrder::findOrfail($id);

         

         $data = OrderProcessing::with('productionWorkOrder')
                 ->where('production_work_order_id', $id)
                 ->first();

        // dd($data);

        $allProcessList = OrderProcessing::all();

        $processSections = ProcessSection::all();

        // $orderProcessingID = OrderProcessing::findOrfail($id);

        return view('raw-store.order-processing.edit', compact('productionOrder', 'data', 'allProcessList','processSections'));
    }

    
    public function orderStoreOrUpdate(Request $request, $id)
    {
        try{

            $request->validate([
            'production_work_order_id' => 'required',
            'process_section_id' => 'required'
            ]);


        // check if processing exists
        $orderProcessing = OrderProcessing::where('production_work_order_id', $id)->first();

        if ($orderProcessing) {
            // if not found → create
            $orderProcessing->process_section_id = $request->process_section_id;
            $orderProcessing->updated_by = Auth::user()->user_name ?? Auth::user()->name;
            $orderProcessing->save();

            $notification = array('message'=>'Order Update Successfull', 'alert-type' => 'success');
            return redirect()->route('order-processing.index')->with($notification);
        }else{

            $processing = new OrderProcessing();
            $processing->production_work_order_id = $request->production_work_order_id;
            $processing->process_section_id = $request->process_section_id;
            $processing->created_by = Auth::user()->user_name ?? Auth::user()->name;;
            $processing->save();

            $notification = array('message'=>'Order Assign Successfull', 'alert-type' => 'success');

            return redirect()->route('order-processing.index')->with($notification);
        }

        }catch(Exception $e){
            return redirect()->back()->with([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
        
        

    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderProcessing $orderProcessing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, OrderProcessing $orderProcessing)
    // {

    //     $request->validate([
    //     'production_work_order_id' => 'required',
    //     'status' => 'required'
    //     ]);

    //     $orderProcessing = OrderProcessing::find($orderProcessing->id);
    //     $orderProcessing->production_work_order_id = $request->production_work_order_id;
    //     $orderProcessing->status = $request->status;
    //     $orderProcessing->updated_by = Auth::user()->user_name ?? Auth::user()->name;;
    //     $orderProcessing->update();

    //     $notification = array('message'=>'Order Assign Successfull', 'alert-type' => 'success');

    //     return redirect()->back()->with($notification);

               

    // }

        public function update(Request $request, ProductionWorkOrder $productionWorkOrder)
    {

        $request->validate([
        'production_work_order_id' => 'required',
        'status' => 'required'
        ]);

        $orderProcessing = ProductionWorkOrder::find($productionWorkOrder->id);
        $orderProcessing->production_work_order_id = $request->production_work_order_id;
        $orderProcessing->status = $request->status;
        $orderProcessing->updated_by = Auth::user()->user_name ?? Auth::user()->name;;
        $orderProcessing->update();

        $notification = array('message'=>'Order Assign Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

               

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProcessing $orderProcessing)
    {
        //
    }


}
