<x-layout-app :title="'Tambah Jenis Service'">

    <div class="mb-4">
        <a href="{{ route('admin.service.index') }}" class="text-decoration-none text-muted small">&larr; Kembali ke Data Jenis Service</a>
        <h3 class="fw-bold text-dark mt-2">Tambah Jenis Service</h3>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <ul class="m-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white" style="max-width: 600px;">
        <form method="POST" action="{{ route('admin.service.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Nama Jasa</label>
                <input type="text" name="service_name" value="{{ old('service_name') }}" required
                    class="form-control rounded-3"
                    placeholder="Contoh: Cuci dan Gosok">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Harga per Kg</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3">Rp</span>
                    <input type="number" name="price" value="{{ old('price') }}" required
                        class="form-control rounded-end-3"
                        placeholder="5000">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="form-control rounded-3"
                    placeholder="Deskripsi tambahan (opsional)">{{ old('description') }}</textarea>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
                    Simpan
                </button>
                <a href="{{ route('admin.service.index') }}" class="text-decoration-none text-muted fw-semibold small">Batal</a>
            </div>
        </form>
    </div>

</x-layout-app>