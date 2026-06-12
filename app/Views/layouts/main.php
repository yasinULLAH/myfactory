<!DOCTYPE html>
<html lang="en" class="<?= isset($_COOKIE['sidebar_collapsed']) && $_COOKIE['sidebar_collapsed'] == '1' ? 'sidebar-collapsed' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= htmlspecialchars($title ?? 'Factory Management') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --font-family: <?= htmlspecialchars($_SESSION['theme']['font_family'] ?? 'Inter') ?>;
            --primary-color: <?= htmlspecialchars($_SESSION['theme']['primary_color'] ?? '#3b82f6') ?>;
            --secondary-color: <?= htmlspecialchars($_SESSION['theme']['secondary_color'] ?? '#1e293b') ?>;
            --sidebar-bg: <?= htmlspecialchars($_SESSION['theme']['sidebar_bg'] ?? '#ffffff') ?>;
            --header-bg: <?= htmlspecialchars($_SESSION['theme']['header_bg'] ?? '#ffffff') ?>;
        }
        body { font-family: var(--font-family), sans-serif; background-color: #f3f4f6; }
        .text-primary-custom { color: var(--primary-color); }
        .bg-primary-custom { background-color: var(--primary-color); }
        .btn-primary { background-color: var(--primary-color); color: white; transition: all 0.2s; }
        .btn-primary:hover { opacity: 0.9; }
        
        /* Minimalist DataTables styling */
        table.dataTable.no-footer { border-bottom: 1px solid #e5e7eb; }
        .dataTables_wrapper .dataTables_length select, .dataTables_wrapper .dataTables_filter input { 
            border: 1px solid #d1d5db; border-radius: 6px; padding: 4px 8px; outline: none; margin-bottom: 10px;
        }
        table.dataTable thead th, table.dataTable thead td { border-bottom: 2px solid #e5e7eb; color: #4b5563; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; }
        table.dataTable tbody td { border-bottom: 1px solid #f3f4f6; color: #1f2937; padding: 12px 10px; font-size: 0.875rem; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 4px 10px; border-radius: 6px; border: 1px solid transparent; margin: 0 2px; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--primary-color) !important; color: white !important; border: none; box-shadow: none; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f3f4f6 !important; border: 1px solid #d1d5db; color: #374151 !important; }
        
        /* Sidebar transitions and states */
        #app-container { transition: padding-left 0.3s ease; }
        #sidebar { transition: width 0.3s ease; background-color: var(--sidebar-bg); }
        .sidebar-text { transition: opacity 0.2s ease, width 0.2s ease; white-space: nowrap; overflow: hidden; }
        .sidebar-header-text { transition: opacity 0.2s ease; white-space: nowrap; overflow: hidden; }
        
        /* Desktop Collapsed State */
        @media (min-width: 769px) {
            html.sidebar-collapsed #sidebar { width: 4.5rem; }
            html.sidebar-collapsed #app-container { padding-left: 4.5rem; }
            html.sidebar-collapsed .sidebar-text,
            html.sidebar-collapsed .sidebar-header-text,
            html.sidebar-collapsed .sidebar-group-title { opacity: 0; width: 0; display: none; }
            html.sidebar-collapsed .nav-item { justify-content: center; padding-left: 0; padding-right: 0; position: relative; }
            html.sidebar-collapsed .nav-item svg { margin-right: 0; }
            /* Show title on hover as tooltip in collapsed mode */
            html.sidebar-collapsed .nav-item:hover::after {
                content: attr(title); position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
                background: #1f2937; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; z-index: 50; margin-left: 10px;
            }
        }
        
        /* Smart Mobile Bottom Navigation */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed; bottom: 0; left: 0; right: 0; top: auto; width: 100%; height: auto;
                border-top: 1px solid #e5e7eb; border-right: none; display: flex; flex-direction: column;
                z-index: 50; transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.05); padding-bottom: env(safe-area-inset-bottom);
            }
            #sidebar.nav-hidden { transform: translateY(100%); }
            .sidebar-header-container, .sidebar-footer, .sidebar-toggle-btn { display: none !important; }
            #sidebar nav {
                display: flex; flex-direction: row; overflow-x: auto; overflow-y: hidden;
                padding: 0; padding-top: 5px; scroll-behavior: smooth;
                -ms-overflow-style: none; scrollbar-width: none;
            }
            #sidebar nav::-webkit-scrollbar { display: none; }
            .sidebar-group-title { display: none; }
            .nav-item {
                flex-direction: column; justify-content: center; align-items: center;
                padding: 5px 12px; min-width: 70px; min-height: 44px; /* Touch target */
                color: #4b5563; font-size: 0.65rem;
            }
            .nav-item svg { margin-right: 0; margin-bottom: 4px; width: 22px; height: 22px; stroke-width: 1.8; color: #4b5563; }
            .nav-item.active { color: var(--primary-color); }
            .nav-item.active svg { stroke-width: 2.2; color: var(--primary-color); }
            .sidebar-text { opacity: 1; width: auto; font-weight: 500; }
            #app-container { padding-left: 0 !important; padding-bottom: 60px; }
        }
    </style>
</head>
<body class="text-gray-800 antialiased overflow-hidden">
    <!-- Unified Sidebar / Mobile Nav -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 border-r border-gray-200 z-40 flex flex-col">
        <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200 sidebar-header-container">
            <h1 class="text-xl font-bold text-primary-custom sidebar-header-text truncate">FactoryOS</h1>
            <button id="sidebarToggle" class="sidebar-toggle-btn text-gray-500 hover:text-gray-700 p-1 rounded-md hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
        
        <nav class="flex-1 overflow-y-auto overflow-x-hidden py-2 desktop-nav-scroll">
            <a href="/myfactory/public/dashboard" title="Dashboard" class="nav-item flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false ? 'active bg-blue-50 text-blue-600' : '' ?>">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="sidebar-text">Dashboard</span>
            </a>
            
            <div class="px-6 py-2 mt-2 text-xs font-bold text-gray-400 uppercase tracking-wider sidebar-group-title">Master Data</div>
            <a href="/myfactory/public/master/factories" title="Factories" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span class="sidebar-text">Factories</span>
            </a>
            <a href="/myfactory/public/master/products" title="Products" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span class="sidebar-text">Products</span>
            </a>
            <a href="/myfactory/public/master/suppliers" title="Suppliers" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="sidebar-text">Suppliers</span>
            </a>
            
            <div class="px-6 py-2 mt-2 text-xs font-bold text-gray-400 uppercase tracking-wider sidebar-group-title">Inventory</div>
            <a href="/myfactory/public/inventory/warehouses" title="Warehouses" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                <span class="sidebar-text">Warehouses</span>
            </a>
            <a href="/myfactory/public/inventory/stock" title="Stock Ledger" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="sidebar-text">Stock Ledger</span>
            </a>
            
            <div class="px-6 py-2 mt-2 text-xs font-bold text-gray-400 uppercase tracking-wider sidebar-group-title">Manufacturing</div>
            <a href="/myfactory/public/procurement" title="Procurement" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="sidebar-text">Procurement</span>
            </a>
            <a href="/myfactory/public/production/bom" title="BOM" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="sidebar-text">BOM</span>
            </a>
            
            <div class="px-6 py-2 mt-2 text-xs font-bold text-gray-400 uppercase tracking-wider sidebar-group-title">Operations</div>
            <a href="/myfactory/public/qc" title="QC" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="sidebar-text">Quality Control</span>
            </a>
            <a href="/myfactory/public/sales" title="Sales" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                <span class="sidebar-text">Sales</span>
            </a>
            
            <div class="px-6 py-2 mt-2 text-xs font-bold text-gray-400 uppercase tracking-wider sidebar-group-title">System</div>
            <a href="/myfactory/public/settings" title="Settings" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                <span class="sidebar-text">Settings</span>
            </a>
            
            <?php if(\App\Models\User::hasPermission($_SESSION['user_id'] ?? 0, 'User Management', 'read')): ?>
            <a href="/myfactory/public/users" title="Users & Roles" class="nav-item flex items-center px-6 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/users') !== false ? 'active bg-blue-50 text-blue-600' : '' ?>">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="sidebar-text">Users & Roles</span>
            </a>
            <?php endif; ?>
        </nav>
        
        <div class="sidebar-footer p-4 border-t border-gray-200 text-xs text-center text-gray-500 sidebar-text">
            Created by Yasin Ullah
        </div>
    </aside>

    <div id="app-container" class="flex-1 flex flex-col h-screen <?= isset($_COOKIE['sidebar_collapsed']) && $_COOKIE['sidebar_collapsed'] == '1' ? 'pl-[4.5rem]' : 'pl-64' ?>">
        <!-- Top Header -->
        <header class="h-16 top-header shadow-sm border-b border-gray-200 flex items-center justify-between px-6 z-10 sticky top-0 bg-white">
            <h2 class="text-xl font-semibold text-gray-800 truncate"><?= htmlspecialchars($title ?? '') ?></h2>
            <div class="flex items-center flex-shrink-0 ml-4">
                <span class="hidden sm:inline mr-4 text-sm font-medium text-gray-600"><?= htmlspecialchars($_SESSION['full_name'] ?? 'User') ?></span>
                <a href="/myfactory/public/logout" class="text-sm px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-md font-medium transition-colors">Logout</a>
            </div>
        </header>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 sm:p-6">
            <?= $content ?? '' ?>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            // Minimalist styling applied via CSS, just initialize plugins
            $('select').select2({ width: '100%' });
            if($.fn.DataTable) {
                $('table').DataTable({ 
                    responsive: true,
                    language: { search: "", searchPlaceholder: "Search records..." }
                });
            }
        });

        // Sidebar Toggle Logic
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const html = document.documentElement;
            html.classList.toggle('sidebar-collapsed');
            
            const isCollapsed = html.classList.contains('sidebar-collapsed');
            document.cookie = "sidebar_collapsed=" + (isCollapsed ? "1" : "0") + "; path=/; max-age=31536000";
            
            const appContainer = document.getElementById('app-container');
            if (window.innerWidth >= 769) {
                appContainer.style.paddingLeft = isCollapsed ? '4.5rem' : '16rem';
            }
        });

        // Smart Mobile Bottom Nav Auto-Hide Logic
        let lastScrollTop = 0;
        const mainContent = document.getElementById('main-content');
        const sidebar = document.getElementById('sidebar');

        if (mainContent) {
            mainContent.addEventListener('scroll', function() {
                if (window.innerWidth <= 768) {
                    let st = mainContent.scrollTop;
                    if (st > lastScrollTop && st > 60) {
                        // Scrolling down
                        sidebar.classList.add('nav-hidden');
                    } else {
                        // Scrolling up
                        sidebar.classList.remove('nav-hidden');
                    }
                    lastScrollTop = st <= 0 ? 0 : st;
                }
            }, { passive: true });
        }
    </script>
</body>
</html>