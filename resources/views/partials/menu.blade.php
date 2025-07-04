<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">

            {{-- @can('user_management_access')
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    @can('permission_access')
                    <li class="nav-item">
                        <a href="{{ route(" admin.permissions.index") }}"
                            class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('cruds.permission.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('role_access')
                    <li class="nav-item">
                        <a href="{{ route(" admin.roles.index") }}"
                            class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-briefcase nav-icon">

                            </i>
                            {{ trans('cruds.role.title') }}
                        </a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan --}}


            <li class="nav-item" style="text-align: center; font-weight: bold; padding: 1rem;">
                @if (session()->has('student_as_admin'))
                    Student Portal
                @elseif (session()->has('admin'))
                    Admin Portal
                @else
                    Guest
                @endif
            </li>


            @can('user_management_access')
                <li class="nav-item">
                    <a href="{{ route("admin.users.index") }}"
                        class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user nav-icon">

                        </i>
                        Students
                    </a>
                </li>
            @endcan
            @can('discipline_access')
                @unless(session()->has('student_as_admin'))
                    <li class="nav-item">
                        <a href="{{ route("admin.disciplines.index") }}"
                            class="nav-link {{ request()->is('admin/disciplines') || request()->is('admin/disciplines/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-book-open nav-icon"></i>
                            Courses
                        </a>
                    </li>
                @endunless
            @endcan
            <li class="nav-item">
                <a href="{{ route("help-desk.index") }}"
                    class="nav-link {{ request()->is('help-desk') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-headset nav-icon"></i>
                    Help Desk
                </a>
            </li>







            <li class="nav-item">
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>