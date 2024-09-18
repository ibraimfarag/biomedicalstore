<aside class="sidebar" id="sidebar">
    <nav>
        <ul>
            <ul>

                @if (hasPermission('view_dashboard'))
                    <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                    </li>
                @endif

                @if (hasPermission('department'))
                    <li>
                        <a href="{{ route('departments.index') }}">
                            <i class="fas fa-building"></i> <!-- Department Icon -->
                            <span>Departments</span>
                        </a>
                    </li>
                @endif
                     <!-- New Division Requester Section -->
            @if (hasPermission('division_requester'))
            <li>
                <a href="{{ route('divisions.index') }}">
                    <i class="fas fa-sitemap"></i> <!-- Division Icon -->
                    <span>Division Requester</span>
                </a>
            </li>
        @endif
                @if (hasPermission('orders'))
                    <li><a href="{{ route('orders.index') }}"><i class="fas fa-list"></i><span>Orders</span></a></li>
                @endif

                @if (hasPermission('manage_users'))
                    <li>
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i> <!-- User Icon -->
                            <span>User</span>
                        </a>
                    </li>
                @endif


                @if (hasPermission('manage_roles'))
                    <li><a href="{{ route('roles.index') }}"><i class="fas fa-user-shield"></i><span>Roles</span></a>
                    </li>
                @endif


                @if (hasPermission('manage_permissions'))
                    <li><a href="{{ route('permissions.index') }}"><i
                                class="fas fa-key"></i><span>Permissions</span></a></li>
                @endif


                @if (hasPermission('manage_items'))
                    <li><a href="{{ route('items.index') }}"><i class="fas fa-box"></i><span>Items</span></a></li>
                @endif


                @if (hasPermission('stocks'))
                    <li><a href="{{ route('stocks.index') }}"><i class="fas fa-cubes"></i><span>Stocks</span></a></li>
                @endif


                @if (hasPermission('Request'))
                    <li><a href="{{ route('requests.index') }}"><i
                                class="fas fa-cart-plus"></i><span>Requests</span></a></li>
                @endif


                @if (hasPermission('view_reports'))
                    <li><a href="{{ route('orders.export') }}"><i class="fas fa-file-export"></i><span>Export Done
                                Orders</span></a></li>
                @endif


            </ul>


        </ul>
    </nav>

</aside>
