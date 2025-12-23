<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\StoreCategory;
use Illuminate\Support\Facades\Auth;

class MaterialSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::all();
        $storeCategories = StoreCategory::all();
        $units = Unit::all();
        $materialSetups = MaterialSetup::with('store','storeCategory','unit')->get();

        return view('raw-store.material-setup.index', compact('stores','storeCategories','materialSetups','units'));
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
            'store_id' => 'required',
            'store_category_id' => 'required',
            'material_name' => 'required|string',
            'unit_id' => 'required',
        ]);

        $materialSetup = new MaterialSetup;

        $materialSetup->store_id = $request->store_id;
        $materialSetup->store_category_id = $request->store_category_id;
        $materialSetup->material_name = $request->material_name;
        $materialSetup->unit_id = $request->unit_id;
        $materialSetup->created_by = Auth::user()->user_name;

        //dd($materialSetup);

        $materialSetup->save();

        $notification = array('message'=>'Material Setup Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);


        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialSetup $materialSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialSetup $materialSetup)
    {
        
        $materialSetup = MaterialSetup::findOrfail($materialSetup->id);
        $storeCategoryID = $materialSetup->store_category_id;
        $stores = Store::all();
        $storeCategories = StoreCategory::all();
        $units = Unit::all();
        $unitID = $materialSetup->unit_id;
        //$storeCategory = StoreCategory::findOrfail($storeCategory->id);
        $materialSetups = MaterialSetup::with('store','storeCategory','unit')->get();

        return view('raw-store.material-setup.edit', compact('materialSetups', 'storeCategories', 'stores','materialSetup','storeCategoryID','units','unitID'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialSetup $materialSetup)
    {
        //
         $request->validate([
            'store_id' => 'required',
            'store_category_id' => 'required',
            'material_name' => 'required|string',
            'unit_id' => 'required',
        ]);

        $materialSetup = MaterialSetup::findOrfail($materialSetup->id);

        $materialSetup->store_id = $request->store_id;
        $materialSetup->store_category_id = $request->store_category_id;
        $materialSetup->material_name = $request->material_name;
        $materialSetup->unit_id = $request->unit_id;
        $materialSetup->updated_by = Auth::user()->user_name;

        $materialSetup->update();

        $notification = array('message'=>'Material Setup Updated Successfull', 'alert-type' => 'success');

        return redirect()->route('material-setup.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialSetup $materialSetup)
    {
        $materialSetup->delete($materialSetup->id);

        $notification = array('message'=>'Material Setup Deleted Successfull', 'alert-type' => 'success');

        return redirect()->route('material-setup.index')->with($notification);
    }

    public function getStoreCategory(Request $request){
        
        // $data['stcategory'] = StoreCategory::where('store_id', $request->store_id)->get(['category_name', 'id']);

        // return response()->json($data);

        $store_id = $request->store_id;

        $allStoreCategory = StoreCategory::select('id', 'category_name')->where('store_id', $store_id)->get();

        //dd($allStoreCategory);

        return response()->json($allStoreCategory); 
 
    }
}
