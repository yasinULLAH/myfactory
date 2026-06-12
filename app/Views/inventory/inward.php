<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold mb-6">Stock Inward (GRN)</h3>
        
        <form action="/inventory/inward" method="post" id="inward-form" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                    <select name="product_id" id="product_id" class="w-full" required>
                        <option value=""></option>
                        <?php foreach ($products as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= $p['sku'] ?> - <?= $p['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warehouse</label>
                    <select name="warehouse_id" id="warehouse_id" class="w-full" required>
                        <option value=""></option>
                        <?php foreach ($warehouses as $w): ?>
                            <option value="<?= $w['id'] ?>"><?= $w['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batch Number</label>
                    <input type="text" name="batch_number" id="batch_number" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" step="0.01" name="quantity" id="quantity" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary outline-none" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date (Optional)</label>
                <input type="date" name="expiry_date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary outline-none">
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" id="submit-btn" class="bg-primary text-white px-8 py-2 rounded-lg font-semibold hover:opacity-90">
                    Process Inward
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const validator = new JustValidate('#inward-form');
        validator
            .addField('#product_id', [{ rule: 'required' }])
            .addField('#warehouse_id', [{ rule: 'required' }])
            .addField('#batch_number', [{ rule: 'required' }])
            .addField('#quantity', [
                { rule: 'required' },
                { rule: 'minNumber', value: 0.01 }
            ])
            .onSuccess((event) => {
                const btn = document.getElementById('submit-btn');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                event.target.submit();
            });
    });
</script>
