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

        /* ── Sidebar ── */
        .sidebar {
            width: 200px;
            min-width: 200px;
            background: #5a2d0c;
            display: flex;
            flex-direction: column;
            padding: 0;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
        }
        .sidebar-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 22px 16px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand img { width: 300px; height: 160px; border-radius: 0; padding: 0; object-fit: contain; }
        .sidebar-brand .brand-name { color: #fff; font-weight: 700; font-size: 0.82rem; text-align: center; margin-top: 8px; letter-spacing: 0.5px; text-transform: uppercase; }
        .sidebar-brand .brand-sub  { color: #c4a07a; font-size: 0.73rem; text-align: center; margin-top: 2px; font-weight: normal; }

        .sidebar-nav { flex: 1; padding: 14px 10px; overflow-y: auto; }
        .sidebar-section-label {
            color: #c4a07a;
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 8px 4px;
            font-weight: 600;
        }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 9px;
            color: #f5e6d3; text-decoration: none;
            padding: 8px 12px; border-radius: 8px;
            font-size: 0.83rem; margin-bottom: 2px;
            transition: background 0.15s; font-weight: 600;
        }
        .sidebar-nav a:hover  { background: #7a3e1a; }
        .sidebar-nav a.active { background: #3d1c06; font-weight: 700; }
        .sidebar-nav a img    { width: 18px; filter: brightness(0) invert(1); opacity: 0.7; flex-shrink: 0; }
        .sidebar-nav a.active img { opacity: 1; }

        .sidebar-footer { padding: 14px 10px; border-top: 1px solid rgba(255,255,255,0.1); }
        .sidebar-footer form button {
            width: 100%; display: flex; align-items: center; gap: 9px;
            background: transparent; border: 1px solid rgba(255,255,255,0.2);
            color: #f5e6d3; padding: 8px 12px; border-radius: 8px;
            font-size: 0.83rem; cursor: pointer; transition: background 0.15s;
            font-family: 'Nunito', sans-serif;
        }
        .sidebar-footer form button:hover { background: #7a3e1a; }
        .sidebar-footer form button img   { width: 16px; filter: brightness(0) invert(1); opacity: 0.7; }

        /* ── MAIN ── */
        .main { margin-left: 200px; flex: 1; padding: 2rem; }

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
            <span class="brand-name">CPAMA SANDWICH</span>
            <span class="brand-sub">Baker: {{ auth()->user()->name }}</span>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Main</div>
            <a href="{{ route('baker.queue') }}">
                <img src="{{ asset('images/baker_queue_icon.png') }}"> Baker Queue
            </a>

            <div class="sidebar-section-label" style="margin-top:8px;">Catalog</div>
            <a href="{{ route('baker.inventorymanagement.index') }}">
                <img src="{{ asset('images/employee_inventory_icon.png') }}"> Inventory
            </a>
            <a href="{{ route('baker.orders.report') }}" class="active">
                <img src="{{ asset('images/reports_icon.png') }}"> Orders Report
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <img src="{{ asset('images/logout_icon.png') }}"> Logout
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