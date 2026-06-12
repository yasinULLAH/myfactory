<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Database Backups</h3>
            <button id="createBackupBtn" class="bg-green-600 text-white px-4 py-2 text-sm rounded-lg shadow-sm flex items-center gap-2 hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Create Manual Backup
            </button>
        </div>
        <div class="p-6">
            <table id="backupTable" class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="pb-4">Filename</th>
                        <th class="pb-4">Size</th>
                        <th class="pb-4">Created At</th>
                        <th class="pb-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($backups as $b): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 font-medium text-gray-900"><?= htmlspecialchars($b['filename']) ?></td>
                        <td class="py-4 text-gray-600"><?= $b['size'] ?></td>
                        <td class="py-4 text-gray-600"><?= $b['date'] ?></td>
                        <td class="py-4 flex gap-2">
                            <a href="/myfactory/public/settings/backups/download?file=<?= urlencode($b['filename']) ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Download">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#backupTable').DataTable({ responsive: true });

        $('#createBackupBtn').click(function() {
            const btn = $(this);
            btn.prop('disabled', true).text('Processing...');
            
            $.post('/myfactory/public/settings/backups/create', function(res) {
                btn.prop('disabled', false).html('<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg> Create Manual Backup');
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Backup Successful', text: res.message, toast: true, position: 'top-right', timer: 3000, showConfirmButton: false }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Backup Failed', text: res.message });
                }
            });
        });
    });
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
