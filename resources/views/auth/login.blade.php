<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DutaPrint ERP</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700;900&display=swap');
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #e3e7ed;
        }
        .neo-box {
            border: 4px solid #000000;
            box-shadow: 10px 10px 0px 0px #000000;
        }
        .neo-btn {
            border: 3px solid #000000;
            box-shadow: 4px 4px 0px 0px #000000;
            transition: all 0.1s ease;
        }
        .neo-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #000000;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md neo-box bg-[#ffec00] p-8 text-black">
        <!-- Logo / Title -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-black uppercase tracking-wider mb-1">DUTAPRINT</h1>
            <span class="bg-black text-white text-xs font-mono px-2 py-0.5 uppercase tracking-widest font-bold">⚡ SOLUSI CEPAT CETAK DIGITAL ⚡</span>
        </div>

        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div class="bg-rose-300 border-3 border-black p-3 font-bold text-sm mb-6 shadow-[4px_4px_0px_0px_#000000]">
                @foreach ($errors->all() as $error)
                    <p>🛑 {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block font-black uppercase text-sm mb-1.5">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@dutaprint.com" 
                       class="w-full p-3 border-3 border-black bg-white font-bold text-black focus:outline-none placeholder-gray-400" required autofocus>
            </div>

            <div>
                <label class="block font-black uppercase text-sm mb-1.5">Kata Sandi (Password)</label>
                <input type="password" name="password" placeholder="••••••••" 
                       class="w-full p-3 border-3 border-black bg-white font-bold text-black focus:outline-none placeholder-gray-400" required>
            </div>

            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 font-bold text-sm cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 border-2 border-black accent-black">
                    Ingat Saya
                </label>
            </div>

            <button type="submit" class="w-full neo-btn bg-black text-white py-3.5 uppercase font-black text-md tracking-wider mt-4">
                Masuk ke Dasbor 🔑
            </button>
        </form>

        <!-- Informasi Bantuan Quick-Test -->
        <div class="mt-8 pt-4 border-t-3 border-black border-dashed text-xs font-bold text-gray-800">
            <p class="mb-1">💡 Akun Pengujian Default (Seeder):</p>
            <ul class="list-disc list-inside opacity-80 font-mono">
                <li>Kasir: kasir@dutaprint.com / password123</li>
                <li>Admin: admin@dutaprint.com / password123</li>
            </ul>
        </div>
    </div>

</body>
</html>