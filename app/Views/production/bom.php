<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Bill of Materials (BOM)</h3>
            <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 text-sm rounded-lg shadow-sm flex items-center gap-2 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Create BOM
            </button>
        </div>
        <div class="p-6">
            <table id="bomTable" class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="pb-4">Finished Product</th>
                        <th class="pb-4">BOM Name</th>
                        <th class="pb-4">Version</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($boms as $bom): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 font-bold text-blue-600"><?= htmlspecialchars($bom['product_name']) ?> (<?= htmlspecialchars($bom['sku']) ?>)</td>
                        <td class="py-4 text-gray-900"><?= htmlspecialchars($bom['name']) ?></td>
                        <td class="py-4 text-gray-600"><?= htmlspecialchars($bom['version']) ?></td>
                        <td class="py-4">
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Active</span>
                        </td>
                        <td class="py-4">
                            <button class="text-blue-600 hover:underline">View Details</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- BOM Modal -->
<div id="bomModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black opacity-30"></div>
        <div class="bg-white rounded-2xl shadow-2xl z-50 w-full max-w-3xl transform transition-all animate__animated animate__zoomIn">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Create New BOM</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="bomForm" class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Finished Product</label>
                        <select name="product_id" id="product_id" class="w-full">
                            <option value="">Select Product</option>
                            <?php foreach ($products as $p): if ($p['type'] === 'finished_good'): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> (<?= $p['sku'] ?>)</option>
                            <?php endif; endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">BOM Name</label>
                        <input type="text" name="name" id="bom_name" class="w-full px-4 py-2 rounded-lg border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="font-bold text-slate-700 border-b pb-2">Components (Raw Materials)</h4>
                    <div id="componentContainer" class="space-y-3">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-gray-50 p-4 rounded-xl border border-gray-100 component-row">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Material</label>
                                <select name="material_id[]" class="material-select w-full" required>
                                    <option value="">Select Material</option>
                                    <?php foreach ($products as $p): if ($p['type'] === 'raw_material'): ?>
                                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> (<?= $p['sku'] ?>)</option>
                                    <?php endif; endforeach; ?>
                                </select>
                            </div>
                            <div class="relative">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Quantity</label>
                                <input type="number" name="quantity[]" step="0.0001" class="w-full px-3 py-2 rounded-lg border border-gray-200" value="1">
                                <button type="button" class="remove-row absolute -right-2 -top-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center shadow-md hover:bg-red-600 transition-colors hidden">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addComponent" class="text-blue-600 font-semibold text-sm flex items-center gap-2 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Component
                    </button>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" id="saveBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Save BOM</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#bomTable').DataTable({ responsive: true });
        $('#product_id').select2({ dropdownParent: $('#bomModal') });
        initMaterialSelect($('.material-select'));

        $('#addComponent').click(function() {
            const newRow = $('.component-row').first().clone();
            newRow.find('.select2-container').remove();
            newRow.find('select').removeClass('select2-hidden-accessible').removeAttr('data-select2-id').show().val('');
            newRow.find('input').val('1');
            newRow.find('.remove-row').removeClass('hidden');
            $('#componentContainer').append(newRow);
            initMaterialSelect(newRow.find('.material-select'));
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('.component-row').remove();
        });

        function initMaterialSelect(elem) {
            elem.select2({ dropdownParent: $('#bomModal') });
        }

        const validator = new JustValidate('#bomForm');
        validator
            .addField('#product_id', [{ rule: 'required', errorMessage: 'Finished product is required' }])
            .addField('#bom_name', [{ rule: 'required', errorMessage: 'BOM name is required' }])
            .onSuccess((event) => {
                const btn = $('#saveBtn');
                btn.prop('disabled', true).text('Saving...');
                
                const formData = new FormData(document.getElementById('bomForm'));
                $.ajax({
                    url: <?= json_encode(app_url('/production/bom/save')) ?>,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Success', text: res.message, toast: true, position: 'top-right', timer: 3000, showConfirmButton: false }).then(() => {
                                location.reload();
                            });
                        } else {
                            btn.prop('disabled', false).text('Save BOM');
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                        }
                    }
                });
            });
    });

    function openModal() {
        $('#bomForm')[0].reset();
        $('#product_id').val('').trigger('change');
        $('#bomModal').removeClass('hidden');
    }

    function closeModal() {
        $('#bomModal').addClass('hidden');
    }
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
