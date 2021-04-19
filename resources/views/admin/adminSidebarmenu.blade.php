<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Setting Management
            <i class="fas fa-angle-left right"></i>

        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.setting') }}" class="nav-link">
                <i class="fa fa-circle nav-icon"></i>
                <p>Setting</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.setting.seo') }}" class="nav-link">
                <i class="fa fa-circle nav-icon"></i>
                <p>SEO</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.setting.socila.media') }}" class="nav-link">
                <i class="fa fa-circle nav-icon"></i>
                <p>Social Media</p>
            </a>
        </li>

    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            User Management
            <i class="fas fa-angle-left right"></i>

        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route("admin.permissions.index") }}" class="nav-link">
                <i class="fa fa-circle nav-icon"></i>
                <p>Permissions</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route("admin.roles.index") }}" class="nav-link">
                <i class="fa fa-circle nav-icon"></i>
                <p>Roles</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.all.users') }}" class="nav-link">
                <i class="fa fa-circle nav-icon"></i>
                <p>All users</p>
            </a>
        </li>



    </ul>
</li>
