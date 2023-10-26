<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('add_generic')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
                'notification' => array(
                    'required' => true,
                ),
                'use_case' => array(
                    'required' => true,
                ),
                'maintainance' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    if (Input::get('btn') == 'Add') {
                        $user->createRecord('generic', array(
                            'name' => Input::get('name'),
                            'notification' => Input::get('notification'),
                            'category' => $_GET['category'],
                            'use_case' => Input::get('use_case'),
                            'maintainance' => Input::get('maintainance'),
                            'status' => 1,
                            'create_on' => date('Y-m-d H:i:s'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_id' => $user->data()->id,
                        ));
                        $successMessage = 'Name Added Successful';
                    } elseif (Input::get('btn') == 'Edit') {
                        $user->updateRecord('generic', array(
                            'name' => Input::get('name'),
                            'notification' => Input::get('notification'),
                            'use_case' => Input::get('use_case'),
                            'maintainance' => Input::get('maintainance'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), Input::get('id'));
                        $successMessage = 'Name Updated Successful';
                    } elseif (Input::get('btn') == 'Delete') {
                        $user->updateRecord('generic', array(
                            'status' => 0,
                        ), Input::get('id'));
                        $successMessage = 'Name Deleted Successful';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_clients')) {
            $validate = $validate->check($_POST, array(
                'date_registered' => array(
                    'required' => true,
                ),
                'batch_name' => array(
                    'required' => true,
                ),
                'amount' => array(
                    'required' => true,
                ),
                'units' => array(
                    'required' => true,
                ),
                // 'remarks' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                // One month from today
                $from_today = date('Y-m-d', strtotime('+1 month'));
                $from_today1 = date('Y-m-d H:i:s', strtotime('+1 month'));


                // One month from a specific date
                $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                $age = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));

                try {
                    if (Input::get('btn') == 'Add') {
                        $user->createRecord('batch', array(
                            'date_registered' => Input::get('date_registered'),
                            'study_id' => '',
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'gender' => Input::get('gender'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'hospital_id' => Input::get('hospital_id'),
                            'phone_number' => Input::get('phone_number'),
                            'supporter_name' => Input::get('supporter_name'),
                            'supporter_phone' => Input::get('supporter_phone'),
                            'relation_patient' => Input::get('relation_patient'),
                            'district' => Input::get('district'),
                            'street' => Input::get('street'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => Input::get('head_household'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'pay_services' => Input::get('pay_services'),
                            'status' => 1,
                            'screened' => 0,
                            'eligible' => 0,
                            'enrolled' => 0,
                            'end_study' => 0,
                            'comments' => Input::get('comments'),
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                        ));

                        // $batch_id = $override->lastRow('batch', 'id')[0];

                        // $user->createRecord('batch_records', array(
                        //     'generic_id' => Input::get('generic_name'),
                        //     'batch_id' => $batch_id['id'],
                        //     'amount' => Input::get('amount'),
                        //     'added' => 0,
                        //     'removed' => 0,
                        //     'brand_name' => Input::get('brand_name'),
                        //     'status' => 1,
                        //     'increase_date' => date('Y-m-d'),
                        //     'increase_time' => date('H:i'),
                        //     'remarks' => Input::get('remarks'),
                        //     'units' => Input::get('units'),
                        //     'create_on' => date('Y-m-d H:i:s'),
                        //     'staff_id' => $user->data()->id,
                        //     'site_id' => $_GET['site'],
                        //     'site' => $_GET['site'],
                        //     'study_id' => $_GET['study'],
                        //     'study' => $_GET['study'],
                        //     'category' => $_GET['category'],
                        // ));

                        // $user->createRecord('checking', array(
                        //     'generic_id' => $batch_id['generic_id'],
                        //     'batch_id' => $batch_id['id'],
                        //     'amount' => $batch_id['amount'],
                        //     'visit_date' => date('Y-m-d H:i:s'),
                        //     'check_date' => date('Y-m-d'),
                        //     'next_check' => date('Y-m-d'),
                        //     'expected_date' => date('Y-m-d H:i:s'),
                        //     'checking_date' => date('Y-m-d'),
                        //     'checking_time' => date('H:i:s'),
                        //     'units' => $batch_id['units'],
                        //     'create_on' => date('Y-m-d H:i:s'),
                        //     'update_on' => date('Y-m-d H:i:s'),
                        //     'staff_id' => $user->data()->id,
                        //     'update_id' => $user->data()->id,
                        //     'site_id' => $batch_id['site_id'],
                        //     'site' => $batch_id['site'],
                        //     'study_id' => $batch_id['study_id'],
                        //     'study' => $batch_id['study'],
                        //     'category' => $batch_id['category'],
                        //     'maintainance' => $batch_id['maintainance'],
                        //     'remarks' => $batch_id['remarks'],
                        //     'next_notes' => Input::get('next_notes'),
                        //     'visit_window1' => 2,
                        //     'visit_window2' => 2,
                        //     'status' => 1,
                        //     'seq_no' => 1,
                        //     'visit_status' => 1,
                        //     'check_number' => 'Month 1',
                        // ));

                        // $last_check = $override->lastRow2('checking', 'batch_id', $batch_id['id'], 'id')[0];
                        // $sq = $last_check['seq_no'] + 1;
                        // $check_month = 'Month ' . $sq;

                        // $user->createRecord('checking', array(
                        //     'generic_id' => $batch_id['generic_id'],
                        //     'batch_id' => $batch_id['id'],
                        //     'amount' => $batch_id['amount'],
                        //     'check_date' => '',
                        //     'visit_date' => '',
                        //     'next_check' => $from_today,
                        //     'expected_date' => $from_today1,
                        //     'units' => $batch_id['units'],
                        //     'create_on' => date('Y-m-d H:i:s'),
                        //     'update_on' => date('Y-m-d H:i:s'),
                        //     'staff_id' => $user->data()->id,
                        //     'update_id' => $user->data()->id,
                        //     'site_id' => $batch_id['site_id'],
                        //     'site' => $batch_id['site'],
                        //     'study_id' => $batch_id['study_id'],
                        //     'study' => $batch_id['study'],
                        //     'category' => $batch_id['category'],
                        //     'maintainance' => $batch_id['maintainance'],
                        //     'remarks' => $batch_id['remarks'],
                        //     'next_notes' => Input::get('next_notes'),
                        //     'visit_window1' => 2,
                        //     'visit_window2' => 2,
                        //     'status' => 0,
                        //     'seq_no' => $sq,
                        //     'visit_status' => 0,
                        //     'check_number' => $check_month,
                        // ));

                        $successMessage = 'Batch Added Successful';
                    } elseif (Input::get('btn') == 'Edit') {
                        $user->updateRecord('batch', array(
                            'generic_id' => Input::get('generic_name'),
                            'name' => Input::get('batch_name'),
                            'amount' => Input::get('amount'),
                            'brand_name' => Input::get('brand_name'),
                            'expire_date' => Input::get('expire_date'),
                            'remarks' => Input::get('remarks'),
                            'units' => Input::get('units'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), Input::get('id'));

                        $generic = $override->getNews('generic', 'status', 1, 'id', $_GET['gid'])[0];

                        if ($generic['maintainance'] == 2) {
                            $user->updateRecord('batch', array(
                                'expire_date' => Input::get('expire_date'),
                            ), Input::get('id'));
                        }

                        $successMessage = 'Batch Updated Successful';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        }
    }
} else {
    Redirect::to('index.php');
}
?>



<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/form-wizard.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:58:18 GMT -->

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

                    <?php if ($successMessage) { ?>
                        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Success - </strong>
                            <?= $successMessage ?>
                        </div>
                    <?php } elseif ($pageError) { ?>
                        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Error - </strong>
                            <?php foreach ($pageError as $error) {
                                echo $error . ' , ';
                            } ?>
                        </div>
                    <?php } elseif ($errorMessage) { ?>
                        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Error - </strong>
                            <?= $errorMessage ?>
                        </div>
                    <?php } ?>
                    <?php
                    $Sub_Tiltle = '';
                    $Tiltle = '';
                    if ($_GET['category'] == 1) {
                        $Sub_Tiltle = 'Add Medicines';
                        $Tiltle = 'Medicines';
                    } elseif ($_GET['category'] == 2) {
                        $Sub_Tiltle = 'Add Equipments';
                        $Tiltle = 'Equipments';
                    } elseif ($_GET['category'] == 3) {
                        $Sub_Tiltle = 'Add Accessories';
                        $Tiltle = 'Accessories';
                    } elseif ($_GET['category'] == 4) {
                        $Sub_Tiltle = 'Add Supllies';
                        $Tiltle = 'Supllies';
                    }
                    ?>
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Lung Cancer</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                        <li class="breadcrumb-item active"><?= $Tiltle; ?></li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?= $Tiltle; ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php if ($_GET['id'] == 1) { ?>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0"> CRF 1 : Screening Form </h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="rootwizard">
                                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                                <li class="nav-item" data-target-form="#accountForm">
                                                    <a href="#first" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                        <i class="ri-account-circle-line fw-normal fs-20 align-middle me-1"></i>
                                                        <span class="d-none d-sm-inline">Part A: Demographics</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" data-target-form="#profileForm">
                                                    <a href="#second" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                        <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                                        <span class="d-none d-sm-inline">Smoking history</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" data-target-form="#otherForm">
                                                    <a href="#third" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                        <i class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                                        <span class="d-none d-sm-inline">Finish</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content mb-0 b-0">

                                                <div class="tab-pane" id="first">
                                                    <form id="accountForm" method="post" action="#" class="form-horizontal">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="userName3">User name</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" id="userName3" name="userName3" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="password3"> Password</label>
                                                                    <div class="col-md-9">
                                                                        <input type="password" id="password3" name="password3" class="form-control" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm3">Re Password</label>
                                                                    <div class="col-md-9">
                                                                        <input type="password" id="confirm3" name="confirm3" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                    </form>
                                                    <ul class="list-inline wizard mb-0">
                                                        <li class="next list-inline-item float-end">
                                                            <a href="javascript:void(0);" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab-pane fade" id="second">
                                                    <form id="profileForm" method="post" action="#" class="form-horizontal">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="name3"> First name</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" id="name3" name="name3" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="surname3"> Last name</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" id="surname3" name="surname3" class="form-control" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="email3">Email</label>
                                                                    <div class="col-md-9">
                                                                        <input type="email" id="email3" name="email3" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end col -->
                                                        </div>
                                                        <!-- end row -->
                                                    </form>
                                                    <ul class="pager wizard mb-0 list-inline">
                                                        <li class="previous list-inline-item">
                                                            <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Account</button>
                                                        </li>
                                                        <li class="next list-inline-item float-end">
                                                            <button type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></button>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab-pane fade" id="third">
                                                    <form id="otherForm" method="post" action="#" class="form-horizontal"></form>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="text-center">
                                                                <h2 class="mt-0">
                                                                    <i class="ri-check-double-line"></i>
                                                                </h2>
                                                                <h3 class="mt-0">Thank you !</h3>

                                                                <p class="w-75 mb-2 mx-auto">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis
                                                                    dui. Aliquam mattis dictum aliquet.</p>

                                                                <div class="mb-3">
                                                                    <div class="form-check d-inline-block">
                                                                        <input type="checkbox" class="form-check-input" id="customCheck4" required>
                                                                        <label class="form-check-label" for="customCheck4">I agree with the Terms and Conditions</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                    <!-- end row -->
                                                    </form>
                                                    <ul class="pager wizard mb-0 list-inline mt-1">
                                                        <li class="previous list-inline-item">
                                                            <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Profile</button>
                                                        </li>
                                                        <li class="next list-inline-item float-end">
                                                            <button type="button" class="btn btn-info">Submit</button>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div> <!-- tab-content -->
                                        </div> <!-- end #rootwizard-->
                                        </form>

                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    <?php } elseif ($_GET['id'] == 2) { ?>
                        <?php
                        $clients = $override->get('clients', 'status', 1)[0];
                        $sex = $override->get('sex', 'id', $clients['sex'])[0];
                        $district = $override->get('district', 'id', $clients['district'])[0];
                        $education = $override->get('education', 'id', $clients['education'])[0];
                        $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                        $yes_no = $override->get('yes_no', 'id', $clients['health_insurance'])[0];
                        $household = $override->get('household', 'id', $clients['head_household'])[0];


                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0"> CRF 1 : Screening Form </h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="rootwizard">
                                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                                <li class="nav-item" data-target-form="#accountForm">
                                                    <a href="#first" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                        <i class="ri-account-circle-line fw-normal fs-20 align-middle me-1"></i>
                                                        <span class="d-none d-sm-inline">Part A: Demographics 1</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" data-target-form="#profileForm">
                                                    <a href="#second" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                        <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                                        <span class="d-none d-sm-inline">Part A: Demographics 2</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" data-target-form="#otherForm">
                                                    <a href="#third" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                        <i class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                                        <span class="d-none d-sm-inline">Finish</span>
                                                    </a>
                                                </li>
                                            </ul>


                                            <form id="validation" method="post">
                                                <div class="tab-content mb-0 b-0">


                                                    <div class="tab-pane" id="first">
                                                        <!-- <form id="accountForm" method="post" action="#" class="form-horizontal"> -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="dob">Date of Registration;</label>
                                                                    <div class="col-md-9">
                                                                        <input type="date" value="<?php if ($clients) {
                                                                                                        print_r($clients['date_registered']);
                                                                                                    } ?>" id="date_registered" name="date_registered" class="form-control" placeholder="Enter Date of Registration" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="firstname">First Name</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['firstname']);
                                                                                                    } ?>" id="firstname" name="firstname" class="form-control" placeholder="Enter First name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="middlename">Middle Name</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['middlename']);
                                                                                                    } ?>" id="middlename" name="middlename" class="form-control" placeholder="Enter Middle name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="laststname">Last Name</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['lastname']);
                                                                                                    } ?>" id="lastname" name="lastname" class="form-control" placeholder="Enter Last tname" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="sex">Sex:</label>
                                                                    <div class="col-md-9">
                                                                        <select id="sex" name="sex" class="form-select form-select-lg mb-3" required>
                                                                            <option value="<?= $sex['id'] ?>"><?php if ($clients) {
                                                                                                                    print_r($sex['name']);
                                                                                                                } else {
                                                                                                                    echo 'Select Sex';
                                                                                                                } ?>
                                                                            </option>
                                                                            <?php foreach ($override->get('sex', 'status', 1) as $value) { ?>
                                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="dob">Date of birth;</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['dob']);
                                                                                                    } ?>" id="dob" name="dob" class="form-control" placeholder="Enter Date of birth" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="hospital_id">Hospital ID;</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['hospital_id']);
                                                                                                    } ?>" id="hospital_id" name="hospital_id" class="form-control" placeholder="Enter Hospital ID" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="patient_phone">Patients’ mobile number:</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['patient_phone']);
                                                                                                    } ?>" id="patient_phone" name="patient_phone" class="form-control" placeholder="Enter patient phone" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="supporter_name">Name of a treatment supporter or next of kin:</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['supporter_name']);
                                                                                                    } ?>" id="supporter_name" name="supporter_name" class="form-control" placeholder="Enter supporter name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="relation_patient">Relation to patient:</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['relation_patient']);
                                                                                                    } ?>" id="relation_patient" name="relation_patient" class="form-control" placeholder="Enter Relation" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="supporter_phone">Mobile number of a treatment supporter or next of kin:</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['supporter_phone']);
                                                                                                    } ?>" id="supporter_phone" name="supporter_phone" class="form-control" placeholder="Enter supporter phone" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="district">District</label>
                                                                    <div class="col-md-9">
                                                                        <select id="district" name="district" class="form-select form-select-lg mb-3" required>
                                                                            <option value="<?= $district['id'] ?>"><?php if ($clients) {
                                                                                                                        print_r($district['name']);
                                                                                                                    } else {
                                                                                                                        echo 'Select district';
                                                                                                                    } ?>
                                                                            </option>
                                                                            <?php foreach ($override->get('district', 'status', 1) as $value) { ?>
                                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="residence">Residence street</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['residence']);
                                                                                                    } ?>" id="residence" name="residence" class="form-control" placeholder="Enter Residence name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="house_number">House number, if any</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['house_number']);
                                                                                                    } ?>" id="house_number" name="house_number" class="form-control" placeholder="Enter house number" required>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                        <!-- <input type="submit" name="add_demo1" value="Save" class="btn btn-info" /> -->
                                                        <!-- </form> -->
                                                        <ul class="list-inline wizard mb-0">
                                                            <li class="next list-inline-item float-end">
                                                                <a href="javascript:void(0);" class="btn btn-info">Add Demographics 2 <i class="ri-arrow-right-line ms-1"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="tab-pane fade" id="second">
                                                        <!-- <form id="profileForm" method="post" action="#" class="form-horizontal"> -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="head_household">Who is the head of your household?</label>
                                                                    <div class="col-md-9">
                                                                        <select id="head_household" name="head_household" class="form-select form-select-lg mb-3" required>
                                                                            <option value="<?= $household['id'] ?>"><?php if ($clients) {
                                                                                                                        print_r($household['head_household']);
                                                                                                                    } else {
                                                                                                                        echo 'Select household head';
                                                                                                                    } ?>
                                                                            </option>
                                                                            <?php foreach ($override->get('education', 'status', 1) as $value) { ?>
                                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="education">Level of education</label>
                                                                    <div class="col-md-9">
                                                                        <select id="education" name="education" class="form-select form-select-lg mb-3" required>
                                                                            <option value="<?= $education['id'] ?>"><?php if ($clients) {
                                                                                                                        print_r($education['name']);
                                                                                                                    } else {
                                                                                                                        echo 'Select education';
                                                                                                                    } ?>
                                                                            </option>
                                                                            <?php foreach ($override->get('education', 'status', 1) as $value) { ?>
                                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="occupation">Occupation</label>
                                                                    <div class="col-md-9">
                                                                        <select id="occupation" name="occupation" class="form-select form-select-lg mb-3" required>
                                                                            <option value="<?= $occupation['id'] ?>"><?php if ($clients) {
                                                                                                                            print_r($occupation['name']);
                                                                                                                        } else {
                                                                                                                            echo 'Select Occupation';
                                                                                                                        } ?>
                                                                            </option>
                                                                            <?php foreach ($override->get('occupation', 'status', 1) as $value) { ?>
                                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="health_insurance">Do you own health insurance?</label>
                                                                    <div class="col-md-9">
                                                                        <select id="health_insurance" name="health_insurance" class="form-select form-select-lg mb-3" required>
                                                                            <option value="<?= $yes_no['id'] ?>"><?php if ($clients) {
                                                                                                                        print_r($yes_no['name']);
                                                                                                                    } else {
                                                                                                                        echo 'Select units';
                                                                                                                    } ?>
                                                                            </option>
                                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="insurance_name">Name of insurance</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['insurance_name']);
                                                                                                    } ?>" id="insurance_name" name="insurance_name" class="form-control" placeholder="Enter insurance name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="pay_services">If no, how do you pay for your health care services</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['pay_services']);
                                                                                                    } ?>" id="pay_services" name="pay_services" class="form-control" placeholder="Enter pay name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label for="comments" class="form-label">Remarks / Comments</label>
                                                                        <textarea class="form-control" name="comments" id="comments" rows="5">
                                                                        <?php if ($clients) {
                                                                            print_r($clients['comments']);
                                                                        } ?>
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                        <!-- <input type="submit" name="add_demo2" value="Save" class="btn btn-info" /> -->
                                                        <!-- </form> -->
                                                        <ul class="pager wizard mb-0 list-inline">
                                                            <li class="previous list-inline-item">
                                                                <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Demographics 1</button>
                                                            </li>
                                                            <li class="next list-inline-item float-end">
                                                                <button type="button" class="btn btn-info">Add Final <i class="ri-arrow-right-line ms-1"></i></button>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="tab-pane fade" id="third">
                                                        <!-- <form id="otherForm" method="post" action="#" class="form-horizontal"></form> -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="text-center">
                                                                    <h2 class="mt-0">
                                                                        <i class="ri-check-double-line"></i>
                                                                    </h2>
                                                                    <h3 class="mt-0">Thank you ! Please Submit to complete</h3>

                                                                    <!-- <p class="w-75 mb-2 mx-auto">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis
                                                                    dui. Aliquam mattis dictum aliquet.</p>

                                                                <div class="mb-3">
                                                                    <div class="form-check d-inline-block">
                                                                        <input type="checkbox" class="form-check-input" id="customCheck4" required>
                                                                        <label class="form-check-label" for="customCheck4">I agree with the Terms and Conditions</label>
                                                                    </div>
                                                                </div> -->
                                                                </div>
                                                            </div>
                                                            <!-- end col -->
                                                        </div>
                                                        <!-- end row -->
                                                        <!-- <input type="submit" name="add_demo3" value="Save" class="btn btn-info" /> -->
                                                        <!-- </form> -->
                                                        <ul class="pager wizard mb-0 list-inline mt-1">
                                                            <li class="previous list-inline-item">
                                                                <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Demographics 2</button>
                                                            </li>
                                                            <li class="next list-inline-item float-end">
                                                                <input type="submit" name="add_demographic" value="Save" class="btn btn-info" />

                                                                <!-- <button type="button" class="btn btn-info">Submit</button> -->
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- tab-content -->
                                            </form>
                                        </div> <!-- end #rootwizard-->

                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    <?php } elseif ($_GET['id'] == 3) { ?>
                    <?php } ?>


                </div> <!-- container -->

            </div> <!-- content -->

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
    <?php include 'settings.php'; ?>


    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Bootstrap Wizard Form js -->
    <script src="assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

    <!-- Wizard Form Demo js -->
    <script src="assets/js/pages/form-wizard.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

<!-- Mirrored from techzaa.getappui.com/velonic/layouts/form-wizard.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:58:20 GMT -->

</html>