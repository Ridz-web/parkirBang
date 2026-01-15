<?php 
include "../config/auth.php"; 
include "../config/layout_header.php";
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Dashboard Admin</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Selamat datang kembali, Admin.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card: Kelola User -->
    <a href="user.php" class="group block p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-lg hover:border-primary-100 dark:hover:border-primary-900 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 dark:text-gray-600 group-hover:text-primary-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Kelola User</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manajemen data pengguna sistem</p>
    </a>

    <!-- Card: Tarif Parkir -->
    <a href="tarif.php" class="group block p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-lg hover:border-primary-100 dark:hover:border-primary-900 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 dark:text-gray-600 group-hover:text-primary-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Tarif Parkir</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Atur harga per jenis kendaraan</p>
    </a>

    <!-- Card: Area Parkir -->
    <a href="area.php" class="group block p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-lg hover:border-primary-100 dark:hover:border-primary-900 transition-all duration-300">
         <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 dark:text-gray-600 group-hover:text-primary-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Area Parkir</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola lokasi dan kapasitas</p>
    </a>

    <!-- Card: Data Kendaraan -->
    <a href="kendaraan.php" class="group block p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-lg hover:border-primary-100 dark:hover:border-primary-900 transition-all duration-300">
         <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m10 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 dark:text-gray-600 group-hover:text-primary-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Data Kendaraan</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Data master kendaraan</p>
    </a>

    <!-- Card: Log Aktivitas -->
    <a href="log.php" class="group block p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-lg hover:border-primary-100 dark:hover:border-primary-900 transition-all duration-300">
         <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 dark:text-gray-600 group-hover:text-primary-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Log Aktivitas</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Riwayat aktivitas petugas</p>
    </a>
</div>

<?php include "../config/layout_footer.php"; ?>