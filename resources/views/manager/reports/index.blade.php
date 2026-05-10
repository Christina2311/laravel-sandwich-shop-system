<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reports - CPAMA Sandwich</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --sidebar-bg:      #5C2D0E;
            --sidebar-hover:   #7A3D18;
            --sidebar-active:  #7A3D18;
            --sidebar-text:    #F5E6D3;
            --sidebar-muted:   #C9A882;
            --sidebar-border:  rgba(255,255,255,0.12);
            --sidebar-width:   220px;

            --page-bg:         #F7F3EE;
            --card-bg:         #FFFFFF;
            --card-border:     #EDE5D8;
            --text-dark:       #2C2C2C;
            --font:            'Nunito', sans-serif;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: var(--font);
            background: var(--page-bg);
            color: var(--text-dark);
        }

        .wrapper { display: flex; min-height: 100vh; }

        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 36px 36px 60px;
        }

         /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 24px 14px 20px;
            z-index: 100;
        }

        /* Logo block */
        .sidebar-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            margin-bottom: 18px;
        }

        .sidebar-logo img.logo-img {
            width: 500px;
            height: 160px;
            object-fit: contain;
        }

        .sidebar-logo .brand-name {
            font-size: 13px;
            font-weight: 800;
            color: #FFFFFF;
            text-align: center;
        }

        .sidebar-logo .manager-label {
            font-size: 11px;
            color: #C9A882;
            text-align: center;
            line-height: 1.4;
        }

        .manager-label span {
            color: #FFFFFF;
            font-weight: 700;
        }

        /* Section headings */
        .nav-section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #C9A882;
            padding: 6px 8px 4px;
            margin-top: 6px;
        }

        /* Nav items */
        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0 0 6px;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: #F5E6D3;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.18s;
        }

        .sidebar-nav li a img {
            width: 18px;
            height: 18px;
            object-fit: contain;
            opacity: 0.85;
            filter: brightness(0) invert(1);
        }

        .sidebar-nav li a:hover {
            background: #7A3D18;
        }

        .sidebar-nav li a.active {
            background: #7A3D18;
            color: #FFFFFF;
        }

        .sidebar-nav li a.active img {
            opacity: 1;
        }

        /* Logout button */
        .sidebar-logout {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid rgba(255,255,255,0.12);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 9px 12px;
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.25);
            border-radius: 8px;
            color: #F5E6D3;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.18s, border-color 0.18s;
            text-decoration: none;
        }

        .btn-logout img {
            width: 16px;
            height: 16px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            opacity: 0.85;
        }

        .btn-logout:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.45);
            color: #FFFFFF;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 28px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .page-header .page-title {
            margin-bottom: 0;
        }

        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--sidebar-bg);
            color: #fff;
            font-family: var(--font);
            font-size: 13px;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.18s;
            text-decoration: none;
        }

        .btn-download:hover { background: var(--sidebar-hover); color: #fff; }

        .btn-download svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: 16px;
        }

        /* ── Tab Buttons ── */
        .tab-btn {
            background: none;
            border: none;
            padding: 12px 18px;
            font-family: var(--font);
            font-size: 13px;
            font-weight: 600;
            color: #888;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: color 0.18s, border-color 0.18s;
        }

        .tab-btn:hover { color: var(--text-dark); }

        .tab-btn.active {
            color: #5C2D0E;
            border-bottom-color: #5C2D0E;
        }

        /* ── Filter Buttons ── */
        .filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #F5F0EB;
            border: 1.5px solid #EDE5D8;
            border-radius: 8px;
            padding: 6px 14px;
            font-family: var(--font);
            font-size: 12px;
            font-weight: 600;
            color: #555;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
        }

        .filter-btn:hover { background: #EDE5D8; }

        .filter-btn.active {
            background: #5C2D0E;
            border-color: #5C2D0E;
            color: #fff;
        }

        /* ── Printable Report ── */
        #printable-report { display: none; }

        @media print {
            body * { visibility: hidden; }
            #printable-report,
            #printable-report * { visibility: visible; }
            #printable-report {
                display: block !important;
                position: fixed;
                inset: 0;
                padding: 40px 48px;
                background: #fff;
                font-family: 'Nunito', sans-serif;
                color: #2C2C2C;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">

        <!-- Logo + Brand -->
        <div class="sidebar-logo">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="CPAMA Sandwich Logo" class="logo-img" />
            <div class="brand-name">CPAMA SANDWICH</div>
            <div class="manager-label">
                Manager: <span>{{ Auth::user()->name }}</span>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="nav-section-title">Main</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('manager.dashboard') }}">
                    <img src="{{ asset('images/dashboard_icon.png') }}" alt="Dashboard" />
                    Dashboard
                </a>
            </li>
        </ul>

        <!-- Catalog Navigation -->
        <div class="nav-section-title">Catalog</div>
        <ul class="sidebar-nav">
            <li>
                <a href="#">
                    <img src="{{ asset('images/manager_inventory_icon.png') }}" alt="Inventory" />
                    Inventory
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{ asset('images/products_icon.png') }}" alt="Products" />
                    Products
                </a>
            </li>
            <li>
                <a href="{{ route('manager.employees.index') }}">
                    <img src="{{ asset('images/employee_management_icon.png') }}" alt="Employee Management" />
                    Employee Management
                </a>
            </li>
            <li>
                <a href="{{ route('manager.reports') }}" class="active">
                    <img src="{{ asset('images/reports_icon.png') }}" alt="Reports" />
                    Reports
                </a>
            </li>
            <li>
                <a href="{{ route('manager.stockrequests.index') }}">
                    <img src="{{ asset('images/notif_icon.png') }}" alt="Stock Requests" />
                    Stock Requests
                </a>
            </li>
        </ul>

        <!-- Logout -->
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <img src="{{ asset('images/logout_icon.png') }}" alt="Logout" />
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <div class="page-header">
            <h1 class="page-title">Reports</h1>
            <button class="btn-download" onclick="downloadReport()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Download
            </button>
        </div>

        {{-- ══════════════════════════
             TAB NAV
        ══════════════════════════ --}}
        <div class="card px-4 pt-3 pb-0 mb-4" style="border-radius:12px;">
            <div style="display:flex;gap:0;border-bottom:2px solid #EDE5D8;justify-content:space-between;align-items:center;">
                <div style="display:flex;gap:0;">
                    <button class="tab-btn active" data-tab="daily">Daily Sales</button>
                    <button class="tab-btn" data-tab="top">Top Products</button>
                    <button class="tab-btn" data-tab="inventory">Inventory Status</button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════
             TAB: DAILY SALES
        ══════════════════════════ --}}
        <div id="tab-daily" class="tab-panel">

            {{-- Summary Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-sm-4">
                    <div class="card p-3" style="border-top:4px solid #27AE60;">
                        <div class="text-muted" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">Monthly Revenue</div>
                        <div style="font-size:12px;color:#27AE60;margin-top:2px;">↑ {{ $revenueChange ?? '0' }}% vs last month</div>
                        <div style="font-size:28px;font-weight:800;margin-top:4px;">₱{{ number_format($totalRevenue ?? 0, 2) }}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card p-3" style="border-top:4px solid #4A90D9;">
                        <div class="text-muted" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">Total Orders</div>
                        <div style="font-size:12px;color:#4A90D9;margin-top:2px;">↑ {{ $ordersChange ?? '0' }} from last month</div>
                        <div style="font-size:28px;font-weight:800;margin-top:4px;">{{ number_format($totalOrders ?? 0) }}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card p-3" style="border-top:4px solid #FF9F1C;">
                        <div class="text-muted" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">Avg Order Value</div>
                        <div style="font-size:12px;color:#FF9F1C;margin-top:2px;">↑ ₱{{ $avgChange ?? '0' }} this month</div>
                        <div style="font-size:28px;font-weight:800;margin-top:4px;">
                            ₱{{ ($totalOrders ?? 0) > 0 ? number_format(($totalRevenue ?? 0) / $totalOrders, 2) : '0.00' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Date Filters --}}
            <form method="GET" action="{{ route('manager.reports') }}" id="filterForm">
                <input type="hidden" name="tab" value="daily">
                <div class="card p-3 mb-4">
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                        <span style="font-size:12px;font-weight:700;text-transform:uppercase;color:#888;letter-spacing:1px;">Quick Filters</span>
                        <button type="button" class="filter-btn {{ $activeFilter === 'weekly'  ? 'active' : '' }}" onclick="setFilter('weekly',this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Weekly
                        </button>
                        <button type="button" class="filter-btn {{ $activeFilter === 'monthly' ? 'active' : '' }}" onclick="setFilter('monthly',this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Monthly
                        </button>
                        <button type="button" class="filter-btn {{ $activeFilter === '3months' ? 'active' : '' }}" onclick="setFilter('3months',this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            3 Months
                        </button>
                        <button type="button" class="filter-btn {{ $activeFilter === 'year'    ? 'active' : '' }}" onclick="setFilter('year',this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            This Year
                        </button>
                        <div style="margin-left:auto;display:flex;align-items:center;gap:8px;font-size:12px;font-weight:700;text-transform:uppercase;color:#888;letter-spacing:1px;">
                            Date Range
                            <input type="date" id="dateFrom" name="from" value="{{ $dateFrom }}" class="form-control form-control-sm" style="width:140px;font-size:12px;" onchange="document.getElementById('filterForm').submit()">
                            <span>To</span>
                            <input type="date" id="dateTo" name="to" value="{{ $dateTo }}" class="form-control form-control-sm" style="width:140px;font-size:12px;" onchange="document.getElementById('filterForm').submit()">
                        </div>
                    </div>
                </div>
            </form>

            {{-- Daily Sales Table --}}
            <div class="card p-4">
                <div style="font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#5C2D0E;margin-bottom:14px;">
                    Sales — {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th class="text-center">Orders</th>
                                <th class="text-end">Total Sales</th>
                                <th class="text-end">Avg Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($dailySales)
                                @forelse($dailySales as $day)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($day->sale_date)->format('M d, Y') }}</td>
                                        <td class="text-center fw-bold">{{ number_format($day->orders) }}</td>
                                        <td class="text-end fw-bold">₱{{ number_format($day->total_sales, 2) }}</td>
                                        <td class="text-end">₱{{ $day->orders > 0 ? number_format($day->total_sales / $day->orders, 2) : '0.00' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No sales data for this period.</td></tr>
                                @endforelse
                            @else
                                <tr><td colspan="4" class="text-center text-muted py-4">No sales data available.</td></tr>
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════
             TAB: TOP PRODUCTS
        ══════════════════════════ --}}
        <div id="tab-top" class="tab-panel" style="display:none;">
            <div class="card p-4">
                <div style="font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#5C2D0E;margin-bottom:20px;">
                    Top Selling Products — {{ strtoupper(now()->format('F Y')) }}
                </div>

                @if(!isset($topProducts) || $topProducts->isEmpty())
                    <p class="text-muted text-center py-4">No sales data for this month yet.</p>
                @else
                    @php
                        $chartColors = ['#FF9F1C', '#4A90D9', '#8B5CF6', '#27AE60', '#E74C3C', '#F39C12', '#1ABC9C'];
                        $grandTotal  = $topProducts->sum('total_revenue');
                    @endphp
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th class="text-end">QTY SOLD</th>
                                            <th class="text-end">REVENUE</th>
                                            <th class="text-center">% OF TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topProducts as $index => $product)
                                            @php
                                                $color   = $chartColors[$index % count($chartColors)];
                                                $percent = $grandTotal > 0 ? round(($product->total_revenue / $grandTotal) * 100) : 0;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span style="font-size:16px;margin-right:6px;">🥪</span>
                                                    {{ $product->name }}
                                                </td>
                                                <td class="text-end fw-bold">{{ number_format($product->total_qty) }}</td>
                                                <td class="text-end fw-bold">₱{{ number_format($product->total_revenue, 2) }}</td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill" style="background:{{ $color }}20;color:{{ $color }};font-size:12px;padding:4px 12px;">
                                                        • {{ $percent }}%
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center">
                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#888;margin-bottom:12px;">Revenue Share</div>
                            <canvas id="revenueChart" style="max-height:220px;"></canvas>
                            <div class="mt-3 d-flex flex-wrap justify-content-center gap-2">
                                @foreach($topProducts as $index => $product)
                                    @php $color = $chartColors[$index % count($chartColors)]; @endphp
                                    <span style="font-size:12px;display:flex;align-items:center;gap:5px;">
                                        <span style="width:10px;height:10px;border-radius:50%;background:{{ $color }};display:inline-block;"></span>
                                        {{ $product->name }} {{ $grandTotal > 0 ? round(($product->total_revenue / $grandTotal) * 100) : 0 }}%
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ══════════════════════════
             TAB: INVENTORY STATUS
        ══════════════════════════ --}}
        <div id="tab-inventory" class="tab-panel" style="display:none;">

            {{-- Summary Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <div class="card p-3" style="border-top:4px solid #27AE60;">
                        <div class="text-muted" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">Low Stock Items</div>
                        <div style="font-size:12px;color:#E74C3C;margin-top:2px;">Restock immediately</div>
                        <div style="font-size:28px;font-weight:800;margin-top:4px;">{{ $lowStockCount ?? 0 }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card p-3" style="border-top:4px solid #4A90D9;">
                        <div class="text-muted" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">Total Items Tracked</div>
                        <div style="font-size:12px;color:#4A90D9;margin-top:2px;">Across all products</div>
                        <div style="font-size:28px;font-weight:800;margin-top:4px;">{{ isset($inventoryItems) ? $inventoryItems->count() : 0 }}</div>
                    </div>
                </div>
            </div>

            {{-- Inventory Table --}}
            <div class="card p-4">
                <div style="font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#5C2D0E;margin-bottom:14px;">
                    Inventory Status Report
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ingredient</th>
                                <th class="text-center">Current Qty</th>
                                <th>Unit</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($inventoryItems)
                                @forelse($inventoryItems as $item)
                                    @php
                                        $statusColor = match($item->status) {
                                            'Low Stock'    => '#FF9F1C',
                                            'Out of Stock' => '#E74C3C',
                                            default        => '#27AE60',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $item->name ?? '—' }}</td>
                                        <td class="text-center fw-bold" style="color:{{ $item->status === 'Out of Stock' ? '#E74C3C' : '#27AE60' }};">
                                            {{ number_format($item->quantity ?? 0) }}
                                        </td>
                                        <td>{{ $item->unit ?? '—' }}</td>
                                        <td><span style="color:{{ $statusColor }};font-weight:700;">{{ $item->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No inventory data available.</td></tr>
                                @endforelse
                            @else
                                <tr><td colspan="4" class="text-center text-muted py-4">No inventory data available.</td></tr>
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Hidden Printable Report --}}
        <div id="printable-report">
            @php
                $printColors = ['#FF9F1C','#4A90D9','#8B5CF6','#27AE60','#E74C3C','#F39C12','#1ABC9C'];
                $printTotal  = isset($topProducts) ? $topProducts->sum('total_revenue') : 0;
            @endphp
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px;padding-bottom:16px;border-bottom:2px solid #5C2D0E;">
                <div>
                    <div style="font-size:22px;font-weight:800;color:#5C2D0E;">CPAMA SANDWICH</div>
                    <div style="font-size:13px;color:#888;margin-top:2px;">Sales & Revenue Report</div>
                </div>
                <div style="text-align:right;font-size:12px;color:#555;line-height:1.8;">
                    <div><strong>Downloaded by:</strong> {{ Auth::user()->name }}</div>
                    <div><strong>Date:</strong> {{ now()->format('F d, Y') }}</div>
                    <div><strong>Period:</strong> {{ now()->format('F Y') }}</div>
                </div>
            </div>
            <div style="display:flex;gap:24px;margin-bottom:28px;">
                <div style="flex:1;border:1.5px solid #EDE5D8;border-radius:10px;padding:16px 20px;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#888;">Total Revenue</div>
                    <div style="font-size:24px;font-weight:800;margin-top:4px;">₱{{ number_format($totalRevenue ?? 0, 2) }}</div>
                </div>
                <div style="flex:1;border:1.5px solid #EDE5D8;border-radius:10px;padding:16px 20px;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#888;">Total Orders</div>
                    <div style="font-size:24px;font-weight:800;margin-top:4px;">{{ number_format($totalOrders ?? 0) }}</div>
                </div>
                <div style="flex:1;border:1.5px solid #EDE5D8;border-radius:10px;padding:16px 20px;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#888;">Avg. Order Value</div>
                    <div style="font-size:24px;font-weight:800;margin-top:4px;">
                        ₱{{ ($totalOrders ?? 0) > 0 ? number_format(($totalRevenue ?? 0) / $totalOrders, 2) : '0.00' }}
                    </div>
                </div>
            </div>
            <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#5C2D0E;margin-bottom:10px;">
                Top Selling Products — {{ now()->format('F Y') }}
            </div>
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#F5E6C8;">
                        <th style="padding:10px 12px;text-align:left;font-weight:700;">#</th>
                        <th style="padding:10px 12px;text-align:left;font-weight:700;">Product</th>
                        <th style="padding:10px 12px;text-align:right;font-weight:700;">Qty Sold</th>
                        <th style="padding:10px 12px;text-align:right;font-weight:700;">Revenue</th>
                        <th style="padding:10px 12px;text-align:center;font-weight:700;">% of Total</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($topProducts)
                        @forelse($topProducts as $i => $product)
                            @php
                                $pct   = $printTotal > 0 ? round(($product->total_revenue / $printTotal) * 100) : 0;
                                $color = $printColors[$i % count($printColors)];
                            @endphp
                            <tr style="border-bottom:1px solid #EDE5D8;">
                                <td style="padding:9px 12px;color:#aaa;">{{ $i + 1 }}</td>
                                <td style="padding:9px 12px;font-weight:600;">{{ $product->name }}</td>
                                <td style="padding:9px 12px;text-align:right;font-weight:700;">{{ number_format($product->total_qty) }}</td>
                                <td style="padding:9px 12px;text-align:right;font-weight:700;">₱{{ number_format($product->total_revenue, 2) }}</td>
                                <td style="padding:9px 12px;text-align:center;">
                                    <span style="background:{{ $color }}22;color:{{ $color }};padding:2px 10px;border-radius:20px;font-weight:700;font-size:12px;">{{ $pct }}%</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="padding:20px;text-align:center;color:#aaa;">No data.</td></tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
            <div style="margin-top:40px;padding-top:12px;border-top:1px solid #EDE5D8;font-size:11px;color:#aaa;display:flex;justify-content:space-between;">
                <span>CPAMA Sandwich — Confidential</span>
                <span>Generated on {{ now()->format('F d, Y \a\t h:i A') }}</span>
            </div>
        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── Tab Switching ──
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
            this.classList.add('active');
            document.getElementById('tab-' + this.dataset.tab).style.display = 'block';
        });
    });

    // ── Quick Date Filters ──
    function setFilter(range, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const today = new Date();
        let from = new Date();
        if (range === 'weekly')   from.setDate(today.getDate() - 7);
        if (range === 'monthly')  from.setMonth(today.getMonth() - 1);
        if (range === '3months')  from.setMonth(today.getMonth() - 3);
        if (range === 'year')     from.setFullYear(today.getFullYear() - 1);
        document.getElementById('dateFrom').value = from.toISOString().split('T')[0];
        document.getElementById('dateTo').value   = today.toISOString().split('T')[0];

        // add the active filter name so the controller knows which button to highlight
        const form = document.getElementById('filterForm');
        let input = form.querySelector('input[name="filter"]');
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'filter';
            form.appendChild(input);
        }
        input.value = range;
        form.submit();
    }

    // ── Download (Print) ──
    function downloadReport() {
        window.print();
    }

    // ── Chart.js Doughnut ──
    @if(isset($topProducts) && $topProducts->isNotEmpty())
        @php
            $chartColors = ['#FF9F1C', '#4A90D9', '#8B5CF6', '#27AE60', '#E74C3C', '#F39C12', '#1ABC9C'];
            $grandTotal  = $topProducts->sum('total_revenue');
        @endphp
        new Chart(document.getElementById('revenueChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($topProducts->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($topProducts->map(fn($p) => $grandTotal > 0 ? round(($p->total_revenue / $grandTotal) * 100) : 0)) !!},
                    backgroundColor: {!! json_encode(array_slice($chartColors, 0, $topProducts->count())) !!},
                    borderColor: '#fff',
                    borderWidth: 5
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });
    @endif
</script>
</body>
</html>