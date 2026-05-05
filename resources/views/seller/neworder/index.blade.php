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

        .item-row .form-select { flex: 2; min-width: 0; }

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
                                <select name="items[0][product_id]" class="form-select product-select" required>
                                    <option value="" disabled selected>Select Product</option>
                                    @foreach ($products as $product)
                                        <option
                                            value="{{ $product->id }}"
                                            data-price="{{ $product->price }}"
                                        >
                                            {{ $product->name }} – ₱{{ number_format($product->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
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
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     Bootstrap JS
══════════════════════════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ── Product data passed from PHP ─────────────────────────────────── */
    const PRODUCTS = @json($products->keyBy('id'));
    const TAX_RATE = 0.12;

    let itemIndex = 1; // start at 1 because index 0 is pre-rendered

    /* ── Generate reference IDs on page load ──────────────────────────── */
    function generateId(prefix, length) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = prefix;
        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    const SESSION_PAYMENT_ID = generateId('PAY-', 8);
    const SESSION_ORDER_ID   = generateId('', 6);
    const SESSION_TX_ID      = generateId('TXN-', 10);

    document.getElementById('summaryPaymentId').textContent = SESSION_PAYMENT_ID;
    document.getElementById('summaryOrderId').textContent   = SESSION_ORDER_ID;
    document.getElementById('summaryTxId').textContent      = SESSION_TX_ID;

    /* ── Payment method radio sync to summary ─────────────────────────── */
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('summaryPaymentMethod').textContent = this.value;
            document.getElementById('paymentMethodHidden').value = this.value;
        });
    });

    /* ── Build a product <select> ─────────────────────────────────────── */
    function buildSelect(name) {
        let opts = `<option value="" disabled selected>Select Product</option>`;
        Object.values(PRODUCTS).forEach(p => {
            opts += `<option value="${p.id}" data-price="${p.price}">${p.name} – ₱${parseFloat(p.price).toFixed(2)}</option>`;
        });
        const sel = document.createElement('select');
        sel.name = name;
        sel.className = 'form-select product-select';
        sel.required = true;
        sel.innerHTML = opts;
        return sel;
    }

    /* ── Add a new item row ───────────────────────────────────────────── */
    document.getElementById('addItemBtn').addEventListener('click', function () {
        const idx = itemIndex++;
        const row = document.createElement('div');
        row.className = 'item-row';
        row.dataset.index = idx;

        const sel = buildSelect(`items[${idx}][product_id]`);

        const qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.name = `items[${idx}][quantity]`;
        qtyInput.className = 'form-control qty-input';
        qtyInput.value = 1;
        qtyInput.min = 1;
        qtyInput.placeholder = '0';
        qtyInput.required = true;

        const priceDisplay = document.createElement('span');
        priceDisplay.className = 'item-price-display';
        priceDisplay.textContent = '₱0.00';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn-remove-item';
        removeBtn.title = 'Remove item';
        removeBtn.innerHTML = '<i class="bi bi-trash3"></i>';

        row.append(sel, qtyInput, priceDisplay, removeBtn);
        document.getElementById('itemsContainer').appendChild(row);

        bindRowEvents(row);
        recalculate();
    });

    /* ── Bind change events on a row ──────────────────────────────────── */
    function bindRowEvents(row) {
        const sel   = row.querySelector('.product-select');
        const qty   = row.querySelector('.qty-input');
        const rmBtn = row.querySelector('.btn-remove-item');

        sel.addEventListener('change', () => { updateRowPrice(row); recalculate(); });
        qty.addEventListener('input',  () => { updateRowPrice(row); recalculate(); });

        rmBtn.addEventListener('click', () => {
            // Keep at least one row
            const rows = document.querySelectorAll('.item-row');
            if (rows.length <= 1) {
                sel.value = '';
                qty.value = 1;
                updateRowPrice(row);
                recalculate();
                return;
            }
            row.remove();
            recalculate();
        });
    }

    /* ── Update the price display for one row ─────────────────────────── */
    function updateRowPrice(row) {
        const sel   = row.querySelector('.product-select');
        const qty   = parseInt(row.querySelector('.qty-input').value) || 0;
        const opt   = sel.options[sel.selectedIndex];
        const price = opt && opt.dataset.price ? parseFloat(opt.dataset.price) : 0;
        const total = price * qty;

        row.querySelector('.item-price-display').textContent =
            '₱' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    /* ── Recalculate totals & update summary ──────────────────────────── */
    function recalculate() {
        let subtotal = 0;
        const productNames = [];

        document.querySelectorAll('.item-row').forEach(row => {
            const sel   = row.querySelector('.product-select');
            const qty   = parseInt(row.querySelector('.qty-input').value) || 0;
            const opt   = sel.options[sel.selectedIndex];
            const price = opt && opt.dataset.price ? parseFloat(opt.dataset.price) : 0;

            subtotal += price * qty;

            if (opt && opt.value) {
                productNames.push(opt.text.split('–')[0].trim());
            }
        });

        const tax   = subtotal * TAX_RATE;
        const total = subtotal + tax;

        const fmt = n => '₱' + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        document.getElementById('summarySubtotal').textContent = fmt(subtotal);
        document.getElementById('summaryTax').textContent      = fmt(tax);
        document.getElementById('summaryTotal').textContent    = fmt(total);

        // Product name summary (first 2 items)
        const preview = productNames.slice(0, 2).join(', ');
        document.getElementById('summaryProductName').textContent =
            preview + (productNames.length > 2 ? ` +${productNames.length - 2} more` : '') || '—';

        // Sync date from the date input
        const dateVal = document.querySelector('[name="order_date"]').value;
        if (dateVal) {
            const [y, m, d] = dateVal.split('-');
            document.getElementById('summaryDate').textContent = `${m}/${d}/${y}`;
        }
    }

    /* ── Bind events on the pre-rendered first row ────────────────────── */
    document.querySelectorAll('.item-row').forEach(bindRowEvents);

    /* ── Update summary date when order_date changes ──────────────────── */
    document.querySelector('[name="order_date"]').addEventListener('change', recalculate);

    /* ── Prevent submitting with no selected products ─────────────────── */
    document.getElementById('orderForm').addEventListener('submit', function (e) {
        const hasProduct = [...document.querySelectorAll('.product-select')]
            .some(s => s.value !== '');

        if (!hasProduct) {
            e.preventDefault();
            alert('Please add at least one product to the order.');
        }
    });
</script>
</body>
</html>