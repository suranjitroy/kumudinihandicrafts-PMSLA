<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $productTypes = ProductType::all();

        return view('raw-store.product-type.index', compact('productTypes'));
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
        'name' => 'required'
        ]);

        $productType = new ProductType();
        $productType->name = $request->name;
        $productType->user_id  = Auth::user()->id;
        $productType->created_by = Auth::user()->user_name;
        $productType->save();

        $notification = array('message'=>'Product Type Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductType $productType)
    {
        $single_product_type = ProductType::findOrfail($productType->id);

        return response()->json(['data' => $single_product_type]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductType $productType)
    {
        $productType = ProductType::findOrfail($productType->id);
        $productTypes = ProductType::all();

       return view('raw-store.product-type.edit', compact('productType', 'productTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductType $productType)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $productType = ProductType::find($productType->id);
        $productType->name = $request->name;
        $productType->user_id  = Auth::user()->id;
        $productType->updated_by = Auth::user()->user_name;
        $productType->update();
        
        $notification = array('message'=>'Product Type Update Successfull', 'alert-type' => 'success');
        return redirect()->route('product-type.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete($productType->id);

        $notification = array('message'=>'Product Type Delete Successfull', 'alert-type' => 'success');

        return redirect()->route('product-type.index')->with($notification);
    }
}
