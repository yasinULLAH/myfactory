<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Create New Purchase Order</h3>
            <a href="/myfactory/public/procurement" class="text-sm text-gray-500 hover:text-gray-700 underline">Back to List</a>
        </div>
        <form id="poForm" class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="w-full">
                        <option value="">Select Supplier</option>
                        <?php foreach ($suppliers as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Order Date</label>
                    <input type="date" name="order_date" id="order_date" value="<?= date('Y-m-d') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="space-y-4">
                <h4 class="font-bold text-slate-700 border-b pb-2">Order Items</h4>
                <div id="itemContainer" class="space-y-3">
                    <!-- Dynamic Rows -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end bg-gray-50 p-4 rounded-xl border border-gray-100 item-row">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Product</label>
                            <select name="product_id[]" class="product-select w-full" required>
                                <option value="">Select Product</option>
                                <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>"><?= htmlspecialchars($p['name']) ?> (<?= $p['sku'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Quantity</label>
                            <input type="number" name="quantity[]" step="0.01" class="w-full px-3 py-2 rounded-lg border border-gray-200 qty-input" value="1">
                        </div>
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Unit Price</label>
                            <input type="number" name="unit_price[]" step="0.01" class="w-full px-3 py-2 rounded-lg border border-gray-200 price-input">
                            <button type="button" class="remove-row absolute -right-2 -top-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center shadow-md hover:bg-red-600 transition-colors hidden">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" id="addRow" class="text-blue-600 font-semibold text-sm flex items-center gap-2 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Another Item
                </button>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-between items-center">
                <div class="text-xl font-bold text-gray-800">
                    Total: <span id="totalDisplay" class="text-blue-600">$0.00</span>
                </div>
                <div class="flex gap-3">
                    <a href="/myfactory/public/procurement" class="px-6 py-2.5 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">Cancel</a>
                    <button type="submit" id="saveBtn" class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all">
                        Create Purchase Order
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#supplier_id').select2();
        initProductSelect($('.product-select'));

        $('#addRow').click(function() {
            const newRow = $('.item-row').first().clone();
            newRow.find('.select2-container').remove();
            newRow.find('select').removeClass('select2-hidden-accessible').removeAttr('data-select2-id').show().val('');
            newRow.find('input').val('');
            newRow.find('.remove-row').removeClass('hidden');
            $('#itemContainer').append(newRow);
            initProductSelect(newRow.find('.product-select'));
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('.item-row').remove();
            calculateTotal();
        });

        $(document).on('change', '.product-select', function() {
            const price = $(this).find(':selected').data('price');
            $(this).closest('.item-row').find('.price-input').val(price);
            calculateTotal();
        });

        $(document).on('input', '.qty-input, .price-input', calculateTotal);

        function initProductSelect(elem) {
            elem.select2();
        }

        function calculateTotal() {
            let total = 0;
            $('.item-row').each(function() {
                const qty = parseFloat($(this).find('.qty-input').val()) || 0;
                const price = parseFloat($(this).find('.price-input').val()) || 0;
                total += (qty * price);
            });
            $('#totalDisplay').text('$' + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        }

        const validator = new JustValidate('#poForm');
        validator
            .addField('#supplier_id', [{ rule: 'required', errorMessage: 'Supplier is required' }])
            .addField('#order_date', [{ rule: 'required', errorMessage: 'Date is required' }])
            .onSuccess((event) => {
                const btn = $('#saveBtn');
                btn.prop('disabled', true).text('Processing...');
                
                const formData = new FormData(document.getElementById('poForm'));
                $.ajax({
                    url: '/myfactory/public/procurement/store',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Success', text: res.message, toast: true, position: 'top-right', timer: 3000, showConfirmButton: false }).then(() => {
                                window.location.href = '/myfactory/public' + res.redirect;
                            });
                        } else {
                            btn.prop('disabled', false).text('Create Purchase Order');
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                        }
                    }
                });
            });
    });
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
