<!-- resources/views/dutaprint/penjualan.blade.php -->
@extends('layouts.dutaprint')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Utama -->
    <div class="lg:col-span-2 neo-box bg-white p-6">
        <h2 class="text-3xl font-black uppercase mb-6 flex items-center gap-2">
            <span>Input Penjualan Kasir</span>
            <span class="text-sm bg-black text-white px-2 py-1 font-mono">v1.2 </span>
        </h2>

        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block font-black text-lg mb-2">Nama Pelanggan / Instansi</label>
                <input type="text" name="customer_name" placeholder="Masukkan nama pelanggan..." class="w-full p-3 border-4 border-black font-bold focus:bg-yellow-50 focus:outline-none text-lg" required>
            </div>

            <div class="border-t-4 border-black pt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-black text-2xl uppercase tracking-tight">Rincian Barang / Jasa Cetak</h3>
                    <button type="button" id="btn-add-item" class="neo-btn bg-yellow-300 text-black px-4 py-2 text-sm uppercase font-black hover:bg-yellow-400">
                        + Tambah Baris Cetak
                    </button>
                </div>

                <!-- Wadah Item Dinamis -->
                <div id="item-list" class="space-y-6">
                    <!-- Item ke-1 (Default) -->
                    <div class="item-row p-4 border-3 border-black bg-slate-50 relative">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-black uppercase mb-1">Nama Produk / Pekerjaan</label>
                                <input type="text" name="items[0][name]" placeholder="Contoh: Spanduk Pecel Lele 3x1m" class="w-full p-2.5 border-2 border-black font-bold bg-white" required>
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase mb-1">Mesin Operator</label>
                                <select name="items[0][machine]" class="w-full p-2.5 border-2 border-black font-bold bg-white">
                                    <option value="outdoor">Outdoor (Spanduk/Baliho)</option>
                                    <option value="indoor">Indoor (Stiker/Luster)</option>
                                    <option value="ricoh">Ricoh (Kartu Nama/A3+)</option>
                                    <option value="riso">Riso (Brosur Murah)</option>
                                    <option value="cardpresso">Cardpresso (ID Card)</option>
                                    <option value="sablon">Sablon (Kaos/Plastik)</option>
                                    <option value="cutting">Cutting (Potong Pola)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase mb-1">Quantity</label>
                                <input type="number" name="items[0][qty]" min="1" value="1" class="w-full p-2.5 border-2 border-black font-bold bg-white" required>
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase mb-1">Harga Satuan (Rp)</label>
                                <input type="number" name="items[0][price]" min="0" placeholder="0" class="w-full p-2.5 border-2 border-black font-bold bg-white" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase mb-1">Instruksi & Detail Finishing</label>
                            <textarea name="items[0][notes]" placeholder="Contoh: Mata ayam tiap sudut, laminasi glossy, potong pas..." class="w-full p-2.5 border-2 border-black font-medium bg-white h-20"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form Diskon -->
<div class="my-6 p-4 bg-red-50 border-3 border-black">
    <label class="block font-black text-lg mb-1 text-red-600">Potongan Diskon (%)</label>
    <div class="flex items-center">
        <input type="number" name="discount_percent" value="0" min="0" max="100" placeholder="Contoh: 10"
               class="w-full p-3 border-3 border-black font-bold bg-white text-lg focus:outline-none">
        <span class="p-3 bg-black text-white font-black text-lg border-y-3 border-r-3 border-black">%</span>
    </div>
    <p class="text-xs font-bold text-gray-600 mt-1">*Masukkan angka 0 sampai 100. Sistem akan menghitung otomatis potongan harga.*</p>
</div>

            @if(session('success'))
    <div class="bg-[#adff2f] border-4 border-black p-4 font-black uppercase text-md mb-6 shadow-[6px_6px_0px_0px_#000000]">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="mt-6">
    <button type="submit" class="neo-btn bg-emerald-400 text-black px-6 py-4 uppercase tracking-wider font-black text-xl w-full text-center block">
        Simpan Transaksi Penjualan 💾
    </button>
</div>
        </form>
    </div>

    <!-- Informasi Singkat Kasir -->
    <div class="space-y-6">
        <div class="neo-box bg-[#00f5ff] p-6 text-black">
            <h3 class="text-2xl font-black uppercase mb-4">Informasi Mesin</h3>
            <div class="space-y-3 font-bold text-sm">
                <p>⚠️ Pastikan file desain sudah divalidasi oleh divisi <strong>Design</strong> sebelum mengirim pesanan ke antrean operator.</p>
                <hr class="border-black border-2 my-2">
                <p>💡 Rumus m² untuk Outdoor/Indoor: <br><span class="font-mono bg-white px-1.5 py-0.5 border border-black">Panjang x Lebar x Qty</span></p>
            </div>
        </div>

        <div class="neo-box bg-pink-300 p-6 text-black">
            <h3 class="text-2xl font-black uppercase mb-2">Pemberitahuan</h3>
            <p class="font-bold text-sm">Faktur yang telah disimpan akan langsung didistribusikan ke dasbor operator masing-masing mesin secara otomatis tanpa perlu input ulang manual.</p>
        </div>
    </div>
</div>

<!-- Script Tambah Baris Dinamis -->
<script>
    let itemIndex = 1;
    document.getElementById('btn-add-item').addEventListener('click', function() {
        const list = document.getElementById('item-list');
        const newRow = document.createElement('div');
        newRow.className = "item-row p-4 border-3 border-black bg-slate-50 relative mt-4";
        newRow.innerHTML = `
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 bg-red-500 text-white border-2 border-black w-7 h-7 flex items-center justify-center font-bold text-sm hover:bg-red-600">X</button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-black uppercase mb-1">Nama Produk / Pekerjaan</label>
                    <input type="text" name="items[${itemIndex}][name]" placeholder="Nama Produk" class="w-full p-2.5 border-2 border-black font-bold bg-white" required>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase mb-1">Mesin Operator</label>
                    <select name="items[${itemIndex}][machine]" class="w-full p-2.5 border-2 border-black font-bold bg-white">
                        <option value="outdoor">Outdoor (Spanduk/Baliho)</option>
                        <option value="indoor">Indoor (Stiker/Luster)</option>
                        <option value="ricoh">Ricoh (Kartu Nama/A3+)</option>
                        <option value="riso">Riso (Brosur Murah)</option>
                        <option value="cardpresso">Cardpresso (ID Card)</option>
                        <option value="sablon">Sablon</option>
                        <option value="cutting">Cutting</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase mb-1">Quantity</label>
                    <input type="number" name="items[${itemIndex}][qty]" min="1" value="1" class="w-full p-2.5 border-2 border-black font-bold bg-white" required>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase mb-1">Harga Satuan (Rp)</label>
                    <input type="number" name="items[${itemIndex}][price]" min="0" placeholder="0" class="w-full p-2.5 border-2 border-black font-bold bg-white" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-black uppercase mb-1">Instruksi & Detail Finishing</label>
                <textarea name="items[${itemIndex}][notes]" placeholder="Catatan finishing..." class="w-full p-2.5 border-2 border-black font-medium bg-white h-20"></textarea>
            </div>
        `;
        list.appendChild(newRow);
        itemIndex++;
    });
</script>
@endsection
