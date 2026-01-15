<?php
include "../config/auth.php";
include "../config/database.php";
include "../config/log_helper.php";

// Handle vehicle entry
if(isset($_POST['masuk'])){
    $stmt = $db->prepare(
      "INSERT INTO transaksi(kendaraan_id,tarif_id,waktu_masuk)
       VALUES(?,?,datetime('now'))"
    );
    $stmt->execute([$_POST['kendaraan'],$_POST['tarif']]);
    log_activity($db, $_SESSION['user_id'], "Input kendaraan masuk: " . $_POST['kendaraan']);
    $success_masuk = true;
}

// Handle vehicle exit
if(isset($_POST['keluar'])){
    $id = $_POST['transaksi_id'];
    
    // Get transaction data
    $stmt = $db->prepare(
        "SELECT t.*, r.harga 
         FROM transaksi t 
         JOIN tarif r ON t.tarif_id = r.id 
         WHERE t.id = ?"
    );
    $stmt->execute([$id]);
    $trans = $stmt->fetch();
    
    if($trans){
        // Calculate payment (simple: just use tarif harga)
        $total_bayar = $trans['harga'];
        
        // Update transaction
        $stmt = $db->prepare(
            "UPDATE transaksi 
             SET waktu_keluar = datetime('now'), total_bayar = ? 
             WHERE id = ?"
        );
        $stmt->execute([$total_bayar, $id]);
        log_activity($db, $_SESSION['user_id'], "Proses keluar transaksi ID: " . $id);
        $success_keluar = $id;
    }
}

// Get active transactions (not yet exited)
$active_trans = $db->query(
    "SELECT t.*, k.plat_nomor, r.jenis_kendaraan, r.harga
     FROM transaksi t
     JOIN kendaraan k ON t.kendaraan_id = k.id
     JOIN tarif r ON t.tarif_id = r.id
     WHERE t.waktu_keluar IS NULL
     ORDER BY t.waktu_masuk DESC"
)->fetchAll();

$kendaraan = $db->query("SELECT * FROM kendaraan")->fetchAll();
$tarif = $db->query("SELECT * FROM tarif")->fetchAll();
include "../config/layout_header.php";
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Transaksi Parkir</h1>
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
        <?php if(isset($success_masuk)): ?>
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
            <p class="text-emerald-700 dark:text-emerald-300 font-bold">Berhasil Masuk</p>
            <p class="text-emerald-600 dark:text-emerald-400 text-sm">Kendaraan berhasil dicatat.</p>
        </div>
        <?php endif; ?>
        
        <?php if(isset($success_keluar)): ?>
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
            <p class="text-blue-700 dark:text-blue-300 font-bold">Transaksi Selesai</p>
            <p class="text-blue-600 dark:text-blue-400 text-sm">Pembayaran berhasil diproses.</p>
            <a href="cetak_struk.php?id=<?= $success_keluar ?>" target="_blank" class="text-blue-700 dark:text-blue-300 underline text-sm font-semibold mt-2 inline-flex items-center hover:text-blue-800 dark:hover:text-blue-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Struk
            </a>
        </div>
        <?php endif; ?>
        
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors duration-200">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Kendaraan Masuk</h3>
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Kendaraan</label>
                    <div class="relative">
                        <select name="kendaraan" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition appearance-none">
                            <option value="">-- Pilih Kendaraan --</option>
                            <?php foreach($kendaraan as $k): ?>
                            <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['plat_nomor']) ?> (<?= $k['jenis'] ?>)</option>
                            <?php endforeach ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 dark:text-gray-400">
                             <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Tarif</label>
                    <div class="relative">
                        <select name="tarif" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition appearance-none">
                            <option value="">-- Pilih Tarif --</option>
                            <?php foreach($tarif as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['jenis_kendaraan']) ?> (Rp <?= number_format($t['harga'], 0, ',', '.') ?>)</option>
                            <?php endforeach ?>
                        </select>
                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 dark:text-gray-400">
                             <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" name="masuk"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200 shadow-lg shadow-primary-600/20 active:scale-[0.98] flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Input Kendaraan Masuk
                </button>
            </form>
        </div>
    </div>

    <!-- Active Transactions Table -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-200">
            <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white">Kendaraan Sedang Parkir</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Total: <span class="font-semibold text-gray-800 dark:text-white"><?= count($active_trans) ?></span> kendaraan</p>
                </div>
                <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider">
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Plat</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Jenis</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Masuk</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Tarif</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php if(count($active_trans) > 0): ?>
                            <?php foreach($active_trans as $t): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">
                                <td class="p-4 text-gray-900 dark:text-white font-bold uppercase tracking-wide"><?= htmlspecialchars($t['plat_nomor']) ?></td>
                                <td class="p-4 text-gray-600 dark:text-gray-400"><?= htmlspecialchars($t['jenis_kendaraan']) ?></td>
                                <td class="p-4 text-gray-600 dark:text-gray-400 text-sm font-mono"><?= date('H:i', strtotime($t['waktu_masuk'])) ?></td>
                                <td class="p-4 text-gray-900 dark:text-white font-medium">Rp <?= number_format($t['harga'], 0, ',', '.') ?></td>
                                <td class="p-4 text-right">
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="transaksi_id" value="<?= $t['id'] ?>">
                                        <button type="submit" name="keluar" 
                                            class="bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 px-4 py-2 rounded-lg text-sm font-semibold transition border border-red-100 dark:border-red-800/50 shadow-sm active:scale-95">
                                            Keluar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-400 dark:text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <p>Tidak ada kendaraan yang sedang parkir.</p> 
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "../config/layout_footer.php"; ?>