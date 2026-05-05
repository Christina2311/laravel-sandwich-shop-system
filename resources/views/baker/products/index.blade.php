<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products – CPAMA Sandwich</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 210px;
            --brown:      #5C3D2E;
            --brown-dark: #3B2217;
            --amber:      #F0A500;
            --cream:      #FAF3E0;
            --card-shadow: 0 2px 10px rgba(0,0,0,.08);
            --radius: 12px;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--cream);
            display: flex;
            min-height: 100vh;
        }

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

        /* ── PAGE HEADER ── */
        .page-header {
            margin-bottom: 1.25rem;
        }
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

        /* ── TOOLBAR ── */
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
            font-family: 'Nunito', sans-serif;
            font-size: .85rem; font-weight: 600;
            color: #444; background: transparent;
            width: 100%;
        }
        .search-wrap input::placeholder { color: #bbb; }

        .category-select {
            appearance: none;
            -webkit-appearance: none;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23aaa' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right .75rem center;
            border: 1.5px solid #E5D9C8;
            border-radius: 8px;
            padding: .5rem 2.25rem .5rem .85rem;
            font-family: 'Nunito', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            color: #555;
            box-shadow: var(--card-shadow);
            cursor: pointer;
            outline: none;
        }
        .category-select:focus { border-color: var(--amber); }

        .btn-add {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--brown-dark);
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-size: .85rem;
            font-weight: 900;
            padding: .55rem 1.15rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background .18s;
        }
        .btn-add:hover { background: var(--brown); }
        .btn-add svg { width: 15px; height: 15px; }

        /* ── TABLE CARD ── */
        .table-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: 1.5px solid #EDE5D8;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table thead tr {
            background: #FDF5E4;
        }

        .products-table thead th {
            padding: .85rem 1rem;
            text-align: left;
            font-size: .78rem;
            font-weight: 900;
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
            font-size: .85rem;
            font-weight: 600;
            color: #444;
            vertical-align: middle;
        }

        .td-ingredient {
            font-weight: 900;
            color: var(--brown-dark);
        }

        .td-qty { font-weight: 700; color: #555; }
        .td-unit { color: #888; font-weight: 600; }

        /* Status badge */
        .status-badge {
            display: inline-block;
            font-size: .72rem;
            font-weight: 900;
            padding: .22rem .6rem;
            border-radius: 999px;
            letter-spacing: .3px;
        }
        .status-badge.in  { background: #DCFCE7; color: #15803D; }
        .status-badge.low { background: #FEF9C3; color: #854D0E; }
        .status-badge.out { background: #FEE2E2; color: #B91C1C; }

        .td-managed { color: #777; }
        .td-updated { color: #aaa; font-size: .8rem; }

        /* Action buttons */
        .action-btns { display: flex; gap: .4rem; }
        .action-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 7px;
            border: 1.5px solid #E5D9C8;
            background: #fff;
            cursor: pointer;
            transition: background .15s, border-color .15s;
            text-decoration: none;
        }
        .action-btn svg { width: 14px; height: 14px; }
        .action-btn.edit { color: var(--brown); }
        .action-btn.edit:hover { background: #FDF5E4; border-color: var(--amber); }
        .action-btn.delete { color: #B91C1C; }
        .action-btn.delete:hover { background: #FEE2E2; border-color: #FECACA; }

        /* Empty state */
        .empty-row td {
            text-align: center;
            padding: 3.5rem 1rem;
            color: #ccc;
            font-weight: 700;
            font-size: .9rem;
        }

        @media (max-width: 768px) {
            .toolbar { flex-wrap: wrap; }
            .search-wrap { flex: 1 1 100%; }
            .products-table thead th:nth-child(n+4),
            .products-table tbody td:nth-child(n+4) { display: none; }
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
                <li><a href="{{ route('baker.products') }}" class="active"><img src="{{ asset('images/products_icon.png') }}"> Products</a></li>
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

<!-- ── MAIN CONTENT ── -->
<main class="main">

    <div class="page-header">
        <div class="page-title">Products</div>
        <div class="page-subtitle">{{ $products->count() }} active products</div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="searchInput" placeholder="search product…">
        </div>

        <select class="category-select" id="categoryFilter">
            <option value="">All Categories</option>
            @foreach($products->pluck('category')->unique()->filter() as $cat)
                <option value="{{ strtolower($cat) }}">{{ $cat }}</option>
            @endforeach
        </select>

        <a href="#" class="btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Product
        </a>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <table class="products-table" id="productsTable">
            <thead>
                <tr>
                    <th>Ingredient</th>
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
                    <td class="td-ingredient">{{ $product->name }}</td>
                    <td class="td-qty">{{ $product->inventory_qty ?? '—' }}</td>
                    <td class="td-unit">{{ $product->inventory_unit ?? 'pcs' }}</td>
                    <td>
                        @if(isset($product->inventory_qty))
                            @if($product->inventory_qty <= 0)
                                <span class="status-badge out">Out of Stock</span>
                            @elseif($product->inventory_qty <= 5)
                                <span class="status-badge low">Low Stock</span>
                            @else
                                <span class="status-badge in">In Stock</span>
                            @endif
                        @else
                            <span class="status-badge in">In Stock</span>
                        @endif
                    </td>
                    <td class="td-managed">{{ $product->managed_by ?? auth()->user()->name }}</td>
                    <td class="td-updated">{{ $product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->format('M d, Y') : '—' }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="#" class="action-btn edit" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="#" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="7">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>

<script>
    const searchInput = document.getElementById('searchInput');
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
</script>
</body>
</html>