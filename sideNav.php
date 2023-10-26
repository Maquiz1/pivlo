        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="index.php" class="logo logo-light">
                <span class="logo-lg">
                    <img src="assets/images/logo.png" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="index.php" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="assets/images/logo-dark.png" alt="dark logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Sidebar -left -->
            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title">Main</li>

                    <li class="side-nav-item">
                        <a href="index.php" class="side-nav-link">
                            <i class="ri-dashboard-3-line"></i>
                            <span class="badge bg-success float-end">9+</span>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Registration" aria-expanded="false" aria-controls="Registration" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> Registration </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Registration">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="add.php?id=2">Add New Participant </a>
                                </li>
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#RegistrationManage" aria-expanded="false" aria-controls="RegistrationManage">
                                        <span> Manage </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="RegistrationManage">
                                        <ul class="side-nav-second-level">
                                            <?php
                                            foreach ($override->get('sites', 'status', 1) as $categoryM) {
                                            ?>
                                                <li>
                                                    <a href="info.php?id=1&category=<?= $categoryM['id']; ?>"><?= $categoryM['name']; ?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>
        </div>