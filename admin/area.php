<?php
include "../config/auth.php";
include "../config/database.php";
include "../config/log_helper.php";

// Handle Create
if(isset($_POST['simpan'])){
    $stmt = $db->prepare("INSERT INTO area_parkir(nama_area, kapasitas) VALUES(?, ?)");
    $stmt->execute([$_POST['nama_area'], $_POST['kapasitas']]);
    log_activity($db, $_SESSION['user_id'], "Menambah area parkir: " . $_POST['nama_area']);
    header("Refresh:0");
}

// Handle Update
if(isset($_POST['update'])){
    $stmt = $db->prepare("UPDATE area_parkir SET nama_area=?, kapasitas=? WHERE id=?");
    $stmt->execute([$_POST['nama_area'], $_POST['kapasitas'], $_POST['id']]);
    log_activity($db, $_SESSION['user_id'], "Mengupdate area parkir ID: " . $_POST['id']);
    header("Refresh:0");
}

// Handle Delete
if(isset($_GET['delete'])){
    $stmt = $db->prepare("DELETE FROM area_parkir WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    log_activity($db, $_SESSION['user_id'], "Menghapus area parkir ID: " . $_GET['delete']);
    header("Location: area.php");
    exit;
}

// Get data for edit
$edit_data = null;
if(isset($_GET['edit'])){
    $stmt = $db->prepare("SELECT * FROM area_parkir WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}

$data = $db->query("SELECT * FROM area_parkir ORDER BY id DESC")->fetchAll();
include "../config/layout_header.php";
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Manajemen Area Parkir</h1>
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
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                <?= $edit_data ? 'Edit Area Parkir' : 'Tambah Area Baru' ?>
            </h3>
            <form method="POST" class="space-y-4">
                <?php if($edit_data): ?>
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                <?php endif; ?>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Area</label>
                    <input type="text" name="nama_area" placeholder="Contoh: Area A" required
                        value="<?= $edit_data ? htmlspecialchars($edit_data['nama_area']) : '' ?>"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kapasitas</label>
                    <input type="number" name="kapasitas" placeholder="Contoh: 50" required min="1"
                        value="<?= $edit_data ? $edit_data['kapasitas'] : '' ?>"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" name="<?= $edit_data ? 'update' : 'simpan' ?>"
                        class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-lg shadow-primary-600/20 active:scale-[0.98]">
                        <?= $edit_data ? 'Update' : 'Simpan' ?>
                    </button>
                    <?php if($edit_data): ?>
                        <a href="area.php" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-2 px-4 rounded-lg transition duration-200">
                            Batal
                        </a>
                    <?php endif; ?>
                </div>
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
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">ID</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Nama Area</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Kapasitas</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php if(count($data) > 0): ?>
                            <?php foreach($data as $d): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">
                                <td class="p-4 text-gray-600 dark:text-gray-400"><?= $d['id'] ?></td>
                                <td class="p-4 text-gray-900 dark:text-white font-medium"><?= htmlspecialchars($d['nama_area']) ?></td>
                                <td class="p-4 text-gray-600 dark:text-gray-300"><?= $d['kapasitas'] ?> kendaraan</td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="?edit=<?= $d['id'] ?>" class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <a href="?delete=<?= $d['id'] ?>" onclick="return confirm('Yakin ingin menghapus area ini?')" class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada data area parkir.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "../config/layout_footer.php"; ?>