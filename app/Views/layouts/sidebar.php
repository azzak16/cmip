<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= \Core\Env::get('BASE_URL') ?>/" class="brand-link text-center">
        <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-light">CMIP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= \Core\Env::get('BASE_URL') ?>/" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="<?= \Core\Env::get('BASE_URL') ?>/role" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Role
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= \Core\Env::get('BASE_URL') ?>/permission" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Permission
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= \Core\Env::get('BASE_URL') ?>/user" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    User
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= \Core\Env::get('BASE_URL') ?>/customer" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Customer
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?= \Core\Env::get('BASE_URL') ?>/sales-order" class="nav-link">
                        <i class="nav-icon fas fa-cart-shopping"></i>
                        <p>
                            Sales Order
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= \Core\Env::get('BASE_URL') ?>/spk" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            SPK
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>