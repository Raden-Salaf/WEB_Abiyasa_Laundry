<x-layout-app :title="'Edit User'">

    <div class="mb-4">
        <a href="{{ route('admin.user.index') }}" class="text-decoration-none text-muted small">&larr; Kembali ke Data User</a>
        <h3 class="fw-bold text-dark mt-2">Edit User</h3>
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
        <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="form-control rounded-3">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="form-control rounded-3">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Password</label>
                <input type="password" name="password"
                    class="form-control rounded-3"
                    placeholder="Kosongkan jika tidak ingin mengubah">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Level</label>
                <select name="id_level" required class="form-select rounded-3">
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}" {{ old('id_level', $user->id_level) == $level->id ? 'selected' : '' }}>
                            {{ $level->level_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
                    Update
                </button>
                <a href="{{ route('admin.user.index') }}" class="text-decoration-none text-muted fw-semibold small">Batal</a>
            </div>
        </form>
    </div>

</x-layout-app>