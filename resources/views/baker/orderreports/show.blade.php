<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} – CPAMA Sandwich</title>
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
        .brand-name { font-weight: 900; font-size: 1rem; color: var(--amber); margin-top: .5rem; letter-spacing: 1px; }
        .brand-sub { font-size: .75rem; color: rgba(255,255,255,0.5); font-weight: bold; }
        
        .nav-section { padding: 1rem .8rem; }
        .nav-label { font-size: .65rem; text-transform: uppercase; color: rgba(255,255,255,0.3); font-weight: 800; padding-left: 10px; margin-bottom: 5px; }
        .nav-list { list-style: none; padding: 0; margin: 0; }
        .nav-list a { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-weight: 700; font-size: 0.9rem; transition: 0.2s; }
        .nav-list a:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .nav-list a.active { background: var(--amber); color: var(--brown-dark); }
        .nav-list img { width: 18px; filter: brightness(0) invert(1); opacity: 0.7; }
        .nav-list a.active img { filter: brightness(0); opacity: 1; }

        .sidebar-footer { margin-top: auto; padding: 1rem; }
        .btn-logout { width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 10px; background: transparent; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; color: rgba(255,255,255,0.6); cursor: pointer; font-weight: bold; }

        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 2rem; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .back-btn {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .45rem .9rem;
            border-radius: 8px;
            border: 1.5px solid #E5D9C8;
            background: #fff;
            color: var(--brown);
            font-size: .82rem; font-weight: 700;
            text-decoration: none;
            box-shadow: var(--card-shadow);
            transition: background .15s, border-color .15s;
        }
        .back-btn:hover { background: #FDF5E4; border-color: var(--amber); }
        .page-title { font-weight: 900; font-size: 1.5rem; color: var(--brown-dark); }
        .status-badge {
            display: inline-block;
            font-size: .75rem; font-weight: 900;
            padding: .25rem .75rem;
            border-radius: 999px;
            white-space: nowrap;
        }
        .status-badge.pending   { background: #FEF9C3; color: #854D0E; }
        .status-badge.preparing { background: #DBEAFE; color: #1D4ED8; }
        .status-badge.ready     { background: #DCFCE7; color: #15803D; }
        .status-badge.completed { background: #F0FFF4; color: #15803D; border: 1px solid #BBF7D0; }
        .status-badge.cancelled { background: #FEE2E2; color: #B91C1C; }

        /* ── GRID ── */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        /* ── CARD ── */
        .card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            border: 1.5px solid #EDE5D8;
            overflow: hidden;
        }
        .card-header {
            padding: .75rem 1.25rem;
            background: #FDF5E4;
            border-bottom: 1.5px solid #EDE5D8;
            font-size: .78rem; font-weight: 900;
            color: #9A7A5A;
            text-transform: uppercase; letter-spacing: .8px;
        }
        .card-body { padding: 1.25rem; }

        /* ── INFO ROWS ── */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .5rem 0;
            border-bottom: 1px solid #F2EBE0;
            font-size: .85rem;
        }
        .info-row:last-child { border-bottom: none; padding-bottom: 0; }
        .info-label { font-weight: 700; color: #9A7A5A; }
        .info-value { font-weight: 700; color: #333; text-align: right; }

        /* ── ITEMS TABLE ── */
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table thead tr { background: #FDF5E4; }
        .items-table thead th {
            padding: .75rem 1rem;
            text-align: left;
            font-size: .78rem; font-weight: 900;
            color: #9A7A5A;
            text-transform: uppercase; letter-spacing: .8px;
            border-bottom: 1.5px solid #EDE5D8;
            white-space: nowrap;
        }
        .items-table thead th:last-child { text-align: right; }
        .items-table tbody tr { border-bottom: 1px solid #F2EBE0; }
        .items-table tbody tr:last-child { border-bottom: none; }
        .items-table tbody td {
            padding: .75rem 1rem;
            font-size: .85rem; font-weight: 600;
            color: #444; vertical-align: middle;
        }
        .items-table tbody td:last-child { text-align: right; font-family: 'Bebas Neue', cursive; font-size: 1rem; color: var(--brown); letter-spacing: 1px; }
        .item-category { font-size: .72rem; font-weight: 700; color: #bbb; margin-top: .15rem; }

        /* ── TOTALS ── */
        .totals-section {
            padding: 1rem 1.25rem;
            border-top: 1.5px solid #EDE5D8;
            background: #FDF5E4;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            font-size: .85rem; font-weight: 700;
            color: #666;
            padding: .3rem 0;
        }
        .totals-row.grand {
            font-size: 1rem; font-weight: 900;
            color: var(--brown-dark);
            border-top: 1.5px solid #EDE5D8;
            margin-top: .4rem;
            padding-top: .7rem;
        }
        .totals-row.grand .amount {
            font-family: 'Bebas Neue', cursive;
            font-size: 1.3rem;
            color: var(--brown);
            letter-spacing: 1px;
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

    <div class="page-header">
        <a href="{{ route('baker.orders.report') }}" class="back-btn">&#8592; Back</a>
        <div class="page-title">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
        @php $s = strtolower($order->status); @endphp
        <span class="status-badge {{ $s }}">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="detail-grid">

        <!-- Customer Info -->
        <div class="card">
            <div class="card-header">Customer Information</div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Name</span>
                    <span class="info-value">{{ $order->customer_name ?? 'Walk-in Customer' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $order->customer_phone ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $order->customer_email ?? '—' }}</span>
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div class="card">
            <div class="card-header">Order Information</div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Date</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Seller</span>
                    <span class="info-value">{{ $order->seller_name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Baker</span>
                    <span class="info-value">{{ $order->baker_name ?? '—' }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Order Items -->
    <div class="card">
        <div class="card-header">Order Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Line Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                <tr>
                    <td style="color:#bbb; font-weight:700;">{{ $i + 1 }}</td>
                    <td>
                        <div style="font-weight:700; color:#333;">{{ $item->product_name }}</div>
                        <div class="item-category">{{ $item->category }}</div>
                    </td>
                    <td>₱{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->line_total, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:2rem; color:#ccc; font-weight:700;">No items found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="totals-section">
            <div class="totals-row">
                <span>Subtotal</span>
                <span>₱{{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Tax</span>
                <span>₱{{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="totals-row grand">
                <span>Total</span>
                <span class="amount">₱{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

</main>

</body>
</html>