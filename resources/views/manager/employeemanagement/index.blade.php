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
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: var(--brown-dark);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 24px 14px 20px;
            z-index: 100;
        }

        /* Logo block */
        .sidebar-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
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
            color: var(--white);
            letter-spacing: 0.5px;
            text-align: center;
        }

        .sidebar-logo .manager-label {
            font-size: 11px;
            color: #C9A882;
            text-align: center;
            line-height: 1.4;
        }

        .manager-label span {
            color: var(--white);
            font-weight: 700;
        }

        /* Section headings */
        .nav-section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #C9A882;
            padding: 6px 8px 4px;
            margin-top: 6px;
        }

        /* Nav items */
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
            color: #F5E6D3;
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

        .sidebar-nav li a:hover {
            background: #7A3D18;
        }

        .sidebar-nav li a.active {
            background: #7A3D18;
            color: var(--white);
        }

        .sidebar-nav li a.active img {
            opacity: 1;
        }

        /* Logout button */
        .sidebar-logout {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid rgba(255,255,255,0.12);
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
            color: #F5E6D3;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.18s, border-color 0.18s;
            text-decoration: none;
        }

        .btn-logout img {
            width: 16px;
            height: 16px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            opacity: 0.85;
        }

        .btn-logout:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.45);
            color: var(--white);
        }

        /* ══════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════ */
        .main-content {
            margin-left: 220px;
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
            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                padding: 1.2rem;
            }
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

        <!-- Logo + Brand -->
        <div class="sidebar-logo">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="CPAMA Sandwich Logo" class="logo-img" />
            <div class="brand-name">CPAMA SANDWICH</div>
            <div class="manager-label">
                Manager: <span>{{ Auth::user()->name }}</span>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="nav-section-title">Main</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('manager.dashboard') }}">
                    <img src="{{ asset('images/dashboard_icon.png') }}" alt="Dashboard" />
                    Dashboard
                </a>
            </li>
        </ul>

        <!-- Catalog Navigation -->
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
                <a href="{{ route('manager.employees.index') }}" class="active">
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

        <!-- Logout -->
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


    <!-- MAIN CONTENT -->
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
                                data-barangay="{{ $emp->e_barangay }}"
                                data-address="{{ $emp->e_city }}"
                                data-contact="{{ $emp->e_contact_info }}"
                                data-status="{{ $emp->is_active ? '1' : '0' }}"
                                data-role="{{ $emp->roles->count() > 1 ? 'Seller & Baker' : $emp->roles->pluck('role_name')->first() }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editEmployeeModal">
                                <img src="{{ asset('images/edit_icon.png') }}" alt="Edit">
                            </button>
                            <button class="btn-action btn-archive-emp"
                                    data-id="{{ $emp->id }}"
                                    data-name="{{ $emp->employee_fn }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#archiveEmployeeModal">
                                <img src="{{ asset('images/archive_icon.png') }}" alt="Archive">
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
                            <label class="form-label">First Name</label>
                            <input type="text" name="employee_fn" class="form-control" placeholder="Enter first name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="employee_ln" class="form-control" placeholder="Enter last name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Barangay <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" name="e_barangay" class="form-control" placeholder="Enter barangay">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" name="e_city" class="form-control" placeholder="Enter city">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Number <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" name="e_contact_info" class="form-control" placeholder="e.g. 09XXXXXXXXX">
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
                            <select name="is_active" class="form-select" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
                            <label class="form-label">First Name</label>
                            <input type="text" id="edit_fn" name="employee_fn" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" id="edit_ln" name="employee_ln" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Barangay <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" id="edit_barangay" name="e_barangay" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" id="edit_city" name="e_city" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Number <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" id="edit_contact" name="e_contact_info" class="form-control">
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
                            <select id="edit_status" name="is_active" class="form-select" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
                document.getElementById('edit_fn').value      = this.dataset.fname;
                document.getElementById('edit_ln').value      = this.dataset.lname;
                document.getElementById('edit_barangay').value = this.dataset.barangay ?? '';
                document.getElementById('edit_city').value    = this.dataset.address;
                document.getElementById('edit_contact').value = this.dataset.contact;
                document.getElementById('edit_status').value  = this.dataset.status;
                document.getElementById('edit_role').value    = this.dataset.role;

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