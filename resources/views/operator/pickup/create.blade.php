<x-layout-app :title="'Proses Pengambilan'">

    <div class="mb-4">
        <a href="{{ route('operator.pickup.index') }}" class="text-decoration-none text-muted small">&larr; Kembali ke
            Pengambilan Laundry</a>
        <h3 class="fw-bold text-dark mt-2">Proses Pengambilan — {{ $order->order_code }}</h3>
    </div>

    {{-- Info customer --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white">
        <h5 class="fw-bold text-dark mb-3">Info Customer</h5>
        <div class="row g-3 text-sm">
            <div class="col-md-6">
                <span class="text-muted small d-block">Nama</span>
                <span class="fw-bold text-dark">{{ $order->customer->customer_name ?? 'Pelanggan Terhapus' }}</span>
            </div>
            <div class="col-md-6">
                <span class="text-muted small d-block">Telepon</span>
                <span class="fw-bold text-dark font-monospace">{{ $order->customer->phone ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Rincian jasa yang dilaundry --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold">Jasa</th>
                        <th class="px-4 py-3 fw-semibold">Qty (kg)</th>
                        <th class="px-4 py-3 fw-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $detail)
                        <tr>
                            <td class="px-4 py-3 fw-bold text-dark">{{ $detail->service->service_name }}</td>
                            <td class="px-4 py-3 text-dark">{{ $detail->qty }}</td>
                            <td class="px-4 py-3 font-monospace fw-bold text-success">Rp
                                {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @php
        $subtotal = $order->details->sum('subtotal');
        $taxEnabled = old('tax_enabled', $order->tax_enabled ?? 1);
        $tax = $taxEnabled ? round($subtotal * 0.1) : 0;
        $totalDue = $subtotal + $tax;
        $isPrepaid = $order->order_pay > 0;
        $oldPayment = old('order_pay');
        $paymentDisplay = $oldPayment !== null && $oldPayment !== '' ? 'Rp ' . number_format((float) $oldPayment, 0, ',', '.') : '';
    @endphp

    @if ($isPrepaid)
        <div class="alert alert-success rounded-4 mb-4">
            <div class="fw-semibold">Pembayaran telah dilakukan di muka.</div>
            <div class="small text-muted">Pelanggan sudah bayar kok.</div>
        </div>
    @endif

    {{-- Kartu total bayar --}}
    <div class="card shadow-sm border-0 rounded-4 bg-primary bg-gradient text-white p-4 mb-4" style="max-width: 320px;">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-white-50">Subtotal</span>
            <span id="summary_subtotal" class="font-monospace fw-bold">Rp
                {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-white-50">Pajak 10%</span>
            <span id="summary_tax" class="font-monospace fw-bold">Rp {{ number_format($tax, 0, ',', '.') }}</span>
        </div>
        <div class="d-flex justify-content-between align-items-center border-top border-white border-opacity-25 pt-3">
            <span class="fw-semibold text-white-50">Total Bayar</span>
            <span id="summary_total_due" class="font-monospace fs-4 fw-bold">Rp
                {{ number_format($totalDue, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Form konfirmasi pengambilan --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white" style="max-width: 600px;">
        <form method="POST" action="{{ route('operator.pickup.store', $order->id) }}" class="form-confirm-pickup">
            @csrf

            <input type="hidden" name="order_pay" id="order_pay"
                value="{{ old('order_pay', $isPrepaid ? $order->order_pay : 0) }}">
            <input type="hidden" id="total_due" value="{{ $totalDue }}">

            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Pajak</label>
                <select name="tax_enabled" id="tax_enabled" class="form-select rounded-3">
                    <option value="1" {{ (string) $taxEnabled === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ (string) $taxEnabled === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Jumlah Bayar</label>
                <input type="text" id="payment_amount" class="form-control rounded-3" inputmode="numeric"
                    placeholder="Masukkan jumlah uang customer" autocomplete="off" {{ $isPrepaid ? 'readonly' : '' }}
                    value="{{ $isPrepaid ? 'Rp ' . number_format($order->order_pay, 0, ',', '.') : $paymentDisplay }}">
                @if ($isPrepaid)
                    <div class="form-text text-success">Pelanggan sudah membayar</div>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Kembali</label>
                <div class="form-control rounded-3 bg-light text-dark" id="change_amount">Rp
                    {{ $isPrepaid ? number_format($order->order_change, 0, ',', '.') : '0' }}
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Catatan Pengambilan (opsional)</label>
                <textarea name="notes" rows="3" class="form-control rounded-3"
                    placeholder="Contoh: diambil oleh keluarga customer">{{ old('notes') }}</textarea>
            </div>

            <button type="submit"
                class="btn btn-success px-4 py-2.5 rounded-3 fw-semibold d-inline-flex align-items-center gap-2">
                ✓ {{ $isPrepaid ? 'Konfirmasi Pengambilan' : 'Konfirmasi & Bayar' }}
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.form-confirm-pickup');
            const paymentInput = document.getElementById('payment_amount');
            const orderPayInput = document.getElementById('order_pay');
            const changeAmount = document.getElementById('change_amount');
            const taxEnabledSelect = document.getElementById('tax_enabled');
            const summarySubtotal = document.getElementById('summary_subtotal');
            const summaryTax = document.getElementById('summary_tax');
            const summaryTotalDue = document.getElementById('summary_total_due');
            const totalDueInput = document.getElementById('total_due');
            const isPrepaid = {{ $isPrepaid ? 'true' : 'false' }};

            function formatRupiah(value) {
                return value.toLocaleString('id-ID');
            }

            function parseNumber(value) {
                return Number(value.replace(/[^0-9]/g, '')) || 0;
            }

            function updateChange() {
                const paid = parseNumber(paymentInput.value);
                const taxEnabled = taxEnabledSelect.value === '1';
                const subtotal = Number({{ $subtotal }});
                const tax = taxEnabled ? Math.round(subtotal * 0.1) : 0;
                const totalDue = subtotal + tax;
                orderPayInput.value = paid;
                totalDueInput.value = totalDue;
                summarySubtotal.textContent = 'Rp ' + formatRupiah(subtotal);
                summaryTax.textContent = 'Rp ' + formatRupiah(tax);
                summaryTotalDue.textContent = 'Rp ' + formatRupiah(totalDue);
                const change = paid - totalDue;
                changeAmount.textContent = 'Rp ' + formatRupiah(Math.max(change, 0));
            }

            if (taxEnabledSelect) {
                taxEnabledSelect.addEventListener('change', updateChange);
            }

            if (!isPrepaid && paymentInput) {
                paymentInput.addEventListener('input', function () {
                    const raw = parseNumber(this.value);
                    this.value = raw > 0 ? 'Rp ' + formatRupiah(raw) : '';
                    updateChange();
                });
            }

            if (isPrepaid) {
                orderPayInput.value = {{ $order->order_pay }};
                changeAmount.textContent = 'Rp ' + formatRupiah({{ $order->order_change }});
            }

            updateChange();

            if (form) {
                form.addEventListener('submit', function (e) {
                    const totalDue = Number(totalDueInput.value) || 0;
                    const paid = Number(orderPayInput.value);
                    if (paid < totalDue || paid === 0) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Pembayaran tidak valid',
                            text: 'Jumlah bayar kurang atau tidak sesuai. Pastikan membayar total yang sesuai dengan pengaturan pajak.',
                            icon: 'error',
                            confirmButtonColor: '#3b82f6',
                            background: '#ffffff',
                            color: '#1e293b',
                            customClass: { popup: 'shadow-sm border rounded-4' }
                        });
                        return;
                    }

                    if (form.dataset.confirmed) {
                        return;
                    }

                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Pembayaran',
                        html: '<div class="text-start">' +
                            '<p class="mb-2">Total yang harus dibayar: <strong>Rp ' + formatRupiah(totalDue) + '</strong></p>' +
                            '<p class="mb-0">Uang diterima: <strong>Rp ' + formatRupiah(paid) + '</strong></p>' +
                            '</div>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Bayar & Konfirmasi',
                        cancelButtonText: 'Batal',
                        customClass: { popup: 'shadow-sm border rounded-4' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.dataset.confirmed = true;
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>

</x-layout-app>