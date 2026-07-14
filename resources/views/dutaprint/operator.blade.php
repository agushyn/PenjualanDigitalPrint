@extends('layouts.dutaprint')

@section('content')
<div class="neo-box bg-white p-6">
    <h2 class="text-3xl font-black uppercase mb-6">Workstation Produksi Operator 🛠️</h2>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3 mb-8">
        @foreach(['outdoor', 'indoor', 'ricoh', 'riso', 'cardpresso', 'sablon', 'cutting'] as $m)
        <a href="?machine={{ $m }}" class="neo-btn p-3 text-center uppercase text-sm font-black tracking-tight 
            {{ $machine == $m ? 'bg-lime-400 text-black' : 'bg-black text-white' }}">
            ⚡ {{ $m }}
        </a>
        @endforeach
    </div>

    <h3 class="text-xl font-black uppercase mb-4">Antrean Cetak Aktual: <span class="bg-yellow-300 border-2 border-black px-2 py-0.5 text-black">{{ strtoupper($machine) }}</span></h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($orders as $order)
        <div class="neo-box p-4 bg-stone-50 border-3">
            <div class="flex justify-between items-start mb-2">
                <span class="text-sm font-black bg-black text-white px-2 py-0.5">{{ $order->sale->invoice_number }}</span>
                <span class="text-xs font-bold uppercase px-2 py-1 border-2 border-black bg-rose-200">{{ $order->status }}</span>
            </div>
            <h4 class="text-xl font-black mt-2">{{ $order->item_name }}</h4>
            <p class="font-bold text-md text-red-600">Jumlah Cetak: {{ $order->qty }} pcs</p>
            <div class="bg-white border-2 border-black p-3 my-3 text-sm font-medium">
                <strong>Catatan Instruksi Operator:</strong><br>
                {{ $order->notes ?? 'Tidak ada catatan khusus finishing.' }}
            </div>
            
            <form action="{{ route('operator.update', $order->id) }}" method="POST" class="flex gap-2 mt-4">
                @csrf
                @method('PUT')
                @if($order->status == 'pending')
                <button type="submit" name="status" value="proses" class="neo-btn bg-amber-300 text-black px-4 py-2 text-xs uppercase w-full">Mulai Tarik Cetak ⏳</button>
                @endif
                @if($order->status == 'proses')
                <button type="submit" name="status" value="selesai" class="neo-btn bg-emerald-400 text-black px-4 py-2 text-xs uppercase w-full">Selesai Cetak ✔️</button>
                @endif
            </form>
        </div>
        @empty
        <div class="col-span-2 text-center p-8 border-3 border-dashed border-black font-bold text-lg">
            📭 Antrean untuk divisi mesin ini sedang kosong.
        </div>
        @endforelse
    </div>
</div>
@endsection