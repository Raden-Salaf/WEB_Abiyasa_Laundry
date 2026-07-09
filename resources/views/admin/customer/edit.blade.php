<x-layout-app :title="'Edit Customer'">

    <div class="mb-4">
        <a href="{{ route('admin.customer.index') }}" class="text-decoration-none text-muted small">&larr; Kembali ke Data Customer</a>
        <h3 class="fw-bold text-dark mt-2">Edit Customer</h3>
    </div>

    {{-- Tampilkan semua pesan error validasi --}}
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
        <form method="POST" action="{{ route('admin.customer.update', $customer->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Nama Customer</label>
                <input type="text" name="customer_name" value="{{ old('customer_name', $customer->customer_name) }}" required
                    class="form-control rounded-3">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" maxlength="13" required
                    class="form-control rounded-3">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Alamat</label>
                <textarea name="address" rows="3" required
                    class="form-control rounded-3">{{ old('address', $customer->address) }}</textarea>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
                    Update
                </button>
                <a href="{{ route('admin.customer.index') }}" class="text-decoration-none text-muted fw-semibold small">Batal</a>
            </div>
        </form>
    </div>

</x-layout-app>
