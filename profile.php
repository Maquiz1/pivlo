<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/pages-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:57:22 GMT -->
<?php include 'header.php'; ?>


<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <?php include 'topNav.php'; ?>

        <!-- ========== Topbar End ========== -->


        <!-- ========== Left Sidebar Start ========== -->
        <?php include 'sideNav.php'; ?>

        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="profile-bg-picture" style="background-image:url('assets/images/bg-profile.jpg')">
                                <span class="picture-bg-overlay"></span>
                                <!-- overlay -->
                            </div>
                            <!-- meta -->
                            <div class="profile-user-box">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="profile-user-img"><img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-lg rounded-circle"></div>
                                        <div class="">
                                            <h4 class="mt-4 fs-17 ellipsis"><?= $user->data()->firstname . '-' . $user->data()->lastname; ?></h4>
                                            <p class="font-13"> <?= $override->get('position', 'id', $user->data()->position)[0]['name']; ?></p>
                                            <p class="text-muted mb-0"><small> Bagomoyo, Tanzania</small></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <button type="button" class="btn btn-soft-danger">
                                                <i class="ri-settings-2-line align-text-bottom me-1 fs-16 lh-1"></i>
                                                Edit Profile
                                            </button>
                                            <a class="btn btn-soft-info" href="#"> <i class="ri-check-double-fill fs-18 me-1 lh-1"></i> Following</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ meta -->
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card p-0">
                                <div class="card-body p-0">
                                    <div class="profile-content">
                                        <ul class="nav nav-underline nav-justified gap-0">
                                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" data-bs-target="#aboutme" type="button" role="tab" aria-controls="home" aria-selected="true" href="#aboutme">About</a>
                                            </li>
                                            <!-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#user-activities" type="button" role="tab" aria-controls="home" aria-selected="true" href="#user-activities">Activities</a></li> -->
                                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button" role="tab" aria-controls="home" aria-selected="true" href="#edit-profile">Settings</a></li>
                                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab" aria-controls="home" aria-selected="true" href="#projects">Projects</a></li>
                                        </ul>

                                        <div class="tab-content m-0 p-4">
                                            <div class="tab-pane active" id="aboutme" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                                <div class="profile-desk">
                                                    <h5 class="text-uppercase fs-17 text-dark"><?= $user->data()->firstname . '-' . $user->data()->lastname; ?></h5>
                                                    <div class="designation mb-4"> <?= $override->get('position', 'id', $user->data()->position)[0]['name']; ?></div>
                                                    <p class="text-muted fs-16">
                                                        I have 10 years of experience designing for the web, and
                                                        specialize
                                                        in the areas of user interface design, interaction design,
                                                        visual
                                                        design and prototyping. I’ve worked with notable startups
                                                        including
                                                        Pearl Street Software.
                                                    </p>

                                                    <h5 class="mt-4 fs-17 text-dark">Contact Information</h5>
                                                    <table class="table table-condensed mb-0 border-top">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Url</th>
                                                                <td>
                                                                    <a href="#" class="ng-binding">
                                                                        <?= $user->data()->email_address; ?> </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td>
                                                                    <a href="#" class="ng-binding">
                                                                        <?= $user->data()->email_address; ?> </a>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Phone</th>
                                                                <td class="ng-binding"> <?= $user->data()->phone_number; ?> </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Skype</th>
                                                                <td>
                                                                    <a href="#" class="ng-binding">
                                                                        <?= $user->data()->phone_number; ?> </a>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div> <!-- end profile-desk -->
                                            </div> <!-- about-me -->

                                            <!-- Activities -->
                                            <!-- <div id="user-activities" class="tab-pane">
                                                <div class="timeline-2">
                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">5 minutes ago</div>
                                                            <p><strong><a href="#" class="text-info">John
                                                                        Doe</a></strong>Uploaded a photo</p>
                                                            <img src="assets/images/small/small-3.jpg" alt="" height="40" width="60" class="rounded-1">
                                                            <img src="assets/images/small/small-4.jpg" alt="" height="40" width="60" class="rounded-1">
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">30 minutes ago</div>
                                                            <p><a href="#" class="text-info">Lorem</a> commented your
                                                                post.
                                                            </p>
                                                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit.
                                                                    Aliquam laoreet tellus ut tincidunt euismod. "</em>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">59 minutes ago</div>
                                                            <p><a href="#" class="text-info">Jessi</a> attended a meeting
                                                                with<a href="#" class="text-success">John Doe</a>.</p>
                                                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit.
                                                                    Aliquam laoreet tellus ut tincidunt euismod. "</em>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">5 minutes ago</div>
                                                            <p><strong><a href="#" class="text-info">John
                                                                        Doe</a></strong> Uploaded 2 new photos</p>
                                                            <img src="assets/images/small/small-2.jpg" alt="" height="40" width="60" class="rounded-1">
                                                            <img src="assets/images/small/small-1.jpg" alt="" height="40" width="60" class="rounded-1">
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">30 minutes ago</div>
                                                            <p><a href="#" class="text-info">Lorem</a> commented your
                                                                post.
                                                            </p>
                                                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit.
                                                                    Aliquam laoreet tellus ut tincidunt euismod. "</em>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">59 minutes ago</div>
                                                            <p><a href="#" class="text-info">Jessi</a> attended a meeting
                                                                with<a href="#" class="text-success">John Doe</a>.</p>
                                                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit.
                                                                    Aliquam laoreet tellus ut tincidunt euismod. "</em>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- settings -->
                                            <div id="edit-profile" class="tab-pane">
                                                <div class="user-profile-content">
                                                    <form>
                                                        <div class="row row-cols-sm-2 row-cols-1">
                                                            <div class="mb-2">
                                                                <label class="form-label" for="FullName">Full
                                                                    Name</label>
                                                                <input type="text" value="<?= $user->data()->firstname . ' ' . $user->data()->lastname; ?>" id="FullName" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="Email">Email</label>
                                                                <input type="email" value="<?= $user->data()->email_address; ?>" id="Email" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="web-url">Website</label>
                                                                <input type="text" value="<?= $user->data()->email_address; ?>" id="web-url" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="Username">Username</label>
                                                                <input type="text" value="<?= $user->data()->username; ?>" id="Username" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="Password">Password</label>
                                                                <input type="password" placeholder="6 - 15 Characters" id="Password" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="RePassword">Re-Password</label>
                                                                <input type="password" placeholder="6 - 15 Characters" id="RePassword" class="form-control">
                                                            </div>
                                                            <div class="col-sm-12 mb-3">
                                                                <label class="form-label" for="AboutMe">About Me</label>
                                                                <textarea style="height: 125px;" id="AboutMe" class="form-control">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</textarea>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" type="submit"><i class="ri-save-line me-1 fs-16 lh-1"></i> Save</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- profile -->
                                            <div id="projects" class="tab-pane">
                                                <div class="row m-t-10">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name</th>
                                                                        <th>Start Date</th>
                                                                        <th>Due Date</th>
                                                                        <th>Status</th>
                                                                        <th>Remarks</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $x = 1;
                                                                    foreach ($override->get('study', 'status', 1) as $value) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?= $x; ?></td>
                                                                            <td><?= $value['name']; ?></td>
                                                                            <td><?= $value['start_date']; ?></td>
                                                                            <td><?= $value['end_date']; ?></td>
                                                                            <td><span class="badge bg-purple-subtle text-purple">Work in Progress</span></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    <?php
                                                                        $x++;
                                                                    } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div>
                <!-- end row -->

            </div>
            <!-- container -->

        </div>
        <!-- content -->

        <!-- Footer Start -->
        <?php include 'foot.php'; ?>

        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas">
        <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
            <h5 class="text-white m-0">Theme Settings</h5>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0">
            <div data-simplebar class="h-100">
                <div class="p-3">
                    <h5 class="mb-3 fs-16 fw-bold">Color Scheme</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-bs-theme" id="layout-color-light" value="light">
                                <label class="form-check-label" for="layout-color-light">
                                    <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-bs-theme" id="layout-color-dark" value="dark">
                                <label class="form-check-label" for="layout-color-dark">
                                    <img src="assets/images/layouts/dark.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                        </div>
                    </div>

                    <div id="layout-width">
                        <h5 class="my-3 fs-16 fw-bold">Layout Mode</h5>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-layout-mode" id="layout-mode-fluid" value="fluid">
                                    <label class="form-check-label" for="layout-mode-fluid">
                                        <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Fluid</h5>
                            </div>

                            <div class="col-4">
                                <div id="layout-boxed">
                                    <div class="form-check form-switch card-switch mb-1">
                                        <input class="form-check-input" type="checkbox" name="data-layout-mode" id="layout-mode-boxed" value="boxed">
                                        <label class="form-check-label" for="layout-mode-boxed">
                                            <img src="assets/images/layouts/boxed.png" alt="" class="img-fluid">
                                        </label>
                                    </div>
                                    <h5 class="font-14 text-center text-muted mt-2">Boxed</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="my-3 fs-16 fw-bold">Topbar Color</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-topbar-color" id="topbar-color-light" value="light">
                                <label class="form-check-label" for="topbar-color-light">
                                    <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-topbar-color" id="topbar-color-dark" value="dark">
                                <label class="form-check-label" for="topbar-color-dark">
                                    <img src="assets/images/layouts/topbar-dark.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                        </div>
                    </div>

                    <div>
                        <h5 class="my-3 fs-16 fw-bold">Menu Color</h5>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-menu-color" id="leftbar-color-light" value="light">
                                    <label class="form-check-label" for="leftbar-color-light">
                                        <img src="assets/images/layouts/sidebar-light.png" alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-menu-color" id="leftbar-color-dark" value="dark">
                                    <label class="form-check-label" for="leftbar-color-dark">
                                        <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-size">
                        <h5 class="my-3 fs-16 fw-bold">Sidebar Size</h5>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-default" value="default">
                                    <label class="form-check-label" for="leftbar-size-default">
                                        <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Default</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-compact" value="compact">
                                    <label class="form-check-label" for="leftbar-size-compact">
                                        <img src="assets/images/layouts/compact.png" alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Compact</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-small" value="condensed">
                                    <label class="form-check-label" for="leftbar-size-small">
                                        <img src="assets/images/layouts/sm.png" alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Condensed</h5>
                            </div>


                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-full" value="full">
                                    <label class="form-check-label" for="leftbar-size-full">
                                        <img src="assets/images/layouts/full.png" alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Full Layout</h5>
                            </div>
                        </div>
                    </div>

                    <div id="layout-position">
                        <h5 class="my-3 fs-16 fw-bold">Layout Position</h5>

                        <div class="btn-group checkbox" role="group">
                            <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed" value="fixed">
                            <label class="btn btn-soft-primary w-sm" for="layout-position-fixed">Fixed</label>

                            <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable" value="scrollable">
                            <label class="btn btn-soft-primary w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer border-top p-3 text-center">
            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-light w-100" id="reset-layout">Reset</button>
                </div>
                <div class="col-6">
                    <a href="https://1.envato.market/velonic" target="_blank" role="button" class="btn btn-primary w-100">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Chart.js -->
    <script src="assets/vendor/chart.js/chart.min.js"></script>

    <!-- Profile Demo App js -->
    <script src="assets/js/pages/profile.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/pages-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:57:32 GMT -->

</html>