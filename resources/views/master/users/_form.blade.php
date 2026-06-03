@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name">Nama</label>
        <input class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="email">Email</label>
        <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="role">Role</label>
        <select class="form-select" id="role" name="role" required>
            @foreach(['admin' => 'Admin', 'staff' => 'Staff Inventory', 'owner' => 'Owner'] as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $user->role ?? 'staff') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="password">Password</label>
        <input class="form-control" id="password" name="password" type="password" {{ isset($user) ? '' : 'required' }}>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" {{ isset($user) ? '' : 'required' }}>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Simpan</button>
    <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Batal</a>
</div>
