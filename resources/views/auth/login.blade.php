<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sandwich Shop – Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --cream:        #F5F0E8;
            --brown:        #5C3317;
            --amber:        #F4A636;
            --amber-hover:  #e09420;
            --text-cream:   #F5E9D0;
            --input-border: #d4b896;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Nunito', sans-serif;
            background: var(--cream);
        }

        /* ══════════════════════════════
           LEFT PANEL
        ══════════════════════════════ */
        .panel-left {
            width: 45%;
            min-height: 100vh;
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .panel-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 50%, rgba(244,166,54,.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .logo-wrap {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            position: relative;
            z-index: 1;
        }

        .logo-wrap img {
            width: 200%;
            height: 200%;
            object-fit: contain;
            padding: 1.5rem;
            filter: drop-shadow(0 16px 32px rgba(92,51,23,.3));
            transition: transform .4s ease;
        }

        /* ══════════════════════════════
           RIGHT PANEL
        ══════════════════════════════ */
        .panel-right {
            width: 55%;
            min-height: 100vh;
            background: var(--brown);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .panel-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                135deg,
                transparent, transparent 40px,
                rgba(255,255,255,.015) 40px,
                rgba(255,255,255,.015) 80px
            );
            pointer-events: none;
        }

        .card-login {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            animation: slideUp .65s ease both;
        }

        .shop-title {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            color: var(--text-cream);
            margin-bottom: .2rem;
        }

        .shop-subtitle {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--amber);
            margin-bottom: 2rem;
        }

        /* ── Labels ── */
        .form-label {
            color: #d4b896;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            margin-bottom: .35rem;
        }

        /* ── Inputs ── */
        .form-control {
            background: #fff;
            border: 2px solid var(--input-border);
            border-radius: 8px;
            padding: .7rem 1rem .7rem 2.4rem;
            font-family: 'Nunito', sans-serif;
            font-size: .95rem;
            color: #3a2010;
            transition: border-color .25s, box-shadow .25s;
            width: 100%;
        }

        .form-control::placeholder { color: #b09070; }

        .form-control.is-invalid,
        .form-control.is-invalid:focus {
            background-image: none !important;
            padding-right: 1rem !important;
        }

        /* ── Input icons ── */
        .input-icon { position: relative; }

        .input-icon .bi {
            position: absolute;
            left: .85rem;
            top: .75rem;        /* fixed distance from top instead of 50% */
            transform: none;    /* remove the translateY */
            color: #b09070;
            font-size: 1rem;
            pointer-events: none;
            transition: color .25s;
        }

        .input-icon:focus-within .bi { color: var(--amber); }

        /* ── Login button ── */
        .btn-login {
            width: 100%;
            padding: .8rem;
            background: var(--amber);
            color: #3a1f00;
            font-family: 'Fredoka One', cursive;
            font-size: 1.1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background .25s, transform .15s, box-shadow .25s;
            box-shadow: 0 4px 16px rgba(244,166,54,.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            margin-top: .5rem;
        }

        .btn-login:hover {
            background: var(--amber-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(244,166,54,.45);
        }

        .btn-login:active { transform: translateY(0); }

        .btn-login .spinner-border { width:1rem;height:1rem;border-width:2px;display:none; }
        .btn-login.loading .spinner-border { display: inline-block; }
        .btn-login.loading .btn-text { display: none; }

        .form-control.is-invalid {
    background-image: none !important;
}

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.5rem 0 1rem;
        }

        .divider span { flex:1; height:1px; background:rgba(255,255,255,.12); }

        .divider p {
            color: #9a7a5a;
            font-size: .78rem;
            letter-spacing: .5px;
            text-transform: uppercase;
            white-space: nowrap;
        }


        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .panel-left  { width:100%; min-height: auto; padding: 2.5rem 1rem 1.5rem; }
            .panel-right { width:100%; min-height: auto; padding: 2rem 1.5rem 3rem; }
            .logo-wrap img { width: 55vw; max-width: 220px; min-width: 140px; }
        }
    </style>
</head>
<body>

    <!-- LEFT PANEL -->
    <div class="panel-left">
        <div class="logo-wrap">
            <img src="{{ asset('images/sandwich_logo.png') }}" alt="Sandwich Shop Logo">
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="panel-right">
        <div class="card-login">

            <h1 class="shop-title mb-1">Sandwich Shop</h1>
            <p class="text-warning mb-4">Welcome back!</p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-icon position-relative">
                        <i class="bi bi-person-fill"></i>
                        <input type="email" name="email" 
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" 
                               placeholder="example@gmail.com" required autofocus>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-icon position-relative">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" 
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Password" required>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>