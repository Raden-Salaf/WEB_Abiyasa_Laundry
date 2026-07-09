<x-layout-app :title="'Data User'">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Data User</h3>
            <p class="text-muted small m-0">Kelola akun Administrator, Operator, dan Pimpinan.</p>
        </div>
        <a href="{{ route('admin.user.create') }}"
            class="btn btn-primary px-4 py-2 rounded-3 d-flex align-items-center gap-2">
            <span>+</span> Tambah User
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold">No</th>
                        <th class="px-4 py-3 fw-semibold">Nama</th>
                        <th class="px-4 py-3 fw-semibold">Email</th>
                        <th class="px-4 py-3 fw-semibold">Level</th>
                        <th class="px-4 py-3 fw-semibold text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-muted">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-3 fw-bold text-dark">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-muted">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $badgeColor = match ($user->level->level_name) {
                                        'Administrator' => 'bg-primary text-white',
                                        'Operator' => 'bg-info text-dark',
                                        'Pimpinan' => 'bg-danger text-white',
                                        default => 'bg-secondary text-white',
                                    };
                                @endphp
                                <span class="badge {{ $badgeColor }} rounded-pill px-3 py-1.5 fw-semibold text-xs">
                                    {{ $user->level->level_name }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.user.edit', $user->id) }}"
                                        class="btn btn-sm btn-outline-primary px-3 rounded-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                        class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-2">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-5 text-center text-muted">
                                Belum ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</x-layout-app>