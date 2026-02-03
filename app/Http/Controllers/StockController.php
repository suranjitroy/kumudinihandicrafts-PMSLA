<?php

namespace App\Http\Controllers;
use App\Models\Unit;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\MaterialSetup;
use App\Models\StoreCategory;

class StockController extends Controller
{
    public function fabric()
    {
        $stores = Store::all();
        $storeCategories = StoreCategory::all();
        $units = Unit::all();
        $materialSetups = MaterialSetup::with('store','storeCategory','unit')->where('store_id', 1)->where('store_category_id', 2)->get();

        return view('raw-store.stock.fabric', compact('stores','storeCategories','materialSetups','units'));
    }
    public function accessories()
    {
        $stores = Store::all();
        $storeCategories = StoreCategory::all();
        $units = Unit::all();
        $materialSetups = MaterialSetup::with('store','storeCategory','unit')->where('store_id', 1)->where('store_category_id', 1)->get();

        return view('raw-store.stock.accessories', compact('stores','storeCategories','materialSetups','units'));
    }
}
