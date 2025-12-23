<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Item;
use App\Models\Size;
use App\Models\Bahar;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\ConsumptionSetup;
use Illuminate\Support\Facades\DB;
use App\Models\ConsumptionSetupItem;
use Illuminate\Support\Facades\Auth;

class ConsumptionSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $alldata = ConsumptionSetup::with('materialSetup','unit','item','bahar')->orderBy('item_id','desc')->get();
       // $alldata = PurchaseItem::with('purchaseItems','supplier','material')->orderBy('entry_date','desc')->get();
        return view('raw-store.consumption-setup.index', compact('alldata'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allItem = Item::all();
        $allMaterial = MaterialSetup::where('store_category_id', 2)->get();
        $allBahar = Bahar::all();
        $allSize = Size::all();

        return view('raw-store.consumption-setup.create',compact('allItem','allMaterial','allBahar','allSize'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
        if($request->material_setup_id == null){

             $notification = array('message'=>'Sorry! you do not select any material', 'alert-type' => 'error');

            return redirect()->back()->with($notification);
        }
        else{
        DB::beginTransaction();

        try{

            $consumption = new ConsumptionSetup();
            $consumption->item_id           = $request->item_id;
            $consumption->material_setup_id = $request->material_setup_id;
            $consumption->bahar_id          = $request->bahar_id;
            $consumption->user_id           = Auth::user()->id;
            $consumption->created_by        = Auth::user()->user_name;

            $consumption->save();

            $consumptionID = $consumption->id;
            $consumptionItemID = $consumption->item_id;
            $consumptionMatID  = $consumption->material_setup_id;
            $consumptionBaharID = $consumption->bahar_id;
            $consumptionUserID = $consumption->user_id;
            $consumptionCreatedBy = $consumption->created_by;

            //dd($consumptionID);

            //dd($consumption);

            if($consumptionID){

                $items = count($request->size_id);

                for($i=0; $i <$items; $i++){

                    //dd($items);

                    $consumption_items = new ConsumptionSetupItem();

                    $consumption_items->consumption_setup_id = $consumptionID;
                    $consumption_items->item_id              = $consumptionItemID;
                    $consumption_items->material_setup_id    = $consumptionMatID;
                    $consumption_items->bahar_id             = $consumptionBaharID;
                    $consumption_items->size_id              = $request->size_id[$i];
                    $consumption_items->consumption_qty      = $request->consumption_qty[$i];
                    $consumption_items->unit_id              = $request->unit_id[$i];
                    $consumption_items->user_id             = $consumptionUserID;
                    $consumption_items->created_by          = $consumptionCreatedBy;
                    $consumption_items->save();
                }


            }

            DB::commit();

            $notification = array('message'=>'Consumption Setup Added Successfull', 'alert-type' => 'success');

            return redirect()->route('consumption-setup.index')->with($notification);

        }catch(Exception $e){

            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ConsumptionSetup $consumptionSetup)
    {
        $consumption = ConsumptionSetup::with('materialSetup','unit','item','bahar')->findOrfail($consumptionSetup->id);
        $consumptionItems = ConsumptionSetupItem::with('size','unit')->where('consumption_setup_id', $consumption->id)->get();
        
        //dd($purchaseItems);

        return view('raw-store.consumption-setup.show', compact('consumption','consumptionItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConsumptionSetup $consumptionSetup)
    {

        $allItem = Item::all();
        $allMaterial = MaterialSetup::where('store_category_id', 2)->get();
        $allBahar = Bahar::all();
        $allSize = Size::all();
        $consumption = ConsumptionSetup::findOrfail($consumptionSetup->id);
        $consumptionItems = ConsumptionSetupItem::with('size','unit')->where('consumption_setup_id', $consumption->id)->get();

        //dd($purchaseitems->toArray());

        return view('raw-store.consumption-setup.edit',compact('allItem','allMaterial','allBahar','allSize','consumption','consumptionItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
            try {

                 $consumption = ConsumptionSetup::findOrFail($id);

                 $consumption->item_id           = $request->item_id;
                 $consumption->material_setup_id = $request->material_setup_id;
                 $consumption->bahar_id          = $request->bahar_id;
                 $consumption->user_id           = Auth::user()->id;
                 $consumption->updated_by        = Auth::user()->user_name;

                //  dd($request->all());

                 $consumption->save();

                    
                $consumptionID = $consumption->id;
                $consumptionItemID = $consumption->item_id;
                $consumptionMatID  = $consumption->material_setup_id;
                $consumptionBaharID = $consumption->bahar_id;
                $consumptionUserID = $consumption->user_id;
                $consumptionUpdatedBy = $consumption->updated_by;


                //if($consumptionID){

                    

                // 3. Delete old items (or update them if you need that logic)
                ConsumptionSetupItem::where('consumption_setup_id', $consumptionID)->delete();

                // 4. Insert new items

                $items = count($request->size_id);

                //dd($items);

                     for($i=0; $i <$items; $i++){

                    //dd($items);

                    $consumption_items = new ConsumptionSetupItem();

                    $consumption_items->consumption_setup_id = $consumptionID;
                    $consumption_items->item_id              = $consumptionItemID;
                    $consumption_items->material_setup_id    = $consumptionMatID;
                    $consumption_items->bahar_id             = $consumptionBaharID;
                    $consumption_items->size_id              = $request->size_id[$i];
                    $consumption_items->consumption_qty      = $request->consumption_qty[$i];
                    $consumption_items->unit_id              = $request->unit_id[$i];
                    $consumption_items->user_id             = $consumptionUserID;
                    $consumption_items->updated_by          = $consumptionUpdatedBy;
                    $consumption_items->save();
                }

                //}

                //dd($request->all());

                DB::commit();

                $notification = array('message'=>'Consumption Setup Updated Successfully', 'alert-type' => 'success');
                return redirect()->route('consumption-setup.index')->with($notification);

                
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsumptionSetup $consumptionSetup){
        DB::beginTransaction();

        try {
            // 1. Find Store Requsition
            $consumption = ConsumptionSetup::findOrFail($consumptionSetup->id);

            // 2. Delete related Store Requsition Items first
            ConsumptionSetupItem::where('consumption_setup_id', $consumption->id)->delete();

            // 3. Delete Store Requsition
            $consumption->delete();

            DB::commit();

            $notification = ['message' => 'Consumption Setup Deleted Successfully', 'alert-type' => 'success'];
            
            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function getMaterialDataConsumption(Request $request){
        
        $data['materialID'] = MaterialSetup::with('unit')->where('id', $request->material_setup_id)->get([ 'unit_id']);
        
        //$data= MaterialSetup::where('id', $request->material_setup_id)->first()->unit_id;

        return response()->json($data);

    }
    public function getSizeConsumption(Request $request){
        
        $data['sizeID'] = ConsumptionSetupItem::with('unit')->whereNotIn('size_id', [$request->size_id])->get(['unit_id']);
        
        //$data= MaterialSetup::where('id', $request->material_setup_id)->first()->unit_id;

        return response()->json($data);

    }
}
