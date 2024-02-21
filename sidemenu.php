<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();



$users = $override->getData('user');
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {

        if (Input::get('search_by_site')) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
                'site_id' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {

                $url = 'index1.php?&site_id=' . Input::get('site_id');
                Redirect::to($url);
                $pageError = $validate->errors();
            }
        }
    }

    if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
        if ($_GET['site_id'] != null) {
            $registered = $override->getCount1('clients', 'status', 1, 'site_id', $_GET['site_id']);
            $screened = $override->getCount1('history', 'status', 1, 'site_id', $_GET['site_id']);
            $eligible = $override->getCount1('history', 'eligible', 1, 'site_id', $_GET['site_id']);
            $enrolled = $override->getCount1('history', 'eligible', 1, 'site_id', $_GET['site_id']);
            $end = $override->getCount1('clients', 'status', 0, 'site_id', $_GET['site_id']);
        } else {
            $registered = $override->getCount1('history', 'status', 1, 'site_id', $_GET['site_id']);
            $screened = $override->getCount('history', 'status', 1);
            $eligible = $override->getCount('history', 'eligible', 1);
            $enrolled = $override->getCount('history', 'eligible', 1);
            $end = $override->getCount('clients', 'status', 0);
        }
    } else {
        $registered = $override->getCount1('history', 'status', 1, 'site_id', $_GET['site_id']);
        $screened = $override->getCount1('history', 'status', 1, 'site_id', $user->data()->site_id);
        $eligible = $override->getCount1('history', 'eligible', 1, 'site_id', $user->data()->site_id);
        $enrolled = $override->getCount1('history', 'eligible', 1, 'site_id', $user->data()->site_id);
        $end = $override->getCount1('clients', 'status', 0, 'site_id', $user->data()->site_id);
    }
} else {
    Redirect::to('index.php');
}

?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index1.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Lung Cancer Database</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php if ($user->data()->sex == 1) { ?>
                    <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">

                <?php } elseif ($user->data()->sex == 2) { ?>
                    <img src="dist/img/avatar3.png" class="img-circle elevation-2" alt="User Image">

                <?php } else { ?>
                    <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">

                <?php } ?>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $user->data()->firstname . ' - ' . $user->data()->lastname  ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index1.php" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="./index3.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li> -->
                    </ul>
                </li>
                <?php if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                ?>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Staff <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="add.php?id=1" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Register
                                        <span class="right badge badge-danger">New Staff</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=1&status=1" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Active</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=1&status=2" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Inactive</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=1&status=3" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Locked And Active</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=1&status=4" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Locked And Inactive</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Registration <i class="fas fa-angle-left right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add.php?id=4" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Register
                                    <span class="right badge badge-danger">New Client</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="info.php?id=3&status=7" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Registered Clients</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Data <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="info.php?id=5&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of CLients</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=6&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of KAP</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=7&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=8&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Results</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=9&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Classification</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=10&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Outcome</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=11&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Economics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=12&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Visits</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Clear Data <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="info.php?id=14" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Tables</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="info.php?id=15" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Unset Study ID <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="info.php?id=15" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Tables</p>
                                </a>
                            </li>
                        </ul> -->
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>