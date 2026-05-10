<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Reports – CPAMA Sandwich</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w:  210px;
            --brown:      #5C3D2E;
            --brown-dark: #3B2217;
            --amber:      #F0A500;
            --cream:      #FAF3E0;
            --card-shadow: 0 2px 10px rgba(0,0,0,.08);
            --radius: 12px;
        }

        body { font-family: 'Nunito', sans-serif; background: var(--cream); display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .sidebar { width: var(--sidebar-w); min-height: 100vh; background: var(--brown); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { display: flex; flex-direction: column; align-items: center; padding: 1.5rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand img { width: 80px; height: 80px; object-fit: contain; }
        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,.08);
            margin: .6rem .75rem;
        }
        .sidebar-footer { margin-top: auto; padding: 1rem; }
        
        .brand-name { font-weight: 900; font-size: 1rem; color: var(--amber); margin-top: .5rem; letter-spacing: 1px; }
        .brand-sub { font-size: .75rem; color: rgba(255,255,255,0.5); font-weight: bold; }
        
        .nav-section { padding: 1rem .8rem; }
        .nav-section { padding: .8rem .75rem .2rem; }
        .nav-section-label {
            font-size: .65rem;
            font-weight: 900;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
            padding: 0 .5rem;
            margin-bottom: .3rem;
        }
        .nav-label { font-size: .65rem; text-transform: uppercase; color: rgba(255,255,255,0.3); font-weight: 800; padding-left: 10px; margin-bottom: 5px; }
        .nav-list { list-style: none; padding: 0; margin: 0; }
        .nav-list a { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-weight: 700; font-size: 0.9rem; transition: 0.2s; }
        .nav-list a:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .nav-list a.active { background: var(--amber); color: var(--brown-dark); }
        .nav-list img { width: 18px; filter: brightness(0) invert(1); opacity: 0.7; }
        .nav-list a.active img { filter: brightness(0); opacity: 1; }
        
        .btn-logout { width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 10px; background: transparent; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; color: rgba(255,255,255,0.6); cursor: pointer; font-weight: bold; }
        .btn-logout:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .btn-logout img { width: 16px; filter: brightness(0) invert(1); opacity: 0.7; }
        .btn-logout:hover img { filter: brightness(0); opacity: 1; }
        
        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 2rem; }

        .page-title {
            font-weight: 900;
            font-size: 1.5rem;
            color: var(--brown-dark);
            margin-bottom: 1.25rem;
        }

        /* ── TOOLBAR ── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .search-wrap {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: #fff;
            border: 1.5px solid #E5D9C8;
            border-radius: 8px;
            padding: .5rem .85rem;
            box-shadow: var(--card-shadow);
            flex: 0 0 260px;
        }
        .search-wrap img { width: 16px; height: 16px; opacity: .45; flex-shrink: 0; }
        .search-wrap input {
            border: none; outline: none;
            font-family: 'Nunito', sans-serif;
            font-size: .85rem; font-weight: 600;
            color: #444; background: transparent; width: 100%;
        }
        .search-wrap input::placeholder { color: #bbb; }

        .filter-select {
            appearance: none;
            -webkit-appearance: none;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23aaa' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right .75rem center;
            border: 1.5px solid #E5D9C8;
            border-radius: 8px;
            padding: .5rem 2.25rem .5rem .85rem;
            font-family: 'Nunito', sans-serif;
            font-size: .85rem; font-weight: 700;
            color: #555;
            box-shadow: var(--card-shadow);
            cursor: pointer; outline: none;
            min-width: 140px;
        }
        .filter-select:focus { border-color: var(--amber); }

        .date-wrap {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: #fff;
            border: 1.5px solid #E5D9C8;
            border-radius: 8px;
            padding: .5rem .85rem;
            box-shadow: var(--card-shadow);
        }
        .date-wrap input[type="date"] {
            border: none; outline: none;
            font-family: 'Nunito', sans-serif;
            font-size: .85rem; font-weight: 600;
            color: #444; background: transparent;
            cursor: pointer;
        }
        .date-wrap img { width: 16px; height: 16px; opacity: .45; flex-shrink: 0; }

        /* ── TABLE CARD ── */
        .table-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: 1.5px solid #EDE5D8;
        }

        .orders-table { width: 100%; border-collapse: collapse; }

        .orders-table thead tr { background: #FDF5E4; }
        .orders-table thead th {
            padding: .85rem 1rem;
            text-align: left;
            font-size: .78rem; font-weight: 900;
            color: #9A7A5A;
            text-transform: uppercase; letter-spacing: .8px;
            border-bottom: 1.5px solid #EDE5D8;
            white-space: nowrap;
        }

        .orders-table tbody tr { border-bottom: 1px solid #F2EBE0; transition: background .15s; }
        .orders-table tbody tr:last-child { border-bottom: none; }
        .orders-table tbody tr:hover { background: #FDFAF4; }

        .orders-table tbody td {
            padding: .8rem 1rem;
            font-size: .85rem; font-weight: 600;
            color: #444; vertical-align: middle;
        }

        .td-id { font-weight: 900; color: var(--brown-dark); }
        .td-muted { color: #888; }
        .td-total { font-family: 'Bebas Neue', cursive; font-size: 1rem; color: var(--brown); letter-spacing: 1px; }

        /* Status badge */
        .status-badge {
            display: inline-block;
            font-size: .72rem; font-weight: 900;
            padding: .22rem .65rem;
            border-radius: 999px;
            white-space: nowrap;
        }
        .status-badge.pending   { background: #FEF9C3; color: #854D0E; }
        .status-badge.preparing { background: #DBEAFE; color: #1D4ED8; }
        .status-badge.ready     { background: #DCFCE7; color: #15803D; }
        .status-badge.completed { background: #F0FFF4; color: #15803D; border: 1px solid #BBF7D0; }
        .status-badge.cancelled { background: #FEE2E2; color: #B91C1C; }

        /* Action button */
        .action-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 8px;
            border: 1.5px solid #E5D9C8; background: #fff;
            cursor: pointer; transition: background .15s, border-color .15s;
            text-decoration: none; color: #666;
        }
        .action-btn:hover { background: #FDF5E4; border-color: var(--amber); color: var(--brown); }
        .action-btn img { width: 16px; height: 16px; object-fit: contain; }

        /* Empty state */
        .empty-row td {
            text-align: center;
            padding: 3.5rem 1rem;
            color: #ccc; font-weight: 700; font-size: .9rem;
        }

        /* ── PAGINATION ── */
        .pagination-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .85rem 1rem;
            border-top: 1.5px solid #EDE5D8;
            background: #FDF5E4;
            flex-wrap: wrap;
            gap: .5rem;
        }
        .pagination-info {
            font-size: .8rem;
            font-weight: 700;
            color: #9A7A5A;
        }
        .pagination-links {
            display: flex;
            align-items: center;
            gap: .3rem;
        }
        .pagination-links a,
        .pagination-links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 .5rem;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 700;
            text-decoration: none;
            border: 1.5px solid #E5D9C8;
            background: #fff;
            color: #555;
            transition: background .15s, border-color .15s, color .15s;
        }
        .pagination-links a:hover {
            background: #FDF5E4;
            border-color: var(--amber);
            color: var(--brown);
        }
        .pagination-links span.active {
            background: var(--amber);
            border-color: var(--amber);
            color: var(--brown-dark);
        }
        .pagination-links span.disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .toolbar { flex-direction: column; align-items: stretch; }
            .search-wrap { flex: 1; }
            .orders-table thead th:nth-child(3),
            .orders-table tbody td:nth-child(3),
            .orders-table thead th:nth-child(4),
            .orders-table tbody td:nth-child(4) { display: none; }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="Logo">
            <div class="brand-name">CPAMA SANDWICH</div>
            <div class="brand-sub">Baker: {{ auth()->user()->name }}</div>
        </div>
        <div class="nav-section">
            <div class="nav-label">Main</div>
            <ul class="nav-list">
                <li><a href="{{ route('baker.queue') }}"><img src="{{ asset('images/baker_queue_icon.png') }}"> Baker Queue</a></li>
            </ul>
            <div class="nav-label" style="margin-top:20px;">Catalog</div>
            <ul class="nav-list">
                <li><a href="{{ route('baker.inventorymanagement.index') }}"><img src="{{ asset('images/employee_inventory_icon.png') }}"> Inventory</a></li>
                <li><a href="{{ route('baker.orders.report') }}" class="active"><img src="{{ asset('images/reports_icon.png') }}"> Orders Report</a></li>
            </ul>
        </div>

        {{-- Switch Role (only shown if employee also has baker role) --}}
        @if(auth()->user()->hasRole('seller'))
        <div class="sidebar-divider"></div>
        <div class="nav-section">
            <div class="nav-section-label">Switch Role</div>
            <ul class="nav-list">
                <li>
                    <a href="{{ route('seller.dashboard') }}">
                        <img class="nav-icon" src="{{ asset('images/dashboard_icon.png') }}" alt=""> Go to Seller
                    </a>
                </li>
            </ul>
        </div>
        @endif

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <img src="{{ asset('images/logout_icon.png') }}" style="width:16px;"> Logout
                </button>
            </form>
        </div>
    </aside>

<!-- ── MAIN ── -->
<main class="main">

    <div class="page-title">Order Reports</div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="search-wrap">
            <img src="{{ asset('images/search_icon.png') }}" alt="Search">
            <input type="text" id="searchInput" placeholder="search customer…">
        </div>

        <select class="filter-select" id="statusFilter">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="preparing">Preparing</option>
            <option value="ready">Ready</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>

        <div class="date-wrap">
            <input type="date" id="dateFilter">
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <table class="orders-table" id="ordersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Seller ID</th>
                    <th>Baker ID</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersBody">
                @forelse($orders as $order)
                <tr class="order-row"
                    data-customer="{{ strtolower($order->customer_name ?? 'walk-in') }}"
                    data-status="{{ strtolower($order->status) }}"
                    data-date="{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}">
                    <td class="td-id">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $order->customer_name ?? 'Walk-in Customer' }}</td>
                    <td class="td-muted">{{ $order->seller_id ? '#'.str_pad($order->seller_id, 3, '0', STR_PAD_LEFT) : '—' }}</td>
                    <td class="td-muted">{{ $order->baker_id ? '#'.str_pad($order->baker_id, 3, '0', STR_PAD_LEFT) : '—' }}</td>
                    <td>
                        @php $s = strtolower($order->status); @endphp
                        <span class="status-badge {{ $s }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="td-total">₱{{ number_format($order->total_amount, 2) }}</td>
                    <td class="td-muted">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('baker.orders.report.show', $order->id) }}" class="action-btn" title="View Details">
                            <img src="{{ asset('images/visibility_icon.png') }}" alt="View">
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="8">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="pagination-wrap">
            <div class="pagination-info">
                Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }} orders
            </div>
            <div class="pagination-links">
                {{-- Previous --}}
                @if($orders->onFirstPage())
                    <span class="disabled">&laquo;</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}">&laquo;</a>
                @endif

                {{-- Page numbers --}}
                @foreach($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
                    @if($page == $orders->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}">&raquo;</a>
                @else
                    <span class="disabled">&raquo;</span>
                @endif
            </div>
        </div>
        @endif

    </div>

</main>

<script>
    const searchInput  = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter   = document.getElementById('dateFilter');

    function filterRows() {
        const query  = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        const date   = dateFilter.value;

        document.querySelectorAll('.order-row').forEach(row => {
            const matchCustomer = row.dataset.customer.includes(query);
            const matchStatus   = !status || row.dataset.status === status;
            const matchDate     = !date   || row.dataset.date === date;
            row.style.display   = (matchCustomer && matchStatus && matchDate) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterRows);
    statusFilter.addEventListener('change', filterRows);
    dateFilter.addEventListener('change', filterRows);
</script>
</body>
</html>