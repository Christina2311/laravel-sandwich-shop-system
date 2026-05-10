<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CPAMA Sandwich – Business Overview</title>

    {{-- Bootstrap 5 CSS --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    {{-- Google Font: Nunito (clean, rounded — matches the UI tone) --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap"
        rel="stylesheet"
    />

    {{-- Chart.js --}}
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
            --card-icon-bg:    #F5E6C8;
            --card-border:     #EDE5D8;

            --accent-orange:   #F5A623;
            --accent-blue:     #4A90D9;
            --accent-green:    #27AE60;
            --accent-red:      #E74C3C;

            --text-dark:       #2C2C2C;
            --text-muted:      #888;
            --font:            'Nunito', sans-serif;
        }

        /* ─── Reset / Base ─────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: var(--font);
            background: var(--page-bg);
            color: var(--text-dark);
        }

        /* ─── Layout ────────────────────────────────────────────────── */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 36px 36px 60px;
        }

        /* Sidebar  */
        .sidebar {
            width: var(--sidebar-width);
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
            border-bottom: 1px solid var(--sidebar-border);
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
            letter-spacing: 0.5px;
            text-align: center;
        }

        .sidebar-logo .manager-label {
            font-size: 11px;
            color: var(--sidebar-muted);
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
            color: var(--sidebar-muted);
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
            color: var(--sidebar-text);
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
            background: var(--sidebar-hover);
        }

        .sidebar-nav li a.active {
            background: var(--sidebar-active);
            color: #FFFFFF;
        }

        .sidebar-nav li a.active img {
            opacity: 1;
        }

        /* Logout button */
        .sidebar-logout {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--sidebar-border);
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
            color: var(--sidebar-text);
            font-family: var(--font);
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

        /* ─── Page Header ───────────────────────────────────────────── */
        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 28px;
        }

        /* ─── Metric Cards ──────────────────────────────────────────── */
        .metric-card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: 16px;
            padding: 22px 26px;
            display: flex;
            align-items: flex-start;
            gap: 18px;
            transition: box-shadow 0.2s;
        }

        .metric-card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        }

        .metric-icon {
            width: 52px;
            height: 52px;
            background: var(--card-icon-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .metric-icon img {
            width: 26px;
            height: 26px;
            object-fit: contain;
            opacity: 0.75;
        }

        .metric-info .metric-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .metric-info .metric-sub {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .metric-info .metric-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
        }

        .text-warning-label { color: var(--accent-orange); }
        .text-danger-label  { color: var(--accent-red); }

        /* ─── Panel Cards (chart / staff) ───────────────────────────── */
        .panel-card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: 16px;
            padding: 26px;
        }

        .panel-title {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        /* ─── Weekly Revenue Chart ──────────────────────────────────── */
        .chart-wrapper {
            position: relative;
            height: 210px;
        }

        .chart-legend {
            font-size: 11px;
            color: var(--text-muted);
            text-align: center;
            margin-top: 10px;
        }

        /* ─── Staff Performance ──────────────────────────────────────── */
        .staff-row {
            margin-bottom: 18px;
        }

        .staff-row:last-child {
            margin-bottom: 0;
        }

        .staff-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .staff-name {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .staff-count {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
        }

        .staff-bar {
            height: 10px;
            border-radius: 999px;
            background: #EDEAE5;
            overflow: hidden;
        }

        .staff-bar-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 0.8s ease;
        }

        /* ─── Responsive tweaks ─────────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            .wrapper {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">

    {{-- ═══════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════ --}}
    <aside class="sidebar">

        {{-- Logo + Brand --}}
        <div class="sidebar-logo">
            <img
                src="{{ asset('images/sandwich_logo.png') }}"
                alt="CPAMA Sandwich Logo"
                class="logo-img"
            />
            <div class="brand-name">CPAMA SANDWICH</div>
            <div class="manager-label">
                Manager: <span>{{ Auth::user()->name }}</span>
            </div>
        </div>

        {{-- Main Navigation --}}
        <div class="nav-section-title">Main</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('manager.dashboard') }}" class="active">
                    <img src="{{ asset('images/dashboard_icon.png') }}" alt="Dashboard" />
                    Dashboard
                </a>
            </li>
        </ul>

        {{-- Catalog Navigation --}}
        <div class="nav-section-title">Catalog</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('manager.inventory') }}">
                    <img src="{{ asset('images/manager_inventory_icon.png') }}" alt="Inventory" />
                    Inventory
                </a>
            </li>
            <li>
                <a href="{{ route('manager.products') }}">
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
                <a href="{{ route('manager.reports') }}">
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

        {{-- Logout --}}
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

    {{-- ═══════════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════════ --}}
    <main class="main-content">

        <h1 class="page-title">Business Overview</h1>

        {{-- ── Row 1: 4 Metric Cards ─────────────────────────── --}}
        <div class="row g-3 mb-4">

            {{-- Monthly Revenue --}}
            <div class="col-12 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon">
                        <img src="{{ asset('images/reports_icon.png') }}" alt="Revenue" />
                    </div>
                    <div class="metric-info">
                        <div class="metric-label">Monthly Revenue</div>
                        <div class="metric-value">
                            ₱{{ number_format($monthlyRevenue, 0) }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Orders --}}
            <div class="col-12 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon">
                        <img src="{{ asset('images/baker_queue_icon.png') }}" alt="Orders" />
                    </div>
                    <div class="metric-info">
                        <div class="metric-label">Pending Orders</div>
                        <div class="metric-sub text-warning-label">Needs attention</div>
                        <div class="metric-value">{{ $pendingOrders }}</div>
                    </div>
                </div>
            </div>

            {{-- Low Stock Items --}}
            <div class="col-12 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon">
                        <img src="{{ asset('images/employee_inventory_icon.png') }}" alt="Stock" />
                    </div>
                    <div class="metric-info">
                        <div class="metric-label">Low Stock Items</div>
                        <div class="metric-sub text-danger-label">Restock required</div>
                        <div class="metric-value">{{ $lowStockItems }}</div>
                    </div>
                </div>
            </div>

            {{-- Active Staff --}}
            <div class="col-12 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon">
                        <img src="{{ asset('images/seller_baker_icon.png') }}" alt="Staff" />
                    </div>
                    <div class="metric-info">
                        <div class="metric-label">Active Staff</div>
                        <div class="metric-value">{{ $activeStaff }}</div>
                    </div>
                </div>
            </div>

        </div>{{-- /row 1 --}}

        {{-- ── Row 2: Weekly Revenue + Staff Performance ──────── --}}
        <div class="row g-3">

            {{-- Weekly Revenue Chart --}}
            <div class="col-12 col-lg-7">
                <div class="panel-card h-100">
                    <div class="panel-title">
                        Weekly Revenue — {{ now()->format('F Y') }}
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="weeklyRevenueChart"></canvas>
                    </div>
                    <div class="chart-legend mt-2">
                        Dashed = current week (in progress)
                    </div>
                </div>
            </div>

            {{-- Staff Performance --}}
            <div class="col-12 col-lg-5">
                <div class="panel-card h-100">
                    <div class="panel-title">Staff Performance Today</div>

                    @php
                        $barColors = [
                            '#F5A623', // orange
                            '#F5A623', // orange
                            '#4A90D9', // blue
                            '#27AE60', // green
                            '#E74C3C', // red (fallback for 5th+)
                        ];

                        // Compute max for relative bar widths
                        $maxPerf = $staffPerformance->max(function($s) {
                            return $s->role === 'baker' ? $s->total_baked : $s->total_orders;
                        }) ?: 1;
                    @endphp

                    @forelse ($staffPerformance as $index => $staff)
                        @php
                            $isBaker   = strtolower($staff->role) === 'baker';
                            $count     = $isBaker ? $staff->total_baked : $staff->total_orders;
                            $label     = $isBaker
                                ? $count . ' baked'
                                : $count . ' orders';
                            $roleLabel = ucfirst($staff->role);
                            $pct       = round(($count / $maxPerf) * 100);
                            $color     = $barColors[$index] ?? '#888';
                        @endphp

                        <div class="staff-row">
                            <div class="staff-header">
                                <span class="staff-name">
                                    {{ $staff->name }}
                                    <span style="color:var(--text-muted);font-weight:600;">
                                        ({{ $roleLabel }})
                                    </span>
                                </span>
                                <span class="staff-count">{{ $label }}</span>
                            </div>
                            <div class="staff-bar">
                                <div
                                    class="staff-bar-fill"
                                    style="width: {{ $pct }}%; background: {{ $color }};"
                                ></div>
                            </div>
                        </div>

                    @empty
                        <p class="text-muted" style="font-size:13px;">No staff activity today.</p>
                    @endforelse

                </div>
            </div>

        </div>{{-- /row 2 --}}

    </main>{{-- /main-content --}}

</div>{{-- /wrapper --}}


{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Chart.js: Weekly Revenue Bar Chart --}}
<script>
(function () {
    // Data injected from the controller
    const weeklyLabels = @json($weeklyLabels);   // e.g. ["Apr 1–7","Apr 8–14","Apr 15–21","Apr 22–28"]
    const weeklyValues = @json($weeklyValues);   // e.g. [58000, 72000, 88000, 66000]
    const isCurrentWeek = @json($isCurrentWeek); // e.g. [false, false, false, true]

    // Build per-bar colors & border styles
    const bgColors      = weeklyValues.map((_, i) =>
        isCurrentWeek[i]
            ? 'rgba(245,166,35,0.35)'
            : 'rgba(245,166,35,0.88)'
    );
    const borderColors  = weeklyValues.map(() => '#F5A623');
    const borderWidths  = weeklyValues.map(() => 2);
    const borderDash    = isCurrentWeek; // handled via plugin below

    const ctx = document.getElementById('weeklyRevenueChart').getContext('2d');

    // Custom plugin: dashed border on current-week bars
    const dashedBarPlugin = {
        id: 'dashedBar',
        beforeDatasetsDraw(chart) {
            const { ctx, data, chartArea } = chart;
            const meta = chart.getDatasetMeta(0);

            meta.data.forEach((bar, i) => {
                if (!isCurrentWeek[i]) return;

                const { x, y, width, height, base } = bar.getProps(
                    ['x', 'y', 'width', 'height', 'base'], true
                );

                ctx.save();
                ctx.clearRect(
                    x - width / 2, y,
                    width, base - y
                );

                ctx.setLineDash([6, 4]);
                ctx.strokeStyle = '#F5A623';
                ctx.lineWidth   = 2;
                ctx.fillStyle   = 'rgba(245,166,35,0.30)';

                ctx.beginPath();
                ctx.rect(x - width / 2, y, width, base - y);
                ctx.fill();
                ctx.stroke();

                ctx.restore();
            });
        }
    };

    new Chart(ctx, {
        type: 'bar',
        plugins: [dashedBarPlugin],
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Revenue',
                data: weeklyValues,
                backgroundColor: bgColors,
                borderColor: borderColors,
                borderWidth: borderWidths,
                borderRadius: 6,
                borderSkipped: 'bottom',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx =>
                            ' ₱' + ctx.parsed.y.toLocaleString()
                    }
                },
                // Show value labels on top of bars
                datalabels: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: "'Nunito', sans-serif", size: 11 },
                        color: '#888'
                    }
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    border: { dash: [4, 4] },
                    ticks: {
                        font: { family: "'Nunito', sans-serif", size: 11 },
                        color: '#888',
                        callback: v => '₱' + (v >= 1000 ? (v/1000)+'K' : v)
                    },
                    beginAtZero: true
                }
            }
        }
    });

    // Animate staff bars on load
    document.querySelectorAll('.staff-bar-fill').forEach(el => {
        const target = el.style.width;
        el.style.width = '0%';
        setTimeout(() => { el.style.width = target; }, 200);
    });
})();
</script>

</body>
</html>