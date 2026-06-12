<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">UI Customization</h3>
            <p class="text-sm text-gray-500">Personalize your FactoryOS experience</p>
        </div>
        <form id="settingsForm" class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Typography -->
                <div class="space-y-4">
                    <h4 class="font-bold text-slate-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 5v14m0 0H7m2 0h2M3 5H1m2 0h2"></path></svg>
                        Typography
                    </h4>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Font Family</label>
                        <select name="font_family" id="font_family" class="w-full">
                            <option value="Inter" <?= $settings['font_family'] === 'Inter' ? 'selected' : '' ?>>Inter (Modern)</option>
                            <option value="Roboto" <?= $settings['font_family'] === 'Roboto' ? 'selected' : '' ?>>Roboto (Clean)</option>
                            <option value="Open Sans" <?= $settings['font_family'] === 'Open Sans' ? 'selected' : '' ?>>Open Sans (Friendly)</option>
                            <option value="Poppins" <?= $settings['font_family'] === 'Poppins' ? 'selected' : '' ?>>Poppins (Professional)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Font Size</label>
                        <select name="font_size" id="font_size" class="w-full">
                            <option value="12px" <?= $settings['font_size'] === '12px' ? 'selected' : '' ?>>Small (12px)</option>
                            <option value="14px" <?= $settings['font_size'] === '14px' ? 'selected' : '' ?>>Normal (14px)</option>
                            <option value="16px" <?= $settings['font_size'] === '16px' ? 'selected' : '' ?>>Large (16px)</option>
                        </select>
                    </div>
                </div>

                <!-- Brand Colors -->
                <div class="space-y-4">
                    <h4 class="font-bold text-slate-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                        Brand Colors
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Primary Color</label>
                            <input type="color" name="primary_color" value="<?= $settings['primary_color'] ?>" class="w-full h-10 rounded-lg cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Secondary Color</label>
                            <input type="color" name="secondary_color" value="<?= $settings['secondary_color'] ?>" class="w-full h-10 rounded-lg cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Layout Backgrounds -->
                <div class="space-y-4 md:col-span-2">
                    <h4 class="font-bold text-slate-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                        Layout Elements
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Sidebar Background</label>
                            <input type="color" name="sidebar_bg" value="<?= $settings['sidebar_bg'] ?>" class="w-full h-10 rounded-lg cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Header Background</label>
                            <input type="color" name="header_bg" value="<?= $settings['header_bg'] ?>" class="w-full h-10 rounded-lg cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="reset" class="px-6 py-2.5 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">Reset to Defaults</button>
                <button type="submit" id="saveBtn" class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all transform active:scale-95">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#font_family, #font_size').select2();

        const validator = new JustValidate('#settingsForm');
        validator.onSuccess((event) => {
            const btn = $('#saveBtn');
            btn.prop('disabled', true).text('Saving...');

            const formData = new FormData(document.getElementById('settingsForm'));
            $.ajax({
                url: '/myfactory/public/settings/save',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    btn.prop('disabled', false).text('Save Changes');
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Settings Saved',
                            text: res.message,
                            toast: true,
                            position: 'top-right',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
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
