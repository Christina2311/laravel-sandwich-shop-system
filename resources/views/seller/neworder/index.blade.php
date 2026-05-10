<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>New Order – CPAMA Sandwich</title>

    {{-- Bootstrap 5 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    />

    <style>
        /* ── Root palette (matches screenshot) ───────────────────────── */
        :root {
            --sidebar-bg:      #5a2d0c;
            --sidebar-hover:   #7a3e1a;
            --sidebar-active:  #3d1c06;
            --sidebar-text:    #f5e6d3;
            --sidebar-muted:   #c4a07a;
            --brand-brown:     #5a2d0c;
            --brand-green:     #2e7d32;
            --brand-green-h:   #1b5e20;
            --btn-cancel-bg:   #f5f0e8;
            --btn-cancel-txt:  #5a2d0c;
            --card-radius:     14px;
            --input-radius:    8px;
            --font-main:       'Segoe UI', system-ui, sans-serif;
        }

        /* ── Layout ───────────────────────────────────────────────────── */
        html, body { height: 100%; margin: 0; font-family: var(--font-main); background: #f7f3ee; }

        .wrapper { display: flex; min-height: 100vh; }

        /* ── Sidebar ──────────────────────────────────────────────────── */
        .sidebar {
            width: 200px;
            min-width: 200px;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            padding: 0;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 22px 16px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand img {
            width: 300px;
            height: 160px;
            border-radius: 0;
            padding: 0;
        }

        .sidebar-brand .brand-name {
            color: #fff;
            font-weight: 700;
            font-size: 0.82rem;
            text-align: center;
            margin-top: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-brand .cashier-name {
            color: var(--sidebar-muted);
            font-size: 0.73rem;
            text-align: center;
            margin-top: 2px;
        }

        .sidebar-nav { flex: 1; padding: 14px 10px; }

        .sidebar-section-label {
            color: var(--sidebar-muted);
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 8px 4px;
            font-weight: 600;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--sidebar-text);
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.83rem;
            margin-bottom: 2px;
            transition: background 0.15s;
        }

        .sidebar-nav a:hover   { background: var(--sidebar-hover); }
        .sidebar-nav a.active  { background: var(--sidebar-active); font-weight: 600; }
        .sidebar-nav a i       { font-size: 1rem; flex-shrink: 0; }

        .sidebar-footer {
            padding: 14px 10px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-footer form button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 9px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: var(--sidebar-text);
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.83rem;
            cursor: pointer;
            transition: background 0.15s;
        }

        .sidebar-footer form button:hover { background: var(--sidebar-hover); }

        /* ── Main content ─────────────────────────────────────────────── */
        .main-content { flex: 1; padding: 32px 36px; overflow-y: auto; }

        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 24px;
        }

        /* ── Cards ────────────────────────────────────────────────────── */
        .order-card {
            background: #fff;
            border-radius: var(--card-radius);
            padding: 28px 28px 20px;
            border: 1px solid #e8ddd0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .card-section-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 20px;
        }

        /* ── Form inputs ──────────────────────────────────────────────── */
        .form-control, .form-select {
            border-radius: var(--input-radius) !important;
            border-color: #d5c9b8 !important;
            font-size: 0.875rem;
            color: #333;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand-brown) !important;
            box-shadow: 0 0 0 3px rgba(90,45,12,0.1) !important;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        /* ── Order items ──────────────────────────────────────────────── */
        .item-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #f0e8dc;
        }

        .item-row:last-of-type { border-bottom: none; }

        /* Clickable product pick area (thumb + name) */
        .item-pick-area {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 2;
            min-width: 0;
            cursor: pointer;
            border: 1.5px dashed #d5c9b8;
            border-radius: 10px;
            padding: 6px 12px 6px 8px;
            transition: border-color 0.15s, background 0.15s;
            background: #faf7f3;
            user-select: none;
        }

        .item-pick-area:hover {
            border-color: var(--brand-brown);
            background: #f5ede0;
        }

        .item-pick-area.has-product {
            border-style: solid;
            border-color: #e8ddd0;
            background: #fff;
        }

        .item-pick-area.has-product:hover {
            border-color: var(--brand-brown);
            background: #faf7f3;
        }

        .item-name-display {
            flex: 1;
            min-width: 0;
            font-size: 0.875rem;
            font-weight: 600;
            color: #aaa;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .item-name-display.selected {
            color: #1a1a1a;
        }

        .item-pick-icon {
            font-size: 0.8rem;
            color: #bbb;
            flex-shrink: 0;
        }

        .item-pick-area:hover .item-pick-icon { color: var(--brand-brown); }

        .item-row .qty-input {
            width: 70px;
            min-width: 60px;
            text-align: center;
        }

        .item-price-display {
            min-width: 80px;
            text-align: right;
            font-size: 0.875rem;
            font-weight: 600;
            color: #333;
            white-space: nowrap;
        }

        .btn-remove-item {
            background: none;
            border: none;
            color: #999;
            padding: 4px 6px;
            cursor: pointer;
            border-radius: 6px;
            transition: color 0.15s, background 0.15s;
            line-height: 1;
        }

        .btn-remove-item:hover { color: #c0392b; background: #fde8e6; }

        /* ── Item row thumbnail ───────────────────────────────────────── */
        .item-thumb {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e8ddd0;
            flex-shrink: 0;
            background: #f5f0e8;
        }

        .item-thumb-placeholder {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            border: 1px dashed #d5c9b8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #bbb;
            font-size: 1.1rem;
            flex-shrink: 0;
            background: #faf7f3;
        }

        /* ── Product Picker Modal ─────────────────────────────────────── */
        .picker-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(30,15,5,0.55);
            backdrop-filter: blur(3px);
            z-index: 1050;
            align-items: center;
            justify-content: center;
        }
        .picker-backdrop.open { display: flex; }

        .picker-modal {
            background: #faf7f3;
            border-radius: 20px;
            width: min(860px, 95vw);
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0,0,0,0.28);
            overflow: hidden;
        }

        .picker-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 16px;
            border-bottom: 1px solid #e8ddd0;
            background: #fff;
        }

        .picker-header h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }

        .picker-close {
            background: #f5f0e8;
            border: none;
            font-size: 1.3rem;
            color: #888;
            cursor: pointer;
            line-height: 1;
            padding: 4px 10px 6px;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }
        .picker-close:hover { background: #ede4d8; color: #333; }

        .picker-search-wrap {
            padding: 14px 24px 12px;
            background: #fff;
            border-bottom: 1px solid #ede4d8;
        }

        .picker-search {
            width: 100%;
            border: 1.5px solid #d5c9b8;
            border-radius: 10px;
            padding: 9px 16px;
            font-size: 0.875rem;
            outline: none;
            color: #333;
            background: #faf7f3;
        }
        .picker-search:focus { border-color: var(--brand-brown); box-shadow: 0 0 0 3px rgba(90,45,12,0.1); background: #fff; }

        .picker-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 16px;
            padding: 20px 24px 28px;
            overflow-y: auto;
            flex: 1;
        }

        /* ── Food Menu Card ───────────────────────────────────────────── */
        .product-card {
            border-radius: 18px;
            cursor: pointer;
            background: #fff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
            border: 2px solid transparent;
            transition: transform 0.18s cubic-bezier(.34,1.56,.64,1),
                        box-shadow 0.18s ease,
                        border-color 0.15s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-4px) scale(1.015);
            box-shadow: 0 12px 32px rgba(90,45,12,0.18);
            border-color: var(--brand-brown);
        }

        .product-card:focus-visible {
            outline: 3px solid var(--brand-brown);
            outline-offset: 2px;
        }

        /* Photo area */
        .product-card-img-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 4/3;
            overflow: hidden;
            background: #f0ebe3;
        }

        .product-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-card-img-wrap img {
            transform: scale(1.06);
        }

        .product-card-img-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5ede0 0%, #e8d9c4 100%);
            color: #c4a07a;
            font-size: 3rem;
        }

        /* Info row */
        .product-card-body {
            padding: 11px 14px 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .product-card-info { flex: 1; min-width: 0; }

        .product-card-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.25;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card:hover .product-card-name { white-space: normal; }

        .product-card-price {
            font-size: 0.92rem;
            font-weight: 800;
            color: var(--brand-brown);
            letter-spacing: -0.3px;
        }

        /* "+" add button */
        .product-card-add {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--brand-brown);
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
            transition: background 0.15s, transform 0.15s;
            line-height: 1;
            box-shadow: 0 2px 8px rgba(90,45,12,0.35);
        }

        .product-card-add:hover {
            background: var(--brand-green);
            transform: scale(1.15) rotate(90deg);
        }

        .picker-no-results {
            grid-column: 1/-1;
            text-align: center;
            color: #aaa;
            font-size: 0.9rem;
            padding: 40px 0;
        }

        /* ── Add Item button ──────────────────────────────────────────── */
        .btn-add-item {
            background: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 0.83rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-add-item:hover { background: #333; }

        /* ── Summary card ─────────────────────────────────────────────── */
        .summary-card {
            background: #fff;
            border-radius: var(--card-radius);
            padding: 28px;
            border: 1px solid #e8ddd0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            position: sticky;
            top: 20px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px 12px;
            font-size: 0.8rem;
            color: #777;
            margin-bottom: 18px;
        }

        .summary-grid .label { font-weight: 500; }
        .summary-grid .value { color: #333; font-weight: 600; }

        .summary-totals { border-top: 1px solid #ece4d8; padding-top: 14px; }

        .summary-line {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: #555;
            margin-bottom: 6px;
        }

        .summary-line.total-line {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 2px solid #1a1a1a;
        }

        /* ── Action buttons ───────────────────────────────────────────── */
        .btn-submit {
            width: 100%;
            background: var(--brand-green);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s;
            margin-top: 18px;
        }

        .btn-submit:hover { background: var(--brand-green-h); }

        .btn-cancel-order {
            width: 100%;
            background: var(--btn-cancel-bg);
            color: var(--btn-cancel-txt);
            border: 1px solid #d5c9b8;
            border-radius: 10px;
            padding: 11px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            margin-top: 8px;
        }

        .btn-cancel-order:hover { background: #ede4d8; }

        /* ── Payment method radios ────────────────────────────────────── */
        .payment-method-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .pm-option {
            flex: 1;
            min-width: 80px;
        }

        .pm-option input[type="radio"] { display: none; }

        .pm-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 12px;
            border: 1.5px solid #d5c9b8;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #555;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s, color 0.15s;
            user-select: none;
        }

        .pm-option input[type="radio"]:checked + .pm-label {
            border-color: var(--brand-brown);
            background: rgba(90,45,12,0.06);
            color: var(--brand-brown);
        }

        .pm-label i { font-size: 1rem; }

        /* ── Alerts ───────────────────────────────────────────────────── */
        .flash-alert {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ───────────────────────────────────────────────── */
        @media (max-width: 900px) {
            .sidebar { display: none; }
            .main-content { padding: 20px 16px; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- ══════════════ SIDEBAR ══════════════ --}}
    <aside class="sidebar">

        <div class="sidebar-brand">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="Logo">
            <span class="brand-name">CPAMA SANDWICH</span>
            <span class="cashier-name">Seller: {{ auth()->user()->name }}</span>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Main</div>
            <a href="{{ route('seller.dashboard') }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a href="{{ route('seller.neworder.index') }}" class="active">
                <i class="bi bi-bag-plus-fill"></i> New Orders
            </a>

            @if(auth()->user()->hasRole('baker'))
                <div class="sidebar-section-label" style="margin-top:10px;">Switch Role</div>
                <a href="{{ route('baker.queue') }}">
                    <i class="bi bi-people-fill"></i> Go to Baker
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ══════════════════════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════════════════════ --}}
    <main class="main-content">

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible flash-alert" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible flash-alert" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h1 class="page-title">New Order</h1>

        <form method="POST" action="{{ route('seller.neworder.store') }}" id="orderForm">
            @csrf
            <div class="row g-4 align-items-start">

                {{-- ── Left: Order Details ──────────────────────────────── --}}
                <div class="col-lg-7 col-md-12">
                    <div class="order-card">
                        <div class="card-section-title">Order Details</div>

                        {{-- Customer name --}}
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label">First Name</label>
                                <input
                                    type="text"
                                    name="customer_fn"
                                    class="form-control"
                                    placeholder="Customer's First Name"
                                    value="{{ old('customer_fn') }}"
                                />
                            </div>
                            <div class="col-6">
                                <label class="form-label">Last Name</label>
                                <input
                                    type="text"
                                    name="customer_ln"
                                    class="form-control"
                                    placeholder="Customer's Last Name"
                                    value="{{ old('customer_ln') }}"
                                />
                            </div>
                        </div>

                        {{-- Phone & Order Date --}}
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label">Phone No. <span class="text-muted fw-normal">(Optional)</span></label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    placeholder="09123456789"
                                    value="{{ old('phone') }}"
                                />
                            </div>
                            <div class="col-6">
                                <label class="form-label">Order Date <span class="text-danger">*</span></label>
                                <input
                                    type="date"
                                    name="order_date"
                                    class="form-control"
                                    value="{{ old('order_date', date('Y-m-d')) }}"
                                    required
                                />
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="form-label">Email <span class="text-muted fw-normal">(Optional)</span></label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="example@gmail.com"
                                    value="{{ old('email') }}"
                                />
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="mb-4">
                            <label class="form-label">Address <span class="text-muted fw-normal">(Optional)</span></label>
                            <textarea
                                name="address"
                                class="form-control"
                                rows="3"
                                placeholder="Purok – 22 – A"
                            >{{ old('address') }}</textarea>
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-4">
                            <label class="form-label">Payment Method</label>
                            <div class="payment-method-group">
                                <div class="pm-option">
                                    <input type="radio" name="payment_method" id="pm_cash" value="Cash" checked>
                                    <label class="pm-label" for="pm_cash">
                                        <i class="bi bi-cash-coin"></i> Cash
                                    </label>
                                </div>
                                <div class="pm-option">
                                    <input type="radio" name="payment_method" id="pm_gcash" value="GCash">
                                    <label class="pm-label" for="pm_gcash">
                                        <i class="bi bi-phone-fill"></i> GCash
                                    </label>
                                </div>
                                <div class="pm-option">
                                    <input type="radio" name="payment_method" id="pm_card" value="Card">
                                    <label class="pm-label" for="pm_card">
                                        <i class="bi bi-credit-card-fill"></i> Bank Transfer
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Add Item button --}}
                        <div class="mb-3">
                            <button type="button" class="btn-add-item" id="addItemBtn">
                                <i class="bi bi-plus-lg"></i> Add Item
                            </button>
                        </div>

                        {{-- Order items list --}}
                        <div id="itemsContainer">
                            {{-- Default first row --}}
                            <div class="item-row" data-index="0">
                                <input type="hidden" name="items[0][product_id]" class="product-id-input" value="">
                                <div class="item-pick-area" title="Click to choose a product">
                                    <div class="item-thumb-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                    <span class="item-name-display">Tap to choose a product…</span>
                                    <i class="bi bi-chevron-right item-pick-icon"></i>
                                </div>
                                <input
                                    type="number"
                                    name="items[0][quantity]"
                                    class="form-control qty-input"
                                    value="1"
                                    min="1"
                                    placeholder="0"
                                    required
                                />
                                <span class="item-price-display">₱0.00</span>
                                <button type="button" class="btn-remove-item" title="Remove item">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Right: Order Summary ─────────────────────────────── --}}
                <div class="col-lg-5 col-md-12">
                    <div class="summary-card">
                        <div class="card-section-title">Order Summary</div>

                        <div class="summary-grid">
                            <span class="label">Payment ID:</span>
                            <span class="value" id="summaryPaymentId">—</span>

                            <span class="label">Date:</span>
                            <span class="value" id="summaryDate">{{ date('m/d/Y') }}</span>

                            <span class="label">Order ID:</span>
                            <span class="value">#<span id="summaryOrderId">—</span></span>

                            <span class="label">Product Name:</span>
                            <span class="value" id="summaryProductName">—</span>

                            <span class="label">Payment Method:</span>
                            <span class="value" id="summaryPaymentMethod">Cash</span>

                            <span class="label">Transaction ID:</span>
                            <span class="value" id="summaryTxId">—</span>
                        </div>
                        {{-- Hidden field for payment_method carried into summary --}}
                        <input type="hidden" name="payment_method_hidden" id="paymentMethodHidden" value="Cash">

                        <div class="summary-totals">
                            <div class="summary-line">
                                <span>Subtotal:</span>
                                <span id="summarySubtotal">₱0.00</span>
                            </div>
                            <div class="summary-line">
                                <span>Tax (12%):</span>
                                <span id="summaryTax">₱0.00</span>
                            </div>
                            <div class="summary-line total-line">
                                <span>Total:</span>
                                <span id="summaryTotal">₱0.00</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="bi bi-printer me-1"></i> Print and Send to Baker
                        </button>

                        <button type="button" class="btn-cancel-order"
                            onclick="if(confirm('Discard this order?')) document.getElementById('orderForm').reset(); location.reload();">
                            Cancel
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </main>

    {{-- ══════════════════════════════════════════════════════════════════
         PRODUCT PICKER MODAL
    ══════════════════════════════════════════════════════════════════ --}}
    <div class="picker-backdrop" id="productPickerBackdrop" role="dialog" aria-modal="true" aria-labelledby="pickerTitle">
        <div class="picker-modal">
            <div class="picker-header">
                <h5 id="pickerTitle">
                    <i class="bi bi-bag-heart-fill me-2" style="color:var(--brand-brown);"></i>
                    Select a Product
                </h5>
                <button class="picker-close" id="pickerCloseBtn" aria-label="Close">&times;</button>
            </div>
            <div class="picker-search-wrap">
                <input type="text" class="picker-search" id="pickerSearch"
                       placeholder="&#x1F50D;  Search sandwiches…" autocomplete="off">
            </div>
            <div class="picker-grid" id="pickerGrid">
                @foreach ($products as $product)
                    <div class="product-card"
                         data-product-id="{{ $product->id }}"
                         data-product-name="{{ $product->name }}"
                         data-product-price="{{ $product->price }}"
                         data-product-image="{{ $product->image ?? '' }}"
                         role="button"
                         tabindex="0"
                    >
                        <div class="product-card-img-wrap">
                            @if (!empty($product->image))
                                <img src="{{ asset('images/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     loading="lazy"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                <div class="product-card-img-placeholder" style="display:none;">
                                    <i class="bi bi-egg-fried"></i>
                                </div>
                            @else
                                <div class="product-card-img-placeholder">
                                    <i class="bi bi-egg-fried"></i>
                                </div>
                            @endif
                        </div>
                        <div class="product-card-body">
                            <div class="product-card-info">
                                <div class="product-card-name">{{ $product->name }}</div>
                                <div class="product-card-price">₱{{ number_format($product->price, 2) }}</div>
                            </div>
                            <button class="product-card-add" tabindex="-1" aria-label="Add {{ $product->name }}">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════════════════
     Bootstrap JS
══════════════════════════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ── Product data passed from PHP ─────────────────────────────────── */
    const PRODUCTS = @json($products->keyBy('id'));
    const IMAGES_BASE = "{{ asset('images') }}/";
    const TAX_RATE = 0.12;

    let itemIndex = 1;

    /* ── Generate reference IDs ───────────────────────────────────────── */
    function generateId(prefix, length) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = prefix;
        for (let i = 0; i < length; i++) result += chars.charAt(Math.floor(Math.random() * chars.length));
        return result;
    }
    const SESSION_PAYMENT_ID = generateId('PAY-', 8);
    const SESSION_ORDER_ID   = generateId('', 6);
    const SESSION_TX_ID      = generateId('TXN-', 10);
    document.getElementById('summaryPaymentId').textContent = SESSION_PAYMENT_ID;
    document.getElementById('summaryOrderId').textContent   = SESSION_ORDER_ID;
    document.getElementById('summaryTxId').textContent      = SESSION_TX_ID;

    /* ── Payment method sync ──────────────────────────────────────────── */
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('summaryPaymentMethod').textContent = this.value;
            document.getElementById('paymentMethodHidden').value = this.value;
        });
    });

    /* ── Thumb helpers ────────────────────────────────────────────────── */
    function makePlaceholderThumb() {
        const ph = document.createElement('div');
        ph.className = 'item-thumb-placeholder';
        ph.innerHTML = '<i class="bi bi-image"></i>';
        return ph;
    }

    function setRowProduct(row, p) {
        const hiddenInput  = row.querySelector('.product-id-input');
        const nameDisplay  = row.querySelector('.item-name-display');
        const pickArea     = row.querySelector('.item-pick-area');
        const existing     = row.querySelector('.item-thumb, .item-thumb-placeholder');

        hiddenInput.value = p ? p.id : '';

        if (p) {
            nameDisplay.textContent = p.name;
            nameDisplay.classList.add('selected');
            pickArea.classList.add('has-product');

            // Thumbnail
            if (p.image) {
                const img = document.createElement('img');
                img.className = 'item-thumb';
                img.alt = p.name;
                img.src = IMAGES_BASE + p.image;
                img.onerror = () => img.replaceWith(makePlaceholderThumb());
                existing.replaceWith(img);
            }
        } else {
            nameDisplay.textContent = 'Tap to choose a product…';
            nameDisplay.classList.remove('selected');
            pickArea.classList.remove('has-product');
            if (existing && existing.tagName === 'IMG') existing.replaceWith(makePlaceholderThumb());
        }

        updateRowPrice(row);
        recalculate();
    }

    /* ── Create a new item row ────────────────────────────────────────── */
    function addItemRow(preProduct) {
        const idx = itemIndex++;
        const row = document.createElement('div');
        row.className = 'item-row';
        row.dataset.index = idx;

        // Hidden product id
        const hiddenInput = document.createElement('input');
        hiddenInput.type  = 'hidden';
        hiddenInput.name  = `items[${idx}][product_id]`;
        hiddenInput.className = 'product-id-input';

        // Pick area (thumb + name + chevron)
        const pickArea = document.createElement('div');
        pickArea.className = 'item-pick-area';
        pickArea.title = 'Click to change product';

        const thumb = makePlaceholderThumb();
        const nameDisplay = document.createElement('span');
        nameDisplay.className = 'item-name-display';
        nameDisplay.textContent = 'Tap to choose a product…';
        const chevron = document.createElement('i');
        chevron.className = 'bi bi-chevron-right item-pick-icon';

        pickArea.append(thumb, nameDisplay, chevron);

        // Qty
        const qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.name = `items[${idx}][quantity]`;
        qtyInput.className = 'form-control qty-input';
        qtyInput.value = 1;
        qtyInput.min   = 1;
        qtyInput.required = true;

        // Price display
        const priceDisplay = document.createElement('span');
        priceDisplay.className = 'item-price-display';
        priceDisplay.textContent = '₱0.00';

        // Remove btn
        const removeBtn = document.createElement('button');
        removeBtn.type      = 'button';
        removeBtn.className = 'btn-remove-item';
        removeBtn.title     = 'Remove item';
        removeBtn.innerHTML = '<i class="bi bi-trash3"></i>';

        row.append(hiddenInput, pickArea, qtyInput, priceDisplay, removeBtn);
        document.getElementById('itemsContainer').appendChild(row);

        if (preProduct) setRowProduct(row, preProduct);

        bindRowEvents(row);
        recalculate();
    }

    /* ── "Add Item" button ────────────────────────────────────────────── */
    document.getElementById('addItemBtn').addEventListener('click', () => openPicker(null));

    /* ── Product Picker Modal ─────────────────────────────────────────── */
    const backdrop  = document.getElementById('productPickerBackdrop');
    const searchBox = document.getElementById('pickerSearch');
    const grid      = document.getElementById('pickerGrid');

    let pickerTargetRow = null;

    function openPicker(targetRow) {
        pickerTargetRow = targetRow;
        searchBox.value = '';
        filterCards('');
        backdrop.classList.add('open');
        setTimeout(() => searchBox.focus(), 60);
    }

    function closePicker() {
        backdrop.classList.remove('open');
        pickerTargetRow = null;
    }

    document.getElementById('pickerCloseBtn').addEventListener('click', closePicker);
    backdrop.addEventListener('click', e => { if (e.target === backdrop) closePicker(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closePicker(); });
    searchBox.addEventListener('input', function () { filterCards(this.value.trim().toLowerCase()); });

    function filterCards(query) {
        let anyVisible = false;
        grid.querySelectorAll('.product-card').forEach(card => {
            const show = !query || card.dataset.productName.toLowerCase().includes(query);
            card.style.display = show ? '' : 'none';
            if (show) anyVisible = true;
        });
        let noResult = grid.querySelector('.picker-no-results');
        if (!anyVisible) {
            if (!noResult) {
                noResult = document.createElement('div');
                noResult.className = 'picker-no-results';
                noResult.textContent = 'No products match your search.';
                grid.appendChild(noResult);
            }
        } else {
            if (noResult) noResult.remove();
        }
    }

    grid.querySelectorAll('.product-card').forEach(card => {
        const selectProduct = () => {
            const p = {
                id:    card.dataset.productId,
                name:  card.dataset.productName,
                price: parseFloat(card.dataset.productPrice),
                image: card.dataset.productImage,
            };
            if (pickerTargetRow) {
                setRowProduct(pickerTargetRow, p);
            } else {
                addItemRow(p);
            }
            closePicker();
        };
        card.addEventListener('click', selectProduct);
        card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); selectProduct(); } });
    });

    /* ── Bind row events ──────────────────────────────────────────────── */
    function bindRowEvents(row) {
        const pickArea = row.querySelector('.item-pick-area');
        const qty      = row.querySelector('.qty-input');
        const rmBtn    = row.querySelector('.btn-remove-item');

        // Clicking pick area opens the picker targeting this row
        pickArea.addEventListener('click', () => openPicker(row));

        qty.addEventListener('input', () => { updateRowPrice(row); recalculate(); });

        rmBtn.addEventListener('click', () => {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length <= 1) {
                setRowProduct(row, null);
                row.querySelector('.qty-input').value = 1;
                return;
            }
            row.remove();
            recalculate();
        });
    }

    /* ── Update price for one row ─────────────────────────────────────── */
    function updateRowPrice(row) {
        const id    = row.querySelector('.product-id-input').value;
        const qty   = parseInt(row.querySelector('.qty-input').value) || 0;
        const price = (id && PRODUCTS[id]) ? parseFloat(PRODUCTS[id].price) : 0;

        row.querySelector('.item-price-display').textContent =
            '₱' + (price * qty).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    /* ── Recalculate totals ───────────────────────────────────────────── */
    function recalculate() {
        let subtotal = 0;
        const productNames = [];

        document.querySelectorAll('.item-row').forEach(row => {
            const id    = row.querySelector('.product-id-input').value;
            const qty   = parseInt(row.querySelector('.qty-input').value) || 0;
            const price = (id && PRODUCTS[id]) ? parseFloat(PRODUCTS[id].price) : 0;
            subtotal += price * qty;
            if (id && PRODUCTS[id]) productNames.push(PRODUCTS[id].name);
        });

        const tax   = subtotal * TAX_RATE;
        const total = subtotal + tax;
        const fmt   = n => '₱' + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        document.getElementById('summarySubtotal').textContent = fmt(subtotal);
        document.getElementById('summaryTax').textContent      = fmt(tax);
        document.getElementById('summaryTotal').textContent    = fmt(total);

        const preview = productNames.slice(0, 2).join(', ');
        document.getElementById('summaryProductName').textContent =
            preview + (productNames.length > 2 ? ` +${productNames.length - 2} more` : '') || '—';

        const dateVal = document.querySelector('[name="order_date"]').value;
        if (dateVal) {
            const [y, m, d] = dateVal.split('-');
            document.getElementById('summaryDate').textContent = `${m}/${d}/${y}`;
        }
    }

    /* ── Bind first row on load ───────────────────────────────────────── */
    document.querySelectorAll('.item-row').forEach(bindRowEvents);

    /* ── Date sync ────────────────────────────────────────────────────── */
    document.querySelector('[name="order_date"]').addEventListener('change', recalculate);

    /* ══════════════════════════════════════════════════════════════════
       PRINT RECEIPT  →  then submit to baker
    ══════════════════════════════════════════════════════════════════ */
    document.getElementById('submitBtn').addEventListener('click', function (e) {
        e.preventDefault();

        /* 1 ── Validate: at least one product chosen */
        const filledInputs = [...document.querySelectorAll('.product-id-input')]
            .filter(inp => inp.value !== '');

        if (!filledInputs.length) {
            alert('Please add at least one product to the order.');
            return;
        }

        /* 2 ── Gather data from the live page */
        const customerFn  = document.querySelector('[name="customer_fn"]').value.trim();
        const customerLn  = document.querySelector('[name="customer_ln"]').value.trim();
        const customerName = (customerFn || customerLn)
            ? `${customerFn} ${customerLn}`.trim()
            : 'Walk-in Customer';

        const phone       = document.querySelector('[name="phone"]').value.trim()   || '—';
        const orderDate   = document.getElementById('summaryDate').textContent      || '—';
        const orderId     = document.getElementById('summaryOrderId').textContent   || '—';
        const paymentId   = document.getElementById('summaryPaymentId').textContent || '—';
        const txId        = document.getElementById('summaryTxId').textContent      || '—';
        const payMethod   = document.getElementById('summaryPaymentMethod').textContent || 'Cash';
        const subtotal    = document.getElementById('summarySubtotal').textContent  || '₱0.00';
        const tax         = document.getElementById('summaryTax').textContent       || '₱0.00';
        const total       = document.getElementById('summaryTotal').textContent     || '₱0.00';

        /* 3 ── Build ordered items list */
        let itemRowsHTML = '';
        document.querySelectorAll('.item-row').forEach(row => {
            const id  = row.querySelector('.product-id-input').value;
            if (!id || !PRODUCTS[id]) return;
            const p   = PRODUCTS[id];
            const qty = parseInt(row.querySelector('.qty-input').value) || 1;
            const lineTotal = (parseFloat(p.price) * qty)
                .toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            itemRowsHTML += `
                <tr>
                    <td class="item-name">${p.name}</td>
                    <td class="item-qty">x${qty}</td>
                    <td class="item-price">₱${lineTotal}</td>
                </tr>`;
        });

        /* 4 ── Build the receipt HTML */
        const logoSrc = "{{ asset('images/sandwich_logo.png') }}";
        const receiptHTML = `<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Order Receipt – #${orderId}</title>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body {
    font-family: 'Courier New', Courier, monospace;
    font-size: 13px;
    color: #1a1a1a;
    background: #fff;
    display: flex;
    justify-content: center;
    padding: 24px 0;
  }
  .receipt {
    width: 320px;
    padding: 0 10px 30px;
  }

  /* Header */
  .receipt-header { text-align: center; margin-bottom: 18px; }
  .receipt-logo { width: 110px; margin-bottom: 6px; }
  .receipt-brand { font-size: 15px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
  .receipt-tagline { font-size: 10px; color: #888; margin-top: 2px; letter-spacing: 1px; }

  /* Dividers */
  .dashed  { border: none; border-top: 1px dashed #aaa; margin: 10px 0; }
  .solid   { border: none; border-top: 2px solid #1a1a1a; margin: 10px 0; }

  /* Meta grid */
  .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
  .meta-table td { padding: 2px 0; font-size: 11px; }
  .meta-table td:first-child { color: #666; width: 50%; }
  .meta-table td:last-child  { text-align: right; font-weight: 600; }

  /* Section labels */
  .section-label {
    font-size: 9px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #888;
    text-align: center;
    margin: 8px 0 6px;
  }

  /* Items */
  .items-table { width: 100%; border-collapse: collapse; }
  .items-table td { padding: 4px 0; vertical-align: top; }
  .item-name  { width: 58%; font-weight: 600; font-size: 12px; }
  .item-qty   { width: 12%; text-align: center; color: #555; font-size: 11px; }
  .item-price { width: 30%; text-align: right; font-weight: 600; }

  /* Totals */
  .totals-table { width: 100%; border-collapse: collapse; margin-top: 4px; }
  .totals-table td { padding: 2px 0; font-size: 12px; }
  .totals-table td:last-child { text-align: right; }
  .totals-table .label { color: #555; }
  .grand-total td { font-size: 15px; font-weight: 700; padding-top: 6px; }

  /* Footer */
  .receipt-footer { text-align: center; margin-top: 18px; font-size: 10px; color: #888; line-height: 1.7; }
  .thank-you { font-size: 13px; font-weight: 700; color: #1a1a1a; letter-spacing: 1px; }

  @media print {
    body { padding: 0; }
    .receipt { width: 100%; }
  }
</style>
</head>
<body>
<div class="receipt">

  <div class="receipt-header">
    <img src="${logoSrc}" class="receipt-logo" onerror="this.style.display='none'">
    <div class="receipt-brand">CPAMA Sandwich</div>
    <div class="receipt-tagline">Fresh · Tasty · Made with Love</div>
  </div>

  <hr class="solid">

  <table class="meta-table">
    <tr><td>Order #</td><td>#${orderId}</td></tr>
    <tr><td>Date</td><td>${orderDate}</td></tr>
    <tr><td>Payment ID</td><td>${paymentId}</td></tr>
    <tr><td>Txn ID</td><td>${txId}</td></tr>
  </table>

  <hr class="dashed">

  <table class="meta-table">
    <tr><td>Customer</td><td>${customerName}</td></tr>
    <tr><td>Phone</td><td>${phone}</td></tr>
    <tr><td>Payment</td><td>${payMethod}</td></tr>
  </table>

  <hr class="dashed">

  <div class="section-label">— Order Items —</div>

  <table class="items-table">
    ${itemRowsHTML}
  </table>

  <hr class="dashed">

  <table class="totals-table">
    <tr>
      <td class="label">Subtotal</td>
      <td>${subtotal}</td>
    </tr>
    <tr>
      <td class="label">Tax (12%)</td>
      <td>${tax}</td>
    </tr>
  </table>

  <hr class="solid">

  <table class="totals-table grand-total">
    <tr>
      <td>TOTAL</td>
      <td>${total}</td>
    </tr>
  </table>

  <hr class="dashed">

  <div class="receipt-footer">
    <div class="thank-you">Thank you!</div>
    <div>Please come again 😊</div>
    <div style="margin-top:8px;">Sent to baker queue.</div>
  </div>

</div>
</body>
</html>`;

        /* 5 ── Open print window, print, then submit form */
        const printWin = window.open('', '_blank', 'width=420,height=700,scrollbars=yes');
        printWin.document.write(receiptHTML);
        printWin.document.close();
        printWin.focus();

        // Wait for content to fully render before triggering print
        printWin.onload = function () {
            printWin.print();
            // Submit the order after the print dialog is handled
            printWin.onafterprint = function () {
                printWin.close();
            };
            document.getElementById('orderForm').submit();
        };
    });
</script>
</body>
</html>