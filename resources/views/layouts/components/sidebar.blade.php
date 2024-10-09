<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                {{-- <li @class(['mm-active' => Request::is('dashboard')])>
                    <a href="{{ route('dashboard.index') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li> --}}
                <li @class(['mm-active' => Request::is(['building','building/create','building/*/edit'])])>
                    <a href="{{ route('building.index') }}" class="waves-effect">
                        <i class="bx bx-building"></i>
                        <span>Manage Building</span>
                    </a>
                </li>
                <li @class(['mm-active' => Request::is(['unit','unit/create','unit/*/edit'])])>
                    <a href="{{ route('unit.index') }}" class="waves-effect">
                        <i class="bx bx-buildings"></i>
                        <span>Manage Units</span>
                    </a>
                </li>
                <li @class(['mm-active' => Request::is(['parkings'])])>
                    <a href="{{ route('parking.index') }}" class="waves-effect">
                        <i class="bx bx-building-house"></i>
                        <span>Manage Parkings</span>
                    </a>
                </li>
                <li @class(['mm-active' => Request::is(['settings'])])>
                    <a href="{{ route('settings') }}" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>