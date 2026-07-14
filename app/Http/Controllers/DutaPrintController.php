<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

class DutaPrintController extends Controller
{
    // 1. PASTIKAN METHOD INI ADA
    public function penjualan()
    {
        return view('dutaprint.penjualan');
    }

    // 2. Method untuk menyimpan data dari kasir
   // app/Http/Controllers/DutaPrintController.php

public function storePenjualan(Request $request)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'discount_percent' => 'nullable|numeric|min:0|max:100', // Validasi persen (0 - 100%)
        'items' => 'required|array',
        'items.*.name' => 'required|string',
        'items.*.machine' => 'required|in:outdoor,indoor,ricoh,riso,cardpresso,sablon,cutting',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'items.*.notes' => 'nullable|string',
    ]);
    // Ambil input persen, default 0 jika kosong
        $discountPercent = $request->input('discount_percent', 0);

    // 1. Ambil transaksi terakhir pada hari/bulan ini
        $lastSale = Sale::latest()->first();
        $nextNumber = 1;

if ($lastSale) {
    // Mengambil angka dari nomor invoice terakhir, misal dari DP-0005 diambil angka 5
    $lastNumber = (int) substr($lastSale->invoice_number, 3);
    $nextNumber = $lastNumber + 1;
}

// 2. Format angka menjadi 4 digit (misal: 0001, 0002)
$formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
         $sale = Sale::create([
        'invoice_number' => 'DP-' . $formattedNumber,
        'customer_name' => $validated['customer_name'],
        'total_price' => 0,
        'discount' => 0, // Akan di-update setelah total item dihitung
        'grand_total' => 0,
        'user_id' => Auth::id(),
    ]);

    $total = 0;
    foreach ($validated['items'] as $item) {
        $subtotal = $item['qty'] * $item['price'];
        $total += $subtotal;

        SaleItem::create([
            'sale_id' => $sale->id,
            'item_name' => $item['name'],
            'machine' => $item['machine'],
            'qty' => $item['qty'],
            'price' => $item['price'],
            'subtotal' => $subtotal,
            'notes' => $item['notes'] ?? null,
        ]);
    }

    // Hitung nominal diskon berdasarkan persen
    $discountNominal = ($total * $discountPercent) / 100;
    $grandTotal = max(0, $total - $discountNominal);

    // Simpan nominal diskon ke database agar laporan Excel & Invoice tetap akurat secara finansial
    $sale->update([
        'total_price' => $total,
        'discount' => $discountNominal,
        'grand_total' => $grandTotal
    ]);

    return redirect()->route('penjualan')->with('success', 'Data transaksi penjualan berhasil disimpan!');
}
    // 3. Method untuk cetak faktur
    public function invoice($id)
    {
        $sale = Sale::with('saleItems')->findOrFail($id);
        return view('dutaprint.invoice', compact('sale'));
    }

    // 4. Method untuk halaman laporan
    public function laporan(Request $request)
    {
        $query = SaleItem::with('sale');

        if ($request->filled('machine')) {
            $query->where('machine', $request->machine);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->latest()->paginate(10);
        return view('dutaprint.laporan', compact('items'));
    }

    // 5. Method untuk antrean operator cetak
    public function operatorDashboard(Request $request)
    {
        $user = Auth::user();
        $machine = $request->get('machine', $user->operator_machine ?? 'outdoor');

        $orders = SaleItem::where('machine', $machine)
                            ->whereIn('status', ['pending', 'proses'])
                            ->latest()
                            ->get();

        return view('dutaprint.operator', compact('orders', 'machine'));
    }

    // 6. Method untuk update status cetak oleh operator
    public function updateStatus($id, Request $request)
    {
        $item = SaleItem::findOrFail($id);
        $item->update(['status' => $request->status]);
        return back()->with('success', 'Status antrean berhasil diperbarui!');
    }

    // 7. Method untuk halaman pengaturan user & tema
    public function settings()
    {
        $users = User::all();
        return view('dutaprint.settings', compact('users'));
    }

    // 8. Method untuk update hak akses user & tema
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['role', 'operator_machine', 'theme_color']));
        return back()->with('success', 'Konfigurasi user diperbarui!');
    }

    // 9. TAMBAHKAN METHOD EXPORT
    public function exportExcel(Request $request)
    {
    $fileName = 'Laporan-Penjualan-DutaPrint-' . date('Y-m-d') . '.xlsx';
    return Excel::download(new SalesExport($request->machine, $request->status), $fileName);
    }
}
