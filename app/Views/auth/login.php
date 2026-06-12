<?php $appRoot = rtrim(app_url('/'), '/'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Factory Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        .login-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md animate__animated animate__zoomIn">
        <div class="login-card p-8 rounded-2xl shadow-2xl border border-slate-700/50">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-800">FactoryOS</h1>
                <p class="text-slate-500 mt-2">Sign in to your account</p>
            </div>

            <form id="loginForm" class="space-y-5" novalidate>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <input type="text" name="username" id="username" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="Enter your username">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="••••••••">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Solve the math</label>
                    <div class="flex gap-4 items-center">
                        <img src="<?= htmlspecialchars(app_url('/captcha')) ?>" alt="CAPTCHA" id="captchaImg" class="rounded-xl border border-slate-200 h-12 cursor-pointer" title="Click to refresh">
                        <input type="text" name="captcha" id="captcha" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="Result">
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-500/30 transition-all transform active:scale-[0.98]">
                    Sign In
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-400">
                Created by: <a href="https://www.linkedin.com/in/yasin-ullah-029229232/" class="hover:text-blue-600 underline" target="_blank">Yasin Ullah</a><br>
                WhatsApp: 03361593533
            </div>
        </div>
    </div>

    <script>
        const validator = new JustValidate('#loginForm', {
            errorFieldCssClass: 'is-invalid',
            errorLabelStyle: { color: '#ef4444', fontSize: '12px', marginTop: '4px' }
        });

        validator
            .addField('#username', [{ rule: 'required', errorMessage: 'Username is required' }])
            .addField('#password', [
                { rule: 'required', errorMessage: 'Password is required' },
                { rule: 'minLength', value: 8, errorMessage: 'Minimum 8 characters' }
            ])
            .addField('#captcha', [{ rule: 'required', errorMessage: 'Please solve the captcha' }])
            .onSuccess((event) => {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...</span>';

                const formData = new FormData(document.getElementById('loginForm'));
                
                $.ajax({
                    url: <?= json_encode(app_url('/login')) ?>,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Welcome back!',
                                text: 'Login successful.',
                                timer: 1500,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-right'
                            }).then(() => {
                                window.location.href = <?= json_encode($appRoot) ?> + response.redirect;
                            });
                        } else {
                            btn.disabled = false;
                            btn.innerText = 'Sign In';
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: response.message,
                                toast: true,
                                position: 'top-right',
                                timer: 3000,
                                showConfirmButton: false
                            });
                            refreshCaptcha();
                        }
                    },
                    error: function() {
                        btn.disabled = false;
                        btn.innerText = 'Sign In';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred.',
                            toast: true,
                            position: 'top-right',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                });
            });

        function refreshCaptcha() {
            document.getElementById('captchaImg').src = <?= json_encode(app_url('/captcha')) ?> + '?t=' + new Date().getTime();
            document.getElementById('captcha').value = '';
        }

        document.getElementById('captchaImg').addEventListener('click', refreshCaptcha);
    </script>
</body>
</html>
