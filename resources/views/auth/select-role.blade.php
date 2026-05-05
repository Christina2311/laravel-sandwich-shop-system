<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Select Role – Sandwich Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #5C3317;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
        }
        .select-card {
            background: #F5F0E8;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
        }
        .select-card img {
            width: 90px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 8px rgba(92,51,23,.3));
        }
        .select-card h2 {
            font-family: 'Fredoka One', cursive;
            font-size: 1.6rem;
            color: #5C3317;
            margin-bottom: .25rem;
        }
        .select-card p {
            font-size: .88rem;
            font-weight: 700;
            color: #9a7a5a;
            margin-bottom: 2rem;
        }
        .role-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .75rem;
            width: 100%;
            padding: 1rem;
            border-radius: 12px;
            border: 2px solid #EDE6D6;
            background: #fff;
            color: #5C3317;
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s, border-color .2s, transform .15s;
            margin-bottom: .75rem;
        }
        .role-btn:hover {
            background: #F4A636;
            border-color: #F4A636;
            color: #3a1f00;
            transform: translateY(-2px);
        }
        .role-btn .bi { font-size: 1.3rem; }
        .logout-link {
            display: block;
            margin-top: 1rem;
            font-size: .8rem;
            font-weight: 700;
            color: #9a7a5a;
            text-decoration: none;
        }
        .logout-link:hover { color: #c03030; }
    </style>
</head>
<body>
    <div class="select-card">
        <img src="{{ asset('images/sandwich_logo.png') }}" alt="Logo">
        <h2>Welcome back!</h2>
        <p>{{ Auth::user()->name }} · Choose your role for this session</p>

        @if(in_array('seller', $roles))
        <a href="{{ route('seller.dashboard') }}" class="role-btn">
            <i class="bi bi-cash-register"></i> Continue as Seller
        </a>
        @endif

        @if(in_array('baker', $roles))
        <a href="{{ route('baker.dashboard') }}" class="role-btn">
            <i class="bi bi-fire"></i> Continue as Baker
        </a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-link" style="background:none;border:none;cursor:pointer;">
                Not you? Log out
            </button>
        </form>
    </div>
</body>
</html>