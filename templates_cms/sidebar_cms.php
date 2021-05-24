        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-building" aria-hidden="true"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Innovation System</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="applications.php">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    <span>Pending Applications</span></a>
            </li>
            <?php

            if ($_SESSION['role'] == 'STAFF' || $_SESSION['role'] == 'ADMIN') {
                echo '<li class="nav-item">
            <a class="nav-link" href="manage_applications.php">
                <i class="fa fa-folder-open" aria-hidden="true"></i>
                <span>Manage Applications</span></a>
        </li>';
            }
            ?>

            <?php

            if ($_SESSION['role'] == 'ADMIN') {
                echo '          <li class="nav-item">
                <a class="nav-link" href="manage_admins.php">
                <i class="fa fa-users" aria-hidden="true"></i>
                    <span>Manage Admins</span></a>
            </li>';
            }
            ?>



            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->