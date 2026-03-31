<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <style>
        body { background:#f4f6f9; }

        .sidebar {
            width:250px;
            height:100vh;
            position:fixed;
            background:#343a40;
            color:#fff;
            overflow-y:auto;
        }

        .sidebar a {
            color:#adb5bd;
            display:block;
            padding:10px 20px;
            text-decoration:none;
            transition:0.3s;
        }

        .sidebar a:hover {
            background:#495057;
            color:#fff;
        }

        .sidebar a.active {
            background:#0d6efd;
            color:#fff;
        }

        .main {
            margin-left:250px;
        }

        .topbar {
            background:#fff;
            padding:10px 20px;
            border-bottom:1px solid #ddd;
        }

        .card {
            border:none;
            border-radius:10px;
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="p-3 border-bottom">Admin Panel</h4>
        <div id="menuList"></div>
    </div>

    <!-- Main -->
    <div class="main w-100">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light topbar">
            <div class="container-fluid">

                <span class="navbar-text">
                    Role: {{ auth()->user()->role }}
                </span>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="px-3 py-2">
                                <strong>{{ auth()->user()->name }}</strong><br>
                                <small>{{ auth()->user()->email }}</small>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person"></i> Profile
                                </a>
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>

        <!-- Content -->
        <div class="container mt-4">
            @yield('content')
        </div>

    </div>

</div>

<!-- Bootstrap JS -->


<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// 🔥 Load menu + active highlight
$.get('/get-menus', function(data){

    let currentUrl = window.location.pathname;

    let html = '';

    data.forEach(menu => {

        let active = currentUrl === menu.route ? 'active' : '';

        html += `
            <a href="${menu.route}" class="${active}">
                <i class="bi bi-circle"></i> ${menu.title}
            </a>
        `;
    });

    $('#menuList').html(html);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>