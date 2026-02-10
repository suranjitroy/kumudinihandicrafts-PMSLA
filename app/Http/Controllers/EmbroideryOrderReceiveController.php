<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmbroideryOrder;
use Illuminate\Support\Facades\Auth;
use App\Models\EmbroideryOrderReceive;

class EmbroideryOrderReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receives = EmbroideryOrderReceive::latest()->get();
        return view('raw-store.embroidery-receive.index', compact('receives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $embOrders = EmbroideryOrder::where('status', 1 )->get();
        //dd($embOrders);
        return view('raw-store.embroidery-receive.create', compact('embOrders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receive_date'        => 'required|date',
            'embroidery_order_id' => 'required',
            'receive_quantity'    => 'required|integer',
        ]);

        EmbroideryOrderReceive::create([
            'receive_date'         => $request->receive_date,
            'embroidery_order_id'  => $request->embroidery_order_id,
            'receive_quantity'     => $request->receive_quantity,
            'remark'               => $request->remark,
            'user_id'              => Auth::user()->id,
            'created_by'           => Auth::user()->user_name
        ]);

        $notification = array('message'=>'Embroidery Order Received Successfull', 'alert-type' => 'success');

        return redirect()->route('embroidery-receive.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmbroideryOrderReceive $embroideryOrderReceive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $receive = EmbroideryOrderReceive::findOrFail($id);
        $embOrders = EmbroideryOrder::latest()->get();
        return view('raw-store.embroidery-receive.edit', compact('receive','embOrders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'receive_date'        => 'required|date',
            'embroidery_order_id' => 'required',
            'receive_quantity'    => 'required|integer',
        ]);

        $receive = EmbroideryOrderReceive::findOrFail($id);

        $receive->update([
            'receive_date'          => $request->receive_date,
            'embroidery_order_id'   => $request->embroidery_order_id,
            'receive_quantity'      => $request->receive_quantity,
            'remark'                => $request->remark,
            'user_id'               => Auth::user()->id,
            'updated_by'            => Auth::user()->user_name
        ]);

         $notification = array('message'=>'Embroidery Order Receive Updated successfully', 'alert-type' => 'success');
         return redirect()->route('embroidery-receive.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        EmbroideryOrderReceive::findOrFail($id)->delete();

        $notification = ['message' => 'Embroidery Order Receive Deleted Successfully', 'alert-type' => 'success'];
            
        return redirect()->back()->with($notification);

    }
    // public function getEmbOrderDetails($id)
    // {
    //     $items = EmbroideryOrder::with('artisanGroup')
    //         ->where('id', $id)
    //         ->get();

    //     //$assignTotal = $items->sum('assign_quantity');

    //     return response()->json([
    //         'items' => $items
    //         //'assign_total' => $assignTotal
    //     ]);
    // }

    public function getEmbroideryOrder($id)
    {
        $order = EmbroideryOrder::with('artisanGroup')->find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
}
