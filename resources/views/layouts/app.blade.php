<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css','resources/css/payment.css', 'resources/js/app.js','resources/js/payment.js','resources/js/dashboard.js','resources/css/dashboard.css'])
    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>@yield('title', 'My Laravel App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{Vite::asset('resources/css/app.css')}}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Topbar styling */
        .topbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .topbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .topbar-brand {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }
        
        .topbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        
        .topbar-nav {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .topbar-nav-item {
            margin: 0 5px;
        }
        
        .topbar-nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        
        .topbar-nav-link:hover,
        .topbar-nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .topbar-nav-link i {
            margin-right: 5px;
        }
        
        .user-section {
            display: flex;
            align-items: center;
            color: white;
        }
        
        .user-name {
            margin-right: 15px;
        }
        
        .logout-btn {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        
        .main-content {
            padding: 20px;
            margin-top: 0;
        }
        
        /* Mobile responsive styles */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
        }
        
        @media (max-width: 992px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .topbar-nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
                flex-direction: column;
                padding: 10px;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            }
            
            .topbar-nav.show {
                display: flex;
            }
            
            .topbar-nav-item {
                margin: 5px 0;
                width: 100%;
            }
            
            .topbar-nav-link {
                display: block;
                padding: 10px 15px;
                border-radius: 5px;
            }
            
            .user-section {
                flex-direction: column;
                align-items: flex-start;
                margin-top: 10px;
            }
            
            .user-name {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    @auth
    <!-- Topbar -->
    <nav class="topbar">
        <div class="topbar-content">
            <!-- Logo and Brand -->
            <a href="{{ route('home') }}" class="topbar-brand">
                <img src="{{ asset('images/aclctacloban.png') }}" alt="Logo" />
                <span class="d-none d-md-inline">ACLC Tacloban</span>
            </a>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="bi bi-list"></i>
            </button>

            <!-- Navigation -->
            <ul class="topbar-nav" id="topbarNav">
                <li class="topbar-nav-item">
                    <a href="{{ route('home') }}" class="topbar-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>
                <li class="topbar-nav-item">
                    <a href="{{ route('dashboard') }}" class="topbar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="topbar-nav-item">
                    <a href="{{ route('payment') }}" class="topbar-nav-link {{ request()->routeIs('payment') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i> Payment
                    </a>
                </li>
                <li class="topbar-nav-item">
                    <a href="{{ route('students') }}" class="topbar-nav-link {{ request()->routeIs('students') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Students
                    </a>
                </li>
                <li class="topbar-nav-item">
                    <a href="{{ route('transactions') }}" class="topbar-nav-link {{ request()->routeIs('transactions') ? 'active' : '' }}">
                        <i class="bi bi-journal-text"></i> Transactions
                    </a>
                </li>
                    @if(auth()->check() && auth()->user()->usertype_id == 1)
                        <li class="topbar-nav-item">
                            <a href="{{ route('users') }}" class="topbar-nav-link {{ request()->routeIs('users') ? 'active' : '' }}">
                                <i class="bi bi-person-circle"></i> Users
                            </a>
                        </li>
                    @endif
            </ul>

            <!-- User Section -->
            <div class="user-section">
                <span class="user-name d-none d-md-inline">{{ auth()->user()->name }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right me-2"></i> <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <main class="container-fluid mt-4">
            <div class="container">
                {{-- Flash alerts (success, error, validation) shown under topbar --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>
    @else
    <script>
        window.location.href = "{{ url('/') }}";
    </script>
    @endauth

    <!-- jQuery (some pages use it) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('topbarNav').classList.toggle('show');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const topbarNav = document.getElementById('topbarNav');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            
            if (!topbarNav.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                topbarNav.classList.remove('show');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>