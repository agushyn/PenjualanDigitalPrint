@extends('layouts.dutaprint')

@section('content')
<div class="neo-box bg-white p-6">
    <h2 class="text-3xl font-black uppercase mb-6">Laporan Transaksi & Rincian Barang</h2>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-amber-100 border-3 border-black">
        <div>
            <label class="block font-bold mb-1">Filter Jenis Mesin</label>
            <select name="machine" class="w-full p-2 border-3 border-black font-bold">
                <option value="">-- Semua Mesin --</option>
                <option value="outdoor">Outdoor</option>
                <option value="indoor">Indoor</option>
                <option value="ricoh">Ricoh</option>
                <option value="riso">Riso</option>
                <option value="cardpresso">Cardpresso</option>
                <option value="sablon">Sablon</option>
                <option value="cutting">Cutting</option>
            </select>
        </div>
        <div>
            <label class="block font-bold mb-1">Filter Status Produksi</label>
            <select name="status" class="w-full p-2 border-3 border-black font-bold">
                <option value="">-- Semua Status --</option>
                <option value="pending">Pending</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selasai</option>
            </select>
        </div>
        <!-- Cari bagian tombol filter di halaman laporan dan sesuaikan baris form filternya -->
<div class="flex items-end gap-2">
    <button type="submit" class="neo-btn bg-black text-white px-4 py-2 w-full uppercase">
        Filter 🔍
    </button>
    <!-- Tombol Download Excel Neobrutalism Hijau Stabilo -->
    <a href="{{ route('laporan.export', request()->all()) }}" class="neo-btn bg-[#adff2f] text-black px-4 py-2 w-full uppercase text-center font-black">
        EXPORT KE EXCEL
    </a>
</div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full border-4 border-black text-left font-bold">
            <thead>
                <tr class="bg-black text-white uppercase text-sm">
                    <th class="p-3 border-r-2 border-white">Invoice</th>
                    <th class="p-3 border-r-2 border-white">Tanggal</th>
                    <th class="p-3 border-r-2 border-white">Pelanggan</th>
                    <th class="p-3 border-r-2 border-white">Nama Barang</th>
                    <th class="p-3 border-r-2 border-white">Mesin</th>
                    <th class="p-3 border-r-2 border-white">Qty</th>
                    <th class="p-3 border-r-2 border-white">Subtotal</th>
                    <th class="p-3 border-r-2 border-white">Finishing/Notes</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y-4 divide-black">
                @foreach($items as $item)
                <tr class="bg-white hover:bg-slate-50">
                    <td class="p-3 border-r-4 border-black">{{ $item->sale->invoice_number }}</td>
                    <td class="p-3 border-r-4 border-black">{{ $item->sale->created_at }}</td>
                    <td class="p-3 border-r-4 border-black">{{ $item->sale->customer_name }}</td>
                    <td class="p-3 border-r-4 border-black">{{ $item->item_name }}</td>
                    <td class="p-3 border-r-4 border-black uppercase text-xs"><span class="bg-cyan-200 px-2 py-1 border-2 border-black">{{ $item->machine }}</span></td>
                    <td class="p-3 border-r-4 border-black">{{ $item->qty }}</td>
                    <td class="p-3 border-r-4 border-black">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    <td class="p-3 border-r-4 border-black text-sm text-gray-700 font-medium">{{ $item->notes ?? '-' }}</td>
                    <td class="p-3">
                        <span class="px-3 py-1 text-xs border-2 border-black uppercase
                            {{ $item->status == 'pending' ? 'bg-rose-400' : ($item->status == 'proses' ? 'bg-amber-300' : 'bg-emerald-400') }}">
                            {{ $item->status }}
                        </span>
                <a href="{{ route('invoice', $item->sale_id) }}"
               class="bg-yellow-300 text-black text-xs font-black uppercase px-2.5 py-1 border-2 border-black shadow-[2px_2px_0px_0px_#000000] active:translate-x-[1px] active:translate-y-[1px] active:shadow-[1px_1px_0px_0px_#000000] hover:bg-yellow-400 transition-all text-center">
                🖨️ Invoice
            </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>
@endsection
