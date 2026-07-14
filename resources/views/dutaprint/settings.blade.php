@extends('layouts.dutaprint')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 neo-box bg-white p-6">
        <h2 class="text-3xl font-black uppercase mb-6">Manajemen Pengguna & Privilege</h2>
        
        <div class="space-y-4">
            @foreach($users as $user)
            <div class="border-3 border-black p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-zinc-50">
                <div>
                    <h3 class="font-black text-lg">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-600 font-bold">Email: {{ $user->email }}</p>
                    <p class="text-xs mt-1 font-bold">
                        Role Saat Ini: <span class="bg-purple-300 border-2 border-black px-1.5 py-0.25 uppercase">{{ $user->role }}</span>
                        @if($user->role == 'operator')
                        - Mesin: <span class="bg-cyan-200 border-2 border-black px-1.5 py-0.25 uppercase">{{ $user->operator_machine ?? 'Belum Diatur' }}</span>
                        @endif
                    </p>
                </div>
                
                <form action="{{ route('settings.user.update', $user->id) }}" method="POST" class="mt-4 sm:mt-0 flex flex-wrap gap-2 items-center">
                    @csrf
                    @method('PUT')
                    <select name="role" class="p-1.5 border-2 border-black font-bold text-xs bg-white">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="design" {{ $user->role == 'design' ? 'selected' : '' }}>Designer</option>
                        <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                    </select>

                    <select name="operator_machine" class="p-1.5 border-2 border-black font-bold text-xs bg-white">
                        <option value="">-- Divisi Mesin --</option>
                        @foreach(['outdoor', 'indoor', 'ricoh', 'riso', 'cardpresso', 'sablon', 'cutting'] as $m)
                        <option value="{{ $m }}" {{ $user->operator_machine == $m ? 'selected' : '' }}>{{ strtoupper($m) }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="neo-btn bg-black text-white text-xs px-3 py-1.5 uppercase">Simpan</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <div class="neo-box bg-white p-6">
        <h2 class="text-2xl font-black uppercase mb-4">Pengaturan Tema Dasbor</h2>
        <p class="font-bold text-sm mb-4 text-gray-700">Setiap user dapat mengatur warna aksen utama aplikasi bertema Neobrutalisme secara mandiri:</p>
        
        <form action="{{ route('settings.user.update', Auth::id()) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="role" value="{{ Auth::user()->role }}">
            
            <div class="mb-4">
                <label class="block font-bold mb-2">Pilih Warna Aksen Utama</label>
                <div class="grid grid-cols-4 gap-2">
                    @foreach(['#ffec00' => 'Kuning', '#00f5ff' => 'Cyan', '#adff2f' => 'Hijau', '#ff3366' => 'Pink'] as $color => $label)
                    <label class="border-2 border-black p-2 cursor-pointer flex flex-col items-center gap-1" style="background-color: {{ $color }}">
                        <input type="radio" name="theme_color" value="{{ $color }}" {{ Auth::user()->theme_color == $color ? 'checked' : '' }}>
                        <span class="text-xs font-black drop-shadow-sm">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="neo-btn bg-black text-white w-full py-2 uppercase font-black text-sm">
                Terapkan Tema Aplikasi 🎨
            </button>
        </form>
    </div>
</div>
@endsection