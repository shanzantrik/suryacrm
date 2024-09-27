<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <style>
    /* Overall Layout */
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    /* Top Blue Bar */
    .top-bar {
      background-color: #f0f4f8;
      /* Light grayish background for contrast */
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      position: sticky;
      /* Sticky positioning */
      top: 50px;
      /* Sticky below the header-bar */
      z-index: 999;
      /* Make sure it's above the content */
    }

    .bottom-bar {
      background-color: #f0f4f8;
      height: 80px;
      margin-top: 15%;
    }

    .top-bar .logo img {
      height: 50px;
    }

    .top-bar nav {
      display: flex;
    }

    .top-bar nav a {
      color: #003c7c;
      text-decoration: none;
      margin-left: 20px;
      font-weight: bold;
      font-size: 16px;
      position: relative;
      padding-bottom: 5px;
    }

    /* Hover effect for nav items with a line appearing at the bottom of the top bar */
    .top-bar nav a:hover::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -12px;
      /* Positioned 12px below the link (at the bottom of the top bar) */
      width: 100%;
      height: 2px;
      background-color: #ff7d00;
      /* Blue line */
      transition: width 0.3s ease;
      /* Smooth transition for the line */
    }

    .top-bar nav a:hover {
      color: #ff7d00;
      /* Change text color on hover */
    }


    /* Sticky Icons Menu (Left Floating) */
    /* Floating Menu Styling */
    .floating-menu {
      position: fixed;
      top: 160px;
      left: 20px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    /* Each anchor tag containing the icon */
    .floating-menu a {
      display: block;
      width: 80px;
      /* Limiting to 200px */
      height: 80px;
      /* Making height equal to width */
      background-color: #f0f4f8;
      /* Grayish-blue background */
      border: 4px solid #003c7c;
      /* Blue border */
      border-radius: 50%;
      /* Circular shape */
      text-align: center;
      line-height: 80px;
      /* Centering the icon vertically */
      transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
      /* Smooth transitions */
      position: relative;
    }

    /* Icon images inside the links */
    .floating-menu img {
      width: 60%;
      /* Adjust icon size relative to the container */
      height: 60%;
      object-fit: contain;
      /* Make sure the image fits inside the circle without distortion */
      vertical-align: middle;
    }

    /* Hover effect for the anchor tags */
    .floating-menu a:hover {
      background-color: #b0aba7;
      /* Orange background on hover */
      border-color: #ff7d00;
      /* Orange border on hover */
      box-shadow: -20px 0 40px -10px rgb(255, 123, 0);
      /* Dark orange shadow towards left */
    }

    /* Main Content */
    .content-wrapper {
      padding: 0px;
      margin-top: 30px;
      margin-left: 0%;
    }

    /* Footer */
    footer {
      background-color: #003c7c;
      color: white;
      padding: 20px;
      position: fixed;
      bottom: 0;
      width: 100%;
      text-align: center;
      z-index: 1;
    }

    .cement-image {
      position: absolute;
      right: 20px;
      /* Positioned to the right of the footer */
      top: -60px;
      /* This ensures the image pops out of the top of the footer */
      height: 120px;
      /* Adjust height as per your preference */
      z-index: 2;
      /* Ensure image stays on top of the footer */
    }

    /* Dashboard Card Styling */
    .dashboard-card {
      background-color: #f5f5f5;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      position: relative;
    }

    /* Orange Label as Sticker on the Right */
    .orange-label {
      position: absolute;
      top: -5px;
      right: 10px;
      background-color: #ff7d00;
      /* Orange background */
      color: white;
      padding: 5px 15px;
      border-radius: 5px;
      font-weight: bold;
      font-size: 16px;
      /* Add a slight rotation for sticker effect */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      /* Optional: Add a shadow for the sticker effect */
    }

    /* Table Styling */
    .table thead {
      background-color: #003c7c;
      /* Blue background for the table header */
      color: white;
      /* White text in the table header */
    }

    .table th,
    .table td {
      text-align: left;
      padding: 12px;
    }

    /* View More Button */
    .view-more-btn {
      background-color: black;
      color: white;
      padding: 5px 10px;
      border: none;
      border-radius: 10px;
      text-align: center;
      cursor: pointer;
      font-size: 12px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .view-more-btn:hover {
      background-color: #003c7c;
      /* Blue on hover */
    }

    /* New Blue Bar Styling */
    .header-bar {
      background-color: #003c7c;
      /* Blue background */
      padding: 15px 20px;
      text-align: right;
      position: sticky;
      /* Sticky positioning */
      top: 0;
      z-index: 1000;
      /* Ensure it's above other elements */
    }

    .header-bar h4 {
      color: white;
      font-size: 20px;
      font-weight: bold;
      text-transform: uppercase;
      /* Capitalized Text */
      margin: 0;
    }
  </style>
</head>

<body>
  <div id="app">

    <div class="main-layout">
      <!-- New Blue Bar with Application Title -->
      <header class="header-bar">
        <h4>CUSTOMER RELATIONSHIP MANAGEMENT APPLICATION</h4>
      </header>
      @if (!in_array(Route::currentRouteName(), ['login', 'register', 'password.request', 'password.reset']))
      <header class="top-bar">
        <div class="logo">
          <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <div>
        </div>
        {{-- <nav>
          <a href="{{ route('home') }}">Dashboard</a>
          <a href="{{ route('categories.index') }}">Master Entry</a>
          <a href="#">Member Management</a>
          <a href="#">Activity Panel</a>
          <a href="#">Admin Setting</a>
          <a href="#">Reporting Panel</a>
          <!-- Logout Button -->
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
          </a>

          <!-- Logout Form (hidden) -->
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </nav> --}}
        <nav class="navbar navbar-expand-md navbar-light">
          <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
              {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="{{ __('Toggle navigation') }}">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Left Side Of Navbar -->
              <ul class="navbar-nav me-auto">
                <!-- Master Entry Dropdown -->
                <li class="nav-item dropdown">
                  <a id="masterEntryDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
                    Master Entry
                  </a>

                  <div class="dropdown-menu" aria-labelledby="masterEntryDropdown">
                    <!-- Category Dropdown Item -->
                    <a class="dropdown-item" href="{{ route('categories.index') }}">
                      Categories
                    </a>
                    <!-- SubCategory Dropdown Item -->
                    <a class="dropdown-item" href="{{ route('subcategories.index') }}">
                      SubCategories
                    </a>
                    <a class="dropdown-item" href="{{ route('states.index') }}">
                      States Master
                    </a>
                    <a class="dropdown-item" href="{{ route('districts.index') }}">
                      Districts Master
                    </a>
                    <a class="dropdown-item" href="{{ route('holidays.index') }}">
                      Holidays Master
                    </a>

                  </div>
                </li>
              </ul>

              <!-- Right Side Of Navbar -->
              <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                  </a>

                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </div>
                </li>
                @endguest
              </ul>
            </div>
          </div>
        </nav>
      </header>

      <!-- Sticky Floating Icons Menu (Left Sidebar) -->
      <div class="floating-menu">
        <a href="#"><img src="{{ asset('images/add-user.png') }}" alt="User" title="Add Member"></a>
        <a href="#"><img src="{{ asset('images/calendar-icon.png') }}" alt="Calendar" title="View Anniversaries"></a>
        <a href="#"><img src="{{ asset('images/search-icon.png') }}" alt="Search" title="Search Members"></a>
        <a href="#"><img src="{{ asset('images/sms-icon.png') }}" alt="SMS" title="Send SMS"></a>
      </div>
      @else
      <header class="top-bar">
        <div class="logo">
          <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <nav>
          <a href="{{ route('login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Log in
          </a>

          @if (Route::has('register'))
          {{-- <a href="{{ route('register') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Register
          </a> --}}
          @endif
        </nav>
      </header>
      @endif
      <!-- Breadcrumb -->
      @if (!in_array(Route::currentRouteName(), ['login', 'register', 'password.request', 'password.reset']))
      <div class="container mt-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            @foreach(\App\Helpers\BreadcrumbHelper::generate() as $breadcrumb)
            @if (!$loop->last)
            <li class="breadcrumb-item">
              <a href="{{ url($breadcrumb['url']) }}">{{ $breadcrumb['name'] }}</a>
            </li>
            @else
            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
            @endif
            @endforeach
          </ol>
        </nav>
      </div>
      @endif
      <!-- Main Content Wrapper -->
      <div class="content-wrapper">
        @yield('content')
      </div>

      <!-- Full-Width Blue Footer -->
      <div class="bottom-bar">

      </div>
      <footer>
        Purbanchal Cement &copy; {{ date('Y') }}. All rights reserved.
        <img src="{{ asset('images/cement_bags.png') }}" alt="Surya Cement" class="cement-image">
      </footer>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <!-- Bootstrap Datepicker CSS and JS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
    rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
  </script>
</body>

</html>
