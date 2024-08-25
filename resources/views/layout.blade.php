<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button" style="width: 100px">
                    <i class="fa-solid fa-house-chimney"></i></button>
                <div class="sidebar-logo">
                    <a href="/dashboard">{{ auth()->user()->name }}</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#terms" aria-expanded="false" aria-controls="terms">
                        <i class="fa-solid fa-circle-check"></i> <span>Terms</span>
                    </a>
                    <ul id="terms" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{ route('term.index') }}" class="sidebar-link">Terms</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('term.create') }}" class="sidebar-link">Create Terms</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Category</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{ route('categories.show') }}" class="sidebar-link">Categories</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('categories.form') }}" class="sidebar-link">Create Category</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#Properties" aria-expanded="false" aria-controls="auth">
                        <i class="fa-solid fa-city"></i>
                        <span>Properties</span>
                    </a>
                    <ul id="Properties" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{ route('property.index') }}" class="sidebar-link">Properties</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('property.show') }}" class="sidebar-link">Create Property</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#Payments" aria-expanded="false" aria-controls="auth">
                        <i class="fa-regular fa-credit-card"></i>
                        <span>Payments</span>
                    </a>
                    <ul id="Payments" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{ route('payment.index') }}" class="sidebar-link">Payments</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('payment.add') }}" class="sidebar-link">Create Payment</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#Requests" aria-expanded="false" aria-controls="auth">
                        @if (App\Models\Receipt::where('status', 'pending')->count() > 0 ||
                                App\Models\Identification::where('status', 'waiting')->count() > 0 ||
                                App\Models\Sale::where('status', 'pending')->count() > 0)
                            <i style="color: red;" class="fa-solid fa-bell"></i>
                            <span style="color: red;">Requests</span>
                        @else
                            <i class="fa-solid fa-bell"></i>
                            <span>Requests</span>
                        @endif
                    </a>
                    <ul id="Requests" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            @if (App\Models\Identification::where('status', 'waiting')->count() > 0)
                                <a href="{{ route('identify.index') }}" style="color: red;"
                                    class="sidebar-link">Identifications</a>
                            @else
                                <a href="{{ route('identify.index') }}" class="sidebar-link">Identifications</a>
                            @endif
                        </li>
                        <li class="sidebar-item">
                            @if (App\Models\Receipt::where('status', 'pending')->count() > 0)
                                <a href="{{ route('receipts.index') }}" style="color: red;"
                                    class="sidebar-link">Receipts</a>
                            @else
                                <a href="{{ route('receipts.index') }}" class="sidebar-link">Receipts</a>
                            @endif
                        </li>
                        <li class="sidebar-item">
                            @if (App\Models\Sale::where('status', 'pending')->count() > 0)
                                <a href="{{ route('sale.index') }}" style="color: red;"
                                    class="sidebar-link">Sales</a>
                            @else
                                <a href="{{ route('sale.index') }}" class="sidebar-link">Sales</a>
                            @endif
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('profile.edit') }}" class="sidebar-link">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('user.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-people-group"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="sidebar-footer">
                @csrf
                <button
                    style="width: 100%;
                                padding: 10px 0;
                                color: white;
                                background-color: #0e2238;
                                border: none;"
                    class="sidebar-link">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </aside>
        <div class="main p-3">
            <div class="text-center">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/5c08f7844a.js" crossorigin="anonymous"></script>
    <script src="{{ url('js/script.js') }}"></script>
</body>

</html>
