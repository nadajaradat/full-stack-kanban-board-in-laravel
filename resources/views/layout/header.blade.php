<header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="height: 60px; background-color: #6396b1;">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('home') }}">To Do</a>
    
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-nav">
        @auth
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="{{ route('logout') }}">Logout</a>
            </div>
        @else 
            <div class="nav-item d-flex">
                <a class="nav-link px-3" href="{{ route('login') }}">Login</a>
                <a class="nav-link px-3" href="{{ route('register') }}">Register</a>
            </div>
        @endauth
    </div>
</header>
