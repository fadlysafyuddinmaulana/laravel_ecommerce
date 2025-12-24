<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Menu Dropdown (hover) -->
        <li class="nav-item dropdown user-dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">
                    <i class="fas fa-user mr-2"></i> {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-id-badge mr-2"></i> Profile
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                @if(Auth::check())
                <form id="logout-form" action="#" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger" style="width:100%;text-align:left;">
                        <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                    </button>
                </form>
                @else
                <a href="#" class="dropdown-item">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>
                @endif
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->