<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::all();

        return view('raw-store.store.index', compact('stores'));

       // return response()->json(['data' => $store], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
        'name' => 'required'
        ]);

        $store = new Store;
        $store->name = $request->name;
        $store->save();

        $notification = array('message'=>'Store Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

        //return response()->json(['message' => 'store Added Succesfully!'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $single_store = store::findOrfail($id);

        return response()->json(['data' => $single_store]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(store $store)
    {
       $store = store::findOrfail($store->id);
       $stores = store::all();

       return view('raw-store.store.edit', compact('store', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, store $store)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $store = store::find($store->id);
        $store->name = $request->name;
        $store->update();
        
        $notification = array('message'=>'Store Update Successfull', 'alert-type' => 'success');
        return redirect()->route('store.index')->with($notification);

        //return response()->json(['message' => 'store Update Succesfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(store $store)
    {
        $store->delete($store->id);

        $notification = array('message'=>'Store Delete Successfull', 'alert-type' => 'success');

        return redirect()->route('store.index')->with($notification);
        
        //return response()->json(['name'=>'Deletede Successfull!'],200);
    }
}
