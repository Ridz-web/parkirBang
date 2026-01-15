<?php
session_start();
if(isset($_SESSION['role'])){
    header("Location: ".$_SESSION['role']."/dashboard.php");
}
include "config/layout_header.php"; 
?>

<div class="flex items-center justify-center min-h-[80vh]">
    <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden transition-all duration-300">
        
        <!-- Header Section -->
        <div class="px-8 pt-10 pb-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 mb-6 ring-8 ring-primary-50/50 dark:ring-primary-900/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Selamat Datang</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <!-- content -->
        <div class="px-8 pb-10">
            <?php if(isset($_GET['error']) && $_GET['error'] == 'login_failed'): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 mb-6 rounded-xl flex items-start gap-3" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 dark:text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-red-800 dark:text-red-300 font-semibold text-sm">Login Gagal</p>
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">Username atau password salah.</p>
                </div>
            </div>
            <?php endif; ?>

            <form method="POST" action="auth/login.php" class="space-y-5">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="username" name="username" placeholder="Masukan username" required 
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Masukan password" required 
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200 shadow-lg shadow-primary-600/20 transform active:scale-[0.98]">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<?php include "config/layout_footer.php"; ?>