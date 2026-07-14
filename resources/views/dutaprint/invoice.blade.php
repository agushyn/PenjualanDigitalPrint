<!-- resources/views/dutaprint/invoice.blade.php -->
@extends('layouts.dutaprint')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="no-print mb-6 flex justify-between items-center">
        <a href="{{ route('laporan') }}" class="neo-btn bg-black text-white px-4 py-2 uppercase font-bold text-sm">⬅️ Kembali ke Laporan</a>
        <button onclick="window.print()" class="neo-btn bg-yellow-300 text-black px-6 py-2.5 uppercase font-black text-md">Cetak Invoice 🖨️</button>
    </div>

    <!-- Tampilan Struk / Faktur Neobrutalisme -->
    <div class="neo-box bg-white p-8 relative overflow-hidden" id="print-area">
        <!-- Dekorasi Gunting Nota -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-stone-200" style="background-image: radial-gradient(circle, transparent 40%, white 41%), linear-gradient(0deg, #ccc 2px, transparent 2px); background-size: 16px 16px;"></div>

        <!-- Header Nota -->
        <div class="text-center my-6">
            <h1 class="text-4xl font-black uppercase tracking-wider mb-1">DUTAPRINT</h1>
            <p class="font-bold text-sm">SOLUSI CETAK DIGITAL CEPAT & BERKUALITAS</p>
            <p class="text-xs font-medium">Jl. Villa Pertiwi No 1, Sukamaju,Depok, Jawa Barat</p>
            <p class="text-xs font-medium">Telp: (021) 876-54321 | WA: 0812-3456-7890</p>
        </div>

        <hr class="border-t-4 border-dashed border-black my-6">

        <!-- Informasi Transaksi -->
        <div class="grid grid-cols-2 gap-4 text-sm font-bold mb-6">
            <div>
                <p class="text-gray-600">No. Invoice:</p>
                <p class="text-lg font-black uppercase">{{ $sale->invoice_number }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-600">Tanggal Transaksi:</p>
                <p>{{ $sale->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-600">Pelanggan:</p>
                <p class="text-md uppercase">{{ $sale->customer_name }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-600">Kasir:</p>
                <p class="uppercase">{{ $sale->user->name ?? 'System' }}</p>
            </div>
        </div>

        <!-- Tabel Item Belanja -->
        <table class="w-full text-left font-bold text-sm mb-6">
            <thead>
                <tr class="border-b-4 border-black text-gray-700">
                    <th class="pb-2">Deskripsi Layanan</th>
                    <th class="pb-2 text-center">Qty</th>
                    <th class="pb-2 text-right">Harga</th>
                    <th class="pb-2 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-gray-200">
                @foreach($sale->saleItems as $item)
                <tr>
                    <td class="py-3">
                        <span class="block font-black">{{ $item->item_name }}</span>
                        <span class="inline-block text-[10px] bg-black text-white px-1.5 py-0.25 uppercase mt-1">Divisi: {{ $item->machine }}</span>
                        @if($item->notes)
                        <span class="block text-xs text-gray-600 italic font-medium mt-1">Ket: {{ $item->notes }}</span>
                        @endif
                    </td>
                    <td class="py-3 text-center">{{ $item->qty }}</td>
                    <td class="py-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="py-3 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr class="border-t-4 border-black my-4">

        <!-- Total Pembayaran & Cap Status -->
        <div class="flex justify-between items-center">
            <!-- Cap LUNAS Neobrutalism -->
            <div class="border-4 border-emerald-500 text-emerald-500 font-black text-xl px-4 py-2 rotate-[-6deg] uppercase tracking-widest bg-emerald-50">
                💵 LUNAS
            </div>
            <div class="text-right">
                <p class="font-bold text-gray-600 text-sm">TOTAL BAYAR</p>
                <p class="text-3xl font-black">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="text-right space-y-1 font-bold">
    <p class="text-xs text-gray-600">Total Kotor: Rp {{ number_format($sale->total_price, 0, ',', '.') }}</p>

    @if($sale->total_price > 0 && $sale->discount > 0)
        @php
            // Menghitung kembali persentase untuk ditampilkan di struk
            $percentValue = round(($sale->discount / $sale->total_price) * 100);
        @endphp
        <p class="text-xs text-red-500">Diskon ({{ $percentValue }}%): -Rp {{ number_format($sale->discount, 0, ',', '.') }}</p>
    @else
        <p class="text-xs text-gray-600">Diskon: 0%</p>
    @endif

    <hr class="border-black border-dashed">
    <p class="font-bold text-gray-600 text-sm">TOTAL BERSIH (GRAND TOTAL)</p>
    <p class="text-3xl font-black bg-yellow-300 border-2 border-black inline-block px-2">
        Rp {{ number_format($sale->grand_total, 0, ',', '.') }}
    </p>
</div>
    </div>
</div>

<style>
    @media print {
        body {
            background-color: white !important;
            padding: 0 !important;
        }
        nav, .no-print {
            display: none !important;
        }
        .neo-box {
            box-shadow: none !important;
            border-width: 2px !important;
        }
    }
</style>
@endsection
