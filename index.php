<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$usr = null;
$email = new Email();
$st = null;
$random = new Random();
$pageError = null;
$successMessage = null;
$errorM = false;
$errorMessage = null;
if (!$user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Token::check(Input::get('token'))) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
                'username' => array('required' => true),
                'password' => array('required' => true)
            ));
            if ($validate->passed()) {
                $st = $override->get('user', 'username', Input::get('username'));
                if ($st) {
                    if ($st[0]['count'] > 3) {
                        $errorMessage = 'You Account have been deactivated,Someone was trying to access it with wrong credentials. Please contact your system administrator';
                    } else {
                        $login = $user->loginUser(Input::get('username'), Input::get('password'), 'user');
                        if ($login) {
                            $lastLogin = $override->get('user', 'id', $user->data()->id);
                            if ($lastLogin[0]['last_login'] == date('Y-m-d')) {
                            } else {
                                try {
                                    $user->updateRecord('user', array(
                                        'last_login' => date('Y-m-d H:i:s'),
                                        'count' => 0,
                                    ), $user->data()->id);
                                } catch (Exception $e) {
                                }
                            }
                            try {
                                $user->updateRecord('user', array(
                                    'count' => 0,
                                ), $user->data()->id);
                            } catch (Exception $e) {
                            }

                            Redirect::to('dashboard.php');
                        } else {
                            $usr = $override->get('user', 'username', Input::get('username'));
                            if ($usr && $usr[0]['count'] < 3) {
                                try {
                                    $user->updateRecord('user', array(
                                        'count' => $usr[0]['count'] + 1,
                                    ), $usr[0]['id']);
                                } catch (Exception $e) {
                                }
                                $errorMessage = 'Wrong username or password';
                            } else {
                                try {
                                    $user->updateRecord('user', array(
                                        'count' => $usr[0]['count'] + 1,
                                    ), $usr[0]['id']);
                                } catch (Exception $e) {
                                }
                                $email->deactivation($usr[0]['email_address'], $usr[0]['lastname'], 'Account Deactivated');
                                $errorMessage = 'You Account have been deactivated,Someone was trying to access it with wrong credentials. Please contact your system administrator';
                            }
                        }
                    }
                } else {
                    $errorMessage = 'Invalid username, Please check your credentials and try again';
                }
            } else {
                $pageError = $validate->errors();
            }
        }
    }
} else {
    Redirect::to('dashboard.php');
}

?>



<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:57:45 GMT -->
<?php include 'header.php'; ?>


<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-lg-10">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block p-2">
                                <img src="assets/images/auth-img.jpg" alt="" class="img-fluid rounded h-100">
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex flex-column h-100">
                                    <div class="auth-brand p-4">
                                        <!-- <a href="index.html" class="logo-light">
                                            <img src="assets/images/logo.png" alt="logo" height="22">
                                        </a>
                                        <a href="index.html" class="logo-dark">
                                            <img src="assets/images/logo-dark.png" alt="dark logo" height="22">
                                        </a> -->
                                    </div>
                                    <div class="p-4 my-auto">
                                        <h4 class="fs-20">Sign In</h4>
                                        <p class="text-muted mb-3">Enter your email address and password to access
                                            account.
                                        </p>

                                        <!-- form -->
                                        <form class="form-horizontal" method="post" id="validation">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">User Name</label>
                                                <input class="form-control" type="username" name="username" id="username" required="" placeholder="Enter your username">
                                            </div>
                                            <div class="mb-3">
                                                <a href="auth-forgotpw.html" class="text-muted float-end"><small>Forgot
                                                        your
                                                        password?</small></a>
                                                <label for="password" class="form-label">Password</label>
                                                <input class="form-control" name="password" type="password" required="" id="password" placeholder="Enter your password">
                                            </div>
                                            <!-- <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                                    <label class="form-check-label" for="checkbox-signin">Remember
                                                        me</label>
                                                </div>
                                            </div> -->
                                            <div class="mb-0 text-start">
                                                <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                                                <!-- <input type="submit" value="Sign in" class="btn btn-default btn-block"> -->
                                                <input class="btn btn-soft-primary w-100" type="submit" value="Sign in"><i class="ri-login-circle-fill me-1"></i> <span class="fw-bold"></span>
                                            </div>

                                            <div class="text-center mt-4">
                                                <p class="text-muted fs-16">Sign in with</p>
                                                <div class="d-flex gap-2 justify-content-center mt-3">
                                                    <a href="javascript: void(0);" class="btn btn-soft-primary"><i class="ri-facebook-circle-fill"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-soft-danger"><i class="ri-google-fill"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-soft-info"><i class="ri-twitter-fill"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-soft-dark"><i class="ri-github-fill"></i></a>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- end form-->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <!-- <p class="text-dark-emphasis">Don't have an account? <a href="auth-register.html" class="text-dark fw-bold ms-1 link-offset-3 text-decoration-underline"><b>Sign up</b></a>
                    </p> -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <?php include 'foot.php'; ?>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:57:45 GMT -->

</html>