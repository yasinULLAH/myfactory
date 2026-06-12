<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Factories List</h3>
            <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 text-sm rounded-lg shadow-sm flex items-center gap-2 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Factory
            </button>
        </div>
        <div class="p-6">
            <table id="factoriesTable" class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="pb-4">Name</th>
                        <th class="pb-4">Location</th>
                        <th class="pb-4">Contact</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($factories as $factory): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 font-medium text-gray-900"><?= htmlspecialchars($factory['name']) ?></td>
                        <td class="py-4 text-gray-600"><?= htmlspecialchars($factory['location']) ?></td>
                        <td class="py-4 text-gray-600"><?= htmlspecialchars($factory['contact_number']) ?></td>
                        <td class="py-4">
                            <span class="px-2.5 py-1 <?= $factory['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?> rounded-full text-xs font-semibold">
                                <?= ucfirst($factory['status']) ?>
                            </span>
                        </td>
                        <td class="py-4">
                            <div class="flex gap-2">
                                <button onclick="editFactory(<?= $factory['id'] ?>)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button onclick="deleteFactory(<?= $factory['id'] ?>)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="factoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black opacity-30"></div>
        <div class="bg-white rounded-2xl shadow-2xl z-50 w-full max-w-md transform transition-all animate__animated animate__zoomIn">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Add Factory</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="factoryForm" class="p-6 space-y-4">
                <input type="hidden" name="id" id="factoryId">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Factory Name</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" id="location" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" id="saveBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Save Factory</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const validator = new JustValidate('#factoryForm');

    validator
        .addField('#name', [{ rule: 'required', errorMessage: 'Name is required' }])
        .addField('#location', [{ rule: 'required', errorMessage: 'Location is required' }])
        .onSuccess((event) => {
            saveFactory();
        });

    function openModal(id = null) {
        document.getElementById('factoryForm').reset();
        document.getElementById('factoryId').value = '';
        document.getElementById('modalTitle').innerText = 'Add Factory';
        document.getElementById('factoryModal').classList.remove('hidden');
        if (id) {
            document.getElementById('modalTitle').innerText = 'Edit Factory';
            fetch(<?= json_encode(app_url('/master/factories/get')) ?> + '?id=' + id)
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        document.getElementById('factoryId').value = res.data.id;
                        document.getElementById('name').value = res.data.name;
                        document.getElementById('location').value = res.data.location;
                        document.getElementById('contact_number').value = res.data.contact_number;
                        $('#status').val(res.data.status).trigger('change');
                    }
                });
        }
    }

    function closeModal() {
        document.getElementById('factoryModal').classList.add('hidden');
    }

    function saveFactory() {
        const formData = new FormData(document.getElementById('factoryForm'));
        $.ajax({
            url: <?= json_encode(app_url('/master/factories/save')) ?>,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, toast: true, position: 'top-right', timer: 3000, showConfirmButton: false });
                    closeModal();
                    location.reload();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            }
        });
    }

    function editFactory(id) {
        openModal(id);
    }

    function deleteFactory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(<?= json_encode(app_url('/master/factories/delete')) ?>, { id: id }, function(res) {
                    if (res.success) {
                        Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, toast: true, position: 'top-right', timer: 3000, showConfirmButton: false });
                        location.reload();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        $('#factoriesTable').DataTable({ responsive: true });
        $('#status').select2();
    });
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
