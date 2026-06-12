<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold">Production Orders</h3>
        <a href="/production/create" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90"><i class="fas fa-plus mr-2"></i>New Work Order</a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">ID</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Product</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">BOM</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Quantity</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Dates</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($orders as $o): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4 text-sm text-gray-500">#<?= $o['id'] ?></td>
                    <td class="px-4 py-4 font-medium"><?= $o['product_name'] ?></td>
                    <td class="px-4 py-4 text-sm"><?= $o['bom_name'] ?></td>
                    <td class="px-4 py-4 font-bold"><?= number_format($o['quantity'], 2) ?></td>
                    <td class="px-4 py-4 text-xs text-gray-500">
                        S: <?= $o['start_date'] ?><br>E: <?= $o['end_date'] ?>
                    </td>
                    <td class="px-4 py-4">
                        <span class="px-2 py-1 bg-yellow-50 text-yellow-600 rounded text-xs"><?= ucfirst($o['status']) ?></span>
                    </td>
                    <td class="px-4 py-4">
                        <button class="text-primary hover:underline text-sm">Manage</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
