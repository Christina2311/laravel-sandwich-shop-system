<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Dashboard – Sandwich Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg:      #5a2d0c;
            --sidebar-hover:   #7a3e1a;
            --sidebar-active:  #3d1c06;
            --sidebar-text:    #f5e6d3;
            --sidebar-muted:   #c4a07a;
            --brand-brown:     #5a2d0c;
            --brand-green:     #2e7d32;
            --brand-green-h:   #1b5e20;
            --btn-cancel-bg:   #f5f0e8;
            --btn-cancel-txt:  #5a2d0c;
            --card-radius:     14px;
            --input-radius:    8px;
            --font-main:       'Segoe UI', system-ui, sans-serif;

            /* ── Missing variables fixed ── */
            --white:           #ffffff;
            --cream:           #faf3e0;
            --cream-dark:      #e8dcc8;
            --brown:           #5a2d0c;
            --amber-dark:      #b07010;
            --text-dark:       #2c1a0e;
            --text-mid:        #5a4030;
            --text-light:      #9a7a5a;
        }

        /* ── Layout ───────────────────────────────────────────────────── */
        html, body { height: 100%; margin: 0; font-family: var(--font-main); background: #f7f3ee; }

        .wrapper { display: flex; min-height: 100vh; }

        /* ── Sidebar ──────────────────────────────────────────────────── */
        .sidebar {
            width: 200px;
            min-width: 200px;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            padding: 0;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 22px 16px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand img {
            width: 300px;
            height: 160px;
            border-radius: 0;
            padding: 0;
        }

        .sidebar-brand .brand-name {
            color: #fff;
            font-weight: 700;
            font-size: 0.82rem;
            text-align: center;
            margin-top: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-brand .cashier-name {
            color: var(--sidebar-muted);
            font-size: 0.73rem;
            text-align: center;
            margin-top: 2px;
        }

        .sidebar-nav { flex: 1; padding: 14px 10px; }

        .sidebar-section-label {
            color: var(--sidebar-muted);
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 8px 4px;
            font-weight: 600;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--sidebar-text);
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.83rem;
            margin-bottom: 2px;
            transition: background 0.15s;
        }

        .sidebar-nav a:hover   { background: var(--sidebar-hover); }
        .sidebar-nav a.active  { background: var(--sidebar-active); font-weight: 600; }
        .sidebar-nav a i       { font-size: 1rem; flex-shrink: 0; }

        .sidebar-footer {
            padding: 14px 10px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-footer form button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 9px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: var(--sidebar-text);
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.83rem;
            cursor: pointer;
            transition: background 0.15s;
        }

        .sidebar-footer form button:hover { background: var(--sidebar-hover); }

        /* ══════════════════════════════
           MAIN
        ══════════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 2rem;
            min-height: 100vh;
        }

        .page-title {
            font-family: 'Bebas Neue', cursive;
            font-size: 2rem;
            letter-spacing: 3px;
            color: var(--brown);
            margin-bottom: 1.5rem;
            animation: fadeDown .4s ease both;
        }

        /* ── Stat cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.25rem;
            animation: fadeUp .45s ease both;
        }

        .stat-card {
            background: var(--white);
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            border: 1.5px solid var(--cream-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(244,166,54,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon-wrap img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .stat-icon-wrap.amber { background: rgba(244,166,54,.15); }
        .stat-icon-wrap.brown { background: rgba(92,51,23,.1); }
        .stat-icon-wrap.green { background: rgba(40,160,80,.1); }
        .stat-icon-wrap.red   { background: rgba(200,50,50,.1); }

        .stat-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .stat-label {
            font-size: .8rem;
            font-weight: 800;
            color: var(--text-light);
            margin-bottom: .2rem;
            text-align: right;
        }

        .stat-value {
            font-family: 'Bebas Neue', cursive;
            font-size: 1.9rem;
            letter-spacing: 1px;
            color: var(--text-dark);
            line-height: 1;
            text-align: right;
        }

        .stat-value .peso { color: var(--amber-dark); font-size: 1.4rem; }

        /* ── Bottom panels ── */
        .panels-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 1rem;
            animation: fadeUp .5s ease both;
            animation-delay: .1s;
        }

        .panel {
            background: var(--white);
            border-radius: 14px;
            border: 1.5px solid var(--cream-dark);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem .75rem;
            border-bottom: 1.5px solid var(--cream-dark);
            flex-shrink: 0;
        }

        .panel-header h2 {
            font-family: 'Bebas Neue', cursive;
            font-size: 1.25rem;
            letter-spacing: 2px;
            color: var(--brown);
        }

        /* ── Orders table ── */
        .table-wrap { flex: 1; overflow-x: auto; }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table thead th {
            padding: .55rem 1rem;
            font-size: .65rem;
            font-weight: 900;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--text-light);
            background: var(--cream);
            border-bottom: 1.5px solid var(--cream-dark);
            white-space: nowrap;
        }

        .orders-table tbody td {
            padding: .65rem 1rem;
            font-size: .83rem;
            font-weight: 600;
            color: var(--text-mid);
            border-bottom: 1px solid var(--cream-dark);
        }

        .orders-table tbody tr:last-child td { border-bottom: none; }

        .orders-table tbody tr.empty-row td { height: 38px; }

        .status-pill {
            display: inline-block;
            padding: .18rem .6rem;
            border-radius: 20px;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .status-pending { background: rgba(244,166,54,.15); color: #b07010; }
        .status-done    { background: rgba(40,160,80,.12);  color: #1a7a30; }
        .status-prep    { background: rgba(60,100,220,.1);  color: #2a50b0; }

        /* ── Pagination ── */
        .pagination-wrap {
            padding: .65rem 1rem;
            border-top: 1.5px solid var(--cream-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            background: var(--white);
        }

        .pagination-info {
            font-size: .72rem;
            font-weight: 700;
            color: var(--text-light);
        }

        .pagination-btns {
            display: flex;
            gap: .3rem;
        }

        .page-btn {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1.5px solid var(--cream-dark);
            background: var(--white);
            color: var(--text-mid);
            font-size: .78rem;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s, border-color .15s, color .15s;
        }

        .page-btn:hover { background: var(--cream-dark); }

        .page-btn.active {
            background: var(--brown);
            border-color: var(--brown);
            color: #fff;
        }

        .page-btn:disabled {
            opacity: .35;
            cursor: not-allowed;
        }

        /* ── Top products ── */
        .product-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .75rem 1.25rem;
            border-bottom: 1px solid var(--cream-dark);
            transition: background .15s;
        }

        .product-item:last-child { border-bottom: none; }

        .product-name {
            font-size: .88rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .product-count {
            font-family: 'Bebas Neue', cursive;
            font-size: 1.05rem;
            color: var(--brown);
            letter-spacing: 1px;
        }

        .product-unit {
            font-size: .65rem;
            font-weight: 800;
            color: var(--text-light);
            margin-left: .15rem;
        }

        /* ── Date cell ── */
        .date-ordered, .date-completed {
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-mid);
            line-height: 1.5;
        }

        .date-label {
            font-size: .63rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-right: 2px;
        }

        .date-ordered .date-label  { color: var(--text-light); }
        .date-completed .date-label { color: #1a7a30; }

        /* ── Animations ── */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .panels-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; padding: 1.25rem 1rem; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- ══════════════ SIDEBAR ══════════════ --}}
    <aside class="sidebar">

        <div class="sidebar-brand">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="Logo">
            <span class="brand-name">CPAMA SANDWICH</span>
            <span class="cashier-name">Seller: {{ auth()->user()->name }}</span>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Main</div>
            <a href="{{ route('seller.dashboard') }}" class="active">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a href="{{ route('seller.neworder.index') }}">
                <i class="bi bi-bag-plus-fill"></i> New Orders
            </a>

            @if(auth()->user()->hasRole('baker'))
                <div class="sidebar-section-label" style="margin-top:10px;">Switch Role</div>
                <a href="{{ route('baker.queue') }}">
                    <i class="bi bi-people-fill"></i> Go to Baker
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ══════════════ MAIN ══════════════ --}}
    <main class="main">

        <div class="page-title">Dashboard</div>

        {{-- Stat Cards --}}
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon-wrap amber">
                    <i class="bi bi-cart-fill" style="font-size:1.4rem;color:#c47e1a;"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Today's Order</div>
                    <div class="stat-value">{{ $todayOrderCount ?? 0 }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrap brown">
                    <i class="bi bi-people" style="font-size:1.4rem;color:#8b4513;"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Customers</div>
                    <div class="stat-value">{{ $totalCustomers ?? 0 }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrap red">
                    <i class="bi bi-box-seam" style="font-size:1.4rem;color:#dc3545;"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Low Stock Items</div>
                    <div class="stat-value">{{ $lowStockCount ?? 0 }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrap green">
                    <span style="font-family:'Bebas Neue',cursive;font-size:1.6rem;color:#1a8a30;line-height:1;">₱</span>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Revenue Today</div>
                    <div class="stat-value"><span class="peso">₱</span>{{ number_format($totalRevenue ?? 0, 2) }}</div>
                </div>
            </div>

        </div>

        {{-- Bottom Panels --}}
        <div class="panels-grid">

            {{-- Recent Orders with Pagination --}}
            <div class="panel">
                <div class="panel-header">
                    <h2>Recent Orders</h2>
                </div>

                <div class="table-wrap">
                    <table class="orders-table" id="ordersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="ordersBody">
                            {{-- Rows injected by JS --}}
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrap">
                    <span class="pagination-info" id="pageInfo">Showing 0 orders</span>
                    <div class="pagination-btns" id="pageBtns"></div>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="panel">
                <div class="panel-header">
                    <h2>Top Products Today</h2>
                </div>

                @php
                    $products = $topProducts ?? collect([
                        (object)['name' => 'Tuna Sandwich',     'total_sold' => 0],
                        (object)['name' => 'Egg Sandwich',      'total_sold' => 0],
                        (object)['name' => 'Tuna Egg Sandwich', 'total_sold' => 0],
                    ]);
                @endphp

                @foreach($products as $product)
                <div class="product-item">
                    <span class="product-name">
                        {{ is_array($product) ? $product['name'] : $product->name }}
                    </span>
                    <div>
                        <span class="product-count">
                            {{ is_array($product) ? ($product['total_sold'] ?? 0) : ($product->total_sold ?? 0) }}
                        </span>
                        <span class="product-unit">pcs</span>
                    </div>
                </div>
                @endforeach

            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ── Orders pagination ──────────────────────────────────────────
        // Pass orders from Laravel into JS
        const allOrders = @json($recentOrders ?? []);

        const PER_PAGE  = 7;
        let currentPage = 1;

        function totalPages() {
            return Math.max(1, Math.ceil(allOrders.length / PER_PAGE));
        }

        function renderTable() {
            const tbody = document.getElementById('ordersBody');
            const start = (currentPage - 1) * PER_PAGE;
            const slice = allOrders.slice(start, start + PER_PAGE);

            if (allOrders.length === 0) {
                // Show empty placeholder rows
                let html = '';
                for (let i = 0; i < PER_PAGE; i++) {
                    html += '<tr class="empty-row"><td colspan="5"></td></tr>';
                }
                tbody.innerHTML = html;
                document.getElementById('pageInfo').textContent = 'No orders yet today';
                return;
            }

            const fmt = d => d ? new Date(d).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) : '—';

            let html = '';
            slice.forEach(order => {
                const statusClass = 'status-' + (order.status || 'pending').toLowerCase();
                const isCompleted = (order.status || '').toLowerCase() === 'completed';
                const orderedDate = fmt(order.created_at);
                const completedDate = isCompleted ? fmt(order.updated_at) : null;

                const dateCell = completedDate
                    ? `<div class="date-ordered"><span class="date-label">Ordered</span> ${orderedDate}</div><div class="date-completed"><span class="date-label">Completed</span> ${completedDate}</div>`
                    : `<div class="date-ordered"><span class="date-label">Ordered</span> ${orderedDate}</div>`;

                html += `
                    <tr>
                        <td>#${order.id}</td>
                        <td>${order.customer_name ?? '—'}</td>
                        <td><span class="status-pill ${statusClass}">${order.status ?? 'Pending'}</span></td>
                        <td>₱${parseFloat(order.total_amount ?? 0).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                        <td>${dateCell}</td>
                    </tr>`;
            });

            // Pad with empty rows so height stays consistent
            for (let i = slice.length; i < PER_PAGE; i++) {
                html += '<tr class="empty-row"><td colspan="5"></td></tr>';
            }

            tbody.innerHTML = html;

            const from = start + 1;
            const to   = Math.min(start + slice.length, allOrders.length);
            document.getElementById('pageInfo').textContent =
                `Showing ${from}–${to} of ${allOrders.length} orders`;
        }

        function renderPagination() {
            const total  = totalPages();
            const btns   = document.getElementById('pageBtns');
            let html = '';

            // Prev
            html += `<button class="page-btn" onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                        <i class="bi bi-chevron-left"></i>
                     </button>`;

            // Page numbers
            for (let p = 1; p <= total; p++) {
                html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
            }

            // Next
            html += `<button class="page-btn" onclick="goPage(${currentPage + 1})" ${currentPage === total ? 'disabled' : ''}>
                        <i class="bi bi-chevron-right"></i>
                     </button>`;

            btns.innerHTML = html;
        }

        function goPage(p) {
            const total = totalPages();
            if (p < 1 || p > total) return;
            currentPage = p;
            renderTable();
            renderPagination();
        }

        // Init
        renderTable();
        renderPagination();
    </script>
</body>
</html>