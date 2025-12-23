<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\StoreCategory;

class StoreCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storeCategorys = StoreCategory::with('store')->get();
        $stores = Store::all();

        return view('raw-store.store-category.index', compact('storeCategorys','stores'));

       // return response()->json(['data' => $store-category], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * store-category a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
        'store_id' => 'required',
        'category_name' => 'required'
        ]);

        $storeCategory = new StoreCategory;
        $storeCategory->store_id = $request->store_id;
        $storeCategory->category_name = $request->category_name;
        $storeCategory->save();

        $notification = array('message'=>'Store Category Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

        //return response()->json(['message' => 'Store Category Added Succesfully!'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $single_storeCategory = StoreCategory::findOrfail($id);

        return response()->json(['data' => $single_storeCategory]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreCategory $storeCategory)
    {
       $storeCategory = StoreCategory::findOrfail($storeCategory->id);
       //$selectStore = $storeCategory->store;
       $storeCategorys = StoreCategory::with('store')->get();
       $stores = Store::all();

       return view('raw-store.store-category.edit', compact('storeCategory', 'storeCategorys', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StoreCategory $storeCategory)
    {
        $request->validate([
        'store_id' => 'required',
        'category_name' => 'required'
        ]);


        $storeCategory = StoreCategory::find($storeCategory->id);
        $storeCategory->store_id = $request->store_id;
        $storeCategory->category_name = $request->category_name;
        $storeCategory->update();
        
        $notification = array('message'=>'Store Category Update Successfull', 'alert-type' => 'success');
        return redirect()->route('store-category.index')->with($notification);

        //return response()->json(['message' => 'store-category Update Succesfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreCategory $storeCategory)
    {
        $storeCategory->delete($storeCategory->id);

        $notification = array('message'=>'Store Category Delete Successfull', 'alert-type' => 'success');

        return redirect()->route('store-category.index')->with($notification);
        
        //return response()->json(['name'=>'Deletede Successfull!'],200);
    }
}
