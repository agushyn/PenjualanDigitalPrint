<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Duta Print</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap');
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f0f2f5;
        }
        .neo-box {
            border: 4px solid #000000;
            box-shadow: 8px 8px 0px 0px #000000;
            transition: all 0.1s ease;
        }
        .neo-box:active {
            transform: translate(4px, 4px);
            box-shadow: 4px 4px 0px 0px #000000;
        }
        .neo-btn {
            border: 3px solid #000000;
            box-shadow: 4px 4px 0px 0px #000000;
            font-weight: bold;
        }
        .neo-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #000000;
        }
    </style>
</head>
<body class="p-6">
    @php $theme = Auth::user()->theme_color ?? '#ffec00'; @endphp

    <!-- Cari bagian navbar di resources/views/layouts/dutaprint.blade.php dan sesuaikan -->
<nav class="neo-box p-4 mb-6 flex flex-col md:flex-row justify-between items-center gap-4" style="background-color: {{ $theme }}">
    <div class="flex items-center gap-3">
        <span class="text-2xl font-black uppercase tracking-wider">Dashboard Duta Print ⚡</span>
        <span class="text-xs bg-black text-white px-2 py-0.5 font-bold uppercase">{{ Auth::user()->role }}</span>
        <span class="text-xs bg-black text-white px-2 py-0.5 font-bold uppercase">{{ Auth::user()->name }}</span>
    </div>

    <div class="flex flex-wrap gap-4 font-bold items-center">
        <a href="{{ route('penjualan') }}" class="hover:underline">Penjualan</a>
        <a href="{{ route('laporan') }}" class="hover:underline">Laporan</a>
        <a href="{{ route('operator') }}" class="hover:underline">Operator</a>
        <a href="{{ route('settings') }}" class="hover:underline">Settings</a>

        <!-- Tombol Logout Neobrutalism -->
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-black text-white text-xs px-2.5 py-1.5 border-2 border-black font-black uppercase tracking-tight hover:bg-neutral-800">
                Keluar 🚪
            </button>
        </form>
    </div>
</nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
