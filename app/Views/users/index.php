<div x-data="{ tab: 'users' }" class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="border-b border-gray-200 px-6 py-3 flex space-x-6">
        <button @click="tab = 'users'" :class="tab === 'users' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="border-b-2 py-2 font-medium text-sm transition-colors">Users</button>
        <button @click="tab = 'roles'" :class="tab === 'roles' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="border-b-2 py-2 font-medium text-sm transition-colors">Roles & Permissions</button>
    </div>

    <!-- Users Tab -->
    <div x-show="tab === 'users'" class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">User Accounts</h3>
            <?php if(\App\Models\User::hasPermission($_SESSION['user_id'], 'User Management', 'create')): ?>
            <button onclick="openUserModal()" class="btn-primary px-4 py-2 rounded-md text-sm font-medium">Add User</button>
            <?php endif; ?>
        </div>
        <table class="datatable w-full text-left">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['full_name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full border border-gray-200"><?= htmlspecialchars($u['role_name'] ?? 'None') ?></span></td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full <?= $u['status'] === 'active' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' ?>">
                            <?= ucfirst($u['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if(\App\Models\User::hasPermission($_SESSION['user_id'], 'User Management', 'update')): ?>
                        <button onclick="editUser(<?= $u['id'] ?>)" class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                        <?php endif; ?>
                        <?php if(\App\Models\User::hasPermission($_SESSION['user_id'], 'User Management', 'delete') && $u['id'] != 1 && $u['id'] != $_SESSION['user_id']): ?>
                        <button onclick="deleteUser(<?= $u['id'] ?>)" class="text-red-500 hover:text-red-700">Delete</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Roles Tab -->
    <div x-show="tab === 'roles'" class="p-6" style="display: none;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Roles</h3>
            <?php if(\App\Models\User::hasPermission($_SESSION['user_id'], 'User Management', 'create')): ?>
            <button onclick="openRoleModal()" class="btn-primary px-4 py-2 rounded-md text-sm font-medium">Add Role</button>
            <?php endif; ?>
        </div>
        <table class="datatable w-full text-left">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($roles as $r): ?>
                <tr>
                    <td class="font-medium"><?= htmlspecialchars($r['name']) ?></td>
                    <td class="text-gray-500 text-sm"><?= htmlspecialchars($r['description']) ?></td>
                    <td>
                        <?php if(\App\Models\User::hasPermission($_SESSION['user_id'], 'User Management', 'update') && $r['id'] != 1): ?>
                        <button onclick="editRole(<?= $r['id'] ?>)" class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                        <?php endif; ?>
                        <?php if(\App\Models\User::hasPermission($_SESSION['user_id'], 'User Management', 'delete') && $r['id'] > 2): ?>
                        <button onclick="deleteRole(<?= $r['id'] ?>)" class="text-red-500 hover:text-red-700">Delete</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- AlpineJS for tabs -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- User Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold" id="userModalTitle">Add User</h3>
            <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form id="userForm" class="p-6 overflow-y-auto">
            <input type="hidden" name="id" id="userId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" id="userName" required class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="full_name" id="userFullName" required class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="userEmail" required class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role_id" id="userRole" required class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500">
                        <option value="">Select Role</option>
                        <?php foreach($roles as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="userStatus" class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="locked">Locked</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-xs text-gray-500 font-normal" id="pwdHint">(leave blank to keep current)</span></label>
                    <input type="password" name="password" id="userPassword" class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500">
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeUserModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-primary-custom text-white rounded-md hover:opacity-90 transition-opacity">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Role Modal -->
<div id="roleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold" id="roleModalTitle">Add Role</h3>
            <button onclick="closeRoleModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form id="roleForm" class="flex-1 overflow-y-auto p-6">
            <input type="hidden" name="id" id="roleId">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                    <input type="text" name="name" id="roleName" required class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" name="description" id="roleDesc" class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500">
                </div>
            </div>
            
            <h4 class="text-sm font-semibold text-gray-800 mb-3 border-b pb-2">Module Permissions</h4>
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-2 border-b">Module</th>
                            <th class="px-4 py-2 border-b text-center">Read</th>
                            <th class="px-4 py-2 border-b text-center">Create</th>
                            <th class="px-4 py-2 border-b text-center">Update</th>
                            <th class="px-4 py-2 border-b text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="permissionsTbody">
                        <?php foreach($modules as $mod): ?>
                        <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium text-gray-700"><?= $mod ?></td>
                            <td class="px-4 py-2 text-center"><input type="checkbox" name="permissions[<?= $mod ?>][read]" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                            <td class="px-4 py-2 text-center"><input type="checkbox" name="permissions[<?= $mod ?>][create]" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                            <td class="px-4 py-2 text-center"><input type="checkbox" name="permissions[<?= $mod ?>][update]" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                            <td class="px-4 py-2 text-center"><input type="checkbox" name="permissions[<?= $mod ?>][delete]" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeRoleModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-primary-custom text-white rounded-md hover:opacity-90 transition-opacity">Save Role</button>
            </div>
        </form>
    </div>
</div>

<script>
// --- User Management ---
function openUserModal() {
    $('#userForm')[0].reset();
    $('#userId').val('');
    $('#userModalTitle').text('Add User');
    $('#userPassword').prop('required', true);
    $('#pwdHint').text('(required)');
    $('#userModal').removeClass('hidden');
}

function closeUserModal() {
    $('#userModal').addClass('hidden');
}

function editUser(id) {
    $.get('/myfactory/public/users/get?id=' + id, function(data) {
        if(data.error) {
            Swal.fire('Error', data.error, 'error');
            return;
        }
        $('#userId').val(data.id);
        $('#userName').val(data.username);
        $('#userFullName').val(data.full_name);
        $('#userEmail').val(data.email);
        $('#userRole').val(data.role_id).trigger('change');
        $('#userStatus').val(data.status);
        $('#userModalTitle').text('Edit User');
        $('#userPassword').prop('required', false);
        $('#pwdHint').text('(leave blank to keep current)');
        $('#userModal').removeClass('hidden');
    }).fail(function() {
        Swal.fire('Error', 'Failed to fetch user data', 'error');
    });
}

$('#userForm').on('submit', function(e) {
    e.preventDefault();
    $.post('/myfactory/public/users/save', $(this).serialize(), function(res) {
        if(res.success) {
            location.reload();
        } else {
            Swal.fire('Error', res.message || 'Save failed', 'error');
        }
    }).fail(function() {
        Swal.fire('Error', 'Request failed', 'error');
    });
});

function deleteUser(id) {
    Swal.fire({
        title: 'Delete User?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('/myfactory/public/users/delete', {id: id}, function(res) {
                if(res.success) location.reload();
                else Swal.fire('Error', res.message || 'Delete failed', 'error');
            });
        }
    });
}

// --- Role Management ---
function openRoleModal() {
    $('#roleForm')[0].reset();
    $('#roleId').val('');
    $('#roleModalTitle').text('Add Role');
    $('#roleModal').removeClass('hidden');
}

function closeRoleModal() {
    $('#roleModal').addClass('hidden');
}

function editRole(id) {
    $.get('/myfactory/public/roles/get?id=' + id, function(data) {
        if(data.error) {
            Swal.fire('Error', data.error, 'error');
            return;
        }
        $('#roleForm')[0].reset(); // Reset checkboxes
        $('#roleId').val(data.id);
        $('#roleName').val(data.name);
        $('#roleDesc').val(data.description);
        
        // Fill checkboxes
        if(data.permissions) {
            data.permissions.forEach(function(p) {
                let mod = p.module.replace(/([\[\]"'\\])/g, '\\$1');
                if(p.can_read == 1) $(`input[name="permissions[${mod}][read]"]`).prop('checked', true);
                if(p.can_create == 1) $(`input[name="permissions[${mod}][create]"]`).prop('checked', true);
                if(p.can_update == 1) $(`input[name="permissions[${mod}][update]"]`).prop('checked', true);
                if(p.can_delete == 1) $(`input[name="permissions[${mod}][delete]"]`).prop('checked', true);
            });
        }
        
        $('#roleModalTitle').text('Edit Role');
        $('#roleModal').removeClass('hidden');
    }).fail(function() {
        Swal.fire('Error', 'Failed to fetch role data', 'error');
    });
}

$('#roleForm').on('submit', function(e) {
    e.preventDefault();
    $.post('/myfactory/public/roles/save', $(this).serialize(), function(res) {
        if(res.success) {
            location.reload();
        } else {
            Swal.fire('Error', res.message || 'Save failed', 'error');
        }
    }).fail(function() {
        Swal.fire('Error', 'Request failed', 'error');
    });
});

function deleteRole(id) {
    Swal.fire({
        title: 'Delete Role?',
        text: "Make sure no users are assigned to this role.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('/myfactory/public/roles/delete', {id: id}, function(res) {
                if(res.success) location.reload();
                else Swal.fire('Error', res.message || 'Delete failed', 'error');
            });
        }
    });
}
</script>