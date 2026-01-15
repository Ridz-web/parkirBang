<?php 
include "../config/auth.php"; 
include "../config/layout_header.php";
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Dashboard Petugas</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Selamat datang kembali, Petugas.</p>
    </div>
    <a href="../auth/logout.php" class="bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 px-4 py-2 rounded-lg transition duration-200 font-medium text-sm flex items-center border border-red-100 dark:border-red-800/30">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
        </svg>
        Logout
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card: Transaksi Parkir -->
    <a href="transaksi.php" class="block p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-md transition duration-200 group">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-xl group-hover:bg-primary-600 group-hover:text-white dark:group-hover:bg-primary-500 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 3.666A5.102 5.102 0 0117.165 9.3c.65.25 1.144.89 1.144 1.7 0 1.07-1.114 1.574-1.95 2.1-.963.606-2.536 2.39-4.228 3.323-.746.41-1.603.665-2.477 1.002-.511.198-1.05.29-1.542.4L7.5 18a.5.5 0 01-.5-.5v-4c0-1.1.9-2 2-2h1c.901 0 1.25.75 1.25 1.5 0 .25-.25.75-.49 1a.36.36 0 01-.33.226h-.06" />
                </svg>
            </div>
            <div class="bg-gray-100 dark:bg-gray-800 rounded-full p-1 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 dark:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition duration-200">Transaksi Parkir</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Input kendaraan masuk & keluar</p>
    </a>
</div>

<?php include "../config/layout_footer.php"; ?>