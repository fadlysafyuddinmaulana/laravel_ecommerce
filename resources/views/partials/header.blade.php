<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>
        
        <!-- Right navbar links -->
        <ul class="navbar-nav ms-auto">
            <!-- User Menu -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/AdminLTE-4.0.0-rc4/dist/assets/img/user2-160x160.jpg') }}" 
                         class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'User' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('assets/AdminLTE-4.0.0-rc4/dist/assets/img/user2-160x160.jpg') }}" 
                             class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{ Auth::user()->name ?? 'User' }}
                            <small>Member since {{ Auth::user()->created_at->format('M. Y') ?? 'N/A' }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>