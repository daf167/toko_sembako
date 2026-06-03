<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    public function stock()
    {
        return view('inventory.stock', [
            'items' => Item::with('category')->orderBy('name')->get(),
            'logs' => InventoryLog::with('item', 'user')->latest()->limit(10)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'type' => ['required', 'in:masuk,keluar'],
            'quantity' => ['required', 'integer', 'min:1'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($data) {
            $item = Item::with('category')->lockForUpdate()->findOrFail($data['item_id']);
            $stockBefore = $item->current_stock;

            if ($data['type'] === 'keluar' && $item->current_stock < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok keluar melebihi stok tersedia.',
                ]);
            }

            $item->current_stock = $data['type'] === 'masuk'
                ? $item->current_stock + $data['quantity']
                : $item->current_stock - $data['quantity'];
            $stockAfter = $item->current_stock;
            $item->save();

            InventoryLog::create([
                'item_id' => $item->id,
                'user_id' => auth()->id(),
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'date' => $data['date'],
                'item_code_snapshot' => $item->item_code,
                'item_name_snapshot' => $item->name,
                'category_name_snapshot' => $item->category?->name,
                'notes' => $data['notes'] ?? null,
            ]);
        });

        return redirect()->route('inventory.stock')->with('success', 'Transaksi stok berhasil disimpan.');
    }
}
