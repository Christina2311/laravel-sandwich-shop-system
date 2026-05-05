<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management - CPAMA Sandwich</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        /* ── Root Variables ── */
        :root {
            --brown-dark:  #5C2F0E;
            --brown-mid:   #7B3F1A;
            --brown-light: #A0522D;
            --cream:       #FDF6EC;
            --cream-dark:  #F5E6C8;
            --border:      #E0CBA8;
            --text-dark:   #2C1A0E;
            --text-muted:  #7A6655;
            --white:       #FFFFFF;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--cream);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* ══════════════════════════════════
           SIDEBAR
        ══════════════════════════════════ */
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: var(--brown-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 0 1rem;
            flex-shrink: 0;
        }

        .sidebar-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 0.6rem;
        }

        .sidebar-brand {
            color: var(--white);
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-align: center;
            line-height: 1.3;
        }

        .sidebar-manager {
            color: #D4A97A;
            font-size: 0.75rem;
            text-align: center;
            margin-top: 0.25rem;
            margin-bottom: 1.2rem;
            padding: 0 0.5rem;
        }

        .sidebar-divider {
            width: 80%;
            border: none;
            border-top: 1px solid rgba(255,255,255,0.15);
            margin: 0.5rem 0 0.8rem;
        }

        .sidebar-section-label {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            align-self: flex-start;
            padding-left: 1.2rem;
            margin-bottom: 0.4rem;
        }

        .sidebar-nav {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            padding: 0 0.8rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 0.9rem;
            border-radius: 7px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255,255,255,0.15);
            color: var(--white);
        }

        .sidebar-nav a img {
            width: 18px;
            height: 18px;
            filter: invert(1);
            opacity: 0.85;
        }

        .sidebar-logout {
            margin-top: auto;
            width: 100%;
            padding: 0 0.8rem;
        }

        .sidebar-logout a {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 0.9rem;
            border-radius: 7px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            border: 1px solid rgba(255,255,255,0.2);
            transition: background 0.15s;
        }

        .sidebar-logout a:hover {
            background: rgba(255,255,255,0.1);
            color: var(--white);
        }

        .sidebar-logout a img {
            width: 18px;
            height: 18px;
            filter: invert(1);
            opacity: 0.85;
        }

        /* ══════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════ */
        .main-content {
            flex: 1;
            padding: 2rem 2.5rem;
            overflow-y: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .btn-add-employee {
            background: var(--brown-dark);
            color: var(--white);
            border: none;
            border-radius: 6px;
            padding: 0.55rem 1.2rem;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-add-employee:hover {
            background: var(--brown-mid);
            color: var(--white);
        }

        .btn-add-employee img {
            width: 16px;
            height: 16px;
            filter: invert(1);
        }

        /* ── Summary Cards ── */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.2rem;
            margin-bottom: 1.8rem;
        }

        .summary-card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 1.2rem 1.5rem;
        }

        .summary-card-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .summary-card-label img {
            width: 20px;
            height: 20px;
        }

        .summary-card-count {
            font-size: 2.6rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
        }

        /* ── Controls ── */
        .controls-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 380px;
        }

        .search-wrapper img {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            opacity: 0.45;
            pointer-events: none;
        }

        .search-wrapper input {
            width: 100%;
            padding: 0.55rem 0.9rem 0.55rem 2.4rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            background: var(--white);
            font-size: 0.9rem;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.2s;
        }

        .search-wrapper input:focus        { border-color: var(--brown-light); }
        .search-wrapper input::placeholder { color: #BBA98A; }

        .filter-select {
            padding: 0.55rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            background: var(--white);
            font-size: 0.9rem;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus { border-color: var(--brown-light); }

        /* ── Table ── */
        .table-card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .emp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .emp-table thead tr       { background: var(--cream-dark); }
        .emp-table thead th {
            padding: 0.85rem 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            text-align: left;
            border-bottom: 1.5px solid var(--border);
            white-space: nowrap;
        }

        .emp-table tbody tr        { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        .emp-table tbody tr:last-child { border-bottom: none; }
        .emp-table tbody tr:hover  { background: #fdf0df; }
        .emp-table tbody td        { padding: 0.8rem 1.1rem; vertical-align: middle; }

        /* ── Badges ── */
        .badge-role {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.65rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            background: var(--cream-dark);
            color: var(--brown-dark);
        }

        .badge-role img { width: 14px; height: 14px; }

        .badge-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-active   { background: #D4EDDA; color: #155724; }
        .badge-inactive { background: #F8D7DA; color: #721C24; }
        .badge-on-leave { background: #FFF3CD; color: #856404; }

        /* ── Action Buttons ── */
        .btn-action {
            border: none;
            background: transparent;
            cursor: pointer;
            padding: 0.3rem 0.45rem;
            border-radius: 5px;
            transition: background 0.15s;
        }

        .btn-action:hover { background: var(--cream-dark); }
        .btn-action img   { width: 18px; height: 18px; }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 3.5rem 1rem;
            color: var(--text-muted);
        }

        .empty-state img {
            width: 48px;
            height: 48px;
            opacity: 0.35;
            margin-bottom: 0.75rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-state p { font-size: 0.95rem; }

        /* ── Modals ── */
        .modal-header-brown {
            background: var(--brown-dark);
            color: var(--white);
            border-bottom: none;
            border-radius: 10px 10px 0 0 !important;
        }

        .modal-header-brown .btn-close { filter: invert(1); }
        .modal-content  { border-radius: 10px; border: none; }
        .modal-footer   { border-top: 1px solid var(--border); }
        .form-label     { font-weight: 600; font-size: 0.88rem; color: var(--text-dark); }

        .form-control,
        .form-select {
            border: 1.5px solid var(--border);
            border-radius: 7px;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--brown-light);
            box-shadow: 0 0 0 0.15rem rgba(139,69,19,0.15);
        }

        .btn-save {
            background: var(--brown-dark);
            color: var(--white);
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1.3rem;
            font-weight: 600;
        }

        .btn-save:hover { background: var(--brown-mid); color: var(--white); }

        .btn-cancel-modal {
            background: var(--cream-dark);
            color: var(--text-dark);
            border: 1.5px solid var(--border);
            border-radius: 6px;
            padding: 0.5rem 1.3rem;
            font-weight: 600;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { width: 60px; padding: 1rem 0; }
            .sidebar-brand,
            .sidebar-manager,
            .sidebar-section-label,
            .sidebar-nav a span { display: none; }
            .sidebar-nav a { justify-content: center; padding: 0.6rem; }
            .main-content { padding: 1.2rem; }
            .summary-grid { grid-template-columns: 1fr; }
            .controls-bar { flex-direction: column; align-items: stretch; }
            .search-wrapper { max-width: 100%; }
        }
    </style>
</head>
<body>

    <!-- ══════════════════════════════
         SIDEBAR
    ══════════════════════════════ -->
    <aside class="sidebar">
        <img src="{{ asset('images/sandwich_logo.png') }}" alt="CPAMA Logo" class="sidebar-logo">
        <div class="sidebar-brand">CPAMA SANDWICH</div>
        <div class="sidebar-manager">Manager: {{ auth()->user()->name ?? 'Chrisha Velasquez' }}</div>

        <hr class="sidebar-divider">
        <div class="sidebar-section-label">Main</div>
        <nav class="sidebar-nav">
            <a href="{{ route('manager.dashboard') }}">
                <img src="{{ asset('images/dashboard_icon.png') }}" alt="">
                <span>Dashboard</span>
            </a>
        </nav>

        <hr class="sidebar-divider">
        <div class="sidebar-section-label">Catalog</div>
        <nav class="sidebar-nav">
            <a href="#">
                <img src="{{ asset('images/manager_inventory_icon.png') }}" alt="">
                <span>Inventory</span>
            </a>
            <a href="#">
                <img src="{{ asset('images/products_icon.png') }}" alt="">
                <span>Products</span>
            </a>
            <a href="{{ route('manager.employees.index') }}" class="active">
                <img src="{{ asset('images/employee_management_icon.png') }}" alt="">
                <span>Employee Management</span>
            </a>
            <a href="#">
                <img src="{{ asset('images/reports_icon.png') }}" alt="">
                <span>Reports</span>
            </a>
        </nav>

        <div class="sidebar-logout">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="{{ asset('images/logout_icon.png') }}" alt="">
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </aside>


    <!-- ══════════════════════════════
         MAIN CONTENT
    ══════════════════════════════ -->
    <main class="main-content">

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Employee Management</h1>
            <button class="btn-add-employee" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <img src="{{ asset('images/employee_management_icon.png') }}" alt="">
                + Add Employee
            </button>
        </div>

        <!-- Summary Cards -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-card-label">
                    <img src="{{ asset('images/manager_icon.png') }}" alt="Manager">
                    Manager
                </div>
                <div class="summary-card-count">{{ $managerCount ?? 0 }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-label">
                    <img src="{{ asset('images/seller_baker_icon.png') }}" alt="Seller">
                    Seller
                </div>
                <div class="summary-card-count">{{ $sellerCount ?? 0 }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-label">
                    <img src="{{ asset('images/seller_baker_icon.png') }}" alt="Baker">
                    Baker
                </div>
                <div class="summary-card-count">{{ $bakerCount ?? 0 }}</div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="controls-bar">
            <div class="search-wrapper">
                <img src="{{ asset('images/search_icon.png') }}" alt="Search">
                <input type="text" id="employeeSearch" placeholder="search employee...">
            </div>
            <select class="filter-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="on-leave">On Leave</option>
            </select>
        </div>

        <!-- Table -->
        <div class="table-card">
            <table class="emp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee Name</th>
                        <th>Address</th>
                        <th>Contact No.</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    @forelse($employees as $emp)
                    <tr data-name="{{ strtolower($emp->employee_fn) }}" data-status="{{ $emp->is_active ? 'active' : 'inactive' }}">
                        <td>{{ $emp->id }}</td>
                        <td>{{ $emp->employee_fn }} {{ $emp->employee_ln }}</td>
                        <td>{{ $emp->e_city ?? 'Quezon City' }}</td>
                        <td>{{ $emp->e_contact_info }}</td>
                        <td>
                            @php
                                $roleNames = $emp->roles->pluck('role_name')->map(fn($r) => ucfirst(strtolower($r)))->toArray();
                                $roleLabel = count($roleNames) > 1 ? implode(' & ', $roleNames) : ($roleNames[0] ?? 'N/A');
                            @endphp
                            <span class="badge-role">
                                {{ $roleLabel }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status {{ $emp->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $emp->is_active ? 'Active' : 'Inactive (Archived)' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn-action btn-edit-emp"
                                data-id="{{ $emp->id }}"
                                data-fname="{{ $emp->employee_fn }}"
                                data-lname="{{ $emp->employee_ln }}"
                                data-address="{{ $emp->e_city }}"
                                data-contact="{{ $emp->e_contact_info }}"
                                data-status="{{ $emp->is_active ? 'active' : 'inactive' }}"
                                data-role="{{ $emp->roles->count() > 1 ? 'Seller & Baker' : $emp->roles->pluck('role_name')->first() }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editEmployeeModal">
                                <img src="{{ asset('images/visibility_icon.png') }}" alt="Edit">
                            </button>
                            <button class="btn-action btn-archive-emp"
                                    data-id="{{ $emp->id }}"
                                    data-name="{{ $emp->employee_fn }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#archiveEmployeeModal">
                                <img src="{{ asset('images/download_icon.png') }}" alt="Archive">
                            </button>
                        </td>
                    </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="7">
                                <div class="empty-state">
                                    <img src="{{ asset('images/employee_management_icon.png') }}" alt="">
                                    <p>No employees found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($employees) && method_exists($employees, 'links'))
            <div class="mt-4 d-flex justify-content-center">
                {{ $employees->links() }}
            </div>
        @endif

    </main>


    <!-- ══════════════════════════════
         ADD EMPLOYEE MODAL
    ══════════════════════════════ -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-brown">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('manager.employees.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter address" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" placeholder="e.g. 09XXXXXXXXX" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="" disabled selected>Select role</option>
                                <option value="Manager">Manager</option>
                                <option value="Seller">Seller</option>
                                <option value="Baker">Baker</option>
                                <option value="Seller & Baker">Seller &amp; Baker</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="on-leave">On Leave</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="email" name="email" class="form-control" placeholder="employee@email.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to auto-generate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel-modal" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">Save Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════
         EDIT EMPLOYEE MODAL
    ══════════════════════════════ -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-brown">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="editEmployeeForm" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" id="edit_name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" id="edit_address" name="address" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" id="edit_contact" name="contact_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select id="edit_role" name="role" class="form-select" required>
                                <option value="Manager">Manager</option>
                                <option value="Seller">Seller</option>
                                <option value="Baker">Baker</option>
                                <option value="Seller & Baker">Seller &amp; Baker</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select id="edit_status" name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="on-leave">On Leave</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel-modal" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">Update Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════
         Archive CONFIRM MODAL
    ══════════════════════════════ -->
    <div class="modal fade" id="archiveEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--brown-dark); border-radius: 10px 10px 0 0;">
                    <h5 class="modal-title text-white">Archive Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p>Archive <strong><span id="archive_name_label"></span></strong>?</p>
                    <p class="text-muted" style="font-size:.82rem;">This will set the status to Inactive.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <form method="POST" id="archiveEmployeeForm" action="">
                        @csrf
                        @method('PATCH') <!-- Use PATCH for updates[cite: 2] -->
                        <button type="button" class="btn btn-cancel-modal me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Archive</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ── Live Search + Status Filter ── */
        const searchInput  = document.getElementById('employeeSearch');
        const statusFilter = document.getElementById('statusFilter');
        const tableBody    = document.getElementById('employeeTableBody');

        function filterTable() {
            const query  = searchInput.value.toLowerCase().trim();
            const status = statusFilter.value.toLowerCase();
            const rows   = tableBody.querySelectorAll('tr[data-name]');
            let visible  = 0;

            rows.forEach(row => {
                const nameMatch   = row.dataset.name.includes(query);
                const statusMatch = !status || row.dataset.status === status;
                const show        = nameMatch && statusMatch;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            let noResultRow = document.getElementById('noResultRow');
            if (visible === 0) {
                if (!noResultRow) {
                    noResultRow = document.createElement('tr');
                    noResultRow.id = 'noResultRow';
                    noResultRow.innerHTML = `
                        <td colspan="7">
                            <div class="empty-state">
                                <img src="{{ asset('images/employee_management_icon.png') }}" alt="">
                                <p>No employees match your search.</p>
                            </div>
                        </td>`;
                    tableBody.appendChild(noResultRow);
                } else {
                    noResultRow.style.display = '';
                }
            } else if (noResultRow) {
                noResultRow.style.display = 'none';
            }
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);


        /* ── Edit Modal: populate fields ── */
        document.querySelectorAll('.btn-edit-emp').forEach(btn => {
            btn.addEventListener('click', function () {
                // Map the data-fname and data-lname to the Full Name field[cite: 3, 8]
                document.getElementById('edit_name').value = this.dataset.fname + ' ' + this.dataset.lname;
                document.getElementById('edit_address').value = this.dataset.address;
                document.getElementById('edit_contact').value = this.dataset.contact;
                document.getElementById('edit_status').value = this.dataset.status;
                document.getElementById('edit_role').value = this.dataset.role;

                const id = this.dataset.id;
                document.getElementById('editEmployeeForm').action = `/manager/employees/${id}`;
            });
        });

        /* ── Archive Modal: populate action ── */
        document.querySelectorAll('.btn-archive-emp').forEach(btn => {
            btn.addEventListener('click', function () {
                const id      = this.dataset.id;
                const name    = this.dataset.name;
                const baseUrl = "{{ url('manager/employees') }}";

                document.getElementById('archive_name_label').textContent = name;
                document.getElementById('archiveEmployeeForm').action = `${baseUrl}/${id}`;
            });
        });

    });
    </script>

</body>
</html>