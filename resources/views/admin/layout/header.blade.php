<div class="header">

    <div class="header-left">
        <a href="admin-dashboard.html" class="logo">
            <img src="/assets/img/logo.svg" alt="Logo">
        </a>
        <a href="admin-dashboard.html" class="logo collapse-logo">
            <img src="/assets/img/collapse-logo.svg" alt="Logo">
        </a>
        <a href="admin-dashboard.html" class="logo2">
            <img src="/assets/img/logo2.png" width="40" height="40" alt="Logo">
        </a>
    </div>

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <div class="page-title-box">
        <h3>Dreams Technologies</h3>
    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa-solid fa-bars"></i></a>

    <ul class="nav user-menu">

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img"><img src="/assets/img/avatar/avatar-27.jpg" alt="User Image">
                    <span class="status online"></span></span>
                <span>Admin</span>
            </a>
            <div class="dropdown-menu">
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button class="dropdown-item">Logout</button>
                </form>
            </div>
        </li>
    </ul>


    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button class="dropdown-item">Logout</button>
            </form>
        </div>
    </div>

</div>
