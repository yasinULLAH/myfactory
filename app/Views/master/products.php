<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold">Product Master</h3>
        <button class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90"><i class="fas fa-plus mr-2"></i>Add Product</button>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="datatable w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">SKU</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Category</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 text-right">Price</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($products as $p): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4 font-mono text-xs"><?= $p['sku'] ?></td>
                    <td class="px-4 py-4 font-medium"><?= $p['name'] ?></td>
                    <td class="px-4 py-4 text-sm"><?= $p['category_name'] ?></td>
                    <td class="px-4 py-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs"><?= str_replace('_', ' ', $p['type']) ?></span>
                    </td>
                    <td class="px-4 py-4 text-right font-semibold">$<?= number_format($p['price'], 2) ?></td>
                    <td class="px-4 py-4">
                        <span class="px-2 py-1 <?= $p['status'] == 'active' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' ?> rounded text-xs"><?= ucfirst($p['status']) ?></span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></button>
                            <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
