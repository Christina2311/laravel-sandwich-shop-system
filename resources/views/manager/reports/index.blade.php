
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

        /* Sidebar - Exact same as dashboard */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            padding: 24px 14px 20px;
            z-index: 100;
        }

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
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.2);
        }

        .sidebar-logo .brand-name {
            font-size: 13px;
            font-weight: 800;
            color: #FFFFFF;
        }

        .sidebar-logo .manager-label {
            font-size: 11px;
            color: var(--sidebar-muted);
        }

        .nav-section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--sidebar-muted);
            padding: 6px 8px 4px;
            margin-top: 6px;
        }

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
        }

        .sidebar-nav li a:hover,
        .sidebar-nav li a.active {
            background: var(--sidebar-active);
            color: #FFFFFF;
        }

        .sidebar-nav li a img {
            width: 18px;
            height: 18px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .btn-logout {
            width: 100%;
            padding: 9px 12px;
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.25);
            border-radius: 8px;
            color: var(--sidebar-text);
            font-size: 13px;
            font-weight: 600;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 28px;
        }

        .card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: 16px;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="CPAMA Sandwich" class="logo-img" />
            <div class="brand-name">CPAMA SANDWICH</div>
            <div class="manager-label">
                Manager: <span>{{ Auth::user()->name }}</span>
            </div>
        </div>

        <div class="nav-section-title">Main</div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('manager.dashboard') }}"><img src="{{ asset('images/dashboard_icon.png') }}" alt=""> Dashboard</a></li>
        </ul>

        <div class="nav-section-title">Catalog</div>
        <ul class="sidebar-nav">
            <li><a href="#"><img src="{{ asset('images/manager_inventory_icon.png') }}" alt=""> Inventory</a></li>
            <li><a href="#"><img src="{{ asset('images/products_icon.png') }}" alt=""> Products</a></li>
            <li><a href="{{ route('manager.employees.index') }}"><img src="{{ asset('images/employee_management_icon.png') }}" alt=""> Employee Management</a></li>
            <li><a href="{{ route('manager.reports') }}" class="active"><img src="{{ asset('images/reports_icon.png') }}" alt=""> Reports</a></li>
        </ul>

        <div class="mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <img src="{{ asset('images/logout_icon.png') }}" alt=""> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <h1 class="page-title">Reports</h1>

        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold">TOP SELLING PRODUCTS — APRIL 2026</h5>
                <button class="btn btn-dark d-flex align-items-center gap-2">
                    <i class="fas fa-download"></i> Download
                </button>
            </div>

            <div class="row">
                <div class="col-lg-7">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>PRODUCT</th>
                                    <th class="text-end">QTY SOLD</th>
                                    <th class="text-end">REVENUE</th>
                                    <th class="text-center">% OF TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span style="font-size:1.7rem">🥪</span> Tuna Sandwich</td>
                                    <td class="text-end fw-bold">840</td>
                                    <td class="text-end fw-bold">₱46,200</td>
                                    <td class="text-center"><span class="badge rounded-pill" style="background:#FF9F1C20;color:#FF9F1C">45%</span></td>
                                </tr>
                                <tr>
                                    <td><span style="font-size:1.7rem">🥚</span> Egg Sandwich</td>
                                    <td class="text-end fw-bold">620</td>
                                    <td class="text-end fw-bold">₱27,900</td>
                                    <td class="text-center"><span class="badge rounded-pill" style="background:#4A90D920;color:#4A90D9">33%</span></td>
                                </tr>
                                <tr>
                                    <td><span style="font-size:1.7rem">🍳</span> Tuna Egg Sandwich</td>
                                    <td class="text-end fw-bold">360</td>
                                    <td class="text-end fw-bold">₱23,400</td>
                                    <td class="text-center"><span class="badge rounded-pill" style="background:#8B5CF620;color:#8B5CF6">22%</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-5 text-center">
                    <h6 class="text-muted mb-3">REVENUE SHARE</h6>
                    <canvas id="revenueChart" style="max-height: 260px;"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    new Chart(document.getElementById('revenueChart'), {
        type: 'doughnut',
        data: {
            labels: ['Tuna Sandwich', 'Egg Sandwich', 'Tuna Egg Sandwich'],
            datasets: [{
                data: [45, 33, 22],
                backgroundColor: ['#FF9F1C', '#4A90D9', '#8B5CF6'],
                borderColor: '#fff',
                borderWidth: 5
            }]
        },
        options: { cutout: '70%', plugins: { legend: { display: false } } }
    });
</script>
</body>
</html>