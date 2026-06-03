<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalItems' => Item::count(),
            'totalStockIn' => InventoryLog::where('type', 'masuk')->sum('quantity'),
            'totalStockOut' => InventoryLog::where('type', 'keluar')->sum('quantity'),
            'criticalStock' => Item::whereColumn('current_stock', '<', 'lowest_stock_threshold')->count(),
            'highestStockItem' => Item::orderByDesc('current_stock')->first(),
            'highestStockItems' => Item::with('category')->orderByDesc('current_stock')->limit(5)->get(),
            'lowestStockItems' => Item::with('category')->orderBy('current_stock')->limit(5)->get(),
        ]);
    }
}
