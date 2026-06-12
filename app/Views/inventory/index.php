<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold">Current Stock Levels</h3>
        <div class="space-x-2">
            <a href="/inventory/inward" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90"><i class="fas fa-plus mr-2"></i>Stock Inward</a>
            <a href="/inventory/transfer" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90"><i class="fas fa-exchange-alt mr-2"></i>Stock Transfer</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Product</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">SKU</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Warehouse</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Batch #</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 text-right">Quantity</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Expiry</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($stock as $item): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4 font-medium"><?= $item['product_name'] ?></td>
                    <td class="px-4 py-4 text-gray-500"><?= $item['sku'] ?></td>
                    <td class="px-4 py-4"><?= $item['warehouse_name'] ?></td>
                    <td class="px-4 py-4"><span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs"><?= $item['batch_number'] ?></span></td>
                    <td class="px-4 py-4 text-right font-bold"><?= number_format($item['quantity'], 2) ?> <?= $item['unit'] ?></td>
                    <td class="px-4 py-4 text-sm text-gray-500"><?= $item['expiry_date'] ?: 'N/A' ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($stock)): ?>
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">No stock records found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
