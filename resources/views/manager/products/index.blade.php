<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products – CPAMA Sandwich</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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

            /* ── FIX 1: Added all missing variables ── */
            --brown-dark:      #5C2D0E;
            --brown:           #7A3D18;
            --amber:           #F5A623;
            --radius:          14px;
            --card-shadow:     0 1px 4px rgba(0,0,0,0.07);

            --text-dark:       #2C2C2C;
            --text-muted:      #888;
            --font:            'Nunito', sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--page-bg);
            color: var(--text-dark);
        }

        /* ── FIX 2: wrapper flex container ── */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── FIX 3: main uses correct class name ── */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 36px 36px 60px;
        }

        /* ─── Sidebar ─────────────────────────────────────────── */
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

        /* ── FIX 4: logo was 500px wide inside 220px sidebar ── */
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
            transition: background 0.18s;
        }

        .sidebar-nav li a img {
            width: 18px;
            height: 18px;
            object-fit: contain;
            opacity: 0.85;
            filter: brightness(0) invert(1);
        }

        .sidebar-nav li a:hover  { background: var(--sidebar-hover); }
        .sidebar-nav li a.active { background: var(--sidebar-active); color: #fff; }
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
            color: #fff;
        }

        /* ─── Page Header ─────────────────────────────────────── */
        /* ── FIX 5: removed duplicate .page-title, one clean rule ── */
        .page-header { margin-bottom: 1.25rem; }

        .page-title {
            font-weight: 900;
            font-size: 1.5rem;
            color: var(--brown-dark);
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: .82rem;
            font-weight: 600;
            color: #999;
            margin-top: .15rem;
        }

        /* ─── Toolbar ─────────────────────────────────────────── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.25rem;
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
        .search-wrap svg { width: 15px; height: 15px; color: #aaa; flex-shrink: 0; }
        .search-wrap input {
            border: none; outline: none;
            font-family: var(--font);
            font-size: .85rem; font-weight: 600;
            color: #444; background: transparent; width: 100%;
        }
        .search-wrap input::placeholder { color: #bbb; }

        .category-select {
            appearance: none;
            -webkit-appearance: none;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23aaa' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right .75rem center;
            border: 1.5px solid #E5D9C8;
            border-radius: 8px;
            padding: .5rem 2.25rem .5rem .85rem;
            font-family: var(--font);
            font-size: .85rem; font-weight: 700;
            color: #555;
            box-shadow: var(--card-shadow);
            cursor: pointer; outline: none;
        }
        .category-select:focus { border-color: var(--amber); }

        .btn-add {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--brown-dark);
            color: #fff;
            font-family: var(--font);
            font-size: .85rem; font-weight: 900;
            padding: .55rem 1.15rem;
            border-radius: 8px;
            border: none; cursor: pointer;
            text-decoration: none;
            transition: background .18s;
        }
        .btn-add:hover { background: var(--brown); color: #fff; }
        .btn-add svg { width: 15px; height: 15px; }

        /* ─── Table Card ──────────────────────────────────────── */
        .table-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: 1.5px solid #EDE5D8;
        }

        .products-table { width: 100%; border-collapse: collapse; }

        .products-table thead tr { background: #FDF5E4; }

        .products-table thead th {
            padding: .85rem 1rem;
            text-align: left;
            font-size: .78rem; font-weight: 900;
            color: #9A7A5A;
            text-transform: uppercase;
            letter-spacing: .8px;
            border-bottom: 1.5px solid #EDE5D8;
        }

        .products-table tbody tr {
            border-bottom: 1px solid #F2EBE0;
            transition: background .15s;
        }
        .products-table tbody tr:last-child { border-bottom: none; }
        .products-table tbody tr:hover { background: #FDFAF4; }

        .products-table tbody td {
            padding: .85rem 1rem;
            font-size: .85rem; font-weight: 600;
            color: #444; vertical-align: middle;
        }

        .td-name    { font-weight: 900; color: var(--brown-dark); }
        .td-qty     { font-weight: 700; color: #555; }
        .td-unit    { color: #888; font-weight: 600; }
        .td-managed { color: #777; }
        .td-updated { color: #aaa; font-size: .8rem; }

        /* Status badges */
        .status-badge {
            display: inline-block;
            font-size: .72rem; font-weight: 900;
            padding: .22rem .6rem;
            border-radius: 999px; letter-spacing: .3px;
        }
        .status-badge.in  { background: #DCFCE7; color: #15803D; }
        .status-badge.low { background: #FEF9C3; color: #854D0E; }
        .status-badge.out { background: #FEE2E2; color: #B91C1C; }

        /* Action buttons */
        .action-btns { display: flex; gap: .4rem; }
        .action-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 7px;
            border: 1.5px solid #E5D9C8;
            background: #fff; cursor: pointer;
            transition: background .15s, border-color .15s;
            text-decoration: none;
        }
        .action-btn svg { width: 14px; height: 14px; }
        .action-btn.edit   { color: var(--brown); }
        .action-btn.edit:hover   { background: #FDF5E4; border-color: var(--amber); }
        .action-btn.delete { color: #B91C1C; }
        .action-btn.delete:hover { background: #FEE2E2; border-color: #FECACA; }

        /* Empty state */
        .empty-row td {
            text-align: center;
            padding: 3.5rem 1rem;
            color: #ccc; font-weight: 700; font-size: .9rem;
        }

        /* ─── Add Product Modal ───────────────────────────────── */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            justify-content: center;
            align-items: center;
            z-index: 500;
        }
        .modal-overlay.open { display: flex; }

        .modal-box {
            background: #fff;
            border-radius: 16px;
            padding: 28px 30px;
            width: 480px; max-width: 95vw;
            box-shadow: 0 12px 40px rgba(0,0,0,0.18);
        }

        .modal-title {
            font-size: 1.2rem; font-weight: 900;
            color: var(--brown-dark);
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group.full { grid-column: 1 / -1; }

        .form-group label {
            font-size: .8rem; font-weight: 700;
            color: var(--text-dark);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 9px 12px;
            border: 1.5px solid #DDD;
            border-radius: 8px;
            font-family: var(--font);
            font-size: 13px; outline: none;
            transition: border-color .18s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { border-color: var(--brown-dark); }

        .modal-footer {
            display: flex; gap: 10px;
            justify-content: flex-end;
            margin-top: 4px;
        }

        .btn-cancel {
            padding: 9px 20px;
            background: none;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-family: var(--font);
            font-size: 13px; font-weight: 700;
            cursor: pointer; color: #777;
        }
        .btn-cancel:hover { background: #f5f5f5; }

        .btn-submit {
            padding: 9px 24px;
            background: var(--brown-dark);
            border: none; border-radius: 8px;
            color: #fff;
            font-family: var(--font);
            font-size: 13px; font-weight: 900;
            cursor: pointer;
            transition: background .18s;
        }
        .btn-submit:hover { background: var(--brown); }

        @media (max-width: 768px) {
            .toolbar { flex-wrap: wrap; }
            .search-wrap { flex: 1 1 100%; }
            .products-table thead th:nth-child(n+4),
            .products-table tbody td:nth-child(n+4) { display: none; }
        }
    </style>
</head>
<body>

{{-- FIX 6: wrapper div added, one clean sidebar, correct main class --}}
<div class="wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">

        <div class="sidebar-logo">
            <img src="{{ asset('images/sandwich_logo.png') }}"
                 alt="CPAMA Sandwich Logo" class="logo-img" />
            <div class="brand-name">CPAMA SANDWICH</div>
            <div class="manager-label">
                Manager: <span>{{ Auth::user()->name }}</span>
            </div>
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
                {{-- FIX 7: active link is now on Products, not Dashboard --}}
                <a href="{{ route('manager.products') }}" class="active">
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

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <img src="{{ asset('images/logout_icon.png') }}" alt="Logout" />
                    Logout
                </button>
            </form>
        </div>

    </aside>{{-- ── end sidebar (only one closing tag) ── --}}

    {{-- ── MAIN CONTENT ── --}}
    {{-- FIX 8: was <main class="main"> with no matching CSS --}}
    <main class="main-content">

        @if(session('success'))
            <div style="background:#DCFCE7;color:#15803D;border-radius:8px;padding:10px 16px;margin-bottom:16px;font-size:13px;font-weight:700;">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#FEE2E2;color:#B91C1C;border-radius:8px;padding:10px 16px;margin-bottom:16px;font-size:13px;font-weight:700;">
                ✕ {{ session('error') }}
            </div>
        @endif

        <div class="page-header">
            <div class="page-title">Products</div>
            <div class="page-subtitle">{{ $activeCount }} active product{{ $activeCount !== 1 ? 's' : '' }}</div>
        </div>

        {{-- Toolbar --}}
        <div class="toolbar">
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Search product…">
            </div>

            <select class="category-select" id="categoryFilter">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ strtolower($cat) }}">{{ $cat }}</option>
                @endforeach
            </select>

            {{-- FIX 9: Add Product now opens modal instead of href="#" --}}
            <button class="btn-add" onclick="openModal('addProductModal')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add Product
            </button>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <table class="products-table" id="productsTable">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Managed By</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="product-row"
                        data-name="{{ strtolower($product->name) }}"
                        data-category="{{ strtolower($product->category ?? '') }}">

                        <td class="td-name">{{ $product->name }}</td>
                        <td class="td-qty" style="font-weight:700;color:#5C2D0E;">₱{{ number_format($product->price, 2) }}</td>
                        <td class="td-qty">{{ $product->inventory_qty ?? '—' }}</td>
                        <td class="td-unit">{{ $product->inventory_unit ?? 'pcs' }}</td>
                        <td>
                            @php
                                $qty = $product->inventory_qty ?? null;
                            @endphp
                            @if(is_null($qty))
                                <span class="status-badge in">In Stock</span>
                            @elseif($qty <= 0)
                                <span class="status-badge out">Out of Stock</span>
                            @elseif($qty <= 5)
                                <span class="status-badge low">Low Stock</span>
                            @else
                                <span class="status-badge in">In Stock</span>
                            @endif
                        </td>
                        <td class="td-managed">
                            @php
                                $mb = trim($product->managed_by ?? '');
                                echo (empty($mb) || $mb === 'N/A' || $mb === 'N/A ')
                                    ? auth()->user()->name
                                    : $mb;
                            @endphp
                        </td>
                        <td class="td-updated">
                            {{ $product->product_updated_at ? \Carbon\Carbon::parse($product->product_updated_at)->format('M d, Y') : '—' }}
                        </td>
                        <td>
                            <div class="action-btns">
                                {{-- Edit: opens modal pre-filled with this product's data --}}
                                <button type="button" class="action-btn edit" title="Edit"
                                    onclick="openEditModal(
                                        {{ $product->id }},
                                        '{{ addslashes($product->name) }}',
                                        '{{ $product->price }}',
                                        '{{ $product->category }}',
                                        '{{ addslashes($product->description ?? '') }}'
                                    )">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>

                                {{-- Delete: opens styled confirmation modal --}}
                                <button type="button" class="action-btn delete" title="Delete"
                                    onclick="openDeleteModal(
                                        {{ $product->id }},
                                        '{{ addslashes($product->name) }}'
                                    )">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="8">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

</div>{{-- /.wrapper --}}


{{-- ── ADD PRODUCT MODAL ── --}}
<div id="addProductModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Add Product</div>
        <form method="POST" action="{{ route('manager.products.store') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group full">
                    <label>Product Name *</label>
                    <input type="text" name="name" placeholder="e.g. Tuna Sandwich" required>
                </div>
                <div class="form-group">
                    <label>Price (₱) *</label>
                    <input type="number" name="price" min="0" step="0.01" placeholder="e.g. 55" required>
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <option value="" disabled selected>Select category</option>
                        <option value="Sandwich">Sandwich</option>
                        <option value="Drinks">Drinks</option>
                        <option value="Sides">Sides</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Description</label>
                    <textarea name="description" rows="2" placeholder="Short product description…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('addProductModal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Product</button>
            </div>
        </form>
    </div>
</div>

{{-- ── EDIT PRODUCT MODAL ── --}}
<div id="editProductModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Edit Product</div>
        <form method="POST" id="editProductForm" action="">
            @csrf
            @method('PATCH')
            <div class="form-grid">
                <div class="form-group full">
                    <label>Product Name *</label>
                    <input type="text" name="name" id="edit-name" placeholder="e.g. Tuna Sandwich" required>
                </div>
                <div class="form-group">
                    <label>Price (₱) *</label>
                    <input type="number" name="price" id="edit-price" min="0" step="0.01" placeholder="e.g. 55" required>
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" id="edit-category" required>
                        <option value="Sandwich">Sandwich</option>
                        <option value="Drinks">Drinks</option>
                        <option value="Sides">Sides</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Description</label>
                    <textarea name="description" id="edit-description" rows="2" placeholder="Short product description…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editProductModal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- ── DELETE CONFIRMATION MODAL ── --}}
<div id="deleteProductModal" class="modal-overlay">
    <div class="modal-box" style="max-width:420px">
        <div style="text-align:center;margin-bottom:18px">
            <div style="width:52px;height:52px;background:#FEE2E2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#B91C1C" stroke-width="2" style="width:26px;height:26px">
                    <polyline points="3 6 5 6 21 6"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                </svg>
            </div>
            <div style="font-size:1.1rem;font-weight:900;color:var(--brown-dark);margin-bottom:6px">Delete Product</div>
            <div style="font-size:13px;color:var(--text-muted)">
                You are about to delete <strong id="delete-product-name" style="color:var(--brown-dark)"></strong>.
                <br>This cannot be undone.
            </div>
        </div>
        <form method="POST" id="deleteProductForm" action="">
            @csrf
            @method('DELETE')
            <div class="modal-footer" style="justify-content:center;gap:12px">
                <button type="button" class="btn-cancel" onclick="closeModal('deleteProductModal')">
                    Cancel
                </button>
                <button type="submit" class="btn-submit" style="background:#B91C1C">
                    Yes, Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // ── Search & Filter ──
    const searchInput    = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');

    function filterRows() {
        const query = searchInput.value.toLowerCase();
        const cat   = categoryFilter.value.toLowerCase();
        document.querySelectorAll('.product-row').forEach(row => {
            const nameMatch = row.dataset.name.includes(query);
            const catMatch  = !cat || row.dataset.category === cat;
            row.style.display = (nameMatch && catMatch) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterRows);
    categoryFilter.addEventListener('change', filterRows);

    // ── Modals ──
    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
    });

    // ── Edit Modal ──
    function openEditModal(id, name, price, category, description) {
        document.getElementById('editProductForm').action = '/manager/products/' + id;
        document.getElementById('edit-name').value        = name;
        document.getElementById('edit-price').value       = price;
        document.getElementById('edit-description').value = description;
        const catSelect = document.getElementById('edit-category');
        for (let opt of catSelect.options) {
            opt.selected = opt.value === category;
        }
        openModal('editProductModal');
    }

    // ── Delete Modal ──
    function openDeleteModal(id, name) {
        document.getElementById('deleteProductForm').action = '/manager/products/' + id;
        document.getElementById('delete-product-name').textContent = name;
        openModal('deleteProductModal');
    }
</script>
</body>
</html>