<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baker Queue – CPAMA Sandwich</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        
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
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 2rem; display: flex; flex-direction: column; }
        .page-title { font-family: 'Bebas Neue', cursive; font-size: 2rem; letter-spacing: 2px; color: var(--brown-dark); margin-bottom: 1.5rem; }

        /* ── QUEUE COLUMNS ── */
        .queue-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; align-items: start; }
        .queue-col { background: #fff; border-radius: var(--radius); box-shadow: var(--card-shadow); overflow: hidden; }
        .col-header { display: flex; align-items: center; justify-content: center; gap: .5rem; padding: .85rem 1rem; font-family: 'Bebas Neue', cursive; font-size: 1.15rem; letter-spacing: 2px; border-bottom: 3px solid transparent; }
        .col-header .badge { font-family: 'Nunito', sans-serif; font-size: .75rem; font-weight: 900; padding: .15rem .55rem; border-radius: 999px; }
        .col--pending .col-header  { background: #FFF8EC; border-color: #F0A500; color: #92600A; }
        .col--pending .badge       { background: #FDE68A; color: #92600A; }
        .col--progress .col-header { background: #EDF6FF; border-color: #3B82F6; color: #1D4ED8; }
        .col--progress .badge      { background: #BFDBFE; color: #1D4ED8; }
        .col--done .col-header     { background: #EDFBF1; border-color: #22C55E; color: #15803D; }
        .col--done .badge          { background: #BBF7D0; color: #15803D; }

        /* ── SCROLLABLE COLUMN BODY ── */
        .col-body {
            padding: .75rem;
            display: flex;
            flex-direction: column;
            gap: .75rem;
            max-height: 70vh;
            overflow-y: auto;
            min-height: 200px;
        }
        .col-body::-webkit-scrollbar { width: 5px; }
        .col-body::-webkit-scrollbar-track { background: #f5f5f5; border-radius: 10px; }
        .col-body::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
        .col-body::-webkit-scrollbar-thumb:hover { background: #bbb; }

        /* ── ORDER CARD ── */
        .order-card { background: #fff; border: 1.5px solid #EEE; border-radius: 10px; padding: .9rem 1rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
        .order-id { font-weight: 900; font-size: .9rem; color: var(--brown-dark); display: block; margin-bottom: .3rem; }
        .order-meta { font-size: .75rem; color: #888; margin-bottom: .6rem; line-height: 1.5; }
        .order-total { font-size: .78rem; font-weight: 900; color: var(--brown); margin-bottom: .6rem; }
        .order-items { margin-bottom: .65rem; }
        .item-row { display: flex; justify-content: space-between; font-size: .82rem; font-weight: 700; color: #333; padding: .15rem 0; }
        .item-qty { font-weight: 900; color: var(--brown); }
        .ready-label { font-size: .82rem; font-weight: 900; color: #22C55E; letter-spacing: 1px; margin-bottom: .4rem; }
        .btn { width: 100%; padding: .5rem; border: none; border-radius: 7px; font-family: 'Nunito', sans-serif; font-size: .85rem; font-weight: 800; cursor: pointer; transition: filter .15s, transform .1s; }
        .btn:active { transform: scale(.97); }
        .btn-start    { background: #3B82F6; color: #fff; }
        .btn-start:hover { filter: brightness(1.1); }
        .btn-complete { background: #22C55E; color: #fff; }
        .btn-complete:hover { filter: brightness(1.1); }
        .empty-state { text-align: center; color: #bbb; font-size: .82rem; font-weight: 700; padding: 1.5rem 0; }
        .alert-success { background: #DCFCE7; color: #15803D; padding: .6rem 1rem; border-radius: 8px; font-weight: 700; font-size: .85rem; margin-bottom: 1rem; }

        @media (max-width: 900px) { .queue-grid { grid-template-columns: 1fr; } }
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
                <li><a href="{{ route('baker.queue') }}" class="active"><img src="{{ asset('images/baker_queue_icon.png') }}"> Baker Queue</a></li>
            </ul>
            <div class="nav-label" style="margin-top:20px;">Catalog</div>
            <ul class="nav-list">
                <li><a href="{{ route('baker.inventorymanagement.index') }}"><img src="{{ asset('images/employee_inventory_icon.png') }}"> Inventory</a></li>
                <li><a href="{{ route('baker.products') }}"><img src="{{ asset('images/products_icon.png') }}"> Products</a></li>
                <li><a href="{{ route('baker.orders.report') }}"><img src="{{ asset('images/reports_icon.png') }}"> Orders Report</a></li>
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

    <!-- MAIN -->
<main class="main">
    <div class="page-title">Baker Queue</div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="queue-grid">

        {{-- PENDING --}}
        <div class="queue-col col--pending">
            <div class="col-header">
                Pending <span class="badge">{{ $pending->count() }}</span>
            </div>
            <div class="col-body">
                @forelse($pending as $order)
                    <div class="order-card">
                        <span class="order-id">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <div class="order-meta">
                            {{ $order->customer_name ?? 'Walk-in Customer' }}<br>
                            {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}
                        </div>
                        <div class="order-total">Total: ₱{{ number_format($order->total_amount, 2) }}</div>
                        <div class="order-items">
                            @foreach($orderItems->get($order->id, collect()) as $item)
                                <div class="item-row">
                                    <span>{{ $item->product_name }}</span>
                                    <span class="item-qty">x{{ $item->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                        <form method="POST" action="{{ route('baker.queue.update', $order->id) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="Preparing">
                            <button type="submit" class="btn btn-start">Start</button>
                        </form>
                    </div>
                @empty
                    <div class="empty-state">No pending orders</div>
                @endforelse
            </div>
        </div>

        {{-- IN PROGRESS --}}
        <div class="queue-col col--progress">
            <div class="col-header">
                In Progress <span class="badge">{{ $preparing->count() }}</span>
            </div>
            <div class="col-body">
                @forelse($preparing as $order)
                    <div class="order-card">
                        <span class="order-id">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <div class="order-meta">
                            {{ $order->customer_name ?? 'Walk-in Customer' }}<br>
                            {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}
                        </div>
                        <div class="order-total">Total: ₱{{ number_format($order->total_amount, 2) }}</div>
                        <div class="order-items">
                            @foreach($orderItems->get($order->id, collect()) as $item)
                                <div class="item-row">
                                    <span>{{ $item->product_name }}</span>
                                    <span class="item-qty">x{{ $item->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                        <form method="POST" action="{{ route('baker.queue.update', $order->id) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="Ready">
                            <button type="submit" class="btn btn-complete">Complete</button>
                        </form>
                    </div>
                @empty
                    <div class="empty-state">No orders in progress</div>
                @endforelse
            </div>
        </div>

        {{-- COMPLETED --}}
        <div class="queue-col col--done">
            <div class="col-header">
                Completed <span class="badge">{{ $completed->count() }}</span>
            </div>
            <div class="col-body">
                @forelse($completed as $order)
                    <div class="order-card">
                        <span class="order-id">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <div class="order-meta">
                            {{ $order->customer_name ?? 'Walk-in Customer' }}<br>
                            {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}
                        </div>
                        <div class="order-total">Total: ₱{{ number_format($order->total_amount, 2) }}</div>
                        <div class="order-items">
                            @foreach($orderItems->get($order->id, collect()) as $item)
                                <div class="item-row">
                                    <span>{{ $item->product_name }}</span>
                                    <span class="item-qty">x{{ $item->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="ready-label">✓ READY</div>
                    </div>
                @empty
                    <div class="empty-state">No completed orders</div>
                @endforelse
            </div>
        </div>

    </div>
</main>

<script>
    setTimeout(() => location.reload(), 30000);
</script>
</body>
</html>