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
        if (Input::get('delete_generic')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('generic', array(
                        'status' => 0,
                    ), Input::get('id'));
                    $successMessage = 'Name Deleted Successful';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('delete_batch')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('batch', array(
                        'status' => 0,
                    ), Input::get('id'));
                    $successMessage = 'Name Deleted Successful';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_history')) {
            $validate = $validate->check($_POST, array(
                'screening_date' => array(
                    'required' => true,
                ),
                'ever_smoked' => array(
                    'required' => true,
                ),
                'eligible' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                if (Input::get('btn') == 'Add') {
                    $user->createRecord('history', array(
                        'screening_date' => Input::get('screening_date'),
                        'ever_smoked' => Input::get('ever_smoked'),
                        'start_smoking' => Input::get('start_smoking'),
                        'smoking_long' => Input::get('smoking_long'),
                        'currently_smoking' => Input::get('currently_smoking'),
                        'quit_smoking' => Input::get('quit_smoking'),
                        'packs_per_day' => Input::get('packs_per_day'),
                        'packs_per_year' => Input::get('packs_per_year'),
                        'eligible' => Input::get('eligible'),
                        'status' => 1,
                        'patient_id' => Input::get('cid'),
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));
                    $successMessage = 'History  Successful Added';
                } elseif (Input::get('btn') == 'Update') {
                    $user->updateRecord('history', array(
                        'screening_date' => Input::get('screening_date'),
                        'ever_smoked' => Input::get('ever_smoked'),
                        'start_smoking' => Input::get('start_smoking'),
                        'smoking_long' => Input::get('smoking_long'),
                        'currently_smoking' => Input::get('currently_smoking'),
                        'quit_smoking' => Input::get('quit_smoking'),
                        'packs_per_day' => Input::get('packs_per_day'),
                        'packs_per_year' => Input::get('packs_per_year'),
                        'eligible' => Input::get('eligible'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), Input::get('id'));
                    $successMessage = 'History  Successful Updated';
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_results')) {
            $validate = $validate->check($_POST, array(
                'results_date' => array(
                    'required' => true,
                ),
                'ldct_results' => array(
                    'required' => true,
                ),
                'rad_score' => array(
                    'required' => true,
                ),
                'findings' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                if (Input::get('btn') == 'Add') {
                    $user->createRecord('results', array(
                        'results_date' => Input::get('results_date'),
                        'ldct_results' => Input::get('ldct_results'),
                        'rad_score' => Input::get('rad_score'),
                        'findings' => Input::get('findings'),
                        'status' => 1,
                        'patient_id' => Input::get('cid'),
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));
                    $successMessage = 'Results  Successful Added';
                } elseif (Input::get('btn') == 'Update') {
                    $user->updateRecord('results', array(
                        'results_date' => Input::get('results_date'),
                        'ldct_results' => Input::get('ldct_results'),
                        'rad_score' => Input::get('rad_score'),
                        'findings' => Input::get('findings'),
                        'status' => 1,
                        'patient_id' => Input::get('cid'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), Input::get('id'));
                    $successMessage = 'Results  Successful Updated';
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_classification')) {
            $validate = $validate->check($_POST, array(
                'classification_date' => array(
                    'required' => true,
                ),
                // 'category' => array(
                //     'required' => true,
                // ),
            ));

            if ($validate->passed()) {
                if (count(Input::get('category')) == 1) {
                    foreach (Input::get('category') as $value) {
                        if (Input::get('btn') == 'Add') {
                            $user->createRecord('classification', array(
                                'classification_date' => Input::get('classification_date'),
                                'category' => $value,
                                'status' => 1,
                                'patient_id' => Input::get('cid'),
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $user->data()->site_id,
                            ));
                            $successMessage = 'Classification  Successful Added';
                        } elseif (Input::get('btn') == 'Update') {
                            $user->updateRecord('classification', array(
                                'classification_date' => Input::get('classification_date'),
                                'category' => $value,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                            ), Input::get('id'));
                            $successMessage = 'Classification  Successful Updated';
                        }
                    }
                } else {
                    $errorMessage = 'Please chose only one Classification!';
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_economic')) {
            $validate = $validate->check($_POST, array(
                'economic_date' => array(
                    'required' => true,
                ),
                'income_household' => array(
                    'required' => true,
                ),
                'income_patient' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                if (Input::get('btn') == 'Add') {
                    $user->createRecord('economic', array(
                        'economic_date' => Input::get('economic_date'),
                        'income_household' => Input::get('income_household'),
                        'income_patient' => Input::get('income_patient'),
                        'smoking_long' => Input::get('smoking_long'),
                        'monthly_earn' => Input::get('monthly_earn'),
                        'member_earn' => Input::get('member_earn'),
                        'transport' => Input::get('transport'),
                        'support_earn' => Input::get('support_earn'),
                        'food_drinks' => Input::get('food_drinks'),
                        'other_cost' => Input::get('other_cost'),
                        'days' => Input::get('days'),
                        'hours' => Input::get('hours'),
                        'registration' => Input::get('registration'),
                        'consultation' => Input::get('consultation'),
                        'diagnostic' => Input::get('diagnostic'),
                        'medications' => Input::get('medications'),
                        'other_medical_cost' => Input::get('other_medical_cost'),
                        'status' => 1,
                        'patient_id' => Input::get('cid'),
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));
                    $successMessage = 'Economic  Successful Added';
                } elseif (Input::get('btn') == 'Update') {
                    $user->updateRecord('economic', array(
                        'economic_date' => Input::get('economic_date'),
                        'income_household' => Input::get('income_household'),
                        'income_patient' => Input::get('income_patient'),
                        'smoking_long' => Input::get('smoking_long'),
                        'monthly_earn' => Input::get('monthly_earn'),
                        'member_earn' => Input::get('member_earn'),
                        'transport' => Input::get('transport'),
                        'support_earn' => Input::get('support_earn'),
                        'food_drinks' => Input::get('food_drinks'),
                        'other_cost' => Input::get('other_cost'),
                        'days' => Input::get('days'),
                        'hours' => Input::get('hours'),
                        'registration' => Input::get('registration'),
                        'consultation' => Input::get('consultation'),
                        'diagnostic' => Input::get('diagnostic'),
                        'medications' => Input::get('medications'),
                        'other_medical_cost' => Input::get('other_medical_cost'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), Input::get('id'));
                    $successMessage = 'Economic  Successful Updated';
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('Archive_batch')) {
            $validate = $validate->check($_POST, array(
                'archive_date' => array(
                    'required' => true,
                ),
                'archive_time' => array(
                    'required' => true,
                ),
                'remarks' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $user->updateRecord('batch', array(
                    'status' => 2,
                ), Input::get('id'));

                $user->createRecord('archiving', array(
                    'generic_id' => Input::get('generic_id'),
                    'batch_id' => Input::get('id'),
                    'archive_date' => Input::get('archive_date'),
                    'archive_time' => Input::get('archive_time'),
                    'amount' => Input::get('amount'),
                    'remarks' => Input::get('remarks'),
                    'status' => 1,
                    'create_on' => date('Y-m-d H:i:s'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'staff_id' => $user->data()->id,
                    'update_id' => $user->data()->id,
                    'site_id' => $_GET['site'],
                    'site' => $_GET['site'],
                    'study_id' => $_GET['study'],
                    'study' => $_GET['study'],
                ));

                $successMessage = 'Archived Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('Increase_batch')) {
            $validate = $validate->check($_POST, array(
                'increase_date' => array(
                    'required' => true,
                ),
                'increase_time' => array(
                    'required' => true,
                ),
                'added' => array(
                    'required' => true,
                ),
                'remarks' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {

                $amount = Input::get('amount') +    Input::get('added');

                $user->updateRecord('batch', array(
                    'amount' => $amount,
                ), Input::get('id'));

                $user->createRecord('batch_records', array(
                    'generic_id' => Input::get('generic_id'),
                    'batch_id' => Input::get('id'),
                    'amount' => $amount,
                    'added' => Input::get('added'),
                    'removed' => 0,
                    'brand_name' => Input::get('brand_name'),
                    'status' => 1,
                    'increase_date' => Input::get('increase_date'),
                    'increase_time' => Input::get('increase_time'),
                    'remarks' => Input::get('remarks'),
                    'units' => Input::get('units'),
                    'create_on' => date('Y-m-d H:i:s'),
                    'staff_id' => $user->data()->id,
                    'site_id' => Input::get('site_id'),
                    'site' => Input::get('site_id'),
                    'study_id' => Input::get('study_id'),
                    'study' => Input::get('study_id'),
                    'category' => Input::get('category'),
                ));

                $successMessage = 'Increased Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('Dispense_batch')) {
            $validate = $validate->check($_POST, array(
                'dispense_date' => array(
                    'required' => true,
                ),
                'dispense_time' => array(
                    'required' => true,
                ),
                'added' => array(
                    'required' => true,
                ),
                'remarks' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {

                if (Input::get('added') <= Input::get('amount')) {

                    $amount = Input::get('amount') -  Input::get('added');
                    $added =  Input::get('added');

                    $user->updateRecord('batch', array(
                        'amount' => $amount,
                    ), Input::get('id'));

                    $user->createRecord('batch_records', array(
                        'generic_id' => Input::get('generic_id'),
                        'batch_id' => Input::get('id'),
                        'amount' => $amount,
                        'added' => 0,
                        'removed' => $added,
                        'brand_name' => Input::get('brand_name'),
                        'status' => 1,
                        'increase_date' => Input::get('dispense_date'),
                        'increase_time' => Input::get('dispense_time'),
                        'remarks' => Input::get('remarks'),
                        'units' => Input::get('units'),
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'site_id' => Input::get('site_id'),
                        'site' => Input::get('site_id'),
                        'study_id' => Input::get('study_id'),
                        'study' => Input::get('study_id'),
                        'category' => Input::get('category'),
                    ));

                    $successMessage = 'Dispensed Successful';
                } else {
                    $errorMessage = 'Amount not Enough';
                }
            } else {
                $pageError = $validate->errors();
            }
        }
    }
} else {
    Redirect::to('index.php');
}
?>


<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/tables-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:58:35 GMT -->

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
                    <?php
                    if ($_GET['category'] == 1) {
                        $Sub_Tiltle = 'List of Medicines Available';
                        $Tiltle = 'Medicines';
                    } elseif ($_GET['category'] == 2) {
                        $Sub_Tiltle = 'List of Equipments Available';
                        $Tiltle = 'Equipments';
                    } elseif ($_GET['category'] == 3) {
                        $Sub_Tiltle = 'List of Accessories Available';
                        $Tiltle = 'Accessories';
                    } elseif ($_GET['category'] == 4) {
                        $Sub_Tiltle = 'List of Supllies Available';
                        $Tiltle = 'Supllies';
                    }
                    ?>
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">

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

                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">e-CTMIS</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
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
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title"><?= $Sub_Tiltle; ?></h4>
                                        <!-- <p class="text-muted mb-0">
                                        Add <code>.table-bordered</code> & <code>.border-primary</code> can be added to
                                        change colors.
                                    </p> -->
                                        <a href="dashboard.php" class="text-reset fs-16 px-1">
                                            < Back </a>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered border-primary table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Balance</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($override->getNews('generic', 'status', 1, 'category', $_GET['category'])) {
                                                        $amnt = 0;
                                                        foreach ($override->getNews('generic', 'status', 1, 'category', $_GET['category']) as $value) {
                                                            $batch_total = $override->getSumD2('batch', 'amount', 'generic_id', $value['id'], 'status', 1)[0]['SUM(amount)'];
                                                            $balance = 0;
                                                            $total = 'Out of Stock';
                                                            if ($batch_total > 0 & $batch_total <= $value['notification']) {
                                                                $balance = $batch_total;
                                                                $total = 'Sufficient';
                                                            } elseif ($batch_total > $value['notification']) {
                                                                $balance = $batch_total;
                                                                $total = 'Running Low';
                                                            }


                                                            if (!$total == 'Out of Stock') {
                                                                if ($value['maintainance'] == 1) {
                                                                    $status = 'Checked';
                                                                    if ($value['status'] == 1) {
                                                                        $status = 'Not Checked';
                                                                    }
                                                                } else {
                                                                    $status = 'Valid';
                                                                    if ($value['status'] == 1) {
                                                                        $status = 'Expired';
                                                                    }
                                                                }
                                                            }

                                                    ?>
                                                            <tr>
                                                                <td class="table-user">
                                                                    <?= $value['name']; ?>
                                                                </td>
                                                                <td><?= $balance; ?></td>
                                                                <td><?= $total . ' - ' . $status; ?></td>
                                                                <td class="text-center">
                                                                    <a href="add.php?id=1&gid=<?= $value['id'] ?>&category=<?= $_GET['category'] ?>&btn=View" class="text-reset fs-16 px-1"> <i class="ri-edit-circle-line"></i>View</a>
                                                                    <a href="add.php?id=1&gid=<?= $value['id'] ?>&category=<?= $_GET['category'] ?>&btn=Edit" class="text-reset fs-16 px-1"> <i class="ri-edit-box-line"></i>Edit</a>
                                                                    <a href="info.php?id=2&gid=<?= $value['id'] ?>&category=<?= $_GET['category'] ?>&btn=details" class="text-reset fs-16 px-1"> <i class="ri-edit-circle-line"></i>Details</a>
                                                                    <a href="#delete<?= $value['id'] ?>" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#danger-alert-modal">Delete</a>
                                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1"> <i class="ri-edit-box-line"></i>Locations</a>
                                                                </td>
                                                            </tr>
                                                            <!-- Danger Alert Modal -->
                                                            <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm">
                                                                    <form method="post">
                                                                        <div class="modal-content modal-filled bg-danger">
                                                                            <div class="modal-body p-4">
                                                                                <div class="text-center">
                                                                                    <button type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                                        <i class="ri-close-circle-line h1"> </i>
                                                                                    </button>
                                                                                    <h4 class="mt-2">Delete!</h4>
                                                                                    <p class="mt-3">Are you sure you want to delete this Generic Name?</p>
                                                                                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                                    <input type="submit" name="delete_generic" value="Delete" class="btn btn-danger">
                                                                                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                                                                                </div>
                                                                            </div>
                                                                        </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>Opps! - </strong> No records found!
                                                        </div>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                    <?php } elseif ($_GET['id'] == 2) { ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title"><?= $Sub_Tiltle; ?></h4>
                                        <!-- <p class="text-muted mb-0">
                                        Add <code>.table-bordered</code> & <code>.border-primary</code> can be added to
                                        change colors.
                                    </p> -->
                                        <h4 class="header-title text-end">
                                            <a href=" info.php?id=1&category=<?= $_GET['category'] ?>" class="text-reset fs-16 px-1">
                                                << /i>Back
                                            </a>
                                            <?php
                                            // header("location:javascript://history.go(-1)");

                                            ?>
                                        </h4>

                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered border-primary table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Study Id</th>
                                                        <th>Age</th>
                                                        <th>Sex</th>
                                                        <th>Site</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($override->get('clients', 'status', 1)) {
                                                        foreach ($override->get('clients', 'status', 1) as $value) {
                                                            // $batch_total = $override->getSumD2('batch', 'amount', 'generic_id', $value['gid'], 'status', 1)[0]['SUM(amount)'];
                                                            $yes_no = $override->get('yes_no', 'status', 1)[0];
                                                            $history = $override->getNews('history', 'status', 1, 'patient_id', $value['id'])[0];
                                                            $results = $override->getNews('results', 'status', 1, 'patient_id', $value['id'])[0];
                                                            $classification = $override->getNews('classification', 'status', 1, 'patient_id', $value['id'])[0];
                                                            $economic = $override->getNews('economic', 'status', 1, 'patient_id', $value['id'])[0];
                                                    ?>
                                                            <tr>
                                                                <td class="table-user">
                                                                    <?= $value['firstname'] . '  ' . $value['middlename'] . ' ' . $value['lastname']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $value['study_id']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $value['age']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $value['sex']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $site['name']; ?>
                                                                </td>
                                                                <?php if ($value['status'] == 1) { ?>
                                                                    <td class="table-user">
                                                                        Active
                                                                    </td>
                                                                <?php   } ?>
                                                                <?php if ($value['status'] == 2) { ?>
                                                                    <td class="table-user">
                                                                        Not Active
                                                                    </td>
                                                                <?php   } ?>
                                                                <td class="text-center">
                                                                    <a href="add.php?id=2&cid=<?= $value['id'] ?>&btn=View" class="text-reset fs-16 px-1"> <i class="ri-edit-circle-line"></i>View</a>
                                                                    <a href="add.php?id=2&cid=<?= $value['id'] ?>&btn=Update" class="text-reset fs-16 px-1"> <i class="ri-edit-box-line"></i>Update</a>
                                                                    <?php if ($history['status'] == 0) {
                                                                        $btn = 'Add';
                                                                    ?>
                                                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#history<?= $value['id'] ?>&btn=" .$btn>Add history</button>
                                                                    <?php   } elseif ($history['status'] == 1) {
                                                                        $btn = 'Update';
                                                                    ?>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#history<?= $value['id'] ?>&btn=" .$btn>Update history</button>
                                                                    <?php   } ?>
                                                                    <?php if ($results['status'] == 0) {
                                                                        $btn = 'Add';
                                                                    ?>
                                                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#results<?= $value['id'] ?>&btn=" .$btn>Add Results</button>
                                                                    <?php   } elseif ($results['status'] == 1) {
                                                                        $btn = 'Update';
                                                                    ?>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#results<?= $value['id'] ?>&btn=" .$btn>Update Results</button>
                                                                    <?php   } ?>
                                                                    <?php if ($classification['status'] == 0) {
                                                                        $btn = 'Add';
                                                                    ?>
                                                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#classification<?= $value['id'] ?>&btn=" .$btn>Add Classification</button>
                                                                    <?php   } elseif ($classification['status'] == 1) {
                                                                        $btn = 'Update';
                                                                    ?>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classification<?= $value['id'] ?>&btn=" .$btn>Update Classification</button>
                                                                    <?php   } ?>
                                                                    <?php if ($economic['status'] == 0) {
                                                                        $btn = 'Add';
                                                                    ?>
                                                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#economic<?= $value['id'] ?>&btn=" .$btn>Add Economic</button>
                                                                    <?php   } elseif ($economic['status'] == 1) {
                                                                        $btn = 'Update';
                                                                    ?>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#economic<?= $value['id'] ?>&btn=" .$btn>Update Economic</button>
                                                                    <?php   } ?>
                                                                    <a href="#schedule<?= $value['id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#schedule<?= $value['id'] ?>">Schedule</a>

                                                                    <!-- <a href="#delete_batch<?= $value['id'] ?>" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_batch<?= $value['id'] ?>">Delete</a> -->
                                                                </td>
                                                            </tr>
                                                            <div id="history<?= $value['id'] ?>&btn=" .$btn class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">Part B: Smoking history</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="screening_date" class="form-label">Screening date</label>
                                                                                            <input type="date" value="<?php if ($history) {
                                                                                                                            print_r($history['screening_date']);
                                                                                                                        } ?>" id="screening_date" name="screening_date" class="form-control" placeholder="Enter screening date" required />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="ever_smoked" class="form-label">Have you ever smoked cigarette ?</label>
                                                                                            <select name="ever_smoked" id="ever_smoked" class="form-select form-select-lg mb-3" required>
                                                                                                <option value="<?= $history['ever_smoked'] ?>"><?php if ($history) {
                                                                                                                                                    if ($history['ever_smoked'] == 1) {
                                                                                                                                                        echo 'Yes';
                                                                                                                                                    } elseif ($history['ever_smoked'] == 2) {
                                                                                                                                                        echo 'No';
                                                                                                                                                    }
                                                                                                                                                } else {
                                                                                                                                                    echo 'Select';
                                                                                                                                                } ?>
                                                                                                </option>
                                                                                                <option value="1">Yes</option>
                                                                                                <option value="2">No</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="start_smoking" class="form-label">When did you start smoking?</label>
                                                                                            <input type="number" value="<?php if ($history) {
                                                                                                                            print_r($history['start_smoking']);
                                                                                                                        } ?>" min="1970" min="2023" id="start_smoking" name="start_smoking" class="form-control" placeholder="Enter Year" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="smoking_long" class="form-label">How long have you been smoking?</label>
                                                                                            <input type="number" value="<?php if ($history) {
                                                                                                                            print_r($history['smoking_long']);
                                                                                                                        } ?>" min="1970" min="2023" id="smoking_long" name="smoking_long" class="form-control" placeholder="Enter Years" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="currently_smoking" class="form-label">Are you Currently Smoking ?</label>
                                                                                            <select name="currently_smoking" id="currently_smoking" class="form-select form-select-lg mb-3" required>
                                                                                                <option value="<?= $history['currently_smoking'] ?>"><?php if ($history) {
                                                                                                                                                            if ($history['currently_smoking'] == 1) {
                                                                                                                                                                echo 'Yes';
                                                                                                                                                            } elseif ($history['currently_smoking'] == 2) {
                                                                                                                                                                echo 'No';
                                                                                                                                                            }
                                                                                                                                                        } else {
                                                                                                                                                            echo 'Select';
                                                                                                                                                        } ?>
                                                                                                </option>
                                                                                                <option value="1">Yes</option>
                                                                                                <option value="2">No</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="quit_smoking" class="form-label">When did you quit smoking in years?</label>
                                                                                            <input type="number" value="<?php if ($history) {
                                                                                                                            print_r($history['quit_smoking']);
                                                                                                                        } ?>" min="1970" min="2023" id="quit_smoking" name="quit_smoking" class="form-control" placeholder="Enter Year" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="packs_per_day" class="form-label">Number of packs per day</label>
                                                                                            <input type="number" value="<?php if ($history) {
                                                                                                                            print_r($history['packs_per_day']);
                                                                                                                        } ?>" min="0" id="packs_per_day" name="packs_per_day" class="form-control" placeholder="Enter amount" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="packs_per_year" class="form-label">Number of Packs per years</label>
                                                                                            <input type="number" value="<?php if ($history) {
                                                                                                                            print_r($history['packs_per_year']);
                                                                                                                        } ?>" min="0" id="packs_per_year" name="packs_per_year" class="form-control" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-12">
                                                                                        <div class="mb-3">
                                                                                            <label for="eligible" class="form-label">Patient Eligible for Lung Cancer Screening?</label>
                                                                                            <select name="eligible" id="eligible" class="form-select form-select-lg mb-3" required>
                                                                                                <option value="<?= $history['eligible'] ?>"><?php if ($history) {
                                                                                                                                                if ($history['eligible'] == 1) {
                                                                                                                                                    echo 'Yes';
                                                                                                                                                } elseif ($history['eligible'] == 2) {
                                                                                                                                                    echo 'No';
                                                                                                                                                }
                                                                                                                                            } else {
                                                                                                                                                echo 'Select';
                                                                                                                                            } ?>
                                                                                                </option>
                                                                                                <option value="1">Yes</option>
                                                                                                <option value="2">No</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $history['id'] ?>">
                                                                                <input type="hidden" name="cid" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="btn" value="<?= $btn ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="add_history" class="btn btn-primary" value="<?= $btn ?>">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                            <div id="results<?= $value['id'] ?>&btn=" .$btn class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">CRF2: Screeing test results using LDCT</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="results_date" class="form-label">Date</label>
                                                                                            <input type="date" value="<?php if ($results) {
                                                                                                                            print_r($results['results_date']);
                                                                                                                        } ?>" id="results_date" name="results_date" class="form-control" placeholder="Enter results date" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="ldct_results" class="form-label">LDCT RESULTS</label>
                                                                                            <input type="text" value="<?php if ($results) {
                                                                                                                            print_r($results['ldct_results']);
                                                                                                                        } ?>" id="ldct_results" name="ldct_results" class="form-control" placeholder="Enter LDCT results" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="rad_score" class="form-label">RAD SCORE</label>
                                                                                            <input type="text" value="<?php if ($results) {
                                                                                                                            print_r($results['rad_score']);
                                                                                                                        } ?>" id="rad_score" name="rad_score" class="form-control" placeholder="Enter RAD score" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="findings" class="form-label">FINDINGS:</label>
                                                                                            <textarea class="form-control" name="findings" id="findings" rows="5">
                                                                                            <?php if ($results) {
                                                                                                print_r($results['findings']);
                                                                                            } ?>
                                                                                            </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $results['id'] ?>">
                                                                                <input type="hidden" name="cid" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="btn" value="<?= $btn ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="add_results" class="btn btn-primary" value="<?= $btn ?>Results">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                            <div id="classification<?= $value['id'] ?>&btn=" .$btn class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">LUNG- RADS CLASSIFICATION</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <div class="mb-2">
                                                                                            <label for="classification_date" class="form-label">Date</label>
                                                                                            <input type="date" value="<?php if ($classification) {
                                                                                                                            print_r($classification['classification_date']);
                                                                                                                        } ?>" id="classification_date" name="classification_date" class="form-control" placeholder="Enter classification date" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="mb-2">
                                                                                            <input type="checkbox" name="category[]" value="1" <?php if ($classification['category'] == 1) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                                            <label for="ldct_results" class="form-label">Category 1</label><br>
                                                                                            <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 1) as $value) { ?>
                                                                                                - <label><?= $value['name'] ?></label> <br>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="mb-2">
                                                                                            <input type="checkbox" name="category[]" value="2" <?php if ($classification['category'] == 2) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                                            <label for="ldct_results" class="form-label">Category 2</label><br>
                                                                                            <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 2) as $value) { ?>
                                                                                                - <label><?= $value['name'] ?></label> <br>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="mb-2">
                                                                                            <input type="checkbox" name="category[]" value="3" <?php if ($classification['category'] == 3) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                                            <label for="ldct_results" class="form-label">Category 3</label><br>
                                                                                            <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 3) as $value) { ?>
                                                                                                - <label><?= $value['name'] ?></label> <br>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="mb-2">
                                                                                            <input type="checkbox" name="category[]" value="4" <?php if ($classification['category'] == 4) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                                            <label for="ldct_results" class="form-label">Category 4A</label><br>
                                                                                            <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 4) as $value) { ?>
                                                                                                - <label><?= $value['name'] ?></label> <br>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="mb-2">
                                                                                            <input type="checkbox" name="category[]" value="5" <?php if ($classification['category'] == 5) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                                            <label for="ldct_results" class="form-label">Category 4B</label><br>
                                                                                            <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 5) as $value) { ?>
                                                                                                - <label><?= $value['name'] ?></label> <br>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $classification['id'] ?>">
                                                                                <input type="hidden" name="cid" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="btn" value="<?= $btn ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="add_classification" class="btn btn-primary" value="<?= $btn ?>Classification">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                            <div id="economic<?= $value['id'] ?>&btn=" .$btn class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">CRF3: Socio-economic / Patient cost</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="economic_date" class="form-label">Date</label>
                                                                                            <input type="date" value="<?php if ($economic) {
                                                                                                                            print_r($economic['economic_date']);
                                                                                                                        } ?>" id="economic_date" name="economic_date" class="form-control" placeholder="Enter economic date" required />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="income_household" class="form-label">Main source of income of the household head?</label>
                                                                                            <input type="text" value="<?php if ($economic) {
                                                                                                                            print_r($economic['income_household']);
                                                                                                                        } ?>" id="income_household" name="income_household" class="form-control" placeholder="Enter household source" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="income_patient" class="form-label">Main source of income of patient?</label>
                                                                                            <input type="text" value="<?php if ($economic) {
                                                                                                                            print_r($economic['income_patient']);
                                                                                                                        } ?>" min="1970" min="2023" id="income_patient" name="income_patient" class="form-control" placeholder="Enter patient source" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="smoking_long" class="form-label">How long have you been smoking?</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['smoking_long']);
                                                                                                                        } ?>" min="0" min="1000" id="smoking_long" name="smoking_long" class="form-control" placeholder="Enter Years" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="monthly_earn" class="form-label">How much do you earn in monthly basis from all sources of your income? ( TSHS )</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['monthly_earn']);
                                                                                                                        } ?>" min="0" min="100000000" id="monthly_earn" name="monthly_earn" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="member_earn" class="form-label">In monthly basis, how much does other member of household earn from all source of income?</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['member_earn']);
                                                                                                                        } ?>" min="0" min="100000000" id="member_earn" name="member_earn" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="transport" class="form-label">How much did you pay for transport when you visited the health facility for lung cancer screening?</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['transport']);
                                                                                                                        } ?>" min="0" id="transport" name="transport" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="support_earn" class="form-label">If you were you accompanied by treatment supporter, how much did he/she pay for transport?</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['support_earn']);
                                                                                                                        } ?>" min="0" id="support_earn" name="support_earn" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="food_drinks" class="form-label">How much did you pay for food and drinks?</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['food_drinks']);
                                                                                                                        } ?>" min="0" id="food_drinks" name="food_drinks" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="other_cost" class="form-label">Any other cost incurred? If yes, mention and its amount?</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['other_cost']);
                                                                                                                        } ?>" min="0" id="other_cost" name="other_cost" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-12">
                                                                                        How many hours/days did you lost when attending your clinic?
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="days" class="form-label">Days</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['days']);
                                                                                                                        } ?>" min="0" id="days" name="days" class="form-control" placeholder="Enter days" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="hours" class="form-label">Hours</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['hours']);
                                                                                                                        } ?>" min="0" id="hours" name="hours" class="form-control" placeholder="Enter hours" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-12">
                                                                                        How much did you pay for the following services?
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="registration" class="form-label">Registration ( TSHS )</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['registration']);
                                                                                                                        } ?>" min="0" id="registration" name="registration" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="consultation" class="form-label">Consultation ( TSHS )</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['consultation']);
                                                                                                                        } ?>" min="0" id="consultation" name="consultation" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="diagnostic" class="form-label">Diagnostic tests ( TSHS )</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['diagnostic']);
                                                                                                                        } ?>" min="0" id="diagnostic" name="diagnostic" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="medications" class="form-label">Medications ( TSHS )</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['medications']);
                                                                                                                        } ?>" min="0" id="medications" name="medications" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="col-12">
                                                                                        <div class="mb-3">
                                                                                            <label for="other_medical_cost" class="form-label">Any other direct medical costs ( TSHS )</label>
                                                                                            <input type="number" value="<?php if ($economic) {
                                                                                                                            print_r($economic['other_medical_cost']);
                                                                                                                        } ?>" min="0" id="other_medical_cost" name="other_medical_cost" class="form-control" placeholder="Enter TSHS" required />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $economic['id'] ?>">
                                                                                <input type="hidden" name="cid" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="btn" value="<?= $btn ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="add_economic" class="btn btn-primary" value="<?= $btn ?>Social Economic">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                            <div id="delete_batch<?= $value['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm">
                                                                    <form method="post">
                                                                        <div class="modal-content modal-filled bg-danger">
                                                                            <div class="modal-body p-4">
                                                                                <div class="text-center">
                                                                                    <button type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                                        <i class="ri-close-circle-line h1"> </i>
                                                                                    </button>
                                                                                    <h4 class="mt-2">Delete!</h4>
                                                                                    <p class="mt-3">Are you sure you want to delete this Batch Name?</p>
                                                                                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                                    <input type="submit" name="delete_batch" value="Delete" class="btn btn-danger">
                                                                                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                                                                                </div>
                                                                            </div>
                                                                        </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>Opps! - </strong> No records found!
                                                        </div>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                    <?php } elseif ($_GET['id'] == 3) { ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title"><?= $Sub_Tiltle; ?></h4>
                                        <!-- <p class="text-muted mb-0">
                                        Add <code>.table-bordered</code> & <code>.border-primary</code> can be added to
                                        change colors.
                                    </p> -->
                                        <h4 class="header-title text-end">
                                            <a href=" info.php?id=1&category=<?= $_GET['category'] ?>" class="text-reset fs-16 px-1">
                                                << /i>Back
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered border-primary table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Generic Name</th>
                                                        <th>Batch Number</th>
                                                        <th>Balance</th>
                                                        <th>Units</th>
                                                        <th>Last Check</th>
                                                        <th>Next Check</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($override->get('visit', 'patient_id', $_GET['cid'])) {
                                                        $amnt = 0;
                                                        foreach ($override->getNews2('checking', 'visit_status', 0, 'next_check', date('Y-m-d'), 'maintainance', 1, 'category', $_GET['category']) as $value) {
                                                            $generic = $override->getNews('generic', 'status', 1, 'id', $value['generic_id'])[0];
                                                            $batch = $override->getNews('batch', 'status', 1, 'id', $value['batch_id'])[0];
                                                            $units = $override->getNews('units', 'status', 1, 'id', $value['units'])[0]['name'];
                                                            $balance = 0;
                                                            $total = 'Out of Stock';

                                                            if ($value['amount'] > 0) {
                                                                $balance = $value['amount'];
                                                                $total = ' ';
                                                                if ($generic['maintainance'] == 1) {
                                                                    $status = 'Checked';
                                                                    if ($value['expire_date'] <= date('Y-m-d')) {
                                                                        $status = 'Not Checked';
                                                                    }
                                                                } else {
                                                                    $status = 'Valid';
                                                                    if ($value['expire_date'] <= date('Y-m-d')) {
                                                                        $status = 'Expired';
                                                                    }
                                                                }
                                                            }


                                                    ?>
                                                            <tr>
                                                                <td class="table-user">
                                                                    <?= $generic['name']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $batch['name']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $balance; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $units; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $value['check_date']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $value['next_check']; ?>
                                                                </td>
                                                                <td><?= $total . ' - ' . $status; ?></td>

                                                                <td class="text-center">
                                                                    <div class="form-check form-checkbox-success mb-2">
                                                                        <input type="checkbox" class="form-check-input" id="customCheckcolor2" <?php if ($value['visit_status']) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal<?= $value['id'] ?>">Check</button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <!-- Standard modal content -->
                                                            <div id="standard-modal<?= $value['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">checks</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="checking_date" class="form-label">Enter check Date</label>
                                                                                            <input type="date" value="<?php if ($value['checking_date']) {
                                                                                                                            print_r($value['checking_date']);
                                                                                                                        } ?>" id="checking_date" name="checking_date" class="form-control" placeholder="Enter checking date" required />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="checking_time" class="form-label">Enter check Time</label>
                                                                                            <input type="time" value="<?php if ($value['checking_time']) {
                                                                                                                            print_r($value['checking_time']);
                                                                                                                        } ?>" id="checking_date" name="checking_time" class="form-control" placeholder="Enter checking date" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="col-12">
                                                                                        <div class="mb-3">
                                                                                            <label for="remarks" class="form-label">Remarks / Comments</label>
                                                                                            <textarea class="form-control" name="remarks" id="remarks" rows="5">
                                                                                    <?php if ($value['remarks']) {
                                                                                        print_r($value['remarks']);
                                                                                    } ?>
                                                                                </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="bid" value="<?= $value['batch_id'] ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="Update_check" class="btn btn-primary" value="Save">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>Opps! - </strong> No records found!
                                                        </div>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

                    <?php } elseif ($_GET['id'] == 4) { ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title"><?= $Sub_Tiltle; ?></h4>
                                        <!-- <p class="text-muted mb-0">
                                        Add <code>.table-bordered</code> & <code>.border-primary</code> can be added to
                                        change colors.
                                    </p> -->
                                        <h4 class="header-title text-end">
                                            <a href=" info.php?id=1&category=<?= $_GET['category'] ?>" class="text-reset fs-16 px-1">
                                                << /i>Back
                                            </a>
                                        </h4>

                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered border-primary table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Generic Name</th>
                                                        <th>Batch Number</th>
                                                        <th>Balance</th>
                                                        <th>Units</th>
                                                        <th>Last Check</th>
                                                        <th>Next Check</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($override->get5('checking', 'next_check', date('Y-m-d'), 'visit_status', $_GET['visit_status'], 'category', $_GET['category'])) {
                                                        $amnt = 0;
                                                        foreach ($override->get5('checking', 'next_check', date('Y-m-d'), 'visit_status', $_GET['visit_status'], 'category', $_GET['category']) as $value) {
                                                            $generic = $override->getNews('generic', 'status', 1, 'id', $value['generic_id'])[0];
                                                            $batch = $override->getNews('batch', 'status', 1, 'id', $value['batch_id'])[0];
                                                            $units = $override->getNews('units', 'status', 1, 'id', $value['units'])[0]['name'];
                                                            $batch_total = $override->getSumD2('batch', 'amount', 'generic_id', $value['generic_id'], 'status', 1)[0]['SUM(amount)'];

                                                            $balance = 0;
                                                            $total = 'Out of Stock';

                                                            if ($batch['amount'] > 0) {
                                                                $balance = $value['amount'];
                                                                $total = ' ';
                                                                $status = 'Not Checked';
                                                                if ($value['visit_status'] == 1) {
                                                                    $status = 'Checked';
                                                                }
                                                            }


                                                    ?>
                                                            <tr>
                                                                <td class="table-user">
                                                                    <?= $generic['name']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $batch['name']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $balance; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $units; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $batch['check_date']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $value['next_check']; ?>
                                                                </td>
                                                                <td><?= $total . ' - ' . $status; ?></td>

                                                                <td class="text-center">
                                                                    <div class="form-check form-checkbox-success mb-2">
                                                                        <input type="checkbox" class="form-check-input" id="customCheckcolor2" <?php if ($value['visit_status']) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?> <?php if ($value['visit_status']) {
                                                                                                                                                            echo 'disabled';
                                                                                                                                                        } ?>>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal<?= $value['id'] ?>" <?php if ($value['visit_status']) {
                                                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                                                    } ?>>Check</button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <!-- Standard modal content -->
                                                            <div id="standard-modal<?= $value['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">value
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">checks</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="checking_date" class="form-label">Enter check Date</label>
                                                                                            <input type="date" value="<?php if ($value['checking_date']) {
                                                                                                                            print_r($value['checking_date']);
                                                                                                                        } ?>" id="checking_date" name="checking_date" class="form-control" placeholder="Enter checking date" required />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="checking_time" class="form-label">Enter check Time</label>
                                                                                            <input type="time" value="<?php if ($value['checking_time']) {
                                                                                                                            print_r($value['checking_time']);
                                                                                                                        } ?>" id="checking_date" name="checking_time" class="form-control" placeholder="Enter checking date" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="col-12">
                                                                                        <div class="mb-3">
                                                                                            <label for="remarks" class="form-label">Remarks / Comments</label>
                                                                                            <textarea class="form-control" name="remarks" id="remarks" rows="5" required>
                                                                                             </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="Update_check" class="btn btn-primary" value="Save">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>Opps! - </strong> No records found!
                                                        </div>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                    <?php } elseif ($_GET['id'] == 5) { ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title"><?= $Sub_Tiltle; ?></h4>
                                        <!-- <p class="text-muted mb-0">
                                        Add <code>.table-bordered</code> & <code>.border-primary</code> can be added to
                                        change colors.
                                    </p> -->
                                        <h4 class="header-title text-end">
                                            <a href=" info.php?id=1&category=<?= $_GET['category'] ?>" class="text-reset fs-16 px-1">
                                                << /i>Back
                                            </a>
                                        </h4>

                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered border-primary table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Generic Name</th>
                                                        <th>Batch Number</th>
                                                        <th>Balance</th>
                                                        <th>Units</th>
                                                        <th>Expire Date</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    if ($_GET['expiration'] == 'valid') {
                                                        $expiration = $override->get4('batch', 'expire_date', date('Y-m-d'), 'status', 1, 'category', $_GET['category']);
                                                    } elseif ($_GET['expiration'] == 'expired') {
                                                        $expiration = $override->get5('batch', 'expire_date', date('Y-m-d'), 'status', 1, 'category', $_GET['category']);
                                                    }
                                                    if ($expiration) {
                                                        $amnt = 0;
                                                        foreach ($expiration as $value) {
                                                            $generic = $override->getNews('generic', 'status', 1, 'id', $value['generic_id'])[0];
                                                            $units = $override->getNews('units', 'status', 1, 'id', $value['units'])[0]['name'];
                                                            $batch_total = $override->getSumD2('batch', 'amount', 'generic_id', $value['generic_id'], 'status', 1)[0]['SUM(amount)'];

                                                            $balance = 0;
                                                            $total = 'Out of Stock';

                                                            if ($value['amount'] > 0) {
                                                                $balance = $value['amount'];
                                                                $total = ' ';
                                                                $status = 'Expired';
                                                                if ($value['expire_date'] > date('Y-m-d')) {
                                                                    $status = 'Valid';
                                                                }
                                                            }

                                                    ?>
                                                            <tr>
                                                                <td class="table-user">
                                                                    <?= $generic['name']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $value['name']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $balance; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $units; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $value['expire_date']; ?>
                                                                </td>
                                                                <td><?= $total . ' - ' . $status; ?></td>

                                                                <td class="text-center">
                                                                    <div class="form-check form-checkbox-success mb-2">
                                                                        <?php if ($_GET['expiration'] == 'expired') { ?>
                                                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#standard-modal<?= $value['id'] ?>">Archive</button>
                                                                        <?php } elseif ($_GET['expiration'] == 'valid') { ?>
                                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#increase<?= $value['id'] ?>">Increase</button>
                                                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#dispense<?= $value['id'] ?>">Dispense</button>
                                                                        <?php } ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <!-- Standard modal content -->
                                                            <div id="standard-modal<?= $value['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">Archive</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="archive_date" class="form-label">Enter Archive Date</label>
                                                                                            <input type="date" value="" id="archive_date" name="archive_date" class="form-control" placeholder="Enter archive date" required />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="archive_time" class="form-label">Enter Achive Time</label>
                                                                                            <input type="time" value="" id="archive_time" name="archive_time" class="form-control" placeholder="Enter archive time" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="col-12">
                                                                                        <div class="mb-3">
                                                                                            <label for="remarks" class="form-label">Remarks / Comments</label>
                                                                                            <textarea class="form-control" name="remarks" id="remarks" rows="5" required>
                                                                                             </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="generic_id" value="<?= $generic['id'] ?>">
                                                                                <input type="hidden" name="amount" value="<?= $value['amount'] ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="Archive_batch" class="btn btn-primary" value="Save">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                            <div id="increase<?= $value['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">Increase</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="increase_date" class="form-label">Enter Date</label>
                                                                                            <input type="date" value="" id="increase_date" name="increase_date" class="form-control" placeholder="Enter increase date" required />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="increase_time" class="form-label">Enter Time</label>
                                                                                            <input type="time" value="" id="increase_time" name="increase_time" class="form-control" placeholder="Enter increase time" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="col-4">
                                                                                        <div class="mb-2">
                                                                                            <label for="added" class="form-label">Enter amount</label>
                                                                                            <input type="number" value="" min="0" id="added" name="added" class="form-control" placeholder="Enter amount" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        <div class="mb-3">
                                                                                            <label for="remarks" class="form-label">Remarks / Comments</label>
                                                                                            <textarea class="form-control" name="remarks" id="remarks" rows="5" required>
                                                                                             </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="generic_id" value="<?= $generic['id'] ?>">
                                                                                <input type="hidden" name="amount" value="<?= $value['amount'] ?>">
                                                                                <input type="hidden" name="units" value="<?= $value['units'] ?>">
                                                                                <input type="hidden" name="category" value="<?= $generic['category'] ?>">
                                                                                <input type="hidden" name="brand_name" value="<?= $value['brand_name'] ?>">
                                                                                <input type="hidden" name="study_id" value="<?= $value['study_id'] ?>">
                                                                                <input type="hidden" name="site_id" value="<?= $value['site_id'] ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="Increase_batch" class="btn btn-primary" value="Save">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                            <div id="dispense<?= $value['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">Dispense</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="increase_date" class="form-label">Enter Date</label>
                                                                                            <input type="date" value="" id="dispense_date" name="dispense_date" class="form-control" placeholder="Enter increase date" required />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="increase_time" class="form-label">Enter Time</label>
                                                                                            <input type="time" value="" id="dispense_time" name="dispense_time" class="form-control" placeholder="Enter increase time" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="col-4">
                                                                                        <div class="mb-2">
                                                                                            <label for="added" class="form-label">Enter amount</label>
                                                                                            <input type="number" value="" min="0" id="added" name="added" class="form-control" placeholder="Enter amount" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        <div class="mb-3">
                                                                                            <label for="remarks" class="form-label">Remarks / Comments</label>
                                                                                            <textarea class="form-control" name="remarks" id="remarks" rows="5" required>
                                                                                             </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="generic_id" value="<?= $generic['id'] ?>">
                                                                                <input type="hidden" name="amount" value="<?= $value['amount'] ?>">
                                                                                <input type="hidden" name="units" value="<?= $value['units'] ?>">
                                                                                <input type="hidden" name="category" value="<?= $generic['category'] ?>">
                                                                                <input type="hidden" name="brand_name" value="<?= $value['brand_name'] ?>">
                                                                                <input type="hidden" name="study_id" value="<?= $value['study_id'] ?>">
                                                                                <input type="hidden" name="site_id" value="<?= $value['site_id'] ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="Dispense_batch" class="btn btn-primary" value="Save">
                                                                            </div>
                                                                    </div><!-- /.modal-content -->
                                                                    </form>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>Opps! - </strong> No records found!
                                                        </div>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                    <?php } ?>


                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include 'foot.php' ?>

            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    <?php include 'settings.php' ?>


    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/tables-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:58:35 GMT -->

</html>