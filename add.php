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
        } elseif (Input::get('add_batch')) {
            $validate = $validate->check($_POST, array(
                'generic_name' => array(
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
                try {
                    if (Input::get('btn') == 'Add') {
                        $user->createRecord('batch', array(
                            'generic_id' => Input::get('generic_name'),
                            'name' => Input::get('batch_name'),
                            'amount' => Input::get('amount'),
                            'brand_name' => Input::get('brand_name'),
                            'status' => 1,
                            'expire_date' => Input::get('expire_date'),
                            'check_date' => date('Y-m-d'),
                            'next_check' => $from_today,
                            'remarks' => Input::get('remarks'),
                            'units' => Input::get('units'),
                            'create_on' => date('Y-m-d H:i:s'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_id' => $user->data()->id,
                            'site_id' => $_GET['site'],
                            'site' => $_GET['site'],
                            'study_id' => $_GET['study'],
                            'study' => $_GET['study'],
                            'category' => $_GET['category'],
                            'maintainance' => Input::get('maintainance'),
                        ));



                        $batch_id = $override->lastRow('batch', 'id')[0];

                        $user->createRecord('batch_records', array(
                            'generic_id' => Input::get('generic_name'),
                            'batch_id' => $batch_id['id'],
                            'amount' => Input::get('amount'),
                            'added' => 0,
                            'removed' => 0,
                            'brand_name' => Input::get('brand_name'),
                            'status' => 1,
                            'increase_date' => date('Y-m-d'),
                            'increase_time' => date('H:i'),
                            'remarks' => Input::get('remarks'),
                            'units' => Input::get('units'),
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'site_id' => $_GET['site'],
                            'site' => $_GET['site'],
                            'study_id' => $_GET['study'],
                            'study' => $_GET['study'],
                            'category' => $_GET['category'],
                        ));

                        $user->createRecord('checking', array(
                            'generic_id' => $batch_id['generic_id'],
                            'batch_id' => $batch_id['id'],
                            'amount' => $batch_id['amount'],
                            'visit_date' => date('Y-m-d H:i:s'),
                            'check_date' => date('Y-m-d'),
                            'next_check' => date('Y-m-d'),
                            'expected_date' => date('Y-m-d H:i:s'),
                            'checking_date' => date('Y-m-d'),
                            'checking_time' => date('H:i:s'),
                            'units' => $batch_id['units'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_id' => $user->data()->id,
                            'site_id' => $batch_id['site_id'],
                            'site' => $batch_id['site'],
                            'study_id' => $batch_id['study_id'],
                            'study' => $batch_id['study'],
                            'category' => $batch_id['category'],
                            'maintainance' => $batch_id['maintainance'],
                            'remarks' => $batch_id['remarks'],
                            'next_notes' => Input::get('next_notes'),
                            'visit_window1' => 2,
                            'visit_window2' => 2,
                            'status' => 1,
                            'seq_no' => 1,
                            'visit_status' => 1,
                            'check_number' => 'Month 1',
                        ));

                        $last_check = $override->lastRow2('checking', 'batch_id', $batch_id['id'], 'id')[0];
                        $sq = $last_check['seq_no'] + 1;
                        $check_month = 'Month ' . $sq;

                        $user->createRecord('checking', array(
                            'generic_id' => $batch_id['generic_id'],
                            'batch_id' => $batch_id['id'],
                            'amount' => $batch_id['amount'],
                            'check_date' => '',
                            'visit_date' => '',
                            'next_check' => $from_today,
                            'expected_date' => $from_today1,
                            'units' => $batch_id['units'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_id' => $user->data()->id,
                            'site_id' => $batch_id['site_id'],
                            'site' => $batch_id['site'],
                            'study_id' => $batch_id['study_id'],
                            'study' => $batch_id['study'],
                            'category' => $batch_id['category'],
                            'maintainance' => $batch_id['maintainance'],
                            'remarks' => $batch_id['remarks'],
                            'next_notes' => Input::get('next_notes'),
                            'visit_window1' => 2,
                            'visit_window2' => 2,
                            'status' => 0,
                            'seq_no' => $sq,
                            'visit_status' => 0,
                            'check_number' => $check_month,
                        ));

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


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/form-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:58:02 GMT -->
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
                                        <li class="breadcrumb-item"><a href="dashboard.php">e-CTMIS</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                        <li class="breadcrumb-item active"><?= $Tiltle; ?></li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?= $Tiltle; ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <?php if ($_GET['id'] == 1) {
                        $generic = $override->getNews('generic', 'status', 1, 'id', $_GET['gid'])[0];
                        $use_case = $override->getNews('use_case', 'status', 1, 'id', $generic['use_case'])[0];
                        $maintainance = $override->getNews('maintainance', 'status', 1, 'id', $generic['maintainance'])[0];
                    ?>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title"><?= $Sub_Tiltle; ?></h4>
                                        <!-- <p class="text-muted mb-0">
                                            List of generics<code>text</code>, <code>color</code>.
                                        </p> -->
                                    </div>
                                    <div class="card-body">
                                        <form id="validation" method="post">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" value="<?php if ($generic) {
                                                                                        print_r($generic['name']);
                                                                                    } ?>" id="name" name="name" class="form-control" placeholder="Enter generic name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="notification" class="form-label">Notification</label>
                                                        <input type="number" value="<?php if ($generic) {
                                                                                        print_r($generic['notification']);
                                                                                    } ?>" id="notification" name="notification" min="0" max="100000" class="form-control" placeholder="Enter notification amount" required />
                                                    </div>
                                                </div>
                                                <!-- </div>

                                            <div class="row"> -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="maintainance" class="form-label">Maintainance</label>
                                                        <select id="maintainance" name="maintainance" class="form-select form-select-lg mb-3" required>
                                                            <option value="<?= $maintainance['id'] ?>"><?php if ($maintainance) {
                                                                                                            print_r($maintainance['name']);
                                                                                                        } else {
                                                                                                            echo 'Select maintainance type';
                                                                                                        } ?>
                                                            </option>
                                                            <?php foreach ($override->get('maintainance', 'status', 1) as $value) { ?>
                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="use_case" class="form-label">Use Case</label>
                                                        <select id="use_case" name="use_case" class="form-select form-select-lg mb-3" required>
                                                            <option value="<?= $use_case['id'] ?>"><?php if ($use_case) {
                                                                                                        print_r($use_case['name']);
                                                                                                    } else {
                                                                                                        echo 'Select use case';
                                                                                                    } ?>
                                                            </option>
                                                            <?php foreach ($override->get('use_case', 'status', 1) as $value) { ?>
                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="hidden" name="id" value="<?= $_GET['gid'] ?>" />
                                                        <input type="hidden" name="btn" value="<?= $_GET['btn'] ?>" />
                                                        <a href="info.php?id=<?= $_GET['id'] ?>&gid=<?= $_GET['gid'] ?>&category=<?= $_GET['category'] ?>&btn=<?= $_GET['btn'] ?>" class="text-reset fs-16 px-1">
                                                            << /i>Back
                                                        </a>
                                                        <?php if ($_GET['btn'] != 'View') { ?>
                                                            <input type="submit" name="add_generic" value="<?= $_GET['btn'] ?>" class="btn btn-info" />
                                                        <?php } ?>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div>
                                            <!-- end row-->
                                        </form>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div><!-- end col -->
                        </div><!-- end row -->

                    <?php } elseif ($_GET['id'] == 2) {
                        $batch = $override->getNews('batch', 'status', 1, 'id', $_GET['bid'])[0];
                        $generic = $override->getNews('generic', 'status', 1, 'id', $_GET['gid'])[0];
                        $use_case = $override->getNews('use_case', 'status', 1, 'id', $generic['use_case'])[0];
                        $units = $override->getNews('units', 'status', 1, 'id', $batch['units'])[0];
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title"><?= $Sub_Tiltle; ?></h4>
                                        <!-- <p class="text-muted mb-0">
                                            List of generics<code>text</code>, <code>color</code>.
                                        </p> -->
                                    </div>
                                    <div class="card-body">
                                        <form id="validation" method="post">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-2">
                                                        <label for="generic_name" class="form-label">Generic</label>
                                                        <select id="generic_name" name="generic_name" class="form-select form-select-lg mb-3" required>
                                                            <option value="<?= $generic['id'] ?>"><?php if ($batch) {
                                                                                                        print_r($generic['name']);
                                                                                                    } else {
                                                                                                        echo 'Select generic name';
                                                                                                    } ?>
                                                            </option>
                                                            <?php foreach ($override->getNews('generic', 'status', 1, 'category', $_GET['category']) as $value) { ?>
                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="brand_name" class="form-label">Brand</label>
                                                        <input type="text" value="<?php if ($batch) {
                                                                                        print_r($batch['brand_name']);
                                                                                    } ?>" id="brand_name" name="brand_name" class="form-control" placeholder="Enter brand name">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">

                                                    <div class="mb-2">
                                                        <label for="batch_name" class="form-label">Batch / Name</label>
                                                        <input type="text" value="<?php if ($batch) {
                                                                                        print_r($batch['name']);
                                                                                    } ?>" id="batch_name" name="batch_name" class="form-control" placeholder="Enter batch name" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="amount" class="form-label">Amount</label>
                                                        <input type="number" value="<?php if ($batch) {
                                                                                        print_r($batch['amount']);
                                                                                    } ?>" id="amount" name="amount" min="0" max="100000" class="form-control" placeholder="Enter Amount Received / Available" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">

                                                    <div id="expire_date1" class="mb-3">
                                                        <div class="mb-2">
                                                            <label for="expire_date" class="form-label">Expire Date</label>
                                                            <input type="date" value="<?php if ($batch) {
                                                                                            print_r($batch['expire_date']);
                                                                                        } ?>" id="expire_date" name="expire_date" class="form-control" placeholder="Enter expire_date" required />
                                                        </div>
                                                    </div>


                                                    <div class="mb-2">
                                                        <label for="units" class="form-label">Units</label>
                                                        <select id="units" name="units" class="form-select form-select-lg mb-3" required>
                                                            <option value="<?= $units['id'] ?>"><?php if ($batch) {
                                                                                                    print_r($units['name']);
                                                                                                } else {
                                                                                                    echo 'Select units';
                                                                                                } ?>
                                                            </option>
                                                            <?php foreach ($override->get('units', 'status', 1) as $value) { ?>
                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- end col -->
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="remarks" class="form-label">Remarks / Comments</label>
                                                        <textarea class="form-control" name="remarks" id="remarks" rows="5">
                                                            <?php if ($batch) {
                                                                print_r($batch['remarks']);
                                                            } ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <input type="hidden" name="id" value="<?= $_GET['bid'] ?>" />
                                                    <input type="hidden" name="btn" value="<?= $_GET['btn'] ?>" />
                                                    <input type="hidden" name="maintainance" id="maintainance_id" />
                                                    <a href="info.php?id=<?= $_GET['id'] ?>&gid=<?= $_GET['gid'] ?>&category=<?= $_GET['category'] ?>&btn=<?= $_GET['btn'] ?>" class="text-reset fs-16 px-1">
                                                        << /i>Back
                                                    </a>
                                                    <?php if ($_GET['btn'] != 'View') { ?>
                                                        <input type="submit" name="add_batch" value="<?= $_GET['btn'] ?>" class="btn btn-info" />
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <!-- end row-->
                                        </form>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div><!-- end col -->
                        </div><!-- end row -->

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
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#generic_name').change(function() {
                var getUid = $(this).val();
                $('#expire_date').show();
                $.ajax({
                    url: "process.php?content=generic_name",
                    method: "GET",
                    data: {
                        getUid: getUid
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#maintainance_id').val(data.maintainance);
                        if (data.maintainance == 1) {
                            $('#expire_date1').hide();
                            $('#expire_date').prop('required', false);
                        }
                    }
                });
            });
        })
    </script>

    <!-- Theme Settings -->
    <?php include 'settings.php' ?>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/form-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:58:02 GMT -->

</html>