<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2">
        @foreach(request()->except(['page', 'per_page']) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <label class="text-secondary small mb-0" for="{{ $id ?? 'per_page' }}">Show</label>
        <select class="form-select form-select-sm w-auto" id="{{ $id ?? 'per_page' }}" name="per_page" onchange="this.form.submit()">
            @foreach([5, 10, 25, 50, 100] as $option)
                <option value="{{ $option }}" @selected(($perPage ?? 10) === $option)>{{ $option }}</option>
            @endforeach
        </select>
        <span class="text-secondary small">entries</span>
    </form>

    <div class="text-secondary small">
        @if($paginator->total() > 0)
            Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        @else
            Menampilkan 0 data
        @endif
    </div>
</div>
