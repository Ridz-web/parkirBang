<?php
include "../config/auth.php";
include "../config/database.php";

// Pagination
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count
$total = $db->query("SELECT COUNT(*) as count FROM log_aktivitas")->fetch()['count'];
$total_pages = ceil($total / $limit);

// Get logs with user info
$logs = $db->query(
    "SELECT l.*, u.nama, u.username 
     FROM log_aktivitas l 
     LEFT JOIN users u ON l.user_id = u.id 
     ORDER BY l.waktu DESC 
     LIMIT $limit OFFSET $offset"
)->fetchAll();

include "../config/layout_header.php";
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Log Aktivitas Sistem</h1>
    <a href="dashboard.php" class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 font-medium flex items-center transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Kembali ke Dashboard
    </a>
</div>

<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-200">
    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
        <p class="text-sm text-gray-600 dark:text-gray-400">Total: <span class="font-semibold"><?= $total ?></span> aktivitas tercatat</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Waktu</th>
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">User</th>
                    <th class="p-4 font-semibold border-b border-gray-100 dark:border-gray-800">Aktivitas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php if(count($logs) > 0): ?>
                    <?php foreach($logs as $log): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">
                        <td class="p-4 text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">
                            <?= date('d/m/Y H:i:s', strtotime($log['waktu'])) ?>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-full flex items-center justify-center font-bold text-xs mr-2 border border-primary-200 dark:border-primary-800">
                                    <?= strtoupper(substr($log['nama'] ?? 'U', 0, 1)) ?>
                                </div>
                                <div>
                                    <p class="text-gray-900 dark:text-white font-medium text-sm"><?= htmlspecialchars($log['nama'] ?? 'Unknown') ?></p>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs text-xs">@<?= htmlspecialchars($log['username'] ?? 'unknown') ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-gray-700 dark:text-gray-300"><?= htmlspecialchars($log['aktivitas']) ?></td>
                    </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada log aktivitas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($total_pages > 1): ?>
    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 flex justify-center gap-2">
        <?php if($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition">
                &laquo; Prev
            </a>
        <?php endif; ?>
        
        <span class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow-sm">
            <?= $page ?> / <?= $total_pages ?>
        </span>
        
        <?php if($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition">
                Next &raquo;
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php include "../config/layout_footer.php"; ?>
