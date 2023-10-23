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
                        <a data-bs-toggle="collapse" href="#generic" aria-expanded="false" aria-controls="generic" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> Generic </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="generic">
                            <ul class="side-nav-second-level">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#genericAdd" aria-expanded="false" aria-controls="genericAdd">
                                        <span> Add </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="genericAdd">
                                        <ul class="side-nav-second-level">
                                            <ul class="side-nav-forth-level">
                                                <?php
                                                $x = 1;
                                                foreach ($override->get('use_group', 'status', 1) as $category) {
                                                ?>
                                                    <li>
                                                        <a href="add.php?id=1&category=<?= $category['id']; ?>&btn=Add"><?= $category['name']; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </ul>
                                    </div>
                                </li>

                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#genericManage" aria-expanded="false" aria-controls="genericManage">
                                        <span> Manage </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="genericManage">
                                        <ul class="side-nav-second-level">
                                            <ul class="side-nav-forth-level">
                                                <?php
                                                $x = 1;
                                                foreach ($override->get('use_group', 'status', 1) as $category) {
                                                ?>
                                                    <li>
                                                        <a href="info.php?id=1&category=<?= $category['id']; ?>"><?= $category['name']; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarMultiLevel" aria-expanded="false" aria-controls="sidebarMultiLevel" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> Multi Level </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarMultiLevel">
                            <ul class="side-nav-second-level">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarThirdLevel" aria-expanded="false" aria-controls="sidebarThirdLevel">
                                        <span> Level 1.3 </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarThirdLevel">
                                        <ul class="side-nav-third-level">
                                            <li class="side-nav-item">
                                                <a data-bs-toggle="collapse" href="#sidebarFourthLevel" aria-expanded="false" aria-controls="sidebarFourthLevel">
                                                    <span> Item 2 </span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <div class="collapse" id="sidebarFourthLevel">
                                                    <ul class="side-nav-forth-level">
                                                        <li>
                                                            <a href="javascript: void(0);">Item 2.1</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript: void(0);">Item 2.2</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Batch" aria-expanded="false" aria-controls="Batch" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> Batches </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Batch">
                            <ul class="side-nav-second-level">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#BatchAdd" aria-expanded="false" aria-controls="BatchAdd">
                                        <span> Add </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="BatchAdd">
                                        <ul class="side-nav-second-level">
                                            <?php
                                            $x = 1;
                                            foreach ($override->get('use_group', 'status', 1) as $category) {
                                            ?>
                                                <li class="side-nav-item">
                                                    <a data-bs-toggle="collapse" href="#BatchAdd<?= $category['id']; ?>" aria-expanded="false" aria-controls="BatchAdd<?= $category['id']; ?>">
                                                        <span> <?= $category['name']; ?> </span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="collapse" id="BatchAdd<?= $category['id']; ?>">
                                                        <ul class="side-nav-third-level">
                                                            <?php
                                                            $x = 1;
                                                            foreach ($override->get('sites', 'status', 1) as $site) {
                                                            ?>
                                                                <li class="side-nav-item">
                                                                    <a data-bs-toggle="collapse" href="#BatchAddSites<?= $site['id']; ?>" aria-expanded="false" aria-controls="BatchAddSites<?= $site['id'] ?>">
                                                                        <span> <?= $site['name'] ?> </span>
                                                                        <span class="menu-arrow"></span>
                                                                    </a>
                                                                    <div class="collapse" id="BatchAddSites<?= $site['id'] ?>">
                                                                        <ul class="side-nav-forth-level">
                                                                            <?php
                                                                            foreach ($override->get('study', 'status', 1) as $value) {
                                                                            ?>
                                                                                <li>
                                                                                    <a href="add.php?id=2&category=<?= $category['id']; ?>&site=<?= $site['id']; ?>&study=<?= $value['id']; ?>&btn=Add"><?= $value['name']; ?></a>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#CheckingCalibration" aria-expanded="false" aria-controls="CheckingCalibration" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> Checking / Calibration </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="CheckingCalibration">
                            <ul class="side-nav-second-level">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#TodaysChecks" aria-expanded="false" aria-controls="TodaysChecks">
                                        <span> Todays Checks</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="TodaysChecks">
                                        <ul class="side-nav-second-level">
                                            <?php
                                            $x = 1;
                                            foreach ($override->get('use_group', 'status', 1) as $category) {
                                            ?>
                                                <li class="side-nav-item">
                                                    <a data-bs-toggle="collapse" href="#TodaysChecks<?= $category['id']; ?>" aria-expanded="false" aria-controls="TodaysChecks<?= $category['id']; ?>">
                                                        <span> <?= $category['name']; ?> </span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="collapse" id="TodaysChecks<?= $category['id']; ?>">
                                                        <ul class="side-nav-third-level">
                                                            <?php
                                                            $x = 1;
                                                            foreach ($override->get('sites', 'status', 1) as $sites) {
                                                            ?>
                                                                <li class="side-nav-item">
                                                                    <a data-bs-toggle="collapse" href="#TodaySite<?= $sites['id']; ?>" aria-expanded="false" aria-controls="TodaySite<?= $sites['id']; ?>">
                                                                        <span> <?= $sites['name']; ?> </span>
                                                                        <span class="menu-arrow"></span>
                                                                    </a>
                                                                    <div class="collapse" id="TodaySite<?= $sites['id']; ?>">
                                                                        <ul class="side-nav-forth-level">
                                                                            <?php
                                                                            $x = 1;
                                                                            foreach ($override->get('study', 'status', 1) as $value) {
                                                                            ?>
                                                                                <li>
                                                                                    <a href="add.php?id=3&category=<?= $category['id']; ?>&site=<?= $sites['id']; ?>&study=<?= $value['id']; ?>" ?></a>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#Checked" aria-expanded="false" aria-controls="Checked">
                                        <span> Checked</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="Checked">
                                        <ul class="side-nav-second-level">
                                            <?php
                                            $x = 1;
                                            foreach ($override->get('use_group', 'status', 1) as $category) {
                                            ?>
                                                <li class="side-nav-item">
                                                    <a data-bs-toggle="collapse" href="#Checked<?= $category['id']; ?>" aria-expanded="false" aria-controls="Checked<?= $category['id']; ?>">
                                                        <span> <?= $category['name']; ?> </span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="collapse" id="Checked<?= $category['id']; ?>">
                                                        <ul class="side-nav-third-level">
                                                            <?php
                                                            $x = 1;
                                                            foreach ($override->get('sites', 'status', 1) as $sites) {
                                                            ?>
                                                                <li class="side-nav-item">
                                                                    <a data-bs-toggle="collapse" href="#CheckedSite<?= $sites['id']; ?>" aria-expanded="false" aria-controls="CheckedSite<?= $sites['id']; ?>">
                                                                        <span> <?= $sites['name']; ?> </span>
                                                                        <span class="menu-arrow"></span>
                                                                    </a>
                                                                    <div class="collapse" id="CheckedSite<?= $sites['id']; ?>">
                                                                        <ul class="side-nav-forth-level">
                                                                            <?php
                                                                            $x = 1;
                                                                            foreach ($override->get('study', 'status', 1) as $value) {
                                                                            ?>
                                                                                <li>
                                                                                    <a href="info.php?id=4&category=<?= $category['id']; ?>&site=<?= $sites['id']; ?>&study=<?= $value['id']; ?>&visit_status=1"><?= $value['name']; ?></a>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#NotChecked" aria-expanded="false" aria-controls="NotChecked">
                                        <span>Not Checked</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="NotChecked">
                                        <ul class="side-nav-second-level">
                                            <?php
                                            $x = 1;
                                            foreach ($override->get('use_group', 'status', 1) as $category) {
                                            ?>
                                                <li class="side-nav-item">
                                                    <a data-bs-toggle="collapse" href="#NotChecked<?= $category['id']; ?>" aria-expanded="false" aria-controls="NotChecked<?= $category['id']; ?>">
                                                        <span> <?= $category['name']; ?> </span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="collapse" id="NotChecked<?= $category['id']; ?>">
                                                        <ul class="side-nav-third-level">
                                                            <?php
                                                            $x = 1;
                                                            foreach ($override->get('sites', 'status', 1) as $sites) {
                                                            ?>
                                                                <li class="side-nav-item">
                                                                    <a data-bs-toggle="collapse" href="#NotCheckedSite<?= $sites['id']; ?>" aria-expanded="false" aria-controls="NotCheckedSite<?= $sites['id']; ?>">
                                                                        <span> <?= $sites['name']; ?> </span>
                                                                        <span class="menu-arrow"></span>
                                                                    </a>
                                                                    <div class="collapse" id="NotCheckedSite<?= $sites['id']; ?>">
                                                                        <ul class="side-nav-forth-level">
                                                                            <?php
                                                                            $x = 1;
                                                                            foreach ($override->get('study', 'status', 1) as $value) {
                                                                            ?>
                                                                                <li>
                                                                                    <a href="info.php?id=4&category=<?= $category['id']; ?>&site=<?= $sites['id']; ?>&study=<?= $value['id']; ?>&visit_status=0"><?= $value['name']; ?></a>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Expiration" aria-expanded="false" aria-controls="Expiration" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> Valid / Expired </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Expiration">
                            <ul class="side-nav-second-level">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#Expired" aria-expanded="false" aria-controls="Expired">
                                        <span> Expired </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="Expired">
                                        <ul class="side-nav-second-level">
                                            <?php
                                            $x = 1;
                                            foreach ($override->get('use_group', 'status', 1) as $category) {
                                            ?>
                                                <li class="side-nav-item">
                                                    <a data-bs-toggle="collapse" href="#Expired<?= $category['id']; ?>" aria-expanded="false" aria-controls="Expired<?= $category['id']; ?>">
                                                        <span> <?= $category['name']; ?> </span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="collapse" id="Expired<?= $category['id']; ?>">
                                                        <ul class="side-nav-third-level">
                                                            <?php
                                                            $x = 1;
                                                            foreach ($override->get('sites', 'status', 1) as $sites) {
                                                            ?>
                                                                <li class="side-nav-item">
                                                                    <a data-bs-toggle="collapse" href="#ExpiredSites<?= $sites['id']; ?>" aria-expanded="false" aria-controls="ExpiredSites<?= $sites['id']; ?>">
                                                                        <span> <?= $sites['name']; ?> </span>
                                                                        <span class="menu-arrow"></span>
                                                                    </a>
                                                                    <div class="collapse" id="ExpiredSites<?= $sites['id']; ?>">
                                                                        <ul class="side-nav-forth-level">
                                                                            <?php
                                                                            $x = 1;
                                                                            foreach ($override->get('study', 'status', 1) as $value) {
                                                                            ?>
                                                                                <li>
                                                                                    <a href="info.php?id=5&category=<?= $value['id']; ?>&site=<?= $value['id']; ?>&study=<?= $value['id']; ?>&expiration=expired"><?= $value['name']; ?></a>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                            <ul class="side-nav-second-level">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#Valid" aria-expanded="false" aria-controls="Valid">
                                        <span> Valid </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="Valid">
                                        <ul class="side-nav-second-level">
                                            <?php
                                            $x = 1;
                                            foreach ($override->get('use_group', 'status', 1) as $category) {
                                            ?>
                                                <li class="side-nav-item">
                                                    <a data-bs-toggle="collapse" href="#Valid<?= $category['id']; ?>" aria-expanded="false" aria-controls="Valid<?= $category['id']; ?>">
                                                        <span> <?= $category['name']; ?> </span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="collapse" id="Valid<?= $category['id']; ?>">
                                                        <ul class="side-nav-third-level">
                                                            <?php
                                                            $x = 1;
                                                            foreach ($override->get('sites', 'status', 1) as $sites) {
                                                            ?>
                                                                <li class="side-nav-item">
                                                                    <a data-bs-toggle="collapse" href="#ValidSites<?= $sites['id']; ?>" aria-expanded="false" aria-controls="ValidSites<?= $sites['id']; ?>">
                                                                        <span> <?= $sites['name']; ?> </span>
                                                                        <span class="menu-arrow"></span>
                                                                    </a>
                                                                    <div class="collapse" id="ValidSites<?= $sites['id']; ?>">
                                                                        <ul class="side-nav-forth-level">
                                                                            <?php
                                                                            $x = 1;
                                                                            foreach ($override->get('study', 'status', 1) as $value) {
                                                                            ?>
                                                                                <li>
                                                                                    <a href="info.php?id=5&category=<?= $value['id']; ?>&site=<?= $value['id']; ?>&study=<?= $value['id']; ?>&expiration=valid"><?= $value['name']; ?></a>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
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