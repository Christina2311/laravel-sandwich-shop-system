<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - CPAMA Sandwich</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --brown:       #5D3A2E;
            --brown-dark:  #3E2720;
            --amber:       #F4A300;
            --main-bg:     #FFFCF2;
            --accent-yellow: #FEF3C7;
            --btn-green:   #27AE60;
            --btn-red:     #E74C3C;
            --sidebar-w:   220px;
            --border:      #E5E7EB;
            --text-dark:   #2C2C2C;
            --text-muted:  #888;
            --font:        'Nunito', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: var(--font);
            margin: 0;
            background: var(--main-bg);
            color: var(--text-dark);
        }

        .wrapper { display: flex; min-height: 100vh; }

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
        .brand-name { color: #fff; font-weight: 700; font-size: 0.82rem; text-align: center; margin-top: 8px; letter-spacing: 0.5px; text-transform: uppercase; }
        .brand-sub  { color: #c4a07a; font-size: 0.73rem; text-align: center; margin-top: 2px; font-weight: normal; }

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

        .sidebar-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 4px 10px; }

        .sidebar-footer { padding: 14px 10px; border-top: 1px solid rgba(255,255,255,0.1); }
        .sidebar-footer form button {
            width: 100%; display: flex; align-items: center; gap: 9px;
            background: transparent; border: 1px solid rgba(255,255,255,0.2);
            color: #f5e6d3; padding: 8px 12px; border-radius: 8px;
            font-size: 0.83rem; cursor: pointer; transition: background 0.15s;
            font-family: var(--font);
        }
        .sidebar-footer form button:hover { background: #7a3e1a; }
        .sidebar-footer form button img   { width: 16px; filter: brightness(0) invert(1); opacity: 0.7; }

        /* ── Main Content ── */
        .main-content {
            margin-left: 200px;
            flex: 1;
            padding: 36px 36px 60px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        /* ── Top bar ── */
        .top-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .search-bar {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 280px;
        }

        .search-bar input {
            border: none;
            outline: none;
            font-family: var(--font);
            font-size: 0.88rem;
            width: 100%;
            background: transparent;
        }

        .search-bar input::placeholder { color: #BBA98A; }

        .filter-select {
            padding: 9px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            background: #fff;
            font-family: var(--font);
            font-size: 0.88rem;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
        }

        /* ── Tab Card ── */
        .tab-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .tab-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 2px solid #EEE;
        }

        .tab-links { display: flex; gap: 0; }

        .tab-links button {
            background: none;
            border: none;
            padding: 14px 18px;
            font-family: var(--font);
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: color 0.15s, border-color 0.15s;
        }

        .tab-links button.active {
            color: var(--brown);
            border-bottom-color: var(--brown);
        }

        .tab-action-area { padding: 4px 0; }

        .btn-tab-action {
            padding: 8px 18px;
            border: none;
            border-radius: 8px;
            font-family: var(--font);
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .btn-tab-action:hover { opacity: 0.88; }
        .btn-green { background: var(--btn-green); }
        .btn-red   { background: var(--btn-red); }

        /* ── Tables ── */
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead tr { background: var(--accent-yellow); }

        thead th {
            padding: 13px 16px;
            text-align: left;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            color: var(--text-dark);
            white-space: nowrap;
        }

        tbody tr { border-bottom: 1px solid #F3F4F6; }
        tbody tr:last-child { border-bottom: none; }
        tbody td { padding: 12px 16px; vertical-align: middle; }

        .empty-row td {
            text-align: center;
            padding: 48px;
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Status badges */
        .badge-inv {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .inv-in    { background: #D4EDDA; color: #155724; }
        .inv-low   { background: #FFF3CD; color: #856404; }
        .inv-out   { background: #F8D7DA; color: #721C24; }

        .req-pending  { background: #FFF3CD; color: #856404; }
        .req-approved { background: #D4EDDA; color: #155724; }
        .req-rejected { background: #F8D7DA; color: #721C24; }

        /* ── Modals ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-overlay.open { display: flex; }

        .modal-box {
            background: var(--main-bg);
            padding: 30px;
            border-radius: 20px;
            width: 520px;
            max-width: 95vw;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .modal-title {
            font-size: 1.6rem;
            font-weight: 900;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group { display: flex; flex-direction: column; }

        .form-group label {
            font-size: 0.82rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 9px 12px;
            border: 1.5px solid #DDD;
            border-radius: 8px;
            font-family: var(--font);
            font-size: 13px;
            outline: none;
            transition: border-color 0.18s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { border-color: var(--brown); }

        .submit-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-family: var(--font);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 16px;
            transition: opacity 0.15s;
        }

        .submit-btn:hover { opacity: 0.88; }

        .cancel-lnk {
            display: block;
            width: 100%;
            padding: 10px;
            background: none;
            border: none;
            color: var(--text-muted);
            font-family: var(--font);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
            margin-top: 6px;
        }

        /* Pending notice */
        .pending-notice {
            background: #FFF3CD;
            border: 1px solid #FECB2F;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 12px;
            font-weight: 700;
            color: #856404;
            margin-bottom: 14px;
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="Logo">
            <div class="brand-name">CPAMA SANDWICH</div>
            <div class="brand-sub">Baker: {{ auth()->user()->name }}</div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Main</div>
            <a href="{{ route('baker.queue') }}">
                <img src="{{ asset('images/baker_queue_icon.png') }}" alt="Queue"> Baker Queue
            </a>

            <div class="sidebar-section-label" style="margin-top:8px;">Catalog</div>
            <a href="{{ route('baker.inventorymanagement.index') }}" class="active">
                <img src="{{ asset('images/employee_inventory_icon.png') }}" alt="Inventory"> Inventory
            </a>
            <a href="{{ route('baker.orders.report') }}">
                <img src="{{ asset('images/reports_icon.png') }}" alt="Orders Report"> Orders Report
            </a>

            @if(auth()->user()->hasRole('seller'))
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Switch Role</div>
            <a href="{{ route('seller.dashboard') }}">
                <img src="{{ asset('images/dashboard_icon.png') }}" alt="Seller"> Go to Seller
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <img src="{{ asset('images/logout_icon.png') }}" alt="Logout"> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="main-content">

        <div class="page-title">Inventory Management</div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Top bar --}}
        <div class="top-bar">
            <div class="search-bar">
                <img src="{{ asset('images/search_icon.png') }}" width="18" alt="Search">
                <input type="text" id="globalSearch" placeholder="search ingredient....">
            </div>
            <select class="filter-select" id="categoryFilter">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ strtolower($cat) }}">{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tab Card --}}
        <div class="tab-card">

            <div class="tab-header">
                <div class="tab-links">
                    <button class="active" onclick="switchTab('inventory', this)">Inventory List</button>
                    <button onclick="switchTab('stockin', this)">Stock In</button>
                    <button onclick="switchTab('stockout', this)">Stock Out</button>
                </div>
                <div class="tab-action-area" id="tabAction"></div>
            </div>

            {{-- ── INVENTORY LIST ── --}}
            <div id="tab-inventory" class="tab-pane active">
                <table>
                    <thead>
                        <tr>
                            <th>Inventory ID</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryBody">
                        @forelse($inventories as $item)
                        <tr data-name="{{ strtolower($item->product->name ?? '') }}"
                            data-category="{{ strtolower($item->product->category ?? '') }}">
                            <td>#{{ $item->id }}</td>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>
                                @php
                                    $sc = match($item->status) {
                                        'In Stock'     => 'inv-in',
                                        'Low Stock'    => 'inv-low',
                                        'Out of Stock' => 'inv-out',
                                        default        => ''
                                    };
                                @endphp
                                <span class="badge-inv {{ $sc }}">{{ $item->status }}</span>
                            </td>
                            <td>{{ $item->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="6">No inventory records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── STOCK IN (Requests) ── --}}
            <div id="tab-stockin" class="tab-pane">
                <div style="padding: 16px 20px 0;">
                    <div class="pending-notice">
                        ⚠ Stock In requests must be approved by a manager before inventory is updated.
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Manager Note</th>
                        </tr>
                    </thead>
                    <tbody id="stockInBody">
                        @forelse($myRequests as $req)
                        <tr data-name="{{ strtolower($req->product->name ?? '') }}"
                            data-category="{{ strtolower($req->product->category ?? '') }}">
                            <td>#{{ $req->id }}</td>
                            <td>{{ $req->product->name ?? 'N/A' }}</td>
                            <td>{{ $req->quantity }}</td>
                            <td>{{ $req->supplier ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($req->date)->format('M d, Y') }}</td>
                            <td>{{ $req->note ?? '—' }}</td>
                            <td>
                                @php
                                    $rc = match($req->status) {
                                        'pending'  => 'req-pending',
                                        'approved' => 'req-approved',
                                        'rejected' => 'req-rejected',
                                        default    => ''
                                    };
                                @endphp
                                <span class="badge-inv {{ $rc }}">{{ ucfirst($req->status) }}</span>
                            </td>
                            <td>{{ $req->manager_note ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="8">No stock in requests yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── STOCK OUT ── --}}
            <div id="tab-stockout" class="tab-pane">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Reason</th>
                            <th>Date</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody id="stockOutBody">
                        @forelse($stockOuts as $out)
                        <tr data-name="{{ strtolower($out->product->name ?? '') }}"
                            data-category="{{ strtolower($out->product->category ?? '') }}">
                            <td>#{{ $out->id }}</td>
                            <td>{{ $out->product->name ?? 'N/A' }}</td>
                            <td>{{ $out->quantity }}</td>
                            <td>{{ ucfirst($out->reason) }}</td>
                            <td>{{ \Carbon\Carbon::parse($out->date)->format('M d, Y') }}</td>
                            <td>{{ $out->note ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="6">No stock out records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>{{-- /.tab-card --}}
    </main>

</div>{{-- /.wrapper --}}


{{-- ── STOCK IN REQUEST MODAL ── --}}
<div id="stockInModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Stock In Request</div>
        <div class="pending-notice">
            This will be sent to the manager for approval before stock is updated.
        </div>
        <form action="{{ route('baker.inventory.storeStockIn') }}" method="POST">
            @csrf
            <input type="hidden" name="employee_id" value="{{ auth()->user()->employee?->id }}">
            <div class="form-grid">
                <div class="form-group">
                    <label>Ingredient/Product Name</label>
                    <input
                        list="productListIn"
                        name="product_name"
                        placeholder="Select or type a name..."
                        autocomplete="off"
                        required
                        style="width:100%;">
                    <datalist id="productListIn">
                        @foreach($products as $p)
                            <option value="{{ $p->name }}">
                        @endforeach
                    </datalist>
                    <small style="color:#aaa;font-size:11px;">Type a new name to add it automatically.</small>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" min="1" placeholder="Enter Quantity" required>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <input type="text" name="supplier" placeholder="Supplier Name">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Note</label>
                    <textarea name="note" rows="2" placeholder="Additional note.."></textarea>
                </div>
            </div>
            <button type="submit" class="submit-btn" style="background: var(--brown);">
                Submit Request
            </button>
            <button type="button" class="cancel-lnk" onclick="closeModal('stockInModal')">Cancel</button>
        </form>
    </div>
</div>


{{-- ── STOCK OUT MODAL ── --}}
<div id="stockOutModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Stock Out Form</div>
        <form action="{{ route('baker.inventory.storeStockOut') }}" method="POST">
            @csrf
            <input type="hidden" name="employee_id" value="{{ auth()->user()->employee?->id }}">
            <div class="form-grid">
                <div class="form-group">
                    <label>Ingredient/Product Name</label>
                    <input
                        list="productListOut"
                        name="product_name"
                        placeholder="Select or type a name..."
                        autocomplete="off"
                        required
                        style="width:100%;">
                    <datalist id="productListOut">
                        @foreach($products as $p)
                            <option value="{{ $p->name }}">
                        @endforeach
                    </datalist>
                    <small style="color:#aaa;font-size:11px;">Type a new name to add it automatically.</small>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" min="1" placeholder="Enter Quantity" required>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Reason</label>
                    <select name="reason" required>
                        <option value="" disabled selected>Select reason</option>
                        <option value="sold">Sold</option>
                        <option value="expired">Expired</option>
                        <option value="damaged">Damaged</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Note</label>
                    <textarea name="note" rows="2" placeholder="Additional note.."></textarea>
                </div>
            </div>
            <button type="submit" class="submit-btn" style="background: var(--btn-red);">
                Record Stock Out
            </button>
            <button type="button" class="cancel-lnk" onclick="closeModal('stockOutModal')">Cancel</button>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ── Tab switching ──
    function switchTab(tab, btn) {
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-links button').forEach(b => b.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        btn.classList.add('active');

        const area = document.getElementById('tabAction');
        if (tab === 'stockin') {
            area.innerHTML = `<button class="btn-tab-action btn-green"
                onclick="openModal('stockInModal')">+ Request Stock In</button>`;
        } else if (tab === 'stockout') {
            area.innerHTML = `<button class="btn-tab-action btn-red"
                onclick="openModal('stockOutModal')">− Stock Out</button>`;
        } else {
            area.innerHTML = '';
        }

        applyFilters();
    }

    // ── Modals ──
    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    // Close on outside click
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    // ── Search + Category filter ──
    function applyFilters() {
        const query    = document.getElementById('globalSearch').value.toLowerCase().trim();
        const category = document.getElementById('categoryFilter').value.toLowerCase();
        const active   = document.querySelector('.tab-pane.active');
        if (!active) return;

        active.querySelectorAll('tbody tr:not(.empty-row)').forEach(row => {
            const nameMatch     = (row.dataset.name || '').includes(query);
            const categoryMatch = !category || (row.dataset.category || '') === category;
            row.style.display   = nameMatch && categoryMatch ? '' : 'none';
        });
    }

    document.getElementById('globalSearch').addEventListener('input', applyFilters);
    document.getElementById('categoryFilter').addEventListener('change', applyFilters);
</script>

</body>
</html>