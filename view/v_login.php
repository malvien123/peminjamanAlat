<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peminjaman Alat</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <!-- Card Login -->
    <div class="w-full max-w-md bg-slate-800 text-slate-100 rounded-2xl shadow-2xl border border-slate-700/50 p-8 sm:p-10">
        
        <!-- Header / Judul -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold tracking-wider text-white uppercase">Login</h2>
            <p class="text-slate-400 text-sm mt-2">Silakan login ke akun Anda</p>
        </div>

        <!-- Form Login -->
        <form action="../controller/c_login.php?aksi=proses_login" method="post" class="space-y-6">
            
            <!-- Input Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-slate-300 mb-2">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Masukkan username"
                    class="w-full px-4 py-3 rounded-lg bg-slate-900/80 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                    required
                >
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-lg bg-slate-900/80 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                    required
                >
            </div>

            <!-- Tombol Submit -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-200 active:scale-[0.98]"
                >
                    Login
                </button>
            </div>

        </form>

        <!-- Footer / Register Link -->
        <div class="mt-8 pt-6 border-t border-slate-700/60 text-center text-sm text-slate-400">
            Belum punya akun? 
            <a href="v_register.php" class="text-indigo-400 hover:text-indigo-300 font-semibold transition duration-150 hover:underline ml-1">
                Daftar disini
            </a>
        </div>

    </div>

</body>
</html>