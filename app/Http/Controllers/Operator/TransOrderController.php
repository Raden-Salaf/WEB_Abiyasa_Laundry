<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\TypeOfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransOrderController extends Controller
{
    // Menampilkan daftar semua transaksi order
    public function index()
    {
        // Load relasi customer supaya nama customer bisa ditampilkan tanpa query tambahan (N+1 problem)
        $orders = TransOrder::with('customer')->latest()->paginate(10);
        return view('operator.order.index', compact('orders'));
    }

    // Menampilkan form input transaksi baru
    public function create()
    {
        $customers = Customer::orderBy('customer_name')->get(); // untuk dropdown pilih customer
        $services  = TypeOfService::orderBy('service_name')->get(); // untuk pilihan jenis jasa
        return view('operator.order.create', compact('customers', 'services'));
    }

    // Menyimpan transaksi baru beserta detail jasanya
    public function store(Request $request)
    {
        // Validasi: id_customer wajib, dan minimal harus ada 1 baris detail jasa
        $request->validate([
            'id_customer'        => 'required|exists:customer,id',
            'services'           => 'required|array|min:1', // array id_service
            'services.*'         => 'required|exists:type_of_service,id',
            'qty'                => 'required|array|min:1', // array qty, sejajar dengan services
            'qty.*'              => 'required|numeric|min:0.1',
            'notes'              => 'nullable|array',
            'pay_now'            => 'required|in:0,1',
            'order_pay'          => 'nullable|numeric|min:0',
            'order_change'       => 'nullable|numeric|min:0',
        ]);

        // Gunakan DB Transaction supaya proses insert header + detail bersifat atomic
        // (kalau salah satu gagal, semua di-rollback, tidak ada data setengah jadi)
        DB::transaction(function () use ($request) {

            // Generate kode order unik, format: LAUNDRY-YYYYMMDD-XXXX
            $orderCode = 'LAUNDRY-' . now()->format('Ymd') . '-' . str_pad(TransOrder::whereDate('created_at', now())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Buat header transaksi terlebih dahulu, total sementara 0 (akan diupdate setelah detail dihitung)
            $order = TransOrder::create([
                'id_customer'    => $request->id_customer,
                'order_code'     => $orderCode,
                'order_date'     => now()->toDateString(),
                'order_end_date' => null, // belum ditentukan, diisi saat proses/selesai
                'order_status'   => 0, // 0 = baru, sesuai alur dokumentasi
                'order_pay'      => 0,
                'order_change'   => 0,
                'total'          => 0,
            ]);

            $grandTotal = 0;

            // Loop setiap jasa yang dipilih operator, hitung subtotal, simpan ke detail
            foreach ($request->services as $index => $serviceId) {
                $service = TypeOfService::findOrFail($serviceId);
                $qty     = $request->qty[$index];
                $subtotal = $service->price * $qty; // sesuai rumus dokumentasi: Subtotal = harga * qty

                TransOrderDetail::create([
                    'id_order'   => $order->id,
                    'id_service' => $service->id,
                    'qty'        => $qty,
                    'subtotal'   => $subtotal,
                    'notes'      => $request->notes[$index] ?? null,
                ]);

                $grandTotal += $subtotal;
            }

            $tax = round($grandTotal * 0.1);
            $totalDue = $grandTotal + $tax;

            $orderData = ['total' => $grandTotal];
            if ($request->pay_now == '1') {
                $payment = $request->order_pay ?? 0;
                if ($payment < $totalDue) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'order_pay' => 'Jumlah pembayaran harus sama atau lebih besar dari total transaksi termasuk pajak.',
                    ]);
                }

                $orderData['order_pay'] = $payment;
                $orderData['order_change'] = max($payment - $totalDue, 0);
            }

            // Update total keseluruhan di header transaksi setelah semua detail dihitung
            $order->update($orderData);
        });

        return redirect()->route('operator.order.index')->with('success', 'Transaksi laundry berhasil dibuat.');
    }

    // Menampilkan detail 1 transaksi (untuk melihat rincian jasa yang dipilih)
    public function show(TransOrder $order)
    {
        $order->load('customer', 'details.service'); // load relasi customer & detail beserta jenis jasanya
        return view('operator.order.show', compact('order'));
    }
}
