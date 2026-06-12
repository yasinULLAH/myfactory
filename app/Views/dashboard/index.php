<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Products</p>
                <h3 class="text-2xl font-bold text-gray-800"><?= $stats['products'] ?></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Pending Orders</p>
                <h3 class="text-2xl font-bold text-gray-800"><?= $stats['pending_pos'] ?></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Suppliers</p>
                <h3 class="text-2xl font-bold text-gray-800"><?= $stats['suppliers'] ?></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">System Status</p>
                <h3 class="text-2xl font-bold text-green-600">Optimal</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Recent Purchase Orders</h3>
            <a href="/myfactory/public/procurement/create" class="bg-blue-600 text-white px-4 py-2 text-sm rounded-lg shadow-sm flex items-center gap-2 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New PO
            </a>
        </div>
        <div class="p-6">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="pb-4">PO Number</th>
                        <th class="pb-4">Supplier</th>
                        <th class="pb-4">Date</th>
                        <th class="pb-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($recent_pos)): ?>
                        <tr><td colspan="4" class="py-4 text-center text-gray-400">No recent orders found.</td></tr>
                    <?php else: foreach ($recent_pos as $po): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 font-bold text-blue-600"><?= htmlspecialchars($po['po_number']) ?></td>
                        <td class="py-4 font-medium text-gray-900"><?= htmlspecialchars($po['supplier_name']) ?></td>
                        <td class="py-4 text-gray-500"><?= htmlspecialchars($po['order_date']) ?></td>
                        <td class="py-4"><span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold"><?= ucfirst($po['status']) ?></span></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
