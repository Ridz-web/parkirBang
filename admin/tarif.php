<?php
include "../config/auth.php";
include "../config/database.php";

if(isset($_POST['simpan'])){
    $db->prepare("INSERT INTO tarif(jenis_kendaraan,harga) VALUES(?,?)")
       ->execute([$_POST['jenis'],$_POST['harga']]);
    header("Refresh:0"); // Refresh to show new data
}

$data = $db->query("SELECT * FROM tarif")->fetchAll();
include "../config/layout_header.php";
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Manajemen Tarif Parkir</h1>
    <a href="dashboard.php" class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 font-medium flex items-center transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Kembali ke Dashboard
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Section -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors duration-200">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Tambah Tarif Baru</h3>
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kendaraan</label>
                    <input type="text" name="jenis" placeholder="Contoh: Motor" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" placeholder="Contoh: 2000" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                </div>
                <button type="submit" name="simpan"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-lg shadow-primary-600/20 active:scale-[0.98]">
                    Simpan Tarif
                </button>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider">
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Jenis Kendaraan</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Harga</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php if(count($data) > 0): ?>
                            <?php foreach($data as $d): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">
                                <td class="p-4 text-gray-900 dark:text-white font-medium"><?= htmlspecialchars($d['jenis_kendaraan']) ?></td>
                                <td class="p-4 text-gray-600 dark:text-gray-300">Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                                <td class="p-4 text-right">
                                    <button class="text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada data tarif.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "../config/layout_footer.php"; ?>