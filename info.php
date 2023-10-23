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
        } elseif (Input::get('Update_check')) {
            $validate = $validate->check($_POST, array(
                'checking_date' => array(
                    'required' => true,
                ),
                'checking_time' => array(
                    'required' => true,
                ),
                'remarks' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $user->updateRecord('checking', array(
                    'visit_date' => date('Y-m-d H:i:s'),
                    'check_date' => date('Y-m-d'),
                    'checking_date' => Input::get('checking_date'),
                    'checking_time' => Input::get('checking_time'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                    'remarks' => Input::get('remarks'),
                    'next_notes' => Input::get('remarks'),
                    'visit_status' => 1,
                ), Input::get('id'));

                // $from_today = date('Y-m-d', strtotime('+1 month'));
                $from_today = date('Y-m-d', strtotime('+1 month', strtotime(Input::get('checking_date'))));


                $user->updateRecord('batch', array(
                    'check_date' => Input::get('checking_date'),
                    'next_check' => $from_today,
                    'remarks' => Input::get('remarks'),
                ), Input::get('bid'));

                $successMessage = 'Checked Successful';
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

<head>
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">e-CTMIS</a></li>
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
                                                            if ($batch_total > $value['notification']) {
                                                                $balance = $batch_total;
                                                                $total = 'Sufficient';
                                                            } elseif ($batch_total > 0 && $batch_total < $value['notification']) {
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
                        <?php
                        $generic1 = $override->getNews('generic', 'status', 1, 'id', $_GET['gid'])[0];
                        ?>

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
                                                        <?php if ($generic1['maintainance'] == 2) { ?>
                                                            <th>Expire Date</th>
                                                        <?php   } ?>
                                                        <?php if ($generic1['maintainance'] == 1) { ?>
                                                            <th>Last Check</th>
                                                            <th>Next Check</th>
                                                        <?php   } ?>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($override->getNews('batch', 'status', 1, 'generic_id', $_GET['gid'])) {

                                                        $amnt = 0;
                                                        foreach ($override->getNews('batch', 'status', 1, 'generic_id', $_GET['gid']) as $value) {
                                                            $batch_total = $override->getSumD2('batch', 'amount', 'generic_id', $value['gid'], 'status', 1)[0]['SUM(amount)'];
                                                            $generic = $override->getNews('generic', 'status', 1, 'id', $_GET['gid'])[0];
                                                            $units = $override->getNews('units', 'status', 1, 'id', $value['units'])[0]['name'];
                                                            $checking = $override->lastRow2('checking', 'batch_id', $value['id'], 'id')[0];

                                                            $balance = 0;
                                                            $total = 'Out of Stock';

                                                            if ($value['amount'] > 0) {
                                                                $balance = $value['amount'];
                                                                $total = ' ';
                                                                if ($generic['maintainance'] == 1) {
                                                                    $status = 'Not Checked';
                                                                    if ($checking['visit_status']) {
                                                                        $status = 'Checked';
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
                                                                    <?= $value['name']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $balance; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $units; ?>
                                                                </td>
                                                                <?php if ($generic['maintainance'] == 2) { ?>

                                                                    <td class="table-user">
                                                                        <?= $value['expire_date']; ?>
                                                                    </td>
                                                                <?php   } ?>
                                                                <?php if ($generic['maintainance'] == 1) { ?>

                                                                    <td class="table-user">
                                                                        <?= $value['check_date']; ?>
                                                                    </td>
                                                                    <td class="table-user">
                                                                        <?= $value['next_check']; ?>
                                                                    </td>
                                                                <?php   } ?>

                                                                <td><?= $total . ' - ' . $status; ?></td>

                                                                <td class="text-center">
                                                                    <a href="add.php?id=2&gid=<?= $_GET['gid'] ?>&bid=<?= $value['id'] ?>&category=<?= $_GET['category'] ?>&btn=View" class="text-reset fs-16 px-1"> <i class="ri-edit-circle-line"></i>View</a>
                                                                    <a href="add.php?id=2&gid=<?= $_GET['gid'] ?>&bid=<?= $value['id'] ?>&category=<?= $_GET['category'] ?>&btn=Edit" class="text-reset fs-16 px-1"> <i class="ri-edit-box-line"></i>Update</a>
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#increase<?= $value['id'] ?>">Increase</button>
                                                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#dispense<?= $value['id'] ?>">Dispense</button>
                                                                    <a href="#delete_batch<?= $value['id'] ?>" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_batch<?= $value['id'] ?>">Delete</a>
                                                                </td>
                                                            </tr>
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
                                                            <!-- Danger Alert Modal -->
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
                                                    if ($override->getNews2('checking', 'visit_status', 0, 'next_check', date('Y-m-d'), 'maintainance',1, 'category',$_GET['category'])) {
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