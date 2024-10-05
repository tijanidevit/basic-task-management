<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <nav class="greedys sidebar-horizantal">
                <ul class="list-inline-item list-unstyled links">
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li>
                        <a href="{{route('home')}}">
                            <i class="la la-dashcube"></i> <span> Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-title">
                        <span>Operations</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span>
                            <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('employee.index') }}">All Employees</a></li>
                            <li><a href="{{ route('employee.create') }}">New Employee</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-rocket"></i> <span> Schedules</span> <span
                                class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('schedule.index') }}">All Schedules</a></li>
                            <li><a href="{{ route('schedule.create') }}">New Schedules</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li>
                    <a href="{{route('home')}}">
                        <i class="la la-dashcube"></i> <span> Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Operations</span>
                </li>
                <li class="submenu">
                    <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('employee.index') }}">All Employees</a></li>
                        <li><a href="{{ route('employee.create') }}">New Employee</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="la la-rocket"></i> <span> Schedules</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('schedule.index') }}">All Schedules</a></li>
                        <li><a href="{{ route('schedule.create') }}">New Schedules</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
