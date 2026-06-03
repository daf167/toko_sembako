@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="category_id">Kategori</label>
        <select class="form-select" id="category_id" name="category_id" required>
            <option value="">Pilih kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="item_code">Kode Barang</label>
        <input class="form-control" id="item_code" name="item_code" value="{{ old('item_code', $item->item_code ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="name">Nama Barang</label>
        <input class="form-control" id="name" name="name" value="{{ old('name', $item->name ?? '') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="current_stock">Stok Saat Ini</label>
        <input class="form-control" id="current_stock" name="current_stock" type="number" min="0" value="{{ old('current_stock', $item->current_stock ?? 0) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="lowest_stock_threshold">Batas Stok Minimum</label>
        <input class="form-control" id="lowest_stock_threshold" name="lowest_stock_threshold" type="number" min="0" value="{{ old('lowest_stock_threshold', $item->lowest_stock_threshold ?? 10) }}" required>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Simpan</button>
    <a class="btn btn-outline-secondary" href="{{ route('items.index') }}">Batal</a>
</div>
