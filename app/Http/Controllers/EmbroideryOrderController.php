<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ArtisanGroup;
use Illuminate\Http\Request;
use App\Models\EmbroideryOrder;
use App\Models\ProductionChallan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductionChallanItem;
use App\Helpers\EmbroideryOrderHelper;
use App\Notifications\EmbroideryOrderNotification;

class EmbroideryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = EmbroideryOrder::latest()->get();
        return view('raw-store.embroidery-orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('raw-store.embroidery-orders.create', [
            'artisanGroups' => ArtisanGroup::all(),
            'challans' => ProductionChallan::all(),
            'orderNo' => EmbroideryOrderHelper::generateOrderNo()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'order_entry_date'     => 'required|date',
            'order_delivery_date'  => 'required|date',
            'artisan_group_id'     => 'required',
            'production_challan_id'=> 'required',
            'quantity'             => 'required|numeric',
            'unit_price'           => 'required|numeric',
        ]);

        $embOrder = EmbroideryOrder::create([
            'order_entry_date'     => $request->order_entry_date,
            'order_delivery_date'  => $request->order_delivery_date,
            'emb_order_no'         => EmbroideryOrderHelper::generateOrderNo(),
            'artisan_group_id'     => $request->artisan_group_id,
            'production_challan_id'=> $request->production_challan_id,
            'product_name'         => $request->product_name,
            'design_name'          => $request->design_name,
            'color_name'           => $request->color_name,
            'description'          => $request->description,
            'quantity'             => $request->quantity,
            'unit_price'           => $request->unit_price,
            'total'                => $request->total,
            'remark'               => $request->remark,
            'user_id'              => Auth::user()->id,
            'created_by'           => Auth::user()->user_name
        ]);

        $users = User::whereIn('id', [4, 5])->get();

        foreach ($users as $user) {
            $user->notify(new EmbroideryOrderNotification($embOrder,'pending'));
        }

        $notification = array('message'=>'Embroidery Order Added Successfull', 'alert-type' => 'success');

        return redirect()->route('emb-order-sheet.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $embOrder = EmbroideryOrder::with('artisanGroup','productionChallan')->findOrfail($id);

        $items = ProductionChallanItem::with('size')
            ->where('production_challan_id', $embOrder->production_challan_id)
            ->get();

        $assignTotal = $items->sum('assign_quantity');
        
        //dd($purchaseItems);

        return view('raw-store.embroidery-orders.show', compact('embOrder','items','assignTotal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = EmbroideryOrder::findOrFail($id);
        $artisanGroups = ArtisanGroup::all();
        $challans = ProductionChallan::all();

        //dd($order);
        
        return view('raw-store.embroidery-orders.edit', compact(
            'order',
            'artisanGroups',
            'challans'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'order_entry_date'    => 'required|date',
            'order_delivery_date' => 'required|date',
            'quantity'            => 'required|numeric',
            'unit_price'          => 'required|numeric',
        ]);

        $order = EmbroideryOrder::findOrFail($id);

        $order->update([
            'order_entry_date'      => $request->order_entry_date,
            'order_delivery_date'   => $request->order_delivery_date,
            'artisan_group_id'      => $request->artisan_group_id,
            'production_challan_id' => $request->production_challan_id,
            'product_name'         => $request->product_name,
            'design_name'          => $request->design_name,
            'color_name'           => $request->color_name,
            'description'           => $request->description,
            'quantity'              => $request->quantity,
            'unit_price'            => $request->unit_price,
            'total'                 => $request->total,
            'remark'                => $request->remark,
            'user_id'               => Auth::user()->id,
            'updated_by'            => Auth::user()->user_name
        ]);

         $notification = array('message'=>'Embroidery Order Updated Successfully', 'alert-type' => 'success');
         return redirect()->route('emb-order-sheet.index')->with($notification);

        // return redirect()->route('embroidery-orders.index')
        //     ->with('success', 'Embroidery Order Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        EmbroideryOrder::findOrFail($id)->delete();

        $notification = ['message' => 'Embroidery Order Deleted Successfully', 'alert-type' => 'success'];
            
        return redirect()->back()->with($notification);

    }

    public function getChallanDetails($id)
    {
        $items = ProductionChallanItem::with('size')
            ->where('production_challan_id', $id)
            ->get();

        $assignTotal = $items->sum('assign_quantity');

        return response()->json([
            'items' => $items,
            'assign_total' => $assignTotal
        ]);
    }

    public function embroideryOrderApprove($id){

        try {
            // 1. Find the purchase
            $embOrder = EmbroideryOrder::findOrFail($id);

            // 2. Update purchase status
            $embOrder->status = 1; 
            $embOrder->approved_by = auth()->id(); 
            $embOrder->approved_at = now();
            $embOrder->save();

            $users = User::whereIn('id', [1, 4])->get();

            foreach ($users as $user) {
                $user->notify(new EmbroideryOrderNotification($embOrder,'approved'));
            }

                $notification = array('message'=>'Embroidery Order Approved Successfully!', 'alert-type' => 'success');
                return redirect()->back()->with($notification);

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }

    }

    public function recommend($id)
    {
        try {
            // 1. Find the store requsition
            $embOrder = EmbroideryOrder::findOrFail($id);

            // 2. Update store requsition status
            $embOrder->status = 2; 
            $embOrder->approved_by = auth()->id(); 
            $embOrder->approved_at = now();
            $embOrder->save();

            $users = User::whereIn('id', [1, 5])->get();

            foreach ($users as $user) {
            $user->notify(new EmbroideryOrderNotification($embOrder,'recommended'));
            }

            $notification = array('message'=>'Embroidery Order Recommended Successfully!', 'alert-type' => 'success');
            return redirect()->back()->with($notification);


            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

}
