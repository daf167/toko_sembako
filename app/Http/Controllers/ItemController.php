<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $perPage = $this->perPage();

        return view('master.items.index', [
            'items' => Item::with('category')->latest()->paginate($perPage)->withQueryString(),
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        return view('master.items.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Item::create($this->validatedData($request));

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Item $item)
    {
        $item->load('category', 'inventoryLogs.user');

        return view('master.items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('master.items.edit', [
            'item' => $item,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $item->update($this->validatedData($request, $item));

        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        if ($item->current_stock > 0) {
            return back()->withErrors([
                'item' => 'Barang tidak dapat dihapus karena stok masih tersedia.',
            ]);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Item $item = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'item_code' => ['required', 'string', 'max:50', 'unique:items,item_code,'.($item?->id ?? 'NULL')],
            'name' => ['required', 'string', 'max:255'],
            'current_stock' => ['required', 'integer', 'min:0'],
            'lowest_stock_threshold' => ['required', 'integer', 'min:0'],
        ]);
    }
}
