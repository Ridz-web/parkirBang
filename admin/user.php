<?php
include "../config/auth.php";
include "../config/database.php";

if(isset($_POST['simpan'])){
    $stmt = $db->prepare(
        "INSERT INTO users(nama,username,password,role)
         VALUES(?,?,?,?)"
    );
    $stmt->execute([
        $_POST['nama'],
        $_POST['username'],
        md5($_POST['password']),
        $_POST['role']
    ]);
    header("Refresh:0");
}

$users = $db->query("SELECT * FROM users")->fetchAll();
include "../config/layout_header.php";
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Manajemen Pengguna</h1>
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
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Tambah User Baru</h3>
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Contoh: John Doe" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                    <input type="text" name="username" placeholder="Contoh: johndoe" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition duration-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                    <div class="relative">
                        <select name="role" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-900/50 outline-none transition appearance-none duration-200">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="owner">Owner</option>
                        </select>
                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <button type="submit" name="simpan"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-lg shadow-primary-600/20 active:scale-[0.98]">
                    Simpan User
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
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Nama</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Role</th>
                            <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php if(count($users) > 0): ?>
                            <?php foreach($users as $u): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">
                                <td class="p-4 text-gray-900 dark:text-white font-medium">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold text-xs uppercase">
                                            <?= substr($u['nama'], 0, 1) ?>
                                        </div>
                                        <div>
                                            <p class="font-medium"><?= htmlspecialchars($u['nama']) ?></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">@<?= htmlspecialchars($u['username']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full border 
                                        <?= $u['role'] == 'admin' ? 'bg-purple-50 text-purple-600 border-purple-100 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-800' : 
                                           ($u['role'] == 'petugas' ? 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:border-emerald-800' : 
                                           'bg-orange-50 text-orange-600 border-orange-100 dark:bg-orange-900/20 dark:text-orange-300 dark:border-orange-800') ?>">
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>
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
                                <td colspan="3" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada user.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "../config/layout_footer.php"; ?>