<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <h3 class="text-lg font-semibold mb-4">Quality Control Records</h3>
        <table class="w-full text-sm text-left datatable">
            <thead><tr><th>ID</th><th>Type</th><th>Ref ID</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                <?php foreach($records as $r): ?>
                <tr><td><?= $r['id'] ?></td><td><?= $r['reference_type'] ?></td><td><?= $r['reference_id'] ?></td><td><?= $r['status'] ?></td><td><?= $r['inspection_date'] ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>$(document).ready(function(){ $('.datatable').DataTable({responsive:true}); });</script>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/main.php'; ?>