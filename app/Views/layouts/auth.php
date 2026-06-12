<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Factory Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md animate__animated animate__zoomIn">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600">Factory MS</h1>
            <p class="text-gray-500 mt-2">Sign in to your account</p>
        </div>

        <?php if (\App\Core\Application::$app->session->getFlash('error')): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm border border-red-200">
                <?= \App\Core\Application::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="post" id="login-form" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="username" id="username" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Enter username" required autofocus>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="password" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Enter password" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Security Check</label>
                <div class="flex items-center space-x-4">
                    <img src="/captcha" alt="captcha" class="rounded border">
                    <input type="text" name="captcha" id="captcha" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Result" required>
                </div>
            </div>

            <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center justify-center">
                <span>Sign In</span>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center text-xs text-gray-400">
            <p>Created by: Yasin Ullah</p>
            <div class="mt-2 space-x-4">
                <a href="https://www.linkedin.com/in/yasin-ullah-029229232/" target="_blank" class="hover:text-blue-600"><i class="fab fa-linkedin"></i> Linkedin</a>
                <span><i class="fab fa-whatsapp"></i> 03361593533</span>
            </div>
        </div>
    </div>

    <script>
        const validator = new JustValidate('#login-form');
        validator
            .addField('#username', [{ rule: 'required' }])
            .addField('#password', [{ rule: 'required' }])
            .addField('#captcha', [{ rule: 'required' }])
            .onSuccess((event) => {
                const btn = document.getElementById('submit-btn');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                event.target.submit();
            });
    </script>
</body>
</html>
