<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CPAMA Sandwich – Stock Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --sidebar-bg:     #5C2D0E;
            --sidebar-hover:  #7A3D18;
            --sidebar-active: #7A3D18;
            --sidebar-text:   #F5E6D3;
            --sidebar-muted:  #C9A882;
            --sidebar-border: rgba(255,255,255,0.12);
            --sidebar-width:  220px;
            --page-bg:        #F7F3EE;
            --card-bg:        #FFFFFF;
            --card-border:    #EDE5D8;
            --accent-orange:  #F5A623;
            --text-dark:      #2C2C2C;
            --text-muted:     #888;
            --font:           'Nunito', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; font-family: var(--font); background: var(--page-bg); color: var(--text-dark); }

        .wrapper { display: flex; min-height: 100vh; }
        .main-content { margin-left: var(--sidebar-width); flex: 1; padding: 36px 36px 60px; }

        /* ─── Sidebar ────────── */
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

        .manager-label span { color: #FFFFFF; font-weight: 700; }

        .nav-section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--sidebar-muted);
            padding: 6px 8px 4px;
            margin-top: 6px;
        }

        .sidebar-nav { list-style: none; padding: 0; margin: 0 0 6px; }

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
            width: 18px; height: 18px;
            object-fit: contain;
            opacity: 0.85;
            filter: brightness(0) invert(1);
        }

        .sidebar-nav li a:hover  { background: var(--sidebar-hover); }
        .sidebar-nav li a.active { background: var(--sidebar-active); color: #FFFFFF; }
        .sidebar-nav li a.active img { opacity: 1; }

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
            width: 16px; height: 16px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            opacity: 0.85;
        }

        .btn-logout:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.45);
            color: #FFFFFF;
        }

        /* Notification badge */
        .badge-count {
            background: #E74C3C; color: #fff; font-size: 10px; font-weight: 700;
            border-radius: 999px; padding: 1px 6px; margin-left: auto;
        }

        /* Page */
        .page-title { font-size: 26px; font-weight: 800; color: var(--text-dark); margin-bottom: 8px; }
        .page-sub   { font-size: 13px; color: var(--text-muted); margin-bottom: 28px; }

        /* Cards */
        .panel-card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .panel-title { font-size: 15px; font-weight: 800; color: var(--text-dark); margin-bottom: 18px; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th {
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
            color: var(--text-muted); padding: 10px 14px; border-bottom: 2px solid var(--card-border);
        }
        td { padding: 12px 14px; border-bottom: 1px solid #F0EAE0; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }

        /* Status badges */
        .status-badge {
            display: inline-block; font-size: 11px; font-weight: 700;
            border-radius: 999px; padding: 3px 10px;
        }
        .status-pending  { background: #FFF3CD; color: #856404; }
        .status-approved { background: #D1FAE5; color: #065F46; }
        .status-rejected { background: #FEE2E2; color: #991B1B; }

        /* Buttons */
        .btn-approve {
            background: #27AE60; color: #fff; border: none; border-radius: 8px;
            padding: 6px 14px; font-family: var(--font); font-size: 12px;
            font-weight: 700; cursor: pointer; transition: background 0.18s;
        }
        .btn-approve:hover { background: #1E8449; }

        .btn-reject {
            background: #E74C3C; color: #fff; border: none; border-radius: 8px;
            padding: 6px 14px; font-family: var(--font); font-size: 12px;
            font-weight: 700; cursor: pointer; transition: background 0.18s;
        }
        .btn-reject:hover { background: #C0392B; }

        /* Empty state */
        .empty-state {
            text-align: center; padding: 48px 24px;
            color: var(--text-muted); font-size: 13px;
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="Logo" class="logo-img">
            <div class="brand-name">CPAMA SANDWICH</div>
            <div class="manager-label">Manager: <span>{{ auth()->user()->name }}</span></div>
        </div>

        <div class="nav-section-title">Main</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('manager.dashboard') }}">
                    <img src="{{ asset('images/dashboard_icon.png') }}" alt="Dashboard" />
                    Dashboard
                </a>
            </li>
        </ul>

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
                <a href="{{ route('manager.stockrequests.index') }}" class="active">
                    <img src="{{ asset('images/notif_icon.png') }}" alt="Stock Requests" />
                    Stock Requests
                    @if($pendingRequests->count() > 0)
                        <span class="badge-count">{{ $pendingRequests->count() }}</span>
                    @endif
                </a>
            </li>
        </ul>

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

    {{-- Main Content --}}
    <main class="main-content">
        <div class="page-title">Stock Requests</div>
        <div class="page-sub">Review and approve stock-in requests submitted by bakers.</div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif

        {{-- Pending Requests --}}
        <div class="panel-card">
            <div class="panel-title">
                Pending Requests
                @if($pendingRequests->count() > 0)
                    <span class="badge-count ms-2">{{ $pendingRequests->count() }}</span>
                @endif
            </div>

            @if($pendingRequests->isEmpty())
                <div class="empty-state">No pending stock requests. All caught up!</div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Baker</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $req)
                        <tr>
                            <td>#{{ $req->id }}</td>
                            <td>{{ $req->employee?->employee_fn }} {{ $req->employee?->employee_ln }}</td>
                            <td>{{ $req->product?->name }}</td>
                            <td><strong>{{ $req->quantity }}</strong></td>
                            <td>{{ $req->supplier ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($req->date)->format('M d, Y') }}</td>
                            <td>{{ $req->note ?? '—' }}</td>
                            <td>{{ $req->created_at->diffForHumans() }}</td>
                            <td>
                                {{-- Approve --}}
                                <button class="btn-approve"
                                        onclick="openApproveModal({{ $req->id }})">
                                    ✓ Approve
                                </button>
                                {{-- Reject --}}
                                <button class="btn-reject ms-1"
                                        onclick="openRejectModal({{ $req->id }})">
                                    ✗ Reject
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- History --}}
        <div class="panel-card">
            <div class="panel-title">Recent History (last 50)</div>

            @if($historyRequests->isEmpty())
                <div class="empty-state">No history yet.</div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Baker</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Manager Note</th>
                            <th>Processed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historyRequests as $req)
                        <tr>
                            <td>#{{ $req->id }}</td>
                            <td>{{ $req->employee?->employee_fn }} {{ $req->employee?->employee_ln }}</td>
                            <td>{{ $req->product?->name }}</td>
                            <td>{{ $req->quantity }}</td>
                            <td>
                                <span class="status-badge status-{{ $req->status }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td>{{ $req->manager_note ?? '—' }}</td>
                            <td>{{ $req->updated_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </main>

</div>{{-- /.wrapper --}}

{{-- Approve Modal --}}
<div id="approveModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45);
     z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:32px; width:440px; max-width:90%;">
        <h5 style="font-weight:800; margin-bottom:8px;">Approve Stock Request</h5>
        <p style="font-size:13px; color:#666; margin-bottom:16px;">
            This will add the requested quantity to the inventory immediately.
        </p>
        <form id="approveForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:700; display:block; margin-bottom:6px;">
                    Note (optional)
                </label>
                <textarea name="manager_note" rows="3"
                    style="width:100%; border:1.5px solid #EDE5D8; border-radius:8px;
                           padding:10px; font-family:'Nunito',sans-serif; font-size:13px;"
                    placeholder="e.g. Approved for weekly restock..."></textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeApproveModal()"
                    style="padding:8px 18px; border-radius:8px; border:1.5px solid #EDE5D8;
                           background:#fff; font-family:'Nunito',sans-serif; font-weight:700;
                           font-size:13px; cursor:pointer;">
                    Cancel
                </button>
                <button type="submit" class="btn-approve">Confirm Approve</button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45);
     z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:32px; width:440px; max-width:90%;">
        <h5 style="font-weight:800; margin-bottom:16px;">Reject Stock Request</h5>
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:700; display:block; margin-bottom:6px;">
                    Reason (optional)
                </label>
                <textarea name="manager_note" rows="3"
                    style="width:100%; border:1.5px solid #EDE5D8; border-radius:8px;
                           padding:10px; font-family:'Nunito',sans-serif; font-size:13px;"
                    placeholder="e.g. Over-budget, incorrect product..."></textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeRejectModal()"
                    style="padding:8px 18px; border-radius:8px; border:1.5px solid #EDE5D8;
                           background:#fff; font-family:'Nunito',sans-serif; font-weight:700;
                           font-size:13px; cursor:pointer;">
                    Cancel
                </button>
                <button type="submit" class="btn-reject">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
function openApproveModal(id) {
    document.getElementById('approveForm').action = '/manager/stock-requests/' + id + '/approve';
    document.getElementById('approveModal').style.display = 'flex';
}
function closeApproveModal() {
    document.getElementById('approveModal').style.display = 'none';
}
function openRejectModal(id) {
    document.getElementById('rejectForm').action = '/manager/stock-requests/' + id + '/reject';
    document.getElementById('rejectModal').style.display = 'flex';
}
function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>