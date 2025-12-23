<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('raw-store.supplier.index', compact('suppliers'));

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
        $request->validate([
            'name' => 'required|string ',
            'address' => 'required|string ',
            'mobile_no' => 'required|string ',
            'status' => 'required' 
        ]);

        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->mobile_no = $request->mobile_no;
        $supplier->email = $request->email;
        $supplier->status = $request->status;
        $supplier->save();

        $notification = array('message'=>'Store Created Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {

        $supplier = Supplier::findOrfail($supplier->id);
        $suppliers = Supplier::all();
        return view('raw-store.supplier.edit', compact('supplier', 'suppliers'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
         $request->validate([
            'name' => 'required|string ',
            'address' => 'required|string ',
            'mobile_no' => 'required|string ',
            'status' => 'required' 
        ]);

        $supplier = Supplier::findOrfail($supplier->id);
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->mobile_no = $request->mobile_no;
        $supplier->email = $request->email;
        $supplier->status = $request->status;
        $supplier->update();

        $notification = array('message'=>'Supplier Updated Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
        $supplier->delete($supplier->id);

        $notification = array('message'=>'Supplier Delete Successfull', 'alert-type' => 'success');

        return redirect()->route('supplier.index')->with($notification);
    }
}
