<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li @class(['mm-active' => Request::is('dashboard')])>
                    <a href="{{ route('dashboard.index') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li @class(['mm-active' => Request::is(['building','building/create','building/*/edit'])])>
                    <a href="{{ route('building.index') }}" class="waves-effect">
                        <i class="bx bx-building-house"></i>
                        <span key="t-building-house">Manage Building</span>
                    </a>
                </li>
                <li @class(['mm-active' => Request::is(['unit','unit/create','unit/*/edit'])])>
                    <a href="{{ route('unit.index') }}" class="waves-effect">
                        <i class="bx bx-building-house"></i>
                        <span key="t-building-house">Manage Units</span>
                    </a>
                </li>
                <li @class(['mm-active' => Request::is(['parking'])])>
                    <a href="{{ route('parking.index') }}" class="waves-effect">
                        <i class="bx bx-building-house"></i>
                        <span key="t-building-house">Manage Parking</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>