<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = Item::all();

        return view('raw-store.item.index', compact('items'));
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
            'name' => 'required',
            'status' => 'required|in:0,1',
        ]);

        Item::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        $notification = array('message'=>'Item Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
       $item = Item::findOrfail($item->id);
       $items = item::all();

       return view('raw-store.item.edit', compact('item', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {

        $request->validate([
            'name' => 'required'
        ]);

        $item = Item::find($item->id);
        $item->name = $request->name;
        $item->status = $request->status;
        $item->update();
        
        $notification = array('message'=>'Item Updated Successfull', 'alert-type' => 'success');
        return redirect()->route('item.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
        $item->delete($item->id);

        $notification = array('message'=>'Item Deleted Successfull', 'alert-type' => 'success');

        return redirect()->route('item.index')->with($notification);
    }
}
