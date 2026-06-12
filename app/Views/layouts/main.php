<?php
$sidebarCollapsed = sidebar_is_collapsed();
$userId = $_SESSION['user_id'] ?? null;
$currentPath = app_request_path();
$cookiePath = app_cookie_path();

$canReadModule = static function ($module) use ($userId) {
    if (!$userId) {
        return false;
    }

    if ($module === null) {
        return true;
    }

    return \App\Models\User::hasPermission($userId, $module, 'read');
};

$navSections = [
    [
        'title' => null,
        'items' => [
            [
                'label' => 'Dashboard',
                'path' => '/dashboard',
                'module' => null,
                'match' => ['/dashboard'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M3 12l2-2 7-7 7 7 2 2M5 10v9a1 1 0 001 1h3m10-10v9a1 1 0 01-1 1h-3m-6 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>',
            ],
        ],
    ],
    [
        'title' => 'Master Data',
        'items' => [
            [
                'label' => 'Factories',
                'path' => '/master/factories',
                'module' => 'Master Data',
                'match' => ['/master/factories'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 21h16M6 18V6a2 2 0 012-2h8a2 2 0 012 2v12M9 9h.01M9 12h.01M15 9h.01M15 12h.01M10 21v-4a2 2 0 012-2h0a2 2 0 012 2v4"></path>',
            ],
            [
                'label' => 'Products',
                'path' => '/master/products',
                'module' => 'Master Data',
                'match' => ['/master/products'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>',
            ],
            [
                'label' => 'Suppliers',
                'path' => '/master/suppliers',
                'module' => 'Master Data',
                'match' => ['/master/suppliers'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M17 20h5v-1.5a3 3 0 00-5.25-2M17 20H7m10 0v-1.5a5 5 0 00-10 0V20M7 20H2v-1.5a3 3 0 015.25-2M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM5 10a2 2 0 11-4 0 2 2 0 014 0z"></path>',
            ],
        ],
    ],
    [
        'title' => 'Inventory',
        'items' => [
            [
                'label' => 'Warehouses',
                'path' => '/inventory/warehouses',
                'module' => 'Inventory',
                'match' => ['/inventory/warehouses'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M3 10.5l9-5 9 5M5 11.5V18a2 2 0 002 2h10a2 2 0 002-2v-6.5M9 14h6M9 17h6"></path>',
            ],
            [
                'label' => 'Stock Ledger',
                'path' => '/inventory/stock',
                'module' => 'Inventory',
                'match' => ['/inventory/stock'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm7 1v4h4M9 13h6M9 17h4"></path>',
            ],
        ],
    ],
    [
        'title' => 'Manufacturing',
        'items' => [
            [
                'label' => 'Procurement',
                'path' => '/procurement',
                'module' => 'Procurement',
                'match' => ['/procurement'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M3 4h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 6M7 13l-1.2 1.2A1 1 0 006.5 16H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>',
            ],
            [
                'label' => 'BOM',
                'path' => '/production/bom',
                'module' => 'Production',
                'match' => ['/production/bom'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 8h6m-6 4h6"></path>',
            ],
        ],
    ],
    [
        'title' => 'Operations',
        'items' => [
            [
                'label' => 'Quality Control',
                'path' => '/qc',
                'module' => 'QC',
                'match' => ['/qc'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
            ],
            [
                'label' => 'Maintenance',
                'path' => '/maintenance',
                'module' => 'Maintenance',
                'match' => ['/maintenance'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M14.7 6.3a4 4 0 105 5L12 19l-4 1 1-4 7.7-7.7z"></path>',
            ],
            [
                'label' => 'Sales',
                'path' => '/sales',
                'module' => 'Sales',
                'match' => ['/sales'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M3 10h18M7 15h1m4 0h5m-11 5h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v9a3 3 0 003 3z"></path>',
            ],
            [
                'label' => 'HR',
                'path' => '/hr',
                'module' => 'HR',
                'match' => ['/hr'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M16 14a4 4 0 10-8 0v2a2 2 0 01-2 2h12a2 2 0 01-2-2v-2zm-4-8a3 3 0 110 6 3 3 0 010-6z"></path>',
            ],
            [
                'label' => 'Reports',
                'path' => '/reports',
                'module' => 'Reports',
                'match' => ['/reports'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M7 20h10M9 16V8m6 8V4m-3 12v-5"></path>',
            ],
        ],
    ],
    [
        'title' => 'System',
        'items' => [
            [
                'label' => 'Settings',
                'path' => '/settings',
                'module' => 'Settings',
                'match' => ['/settings'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
            ],
            [
                'label' => 'Users & Roles',
                'path' => '/users',
                'module' => 'User Management',
                'match' => ['/users', '/roles'],
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M17 20h5v-1a4 4 0 00-5.9-3.5M17 20H7m10 0v-1a5 5 0 00-10 0v1M7 20H2v-1a4 4 0 015.9-3.5M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM5 10a2 2 0 11-4 0 2 2 0 014 0z"></path>',
            ],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="en" class="<?= $sidebarCollapsed ? 'sidebar-collapsed' : '' ?>">
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
            --primary-color: <?= htmlspecialchars($_SESSION['theme']['primary_color'] ?? '#2563eb') ?>;
            --secondary-color: <?= htmlspecialchars($_SESSION['theme']['secondary_color'] ?? '#0f172a') ?>;
            --sidebar-bg: <?= htmlspecialchars($_SESSION['theme']['sidebar_bg'] ?? '#ffffff') ?>;
            --header-bg: <?= htmlspecialchars($_SESSION['theme']['header_bg'] ?? '#ffffff') ?>;
            --panel-bg: rgba(255, 255, 255, 0.88);
            --panel-border: rgba(148, 163, 184, 0.18);
            --surface-strong: #ffffff;
            --text-soft: #64748b;
            --page-bg: #eef3f8;
            --sidebar-width: 17rem;
            --sidebar-collapsed-width: 5.25rem;
            --nav-height-mobile: 5.5rem;
        }

        * { box-sizing: border-box; }

        body {
            font-family: var(--font-family), sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.10), transparent 28rem),
                radial-gradient(circle at top right, rgba(15, 23, 42, 0.08), transparent 24rem),
                linear-gradient(180deg, #f8fbff 0%, var(--page-bg) 100%);
        }

        .text-primary-custom { color: var(--primary-color); }
        .bg-primary-custom { background-color: var(--primary-color); }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #1d4ed8);
            color: #fff;
            transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
            box-shadow: 0 14px 30px -18px rgba(37, 99, 235, 0.65);
        }
        .btn-primary:hover { transform: translateY(-1px); opacity: 0.98; }

        #app-container { transition: padding-left 0.26s ease; }
        #sidebar {
            background:
                linear-gradient(180deg, color-mix(in srgb, var(--sidebar-bg) 94%, white 6%), var(--sidebar-bg));
            backdrop-filter: blur(18px);
            transition: width 0.26s ease, transform 0.22s ease;
        }

        .sidebar-brand,
        .sidebar-text,
        .sidebar-group-title {
            transition: opacity 0.18s ease, width 0.18s ease, transform 0.18s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.9rem;
            min-height: 3rem;
            border-radius: 1rem;
            color: #334155;
            transition: background-color 0.18s ease, color 0.18s ease, transform 0.18s ease;
        }

        .nav-item:hover {
            background: rgba(37, 99, 235, 0.08);
            color: var(--secondary-color);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.16), rgba(255, 255, 255, 0.88));
            color: #0f172a;
            box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.12);
        }

        .nav-item.active::before {
            content: "";
            position: absolute;
            left: 0.55rem;
            top: 0.6rem;
            bottom: 0.6rem;
            width: 0.24rem;
            border-radius: 999px;
            background: var(--primary-color);
        }

        .nav-item-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.35rem;
            height: 1.35rem;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn {
            width: 2.6rem;
            height: 2.6rem;
            border-radius: 0.9rem;
            color: #475569;
            transition: background-color 0.18s ease, color 0.18s ease, transform 0.18s ease;
        }

        .sidebar-toggle-btn:hover {
            background: rgba(148, 163, 184, 0.14);
            color: var(--secondary-color);
        }

        #sidebarToggleIcon {
            transition: transform 0.22s ease;
        }

        html.sidebar-collapsed #sidebarToggleIcon {
            transform: rotate(180deg);
        }

        .top-header {
            background: color-mix(in srgb, var(--header-bg) 88%, white 12%);
            backdrop-filter: blur(18px);
        }

        .glass-panel {
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            box-shadow: 0 16px 50px -36px rgba(15, 23, 42, 0.28);
            backdrop-filter: blur(18px);
        }

        .dataTables_wrapper {
            color: #334155;
            padding-top: 0.75rem;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.65rem;
            color: var(--text-soft);
            font-size: 0.82rem;
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            min-height: 2.75rem;
            border: 1px solid rgba(148, 163, 184, 0.28);
            border-radius: 0.95rem;
            background: rgba(255, 255, 255, 0.92);
            color: #0f172a;
            padding: 0.55rem 0.9rem;
            outline: none;
            box-shadow: none;
        }

        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: rgba(37, 99, 235, 0.34);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
        }

        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0;
            width: 100% !important;
            background: transparent;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid rgba(148, 163, 184, 0.16);
        }

        table.dataTable thead th,
        table.dataTable thead td {
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
            color: #64748b;
            font-size: 0.73rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.95rem 0.9rem !important;
        }

        table.dataTable tbody td {
            border-bottom: 1px solid rgba(226, 232, 240, 0.7);
            color: #0f172a;
            font-size: 0.9rem;
            padding: 1rem 0.9rem !important;
            vertical-align: middle;
        }

        table.dataTable tbody tr {
            background: rgba(255, 255, 255, 0.72);
            transition: background-color 0.16s ease;
        }

        table.dataTable tbody tr:hover {
            background: rgba(248, 250, 252, 0.96);
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-soft);
            font-size: 0.82rem;
            padding-top: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 0.75rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            min-width: 2.45rem;
            min-height: 2.45rem;
            border-radius: 0.85rem !important;
            border: 1px solid transparent !important;
            margin: 0 0.14rem;
            color: #475569 !important;
            transition: background-color 0.16s ease, color 0.16s ease, border-color 0.16s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--primary-color), #1d4ed8) !important;
            color: #fff !important;
            border-color: transparent !important;
            box-shadow: 0 12px 24px -18px rgba(37, 99, 235, 0.8);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(37, 99, 235, 0.08) !important;
            border-color: rgba(37, 99, 235, 0.14) !important;
            color: #0f172a !important;
        }

        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            min-height: 2.9rem;
            border: 1px solid rgba(148, 163, 184, 0.28) !important;
            border-radius: 0.95rem !important;
            background: rgba(255, 255, 255, 0.92) !important;
            display: flex !important;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #0f172a !important;
            line-height: 2.9rem !important;
            padding-left: 0.95rem !important;
        }

        .select2-dropdown {
            border: 1px solid rgba(148, 163, 184, 0.18) !important;
            border-radius: 1rem !important;
            overflow: hidden;
            box-shadow: 0 16px 50px -34px rgba(15, 23, 42, 0.35);
        }

        @media (min-width: 769px) {
            html.sidebar-collapsed #sidebar { width: var(--sidebar-collapsed-width); }
            html.sidebar-collapsed #app-container { padding-left: var(--sidebar-collapsed-width); }
            html.sidebar-collapsed .sidebar-brand,
            html.sidebar-collapsed .sidebar-group-title,
            html.sidebar-collapsed .sidebar-text,
            html.sidebar-collapsed .sidebar-footer-text {
                opacity: 0;
                width: 0;
                transform: translateX(-6px);
            }
            html.sidebar-collapsed .sidebar-header {
                justify-content: center;
                padding-left: 0.8rem;
                padding-right: 0.8rem;
            }
            html.sidebar-collapsed .nav-item {
                justify-content: center;
                gap: 0;
                padding-left: 0.85rem !important;
                padding-right: 0.85rem !important;
            }
            html.sidebar-collapsed .nav-item.active::before {
                left: 0.35rem;
            }
            html.sidebar-collapsed .nav-item::after {
                content: attr(data-label);
                position: absolute;
                left: calc(100% + 0.8rem);
                top: 50%;
                transform: translateY(-50%);
                background: rgba(15, 23, 42, 0.96);
                color: #fff;
                border-radius: 0.75rem;
                padding: 0.45rem 0.7rem;
                font-size: 0.76rem;
                font-weight: 600;
                opacity: 0;
                pointer-events: none;
                white-space: nowrap;
                transition: opacity 0.14s ease;
                box-shadow: 0 10px 30px -18px rgba(15, 23, 42, 0.8);
            }
            html.sidebar-collapsed .nav-item:hover::after {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            #sidebar {
                inset: auto 0 0 0;
                width: 100%;
                height: auto;
                border-top: 1px solid rgba(148, 163, 184, 0.22);
                border-right: none;
                box-shadow: 0 -20px 40px -34px rgba(15, 23, 42, 0.45);
                padding-bottom: max(0.35rem, env(safe-area-inset-bottom));
            }
            #sidebar.nav-hidden {
                transform: translateY(calc(100% + env(safe-area-inset-bottom)));
            }
            .sidebar-header,
            .sidebar-footer {
                display: none !important;
            }
            #sidebar nav {
                display: flex;
                flex-direction: row;
                align-items: stretch;
                gap: 0.15rem;
                overflow-x: auto;
                overflow-y: hidden;
                padding: 0.55rem 0.35rem 0.2rem;
                scrollbar-width: none;
                scroll-snap-type: x proximity;
                -webkit-overflow-scrolling: touch;
            }
            #sidebar nav::-webkit-scrollbar { display: none; }
            .sidebar-group-title { display: none; }
            .nav-item {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 0.35rem;
                min-width: 4.4rem;
                min-height: 4.4rem;
                padding: 0.55rem 0.7rem !important;
                border-radius: 1.1rem;
                scroll-snap-align: center;
                color: #1e293b;
            }
            .nav-item.active {
                background: linear-gradient(180deg, rgba(37, 99, 235, 0.16), rgba(37, 99, 235, 0.05));
            }
            .nav-item.active::before {
                left: 50%;
                top: 0.32rem;
                bottom: auto;
                width: 1.8rem;
                height: 0.2rem;
                transform: translateX(-50%);
            }
            .nav-item-icon {
                width: 1.45rem;
                height: 1.45rem;
            }
            .sidebar-text {
                width: auto !important;
                opacity: 1 !important;
                transform: none !important;
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.01em;
            }
            #app-container {
                padding-left: 0 !important;
                padding-bottom: calc(var(--nav-height-mobile) + env(safe-area-inset-bottom));
            }
        }
    </style>
</head>
<body class="min-h-screen overflow-hidden text-slate-900 antialiased">
    <aside id="sidebar" class="fixed left-0 top-0 z-40 flex h-screen w-[17rem] flex-col border-r border-slate-200/70">
        <div class="sidebar-header flex h-20 items-center justify-between border-b border-slate-200/70 px-4">
            <div class="min-w-0">
                <div class="sidebar-brand text-[0.7rem] font-semibold uppercase tracking-[0.26em] text-slate-400">FactoryOS</div>
                <div class="sidebar-brand mt-1 truncate text-sm font-semibold text-slate-900"><?= htmlspecialchars($_SESSION['full_name'] ?? 'Workspace') ?></div>
            </div>
            <button id="sidebarToggle" type="button" class="sidebar-toggle-btn inline-flex items-center justify-center" aria-label="Toggle sidebar">
                <svg id="sidebarToggleIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto overflow-x-hidden px-3 py-4">
            <?php foreach ($navSections as $section): ?>
                <?php
                $visibleItems = array_values(array_filter($section['items'], static function ($item) use ($canReadModule) {
                    return $canReadModule($item['module']);
                }));
                if (empty($visibleItems)) {
                    continue;
                }
                ?>
                <?php if (!empty($section['title'])): ?>
                    <div class="sidebar-group-title px-3 pb-2 pt-5 text-[0.68rem] font-bold uppercase tracking-[0.22em] text-slate-400"><?= htmlspecialchars($section['title']) ?></div>
                <?php endif; ?>
                <?php foreach ($visibleItems as $item): ?>
                    <?php
                    $isActive = false;
                    foreach ($item['match'] as $match) {
                        if ($match === '/' && $currentPath === '/') {
                            $isActive = true;
                            break;
                        }
                        if ($match !== '/' && strpos($currentPath, $match) === 0) {
                            $isActive = true;
                            break;
                        }
                    }
                    ?>
                    <a
                        href="<?= htmlspecialchars(app_url($item['path'])) ?>"
                        data-label="<?= htmlspecialchars($item['label']) ?>"
                        class="nav-item mt-1 px-4 py-3 text-sm font-semibold <?= $isActive ? 'active' : '' ?>"
                    >
                        <span class="nav-item-icon">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?= $item['icon'] ?></svg>
                        </span>
                        <span class="sidebar-text"><?= htmlspecialchars($item['label']) ?></span>
                    </a>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </nav>

        <div class="sidebar-footer border-t border-slate-200/70 px-4 py-4 text-xs text-slate-500">
            <div class="sidebar-footer-text">Created by Yasin Ullah</div>
        </div>
    </aside>

    <div id="app-container" class="flex min-h-screen flex-col pl-0 <?= $sidebarCollapsed ? 'lg:pl-[5.25rem]' : 'lg:pl-[17rem]' ?>">
        <header class="top-header sticky top-0 z-30 border-b border-slate-200/70 px-4 py-4 shadow-sm shadow-slate-900/5 sm:px-6">
            <div class="glass-panel flex items-center justify-between rounded-[1.4rem] px-4 py-3 sm:px-5">
                <div class="min-w-0">
                    <div class="text-[0.68rem] font-semibold uppercase tracking-[0.24em] text-slate-400">Workspace</div>
                    <h2 class="truncate pt-1 text-lg font-semibold text-slate-900 sm:text-xl"><?= htmlspecialchars($title ?? '') ?></h2>
                </div>
                <div class="ml-4 flex flex-shrink-0 items-center gap-3">
                    <span class="hidden rounded-full bg-slate-900 px-3 py-1 text-xs font-semibold text-white sm:inline-flex"><?= htmlspecialchars($_SESSION['full_name'] ?? 'User') ?></span>
                    <a href="<?= htmlspecialchars(app_url('/logout')) ?>" class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition-colors hover:bg-red-100">Logout</a>
                </div>
            </div>
        </header>

        <main id="main-content" class="flex-1 overflow-x-hidden overflow-y-auto px-4 py-5 sm:px-6 sm:py-6">
            <?= $content ?? '' ?>
        </main>
    </div>

    <script>
        window.APP_BASE_URL = <?= json_encode(app_url('/')) ?>;

        $(document).ready(function() {
            $('select').not('.select2-hidden-accessible').select2({ width: '100%' });

            if ($.fn.DataTable) {
                $.extend(true, $.fn.dataTable.defaults, {
                    autoWidth: false,
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: '',
                        searchPlaceholder: 'Search records...',
                        lengthMenu: '_MENU_ rows'
                    }
                });

                $('table.datatable').each(function() {
                    if (!$.fn.dataTable.isDataTable(this)) {
                        $(this).DataTable();
                    }
                });
            }
        });

        (function() {
            const html = document.documentElement;
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mainContent = document.getElementById('main-content');
            const sidebar = document.getElementById('sidebar');
            const desktopBreakpoint = window.matchMedia('(min-width: 769px)');
            const cookiePath = <?= json_encode($cookiePath) ?>;
            let lastScrollTop = 0;

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    if (!desktopBreakpoint.matches) {
                        return;
                    }

                    html.classList.toggle('sidebar-collapsed');
                    const isCollapsed = html.classList.contains('sidebar-collapsed');
                    const maxAge = 60 * 60 * 24 * 365;
                    document.cookie = `sidebar_collapsed=${isCollapsed ? '1' : '0'}; path=${cookiePath}; max-age=${maxAge}; SameSite=Lax`;
                });
            }

            if (mainContent && sidebar) {
                mainContent.addEventListener('scroll', function() {
                    if (desktopBreakpoint.matches) {
                        sidebar.classList.remove('nav-hidden');
                        return;
                    }

                    const currentScrollTop = Math.max(mainContent.scrollTop, 0);
                    const scrollingDown = currentScrollTop > lastScrollTop;

                    if (scrollingDown && currentScrollTop > 56) {
                        sidebar.classList.add('nav-hidden');
                    } else {
                        sidebar.classList.remove('nav-hidden');
                    }

                    lastScrollTop = currentScrollTop;
                }, { passive: true });
            }

            desktopBreakpoint.addEventListener('change', function(event) {
                if (event.matches) {
                    sidebar.classList.remove('nav-hidden');
                }
            });
        })();
    </script>
</body>
</html>
