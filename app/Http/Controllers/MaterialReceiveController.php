<?php

namespace App\Http\Controllers;

use App\Models\{MaterialReceive, Store, StoreCategory, Unit, MaterialSetup, Supplier};
use Illuminate\Http\Request;

class MaterialReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alldata = MaterialReceive::all();
        return view('raw-store.material-receive.index', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allSupplier = Supplier::all();
        $allMaterial = MaterialSetup::all();
        //$materialSetups = MaterialSetup::with('store','storeCategory','unit')->get();
        

        return view('raw-store.material-receive.create',compact('allSupplier','allMaterial'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialReceive $materialReceive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialReceive $materialReceive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialReceive $materialReceive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialReceive $materialReceive)
    {
        //
    }
     public function getMaterialData(Request $request){
        
        $data['materialID'] = MaterialSetup::where('id', $request->material_setup_id)->get(['store_id', 'store_category_id', 'unit_id']);
        
        //$data= MaterialSetup::where('id', $request->material_setup_id)->first()->unit_id;

        return response()->json($data);

    }
}
