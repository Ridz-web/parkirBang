<?php
include "../config/auth.php";
include "../config/database.php";

// Get date range from filter
$start_date = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01'); // Default: first day of month
$end_date = isset($_GET['end']) ? $_GET['end'] : date('Y-m-d'); // Default: today

// Get summary data
$stmt = $db->prepare(
    "SELECT COUNT(*) as jumlah, COALESCE(SUM(total_bayar), 0) as total 
     FROM transaksi 
     WHERE DATE(waktu_masuk) BETWEEN ? AND ?"
);
$stmt->execute([$start_date, $end_date]);
$summary = $stmt->fetch();

// Get detailed transactions
$stmt = $db->prepare(
    "SELECT t.*, k.plat_nomor, r.jenis_kendaraan, r.harga
     FROM transaksi t
     JOIN kendaraan k ON t.kendaraan_id = k.id
     JOIN tarif r ON t.tarif_id = r.id
     WHERE DATE(t.waktu_masuk) BETWEEN ? AND ?
     ORDER BY t.waktu_masuk DESC"
);
$stmt->execute([$start_date, $end_date]);
$transactions = $stmt->fetchAll();

include "../config/layout_header.php";
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Laporan & Statistik</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Rekap transaksi parkir</p>
    </div>
    <a href="../auth/logout.php" class="bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 px-4 py-2 rounded-lg transition duration-200 font-medium text-sm flex items-center border border-red-100 dark:border-red-800/30">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
        </svg>
        Logout
    </a>
</div>

<!-- Filter Section -->
<div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 mb-6 transition-colors duration-200">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Filter Periode</h3>
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
            <input type="date" name="start" value="<?= $start_date ?>" required
                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir</label>
            <input type="date" name="end" value="<?= $end_date ?>" required
                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
        </div>
        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-semibold transition shadow-lg shadow-primary-600/20 active:scale-[0.98]">
            Tampilkan
        </button>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Card: Total Kendaraan -->
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center transition-colors duration-200">
        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Transaksi</p>
            <h3 class="text-3xl font-bold text-gray-800 dark:text-white"><?= number_format($summary['jumlah']) ?></h3>
            <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?></p>
        </div>
    </div>

    <!-- Card: Total Pendapatan -->
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center transition-colors duration-200">
        <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Pendapatan</p>
            <h3 class="text-3xl font-bold text-gray-800 dark:text-white">Rp <?= number_format($summary['total'], 0, ',', '.') ?></h3>
            <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Akumulasi pendapatan</p>
        </div>
    </div>
</div>

<!-- Detailed Transactions Table -->
<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-200">
    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
        <h3 class="font-bold text-gray-800 dark:text-white">Detail Transaksi</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">ID</th>
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Plat Nomor</th>
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Jenis</th>
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Masuk</th>
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Keluar</th>
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php if(count($transactions) > 0): ?>
                    <?php foreach($transactions as $t): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">
                        <td class="p-4 text-gray-600 dark:text-gray-400 text-sm">#<?= $t['id'] ?></td>
                        <td class="p-4 text-gray-900 dark:text-white font-medium uppercase"><?= htmlspecialchars($t['plat_nomor']) ?></td>
                        <td class="p-4 text-gray-600 dark:text-gray-400"><?= htmlspecialchars($t['jenis_kendaraan']) ?></td>
                        <td class="p-4 text-gray-600 dark:text-gray-400 text-sm font-mono"><?= date('d/m H:i', strtotime($t['waktu_masuk'])) ?></td>
                        <td class="p-4 text-gray-600 dark:text-gray-400 text-sm font-mono">
                            <?= $t['waktu_keluar'] ? date('d/m H:i', strtotime($t['waktu_keluar'])) : '-' ?>
                        </td>
                        <td class="p-4 text-right">
                            <?php if($t['total_bayar']): ?>
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">Rp <?= number_format($t['total_bayar'], 0, ',', '.') ?></span>
                            <?php else: ?>
                                <span class="text-gray-400 text-sm italic">Belum keluar</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 dark:text-gray-400">Tidak ada transaksi pada periode ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../config/layout_footer.php"; ?>