<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <h3 class="text-lg font-semibold mb-4">Machine Maintenance</h3>
        <table class="w-full text-sm text-left datatable">
            <thead><tr><th>Machine Name</th><th>Code</th><th>Status</th><th>Last Maintenance</th></tr></thead>
            <tbody>
                <?php foreach($machines as $m): ?>
                <tr><td><?= htmlspecialchars($m['name']) ?></td><td><?= htmlspecialchars($m['code']) ?></td><td><?= $m['status'] ?></td><td><?= $m['last_maintenance'] ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>$(document).ready(function(){ $('.datatable').DataTable({responsive:true}); });</script>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/main.php'; ?>