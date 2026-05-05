<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - CPAMA Sandwich</title>
    <style>
        :root {
            --brown: #5D3A2E;
            --brown-dark: #3E2720;
            --amber: #F4A300;
            --main-bg: #FFFCF2;
            --accent-yellow: #FEF3C7;
            --btn-green: #008000;
            --btn-red: #FF4D4D;
            --sidebar-w: 260px;
        }

        body { font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; background: var(--main-bg); overflow-x: hidden; }

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
        
        /* ── MAIN CONTENT ── */
        .main-content { flex: 1; margin-left: var(--sidebar-w); padding: 40px; }
        .header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .search-bar { background: white; border: 1px solid #E5E7EB; border-radius: 10px; padding: 10px; width: 350px; display: flex; align-items: center; }
        .search-bar input { border: none; outline: none; margin-left: 10px; width: 100%; }

        .content-card { background: white; border: 1px solid #E5E7EB; border-radius: 15px; padding: 25px; min-height: 500px; position: relative; }
        .tabs { border-bottom: 2px solid #EEE; display: flex; gap: 30px; margin-bottom: 20px; }
        .tab { padding: 10px 5px; cursor: pointer; color: #999; font-weight: bold; border-bottom: 3px solid transparent; }
        .tab.active { color: #000; border-bottom-color: var(--brown); }

        .action-btn { position: absolute; right: 25px; top: 75px; padding: 10px 20px; border-radius: 8px; border: none; color: white; font-weight: bold; cursor: pointer; }

        table { width: 100%; border-collapse: collapse; margin-top: 50px; }
        th { background: var(--accent-yellow); padding: 15px; text-align: left; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #F3F4F6; font-size: 14px; }

        /* ── MODAL POPUPS ── */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; }
        .modal-content { background: var(--main-bg); padding: 30px; border-radius: 20px; width: 500px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .modal-header { font-size: 1.8rem; font-weight: 900; margin-bottom: 20px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group { display: flex; flex-direction: column; margin-bottom: 10px; }
        .form-group label { font-size: 0.85rem; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select, .form-group textarea { padding: 10px; border: 1px solid #DDD; border-radius: 8px; }
        .submit-btn { width: 100%; padding: 12px; border: none; border-radius: 8px; color: white; font-weight: bold; cursor: pointer; margin-top: 15px; }
        .cancel-btn { width: 100%; padding: 10px; background: none; border: none; color: #666; cursor: pointer; text-decoration: underline; margin-top: 5px; }
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
                <li><a href="{{ route('baker.inventorymanagement.index') }}" class="active"><img src="{{ asset('images/employee_inventory_icon.png') }}"> Inventory</a></li>
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

    <!-- Main -->
    <div class="main-content">
        <h1>Inventory Management</h1>

        <div class="header-row">
            <div class="search-bar">
                <img src="{{ asset('images/search_icon.png') }}" width="18">
                <input type="text" placeholder="search ingredient...">
            </div>
            <select style="padding: 10px; border-radius: 8px; border: 1px solid #DDD;">
                <option>All Categories</option>
                @foreach($categories as $cat) <option>{{ $cat }}</option> @endforeach
            </select>
        </div>

        <div class="content-card">
            <div class="tabs">
                <div class="tab active" onclick="showTab('inventory', this)">Inventory List</div>
                <div class="tab" onclick="showTab('stockin', this)">Stock In</div>
                <div class="tab" onclick="showTab('stockout', this)">Stock Out</div>
            </div>

            <!-- Tab 1: Inventory -->
            <div id="inventory-view" class="tab-view">
                <table>
                    <thead>
                        <tr><th>Inventory ID</th><th>Product Name</th><th>Qty</th><th>Unit</th><th>Status</th><th>Updated</th></tr>
                    </thead>
                    <tbody>
                        @foreach($inventories as $item)
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->updated_at->format('M d, H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab 2: Stock In -->
            <div id="stockin-view" class="tab-view" style="display:none;">
                <button class="action-btn" style="background:var(--brown);" onclick="openModal('stockInModal')">+ Add Stock</button>
                <table>
                    <thead>
                        <tr><th>Stock In ID</th><th>Employee</th><th>Product</th><th>Qty</th><th>Supplier</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @foreach($stockIns as $in)
                        <tr><td>#{{ $in->id }}</td><td>{{ $in->employee_id }}</td><td>{{ $in->product->name ?? 'N/A' }}</td><td>{{ $in->quantity }}</td><td>{{ $in->supplier }}</td><td>{{ $in->date }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab 3: Stock Out -->
            <div id="stockout-view" class="tab-view" style="display:none;">
                <button class="action-btn" style="background:var(--brown);" onclick="openModal('stockOutModal')">- Stock Out</button>
                <table>
                    <thead>
                        <tr><th>ID</th><th>Employee</th><th>Product</th><th>Qty</th><th>Reason</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @foreach($stockOuts as $out)
                        <tr><td>#{{ $out->id }}</td><td>{{ $out->employee_id }}</td><td>{{ $out->product->name ?? 'N/A' }}</td><td>{{ $out->quantity }}</td><td>{{ $out->reason }}</td><td>{{ $out->date }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Stock In[cite: 1] -->
    <div id="stockInModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">Stock In Form</div>
            <form action="{{ route('baker.inventory.storeStockIn') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group"><label>Employee ID</label><input type="text" name="employee_id" required></div>
                    <div class="form-group"><label>Quantity</label><input type="number" name="quantity" required></div>
                    <div class="form-group">
                        <label>Ingredient Name</label>
                        <select name="product_id" required>
                            @foreach($products as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>Date</label><input type="date" name="date" required></div>
                    <div class="form-group"><label>Supplier</label><input type="text" name="supplier"></div>
                    <div class="form-group"><label>Note</label><textarea name="note"></textarea></div>
                </div>
                <button type="submit" class="submit-btn" style="background:var(--btn-green);">Record Stock In</button>
                <button type="button" class="cancel-btn" onclick="closeModal('stockInModal')">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Modal: Stock Out[cite: 1] -->
    <div id="stockOutModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">Stock Out Form</div>
            <form action="{{ route('baker.inventory.storeStockOut') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group"><label>Employee ID</label><input type="text" name="employee_id" required></div>
                    <div class="form-group"><label>Quantity</label><input type="number" name="quantity" required></div>
                    <div class="form-group">
                        <label>Ingredient Name</label>
                        <select name="product_id" required>
                            @foreach($products as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>Date</label><input type="date" name="date" required></div>
                    <div class="form-group">
                        <label>Reason</label>
                        <select name="reason" required>
                            <option value="sold">Sold</option><option value="expired">Expired</option><option value="damaged">Damaged</option><option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Note</label><textarea name="note"></textarea></div>
                </div>
                <button type="submit" class="submit-btn" style="background:var(--btn-red);">Record Stock Out</button>
                <button type="button" class="cancel-btn" onclick="closeModal('stockOutModal')">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function showTab(tabName, el) {
            document.querySelectorAll('.tab-view').forEach(v => v.style.display = 'none');
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.getElementById(tabName + '-view').style.display = 'block';
            el.classList.add('active');
        }
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        window.onclick = function(event) { if (event.target.className === 'modal') { event.target.style.display = 'none'; } }
    </script>
</body>
</html>