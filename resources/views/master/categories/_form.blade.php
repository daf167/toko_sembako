@csrf
<div class="mb-3">
    <label class="form-label" for="name">Nama Kategori</label>
    <input class="form-control" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label" for="description">Deskripsi</label>
    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $category->description ?? '') }}</textarea>
</div>
<div class="d-flex gap-2">
    <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Simpan</button>
    <a class="btn btn-outline-secondary" href="{{ route('categories.index') }}">Batal</a>
</div>
