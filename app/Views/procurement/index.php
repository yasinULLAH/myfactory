<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Purchase Orders</h3>
            <a href="<?= htmlspecialchars(app_url('/procurement/create')) ?>" class="bg-blue-600 text-white px-4 py-2 text-sm rounded-lg shadow-sm flex items-center gap-2 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Purchase Order
            </a>
        </div>
        <div class="p-6">
            <table id="poTable" class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="pb-4">PO Number</th>
                        <th class="pb-4">Supplier</th>
                        <th class="pb-4">Date</th>
                        <th class="pb-4">Total Amount</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($orders as $order): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 font-bold text-blue-600"><?= htmlspecialchars($order['po_number']) ?></td>
                        <td class="py-4 font-medium text-gray-900"><?= htmlspecialchars($order['supplier_name']) ?></td>
                        <td class="py-4 text-gray-600"><?= htmlspecialchars($order['order_date']) ?></td>
                        <td class="py-4 font-semibold text-gray-900">$<?= number_format($order['total_amount'], 2) ?></td>
                        <td class="py-4">
                            <span class="px-2.5 py-1 
                                <?= $order['status'] === 'pending' ? 'bg-orange-100 text-orange-700' : '' ?>
                                <?= $order['status'] === 'approved' ? 'bg-blue-100 text-blue-700' : '' ?>
                                <?= $order['status'] === 'received' ? 'bg-green-100 text-green-700' : '' ?>
                                <?= $order['status'] === 'cancelled' ? 'bg-red-100 text-red-700' : '' ?>
                                rounded-full text-xs font-semibold">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td class="py-4">
                            <a href="<?= htmlspecialchars(app_url('/procurement/view')) ?>?id=<?= $order['id'] ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors inline-block">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
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
        $('#poTable').DataTable({ responsive: true });
    });
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
