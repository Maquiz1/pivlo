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
$numRec = 10;
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('add_user')) {
            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);
            if ($staff) {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                ));
            } else {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                    'username' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'phone_number' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'email_address' => array(
                        'unique' => 'user'
                    ),
                ));
            }
            if ($validate->passed()) {
                $salt = $random->get_rand_alphanumeric(32);
                $password = '12345678';
                switch (Input::get('position')) {
                    case 1:
                        $accessLevel = 1;
                        break;
                    case 2:
                        $accessLevel = 1;
                        break;
                    case 3:
                        $accessLevel = 2;
                        break;
                    case 4:
                        $accessLevel = 3;
                        break;
                    case 5:
                        $accessLevel = 3;
                        break;
                }
                try {

                    // $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);

                    if ($staff) {
                        $user->updateRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => $accessLevel,
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
                            'site_id' => Input::get('site_id'),
                        ), $_GET['staff_id']);

                        $successMessage = 'Account Updated Successful';
                    } else {
                        $user->createRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => $accessLevel,
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
                            'create_on' => date('Y-m-d'),
                            'last_login' => '',
                            'status' => 1,
                            'user_id' => $user->data()->id,
                            'site_id' => Input::get('site_id'),
                            'count' => 0,
                            'pswd' => 0,
                        ));
                        $successMessage = 'Account Created Successful';
                    }

                    Redirect::to('info.php?id=1&status=1');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_position')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('position', array(
                        'name' => Input::get('name'),
                    ));
                    $successMessage = 'Position Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_site')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $site = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id']);
                    if ($site) {
                        $user->updateRecord('sites', array(
                            'name' => Input::get('name'),
                            'entry_date' => Input::get('entry_date'),
                            'arm' => Input::get('arm'),
                            'level' => Input::get('level'),
                            'type' => Input::get('type'),
                            'category' => Input::get('category'),
                            'respondent' => Input::get('respondent'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $site[0]['id']);
                        $successMessage = 'Site Successful Updated';
                    } else {
                        $user->createRecord('sites', array(
                            'name' => Input::get('name'),
                            'entry_date' => Input::get('entry_date'),
                            'arm' => Input::get('arm'),
                            'level' => Input::get('level'),
                            'type' => Input::get('type'),
                            'category' => Input::get('category'),
                            'respondent' => Input::get('respondent'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'status' => 1,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ));
                        $successMessage = 'Site Successful Added';
                    }

                    // $user->visit_delete1($_GET['site_id'], Input::get('visit_date'), $_GET['site_id'], $user->data()->id, $_GET['site_id'], $eligible, $sequence, $visit_code, $visit_name);

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_client')) {
            if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                $validate = $validate->check($_POST, array(
                    'date_registered' => array(
                        'required' => true,
                    ),
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'sex' => array(
                        'required' => true,
                    ),
                    'hospital_id' => array(
                        'required' => true,
                        // 'unique' => 'clients'
                    ),
                    'site' => array(
                        'required' => true,
                    ),
                ));
            } else {
                $validate = $validate->check($_POST, array(
                    'date_registered' => array(
                        'required' => true,
                    ),
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'sex' => array(
                        'required' => true,
                    ),
                    'hospital_id' => array(
                        'required' => true,
                        // 'unique' => 'clients'
                    ),
                ));
            }
            if ($validate->passed()) {
                // $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                try {
                    $site_id = $user->data()->site_id;
                    if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                        $site_id = Input::get('site');
                    }



                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                    $age = $user->dateDiffYears(Input::get('date_registered'), Input::get('dob'));

                    $screened = 0;
                    $eligible = 0;
                    $enrolled = 0;
                    $end_study = 0;
                    if ($age >= 1) {
                        $screened = 1;
                        $eligible = 1;
                    }

                    if ($clients) {
                        $user->updateRecord('clients', array(
                            'date_registered' => Input::get('date_registered'),
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'hospital_id' => Input::get('hospital_id'),
                            'ctc_id' => Input::get('ctc_id'),
                            'patient_phone' => Input::get('patient_phone'),
                            'patient_phone2' => Input::get('patient_phone2'),
                            'supporter_fname' => Input::get('supporter_fname'),
                            'supporter_mname' => Input::get('supporter_mname'),
                            'supporter_lname' => Input::get('supporter_lname'),
                            'supporter_phone' => Input::get('supporter_phone'),
                            'supporter_phone2' => Input::get('supporter_phone2'),
                            'relation_patient' => Input::get('relation_patient'),
                            'relation_patient_other' => Input::get('relation_patient_other'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'street' => Input::get('street'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => Input::get('head_household'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'pay_services' => Input::get('pay_services'),
                            'insurance_name_other' => Input::get('insurance_name_other'),
                            'respondent' => Input::get('respondent'),
                            'screened' => $screened,
                            'eligible' => $eligible,
                            'enrolled' => $enrolled,
                            'end_study' => $end_study,
                            'comments' => Input::get('comments'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['cid']);

                        $successMessage = 'Client Updated Successful';
                    } else {

                        $std_id = $override->getNews('study_id', 'site_id', $site_id, 'status', 0)[0];

                        $user->createRecord('clients', array(
                            'sequence' => 0,
                            'visit_code' => 'M00',
                            'date_registered' => Input::get('date_registered'),
                            'study_id' => $std_id['study_id'],
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'hospital_id' => Input::get('hospital_id'),
                            'ctc_id' => Input::get('ctc_id'),
                            'patient_phone' => Input::get('patient_phone'),
                            'patient_phone2' => Input::get('patient_phone2'),
                            'supporter_fname' => Input::get('supporter_fname'),
                            'supporter_mname' => Input::get('supporter_mname'),
                            'supporter_lname' => Input::get('supporter_lname'),
                            'supporter_phone' => Input::get('supporter_phone'),
                            'supporter_phone2' => Input::get('supporter_phone2'),
                            'relation_patient' => Input::get('relation_patient'),
                            'relation_patient_other' => Input::get('relation_patient_other'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'street' => Input::get('street'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => Input::get('head_household'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'insurance_name_other' => Input::get('insurance_name_other'),
                            'pay_services' => Input::get('pay_services'),
                            'comments' => Input::get('comments'),
                            'respondent' => Input::get('respondent'),
                            'status' => 1,
                            'screened' => $screened,
                            'eligible' => $eligible,
                            'enrolled' => $enrolled,
                            'end_study' => $end_study,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $site_id,
                        ));

                        $last_row = $override->lastRow('clients', 'id')[0];

                        $user->updateRecord('study_id', array(
                            'status' => 1,
                            'client_id' => $last_row['id'],
                        ), $std_id['id']);

                        $user->createRecord('visit', array(
                            'sequence' => 0,
                            'study_id' => $std_id['study_id'],
                            'pid' => $std_id['study_id'],
                            'visit_code' => 'M00',
                            'visit_name' => 'Month 0',
                            'expected_date' => Input::get('date_registered'),
                            'visit_date' => '',
                            'visit_status' => 0,
                            'status' => 1,
                            'patient_id' => $last_row['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $site_id,
                        ));

                        $successMessage = 'Client  Added Successful';
                    }
                    Redirect::to('info.php?id=3&status=7');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_individual')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'previous_vl_date' => array(
                    'required' => true,
                ),
                'recent_vl_results' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // print_r($_POST);
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $individual = $override->getNews('individual', 'status', 1, 'patient_id', $_GET['cid']);
                $first_line = 0;
                $second_line = 0;
                $third_line = 0;
                $sequence = '';
                $visit_code = '';
                $visit_name = '';

                if (Input::get('first_line')) {
                    $first_line = Input::get('first_line');
                }

                if (Input::get('second_line')) {
                    $second_line = Input::get('second_line');
                }

                if (Input::get('third_line')) {
                    $third_line = Input::get('third_line');
                }

                // $expected_date = date('Y-m-d', strtotime('+1 month', strtotime(Input::get('visit_date'))));

                // $last_visit = $override->getlastRow1('visit', 'patient_id', $clients['id'], 'sequence', $_GET['sequence'], 'id')[0];
                $sequence = intval($_GET['sequence']) + 1;
                if ($sequence) {
                    $visit_code = 'M' . $sequence;
                    $visit_name = 'Month ' . $sequence;
                }

                $enrolled = 0;
                $end_study = 0;
                if (Input::get('next_appointment') == 1) {
                    $enrolled = 1;
                }

                if ($individual) {
                    $user->updateRecord('individual', array(
                        'visit_date' => Input::get('visit_date'),
                        'previous_vl_date' => Input::get('previous_vl_date'),
                        'recent_vl_results' => Input::get('recent_vl_results'),
                        'trained_pivlo' => Input::get('trained_pivlo'),
                        'initiate_test_hcw' => Input::get('initiate_test_hcw'),
                        'tested_this_month' => Input::get('tested_this_month'),
                        'new_vl_date' => Input::get('new_vl_date'),
                        'new_vl_results' => Input::get('new_vl_results'),
                        'recent_cd4' => Input::get('recent_cd4'),
                        'cd4_date' => Input::get('cd4_date'),
                        'recent_tb_results' => Input::get('recent_tb_results'),
                        'recent_tb_date' => Input::get('recent_tb_date'),
                        'date_art_treatment' => Input::get('date_art_treatment'),
                        'art_regimen' => Input::get('art_regimen'),
                        'art_regimen_other' => Input::get('art_regimen_other'),
                        'first_line' => $first_line,
                        'other_first_line' => Input::get('other_first_line'),
                        'second_line' => $second_line,
                        'other_second_line' => Input::get('other_second_line'),
                        'third_line' => $third_line,
                        'other_third_line' => Input::get('other_third_line'),
                        'weight' => Input::get('weight'),
                        'height' => Input::get('height'),
                        'systolic' => Input::get('systolic'),
                        'diastolic' => Input::get('diastolic'),
                        'chronic_condition' => Input::get('chronic_condition'),
                        'other_chronic' => Input::get('other_chronic'),
                        'reasons' => Input::get('reasons'),
                        'next_appointment' => Input::get('next_appointment'),
                        'next_date' => Input::get('next_date'),
                        'comments' => Input::get('comments'),
                        'individual_complete' => Input::get('individual_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $individual[0]['id']);

                    $successMessage = 'Individual  Successful Updated';
                } else {
                    $user->createRecord('individual', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $clients['study_id'],
                        'study_id' => $clients['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'previous_vl_date' => Input::get('previous_vl_date'),
                        'recent_vl_results' => Input::get('recent_vl_results'),
                        'trained_pivlo' => Input::get('trained_pivlo'),
                        'initiate_test_hcw' => Input::get('initiate_test_hcw'),
                        'tested_this_month' => Input::get('tested_this_month'),
                        'new_vl_date' => Input::get('new_vl_date'),
                        'new_vl_results' => Input::get('new_vl_results'),
                        'recent_cd4' => Input::get('recent_cd4'),
                        'cd4_date' => Input::get('cd4_date'),
                        'recent_tb_results' => Input::get('recent_tb_results'),
                        'recent_tb_date' => Input::get('recent_tb_date'),
                        'date_art_treatment' => Input::get('date_art_treatment'),
                        'art_regimen' => Input::get('art_regimen'),
                        'art_regimen_other' => Input::get('art_regimen_other'),
                        'first_line' => $first_line,
                        'other_first_line' => Input::get('other_first_line'),
                        'second_line' => $second_line,
                        'other_second_line' => Input::get('other_second_line'),
                        'third_line' => $third_line,
                        'other_third_line' => Input::get('other_third_line'),
                        'weight' => Input::get('weight'),
                        'height' => Input::get('height'),
                        'systolic' => Input::get('systolic'),
                        'diastolic' => Input::get('diastolic'),
                        'chronic_condition' => Input::get('chronic_condition'),
                        'other_chronic' => Input::get('other_chronic'),
                        'reasons' => Input::get('reasons'),
                        'next_appointment' => Input::get('next_appointment'),
                        'next_date' => Input::get('next_date'),
                        'comments' => Input::get('comments'),
                        'individual_complete' => Input::get('individual_complete'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'Individual  Successful Added';
                }


                $user->updateRecord('clients', array(
                    'enrolled' => $enrolled,
                ), $clients['id']);

                $user->visit_delete1($clients['id'], Input::get('next_date'), $clients['study_id'], $user->data()->id, $clients['site_id'], $enrolled, $sequence, $visit_code, $visit_name);


                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $user->updateRecord('visit', array(
                    'visit_date' => Input::get('visit_date'),
                    'visit_status' => Input::get('visit_status'),
                    'comments' => Input::get('comments'),
                    'status' => 1,
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_screening')) {
            $validate = $validate->check($_POST, array(
                'screening_date' => array(
                    'required' => true,
                ),
                'conset' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $screening = $override->get3('screening', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', 0);
                $sequence = 1;
                $visit_code = '';
                $visit_name = '';
                $eligible = 0;
                if (Input::get('conset') == 1) {
                    $eligible = 1;
                    $sequence = 1;
                    $visit_code = 'M' . $sequence;
                    $visit_name = 'Month ' . $sequence;
                }

                if ($screening) {
                    $user->updateRecord('screening', array(
                        'screening_date' => Input::get('screening_date'),
                        'conset' => Input::get('conset'),
                        'conset_date' => Input::get('conset_date'),
                        'comments' => Input::get('comments'),
                        'eligible' => $eligible,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $screening[0]['id']);

                    $successMessage = 'Screening  Successful Updated';
                } else {
                    $user->createRecord('screening', array(
                        'sequence' => 0,
                        'vid' => $_GET['vid'],
                        'pid' => $clients['study_id'],
                        'visit_code' => 'M0',
                        'study_id' => $clients['study_id'],
                        'screening_date' => Input::get('screening_date'),
                        'conset' => Input::get('conset'),
                        'conset_date' => Input::get('conset_date'),
                        'comments' => Input::get('comments'),
                        'eligible' => $eligible,
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));
                    $successMessage = 'Screening  Successful Added';
                }

                $user->visit_delete1($clients['id'], Input::get('screening_date'), $clients['study_id'], $user->data()->id, $clients['site_id'], $eligible, $sequence, $visit_code, $visit_name, $clients['respondent'], 0, $clients['site_id']);


                $user->updateRecord('clients', array(
                    'eligible' => $eligible,
                ), $clients['id']);



                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_facility')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'month_name' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {

                $sites = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];

                $facility = $override->get3('facility', 'status', 1, 'site_id', $_GET['site_id'], 'sequence', $_GET['sequence']);
                $first_line = 0;
                $second_line = 0;
                $third_line = 0;
                $sequence = '';
                $visit_code = '';
                $visit_name = '';

                // if (Input::get('first_line')) {
                //     $first_line = Input::get('first_line');
                // }

                // if (Input::get('second_line')) {
                //     $second_line = Input::get('second_line');
                // }

                // if (Input::get('third_line')) {
                //     $third_line = Input::get('third_line');
                // }

                // $expected_date = date('Y-m-d', strtotime('+1 month', strtotime(Input::get('visit_date'))));

                // $last_visit = $override->getlastRow1('visit', 'patient_id', $clients['id'], 'sequence', $_GET['sequence'], 'id')[0];

                $sequence = intval($_GET['sequence']) + 1;
                if ($sequence) {
                    $visit_code = 'M' . $sequence;
                    $visit_name = 'Month ' . $sequence;
                }
                if ($facility) {
                    $user->updateRecord('facility', array(
                        'facility_id' => Input::get('facility_id'),
                        'visit_date' => Input::get('visit_date'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => Input::get('appointments'),
                        'month_name' => Input::get('month_name'),
                        'patients_tested' => Input::get('patients_tested'),
                        'vl_results_available' => Input::get('vl_results_available'),
                        'comments' => Input::get('comments'),
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => Input::get('facility_completed'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $facility[0]['id']);

                    $successMessage = 'Facility  Successful Updated';
                } else {
                    $user->createRecord('facility', array(
                        'sequence' => $_GET['sequence'],
                        'vid' => $_GET['vid'],
                        'visit_code' => $_GET['visit_code'],
                        'facility_id' => Input::get('facility_id'),
                        'visit_date' => Input::get('visit_date'),
                        'facility_arm' => Input::get('facility_arm'),
                        'facility_level' => Input::get('facility_level'),
                        'facility_type' => Input::get('facility_type'),
                        'appointments' => Input::get('appointments'),
                        'month_name' => Input::get('month_name'),
                        'patients_tested' => Input::get('patients_tested'),
                        'vl_results_available' => Input::get('vl_results_available'),
                        'comments' => Input::get('comments'),
                        'respondent' => $_GET['respondent'],
                        'facility_completed' => Input::get('facility_completed'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $_GET['site_id'],
                    ));
                    $successMessage = 'Facility  Successful Added';
                }

                // $user->visit_delete1($_GET['site_id'], Input::get('visit_date'), $_GET['site_id'], $user->data()->id, $_GET['site_id'], $eligible, $sequence, $visit_code, $visit_name);


                // Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_facility_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $user->updateRecord('visit', array(
                    'visit_date' => Input::get('visit_date'),
                    'visit_status' => Input::get('visit_status'),
                    'comments' => Input::get('comments'),
                    'status' => 1,
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_region')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $regions = $override->get('regions', 'id', $_GET['region_id']);
                    if ($regions) {
                        $user->updateRecord('regions', array(
                            'name' => Input::get('name'),
                        ), $_GET['region_id']);
                        $successMessage = 'Region Successful Updated';
                    } else {
                        $user->createRecord('regions', array(
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Region Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_district')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $districts = $override->get('districts', 'id', $_GET['district_id']);
                    if ($districts) {
                        $user->updateRecord('districts', array(
                            'region_id' => $_GET['region_id'],
                            'name' => Input::get('name'),
                        ), $_GET['district_id']);
                        $successMessage = 'District Successful Updated';
                    } else {
                        $user->createRecord('districts', array(
                            'region_id' => Input::get('region_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'District Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_ward')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'district_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $wards = $override->get('wards', 'id', $_GET['ward_id']);
                    if ($wards) {
                        $user->updateRecord('wards', array(
                            'region_id' => $_GET['region_id'],
                            'district_id' => $_GET['district_id'],
                            'name' => Input::get('name'),
                        ), $_GET['ward_id']);
                        $successMessage = 'Ward Successful Updated';
                    } else {
                        $user->createRecord('wards', array(
                            'region_id' => Input::get('region_id'),
                            'district_id' => Input::get('district_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Ward Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
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

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pivlo Database | Add Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        #medication_table {
            border-collapse: collapse;
        }

        #medication_table th,
        #medication_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #medication_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        #medication_table {
            border-collapse: collapse;
        }

        #medication_list th,
        #medication_list td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #medication_list th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .remove-row {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .remove-row:hover {
            background-color: #da190b;
        }

        .edit-row {
            background-color: #3FF22F;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .edit-row:hover {
            background-color: #da190b;
        }

        #hospitalization_details_table {
            border-collapse: collapse;
        }

        #hospitalization_details_table th,
        #hospitalization_details_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #hospitalization_details_table th,
        #hospitalization_details_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #hospitalization_details_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        #sickle_cell_table {
            border-collapse: collapse;
        }

        #sickle_cell_table th,
        #sickle_cell_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #sickle_cell_table th,
        #sickle_cell_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #sickle_cell_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidemenu.php'; ?>

        <?php if ($errorMessage) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?= $errorMessage ?>
            </div>
        <?php } elseif ($pageError) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?php foreach ($pageError as $error) {
                    echo $error . ' , ';
                } ?>
            </div>
        <?php } elseif ($successMessage) { ?>
            <div class="alert alert-success text-center">
                <h4>Success!</h4>
                <?= $successMessage ?>
            </div>
        <?php } ?>

        <?php if ($_GET['id'] == 1 && ($user->data()->position == 1 || $user->data()->position == 2)) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Staff</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=1">
                                            < Back </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=1">
                                            Go to staff list >
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Staff</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id'])[0];
                            $site = $override->get('sites', 'id', $staff['site_id'])[0];
                            $position = $override->get('position', 'id', $staff['position'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Client Details</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="firstname" id="firstname" value="<?php if ($staff['firstname']) {
                                                                                                                                                print_r($staff['firstname']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input class="form-control" type="text" name="middlename" id="middlename" value="<?php if ($staff['middlename']) {
                                                                                                                                                    print_r($staff['middlename']);
                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="lastname" id="lastname" value="<?php if ($staff['lastname']) {
                                                                                                                                                print_r($staff['lastname']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>User Name</label>
                                                            <input class="form-control" type="text" name="username" id="username" value="<?php if ($staff['username']) {
                                                                                                                                                print_r($staff['username']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Contacts</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone_number" id="phone_number" value="<?php if ($staff['phone_number']) {
                                                                                                                                                                                                            print_r($staff['phone_number']);
                                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Phone Number 2</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone_number2" id="phone_number2" value="<?php if ($staff['phone_number2']) {
                                                                                                                                                                                                            print_r($staff['phone_number2']);
                                                                                                                                                                                                        }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>E-mail Address</label>
                                                            <input class="form-control" type="email" name="email_address" id="email_address" value="<?php if ($staff['email_address']) {
                                                                                                                                                        print_r($staff['email_address']);
                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>SEX</label>
                                                            <select class="form-control" name="sex" style="width: 100%;" required>
                                                                <option value="<?= $staff['sex'] ?>"><?php if ($staff['sex']) {
                                                                                                            if ($staff['sex'] == 1) {
                                                                                                                echo 'Male';
                                                                                                            } elseif ($staff['sex'] == 2) {
                                                                                                                echo 'Female';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?></option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Location And Access Levels</h3>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Site</label>
                                                            <select class="form-control" name="site_id" style="width: 100%;" required>
                                                                <option value="<?= $site['id'] ?>"><?php if ($staff['site_id']) {
                                                                                                        print_r($site['name']);
                                                                                                    } else {
                                                                                                        echo 'Select';
                                                                                                    } ?>
                                                                </option>
                                                                <?php foreach ($override->getData('sites') as $site) { ?>
                                                                    <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Position</label>
                                                            <select class="form-control" name="position" style="width: 100%;" required>
                                                                <option value="<?= $position['id'] ?>"><?php if ($staff['position']) {
                                                                                                            print_r($position['name']);
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('position', 'status', 1) as $position) { ?>
                                                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Access Level</label>
                                                            <input class="form-control" type="number" min="0" max="3" name="accessLevel" id="accessLevel" value="<?php if ($staff['accessLevel']) {
                                                                                                                                                                        print_r($staff['accessLevel']);
                                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Power</label>
                                                            <input class="form-control" type="number" min="0" max="2" name="power" id="power" value="0" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=1" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_user" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 2) { ?>
        <?php } elseif ($_GET['id'] == 3) { ?>
            <?php
            $sites = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];
            $regions = $override->get('regions', 'id', $_GET['region_id']);
            $districts = $override->getNews('districts', 'region_id', $_GET['region_id'], 'id', $_GET['district_id']);
            $wards = $override->get('wards', 'id', $_GET['ward_id']);
            // print_r($regions)
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($sites) { ?>
                                    <h1>Add New Site</h1>
                                <?php } else { ?>
                                    <h1>Update Site</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=12&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=11&status=<?= $_GET['status']; ?>">
                                            Go to Facilities list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($sites) { ?>
                                        <li class="breadcrumb-item active">Add New Site</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Site</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Name & Date</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="entry_date" class="form-label">Date of Entry</label>
                                                        <input type="date" value="<?php if ($sites['entry_date']) {
                                                                                        print_r($sites['entry_date']);
                                                                                    } ?>" id="entry_date" name="entry_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" value="<?php if ($sites['name']) {
                                                                                        print_r($sites['name']);
                                                                                    } ?>" id="name" name="name" class="form-control" placeholder="Enter here name" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ARMS, LEVEL , TYPE & CATEGORY</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="arm" class="form-label">Arm</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_arm', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="arm" id="arm<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['arm'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="level" class="form-label">Level</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_level', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="level" id="level<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['level'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="type" class="form-label">Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="type" id="type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['type'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="category" class="form-label">Category</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_category', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="category" id="category<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['category'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="category" class="form-label">Respondent Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->getNews('respondent_type', 'status', 1, 'respondent', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="respondent" id="respondent<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['respondent'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Adress</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region" name="region" class="form-control" required>
                                                                <option value="<?= $regions['id'] ?>"><?php if ($sites['region']) {
                                                                                                            print_r($regions[0]['name']);
                                                                                                        } else {
                                                                                                            echo 'Select region';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="<?= $districts['id'] ?>"><?php if ($sites['district']) {
                                                                                                            print_r($districts[0]['name']);
                                                                                                        } else {
                                                                                                            echo 'Select district';
                                                                                                        } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward</label>
                                                            <select id="ward" name="ward" class="form-control" required>
                                                                <option value="<?= $wards['id'] ?>"><?php if ($sites['ward']) {
                                                                                                        print_r($wards[0]['name']);
                                                                                                    } else {
                                                                                                        echo 'Select district';
                                                                                                    } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=11&site_id=<?= $sites['id'] ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="site_id" value="<?= $sites['id'] ?>">
                                            <input type="submit" name="add_site" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 4) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Client</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=3&&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            <?php if ($_GET['status'] == 1) { ?>
                                                Go to screening list >
                                            <?php } elseif ($_GET['status'] == 2) { ?>
                                                Go to eligible list >
                                            <?php } elseif ($_GET['status'] == 3) { ?>
                                                Go to enrollment list >
                                            <?php } elseif ($_GET['status'] == 4) { ?>
                                                Go to terminated / end study list >
                                            <?php } elseif ($_GET['status'] == 5) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 6) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 7) { ?>
                                                Go to registered list >
                                            <?php } ?>
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Client</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                            $relation = $override->get('relation', 'id', $clients['relation_patient'])[0];
                            $sex = $override->get('sex', 'id', $clients['sex'])[0];
                            $education = $override->get('education', 'id', $clients['education'])[0];
                            $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                            $insurance = $override->get('insurance', 'id', $clients['health_insurance'])[0];
                            $payments = $override->get('payments', 'id', $clients['pay_services'])[0];
                            $household = $override->get('household', 'id', $clients['head_household'])[0];

                            $regions = $override->get('regions', 'id', $clients['region'])[0];
                            $districts = $override->get('districts', 'id', $clients['district'])[0];
                            $wards = $override->get('wards', 'id', $clients['ward'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Client Details</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="clients" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Registration Date:</label>
                                                            <input class="form-control" type="date" max="<?= date('Y-m-d'); ?>" name="date_registered" id="date_registered" value="<?php if ($clients['date_registered']) {
                                                                                                                                                                                        print_r($clients['date_registered']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Hospital ID</label>
                                                            <input class="form-control" type="text" name="hospital_id" id="hospital_id" placeholder="Type Hospital ID..." value="<?php if ($clients['hospital_id']) {
                                                                                                                                                                                        print_r($clients['hospital_id']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>CTC ID </label>
                                                            <input class="form-control" type="text" minlength="14" maxlength="14" size="14" pattern=[0]{1}[0-9]{13} name="ctc_id" id="ctc_id" placeholder="Type CTC ID..." value="<?php if ($clients['ctc_id']) {
                                                                                                                                                                                                                                        print_r($clients['ctc_id']);
                                                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="patient_phone" id="patient_phone" value="<?php if ($clients['patient_phone']) {
                                                                                                                                                                                                            print_r($clients['patient_phone']);
                                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="patient_phone2" id="patient_phone2" value="<?php if ($clients['patient_phone2']) {
                                                                                                                                                                                                                print_r($clients['patient_phone2']);
                                                                                                                                                                                                            }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Type firstname..." onkeyup="fetchData()" value="<?php if ($clients['firstname']) {
                                                                                                                                                                                                        print_r($clients['firstname']);
                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input class="form-control" type="text" name="middlename" id="middlename" placeholder="Type middlename..." onkeyup="fetchData()" value="<?php if ($clients['middlename']) {
                                                                                                                                                                                                        print_r($clients['middlename']);
                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Type lastname..." onkeyup="fetchData()" value="<?php if ($clients['lastname']) {
                                                                                                                                                                                                    print_r($clients['lastname']);
                                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-1">
                                                    <label>SEX</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="sex" id="sex" value="1" <?php if ($clients['sex'] == 1) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?> required>
                                                                <label class="form-check-label">Male</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="sex" id="sex" value="2" <?php if ($clients['sex'] == 2) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of birth:</label>
                                                            <input class="form-control" max="<?= date('Y-m-d'); ?>" type="date" name="dob" id="dob" style="width: 100%;" value="<?php if ($clients['dob']) {
                                                                                                                                                                                    print_r($clients['dob']);
                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">treatment supporter or next of kin details</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>First Name(Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_fname" id="supporter_fname" value="<?php if ($clients['supporter_fname']) {
                                                                                                                                                            print_r($clients['supporter_fname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Middle Name(Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_mname" id="supporter_mname" value="<?php if ($clients['supporter_mname']) {
                                                                                                                                                            print_r($clients['supporter_mname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Last Name (Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_lname" id="supporter_lname" value="<?php if ($clients['supporter_lname']) {
                                                                                                                                                            print_r($clients['supporter_lname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Mobile number(Supporter)</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="supporter_phone" id="supporter_phone" value="<?php if ($clients['supporter_phone']) {
                                                                                                                                                                                                                print_r($clients['supporter_phone']);
                                                                                                                                                                                                            }  ?>" required />
                                                        </div>
                                                        <span>Example: 0700 000 111</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Mobile number 2 (Supporter)</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="supporter_phone2" id="supporter_phone2" value="<?php if ($clients['supporter_phone2']) {
                                                                                                                                                                                                                    print_r($clients['supporter_phone2']);
                                                                                                                                                                                                                }  ?>" />
                                                        </div>
                                                        <span>Example: 0700 000 111</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>Relation to patient(Supporter)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('relation', 'status', 1) as $relation) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="relation_patient" id="relation_patient<?= $relation['id']; ?>" value="<?= $relation['id']; ?>" <?php if ($clients['relation_patient'] == $relation['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $relation['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label id="relation_patient_other_label">Other relation patient</label>
                                                            <textarea class="form-control" name="relation_patient_other" id="relation_patient_other" rows="3" placeholder="Type other relation here...">
                                                                <?php if ($clients['relation_patient_other']) {
                                                                    print_r($clients['relation_patient_other']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Patient Adress</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region" name="region" class="form-control" required>
                                                                <option value="<?= $regions['id'] ?>"><?php if ($clients['region']) {
                                                                                                            print_r($regions['name']);
                                                                                                        } else {
                                                                                                            echo 'Select region';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="<?= $districts['id'] ?>"><?php if ($clients['district']) {
                                                                                                            print_r($districts['name']);
                                                                                                        } else {
                                                                                                            echo 'Select district';
                                                                                                        } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward</label>
                                                            <select id="ward" name="ward" class="form-control" required>
                                                                <option value="<?= $wards['id'] ?>"><?php if ($clients['ward']) {
                                                                                                        print_r($wards['name']);
                                                                                                    } else {
                                                                                                        echo 'Select district';
                                                                                                    } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Residence street</label>
                                                            <input class="form-control" type="text" name="street" id="street" value="<?php if ($clients['street']) {
                                                                                                                                            print_r($clients['street']);
                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Physical Address ( Location )</label>
                                                            <textarea class="form-control" id="location" placeholder="Type physical address here" name="location" rows="3" style="width: 100%;" required>
                                                                    <?php if ($clients['location']) {
                                                                        print_r($clients['location']);
                                                                    }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>House number, if any</label>
                                                            <input class="form-control" type="text" name="house_number" id="house_number" value="<?php if ($clients['house_number']) {
                                                                                                                                                        print_r($clients['house_number']);
                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Other Details</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Who is the head of your household?</label>
                                                            <select id="head_household" name="head_household" class="form-control" required>
                                                                <option value="<?= $household['id'] ?>"><?php if ($clients) {
                                                                                                            print_r($household['name']);
                                                                                                        } else {
                                                                                                            echo 'Select household head';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('household', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Level of educations</label>
                                                            <select id="education" name="education" class="form-control" required>
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

                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Occupation</label>
                                                            <select id="occupation" name="occupation" class="form-control" required>
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
                                                </div>
                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">health insurance</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Do you own health insurance?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="health_insurance" id="health_insurance1" value="1" <?php if ($clients['health_insurance'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="health_insurance" id="health_insurance2" value="2" <?php if ($clients['health_insurance'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="pay_services">
                                                    <label>If no, how do you pay for your health care services</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('payments', 'status', 1) as $payment) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="pay_services" id="pay_services<?= $payment['id']; ?>" value="<?= $payment['id']; ?>" <?php if ($clients['pay_services'] == $payment['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $payment['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="insurance_name">
                                                    <label>Name of insurance:</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('insurance', 'status', 1) as $insurance) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="insurance_name" id="insurance_name<?= $insurance['id']; ?>" value="<?= $insurance['id']; ?>" <?php if ($clients['insurance_name'] == $insurance['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $insurance['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="insurance_name_other">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Other Name of insurance:</label>
                                                            <textarea class="form-control" name="insurance_name_other" rows="3" placeholder="Type other insurance here...">
                                                                <?php if ($clients['insurance_name_other']) {
                                                                    print_r($clients['insurance_name_other']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Type of Interview</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                                                ?>
                                                    <div class="col-md-3">
                                                        <div class="card card-warning">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Site Name</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>


                                                <div class="col-md-6">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ANY OTHER COMENT OR REMARKS</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Respondent Type</label>
                                                            <select id="respondent" name="respondent" class="form-control" required>
                                                                <option value="<?= $clients['respondent'] ?>"><?php if ($clients['respondent']) {
                                                                                                                    if ($clients['respondent'] == 1) {
                                                                                                                        echo 'Facility';
                                                                                                                    } elseif ($clients['respondent'] == 2) {
                                                                                                                        echo 'Patient';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                                </option>
                                                                <?php foreach ($override->getNews('respondent_type', 'status', 1, 'respondent', 2) as $value) { ?>
                                                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
                                                    <div class="col-sm-3" id="insurance_name">
                                                        <label>Name Of Site:</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('sites', 'status', 1) as $site) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="site" id="site<?= $site['id']; ?>" value="<?= $site['id']; ?>" <?php if ($clients['site_id'] == $site['id']) {
                                                                                                                                                                                                echo 'checked' . ' ' . 'required';
                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $site['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($clients['comments']) {
                                                                                                                                                            print_r($clients['comments']);
                                                                                                                                                        }  ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=3&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_client" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 5) { ?>
            <?php
            $individual = $override->get3('individual', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$individual) { ?>
                                    <h1>Add New Section 2: Individual Patients Information</h1>
                                <?php } else { ?>
                                    <h1>Update Section 2: Individual Patients Information</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$individual) { ?>
                                        <li class="breadcrumb-item active">Add New Section 2: Individual Patients Information</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Section 2: Individual Patients Information</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Most Recents Viroal Load Results</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($individual['visit_date']) {
                                                                                        print_r($individual['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="previous_vl_date" class="form-label">Date of previous VL test</label>
                                                        <input type="date" value="<?php if ($individual['previous_vl_date']) {
                                                                                        print_r($individual['previous_vl_date']);
                                                                                    } ?>" id="previous_vl_date" name="previous_vl_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="recent_vl_results" class="form-label">Most recent VL test results before this month.</label>
                                                        <input type="number" value="<?php if ($individual['recent_vl_results']) {
                                                                                        print_r($individual['recent_vl_results']);
                                                                                    } ?>" id="recent_vl_results" name="recent_vl_results" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>copies/ul</span>
                                                </div>

                                                <div class="col-sm-3" id="trained_pivlo">
                                                    <label for="trained_pivlo" class="form-label">Was the patient trained for PIVLO before test?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="trained_pivlo" id="trained_pivlo<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['trained_pivlo'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">New Viroal Load Results</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3" id="initiate_test_hcw">
                                                    <label for="trained_pivlo" class="form-label">Did he/she initiate the test to the HCW?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="initiate_test_hcw" id="initiate_test_hcw<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['initiate_test_hcw'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="tested_this_month">
                                                    <label for="tested_this_month" class="form-label">Did the patient got tested this month?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tested_this_month" id="tested_this_month<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tested_this_month'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="new_vl_date" class="form-label">New VL test date</label>
                                                        <input type="date" value="<?php if ($individual['new_vl_date']) {
                                                                                        print_r($individual['new_vl_date']);
                                                                                    } ?>" id="new_vl_date" name="new_vl_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="new_vl_results" class="form-label">New VL test Results</label>
                                                        <input type="number" value="<?php if ($individual['new_vl_results']) {
                                                                                        print_r($individual['new_vl_results']);
                                                                                    } ?>" id="new_vl_results" name="new_vl_results" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">CD4 and TB Results</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="recent_cd4" class="form-label">Most recent CD4 count</label>
                                                        <input type="number" value="<?php if ($individual['recent_cd4']) {
                                                                                        print_r($individual['recent_cd4']);
                                                                                    } ?>" id="recent_cd4" name="recent_cd4" min="0" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="cd4_date" class="form-label">CD4 count test date</label>
                                                        <input type="date" value="<?php if ($individual['cd4_date']) {
                                                                                        print_r($individual['cd4_date']);
                                                                                    } ?>" id="cd4_date" name="cd4_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label for="recent_tb_results" class="form-label">Recent TB screening results</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="recent_tb_results" id="recent_tb_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['recent_tb_results'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="recent_tb_date_label" id="recent_tb_date_label" class="form-label">Tb test date</label>
                                                            <input type="date" value="<?php if ($individual['recent_tb_date']) {
                                                                                            print_r($individual['cd4_date']);
                                                                                        } ?>" id="recent_tb_date" name="recent_tb_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                            <div class="text-danger" id="recent_tb_date_error"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ART Services</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="date_art_treatment" class="form-label">3.1 When did you begin taking ART-Treatment?</label>
                                                        <input type="date" value="<?php if ($individual['date_art_treatment']) {
                                                                                        print_r($individual['date_art_treatment']);
                                                                                    } ?>" id="date_art_treatment" name="date_art_treatment" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date art treatment" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>Which antiretroviral therapy regimen is the patient currently on?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('art_regimes', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="art_regimen" id="art_regimen<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['art_regimen'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="art_regimen_other" id="art_regimen_other_label" class="form-label">Other ART Regime</label>
                                                            <input type="text" value="<?php if ($individual['art_regimen_other']) {
                                                                                            print_r($individual['art_regimen_other']);
                                                                                        } ?>" id="art_regimen_other" name="art_regimen_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4" id="first_line">
                                                    <label>First Line</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->getNews('art_regimes_specific', 'status', 1, 'regime_line', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="first_line" id="first_line<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['first_line'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="other_first_line" id="other_first_line_label" class="form-label">Other First Line Regime</label>
                                                            <input type="text" value="<?php if ($individual['other_first_line']) {
                                                                                            print_r($individual['other_first_line']);
                                                                                        } ?>" id="other_first_line" name="other_first_line" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4" id="second_line">
                                                    <label>Second Line</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->getNews('art_regimes_specific', 'status', 1, 'regime_line', 2) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="second_line" id="second_line<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['second_line'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="other_second_line" id="other_second_line_label" class="form-label">Other Second Line Regime</label>
                                                            <input type="text" value="<?php if ($individual['other_second_line']) {
                                                                                            print_r($individual['other_second_line']);
                                                                                        } ?>" id="other_second_line" name="other_second_line" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4" id="third_line">
                                                <label>Third line</label>
                                                <!-- checkbox -->
                                                <div class="row-form clearfix">
                                                    <div class="form-group">
                                                        <?php foreach ($override->getNews('art_regimes_specific', 'status', 1, 'regime_line', 3) as $value) { ?>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="third_line" id="third_line<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['third_line'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                <label class="form-check-label"><?= $value['name']; ?></label>
                                                            </div>
                                                        <?php } ?>
                                                        <label for="other_third_line" id="other_third_line_label" class="form-label">Other Second Line Regime</label>
                                                        <input type="text" value="<?php if ($individual['other_third_line']) {
                                                                                        print_r($individual['other_third_line']);
                                                                                    } ?>" id="other_third_line" name="other_third_line" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Section 3: Examination</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="weight" class="form-label">Weight (kg)</label>
                                                        <input type="number" value="<?php if ($individual['weight']) {
                                                                                        print_r($individual['weight']);
                                                                                    } ?>" id="weight" name="weight" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="height" class="form-label">Height (cm)</label>
                                                        <input type="number" value="<?php if ($individual['height']) {
                                                                                        print_r($individual['height']);
                                                                                    } ?>" id="height" name="height" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="systolic" class="form-label">Systolic blood pressure (mmHg)</label>
                                                        <input type="number" value="<?php if ($individual['systolic']) {
                                                                                        print_r($individual['systolic']);
                                                                                    } ?>" id="systolic" name="systolic" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>Blood pressure reading</span>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="diastolic" class="form-label">Diastolic blood pressure (mmHg)</label>
                                                        <input type="number" value="<?php if ($individual['diastolic']) {
                                                                                        print_r($individual['diastolic']);
                                                                                    } ?>" id="diastolic" name="diastolic" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>Blood pressure reading</span>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Next Visit And Chronic Diseases</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3" id="chronic_condition">
                                                    <label for="chronic_condition" class="form-label">Do the patient has other chronic condition? (Like Diabetes, High BP, renal etc)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="chronic_condition" id="chronic_condition<?= $value['id']; ?>" value="1" <?php if ($individual['chronic_condition'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label>Mention it:</label>
                                                            <textarea class="form-control" name="other_chronic" rows="3" placeholder="Type other here...">
                                                                <?php if ($kap['other_chronic']) {
                                                                    print_r($kap['other_chronic']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="matibabu_saratani">
                                                    <label>What was the reason for this visit?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('reasons', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="reasons" id="reasons<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['reasons'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="next_appointment">
                                                    <label for="next_appointment_schedule" class="form-label">Has the patient been scheduled for their next VL test appointment?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="next_appointment" id="next_appointment_schedule<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['next_appointment'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="next_date" class="form-label">Next appointment date</label>
                                                        <input type="date" value="<?php if ($individual['next_date']) {
                                                                                        print_r($individual['next_date']);
                                                                                    } ?>" id="next_date" name="next_date" min="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($individual['comments']) {
                                                                                                                                                            print_r($individual['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="individual_complete">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="individual_complete" id="recent_tb_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['individual_complete'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($individual['date_completed']) {
                                                                                        print_r($individual['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" min="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_individual" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 6) { ?>
            <?php
            $facility = $override->get3('facility', 'status', 1, 'sequence', $_GET['sequence'], 'site_id', $_GET['site_id'])[0];
            $site = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($facility) { ?>
                                    <h1>Add New Facility</h1>
                                <?php } else { ?>
                                    <h1>Update Facility</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=12&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=11&status=<?= $_GET['status']; ?>">
                                            Go to Facilities list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($facility) { ?>
                                        <li class="breadcrumb-item active">Add New Facility</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Facility</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Section 1: Facility PIVLO-Test list details (to be completed monthly in clinic)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Date of Visit</label>
                                                        <input type="date" value="<?php if ($facility['visit_date']) {
                                                                                        print_r($facility['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="month_name" class="form-label">Month (Name)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('months', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="month_name" id="month_name<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($facility['month_name'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="appointments" class="form-label">Total number of test appointment in a
                                                            month.</label>
                                                        <input type="number" value="<?php if ($facility['appointments']) {
                                                                                        print_r($facility['appointments']);
                                                                                    } ?>" id="appointments" name="appointments" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="patients_tested" class="form-label">Total patients got tested this month</label>
                                                        <input type="number" value="<?php if ($facility['patients_tested']) {
                                                                                        print_r($facility['patients_tested']);
                                                                                    } ?>" id="patients_tested" name="patients_tested" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="vl_results_available" class="form-label">Total VL test results made available for
                                                            this month</label>
                                                        <input type="number" value="<?php if ($facility['vl_results_available']) {
                                                                                        print_r($facility['vl_results_available']);
                                                                                    } ?>" id="vl_results_available" name="vl_results_available" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="comments" class="form-label">Any Comments ( If Available ):</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4" placeholder="Enter comments here">
                                                                                            <?php if ($facility['comments']) {
                                                                                                print_r($facility['comments']);
                                                                                            } ?>
                                                                                            </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="facility_completed">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="facility_completed" id="facility_completed<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($facility['facility_completed'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($facility['date_completed']) {
                                                                                        print_r($facility['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=11&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="facility_id" value="<?= $site['id'] ?>">
                                            <input type="hidden" name="facility_arm" value="<?= $site['arm'] ?>">
                                            <input type="hidden" name="facility_level" value="<?= $site['level'] ?>">
                                            <input type="hidden" name="facility_type" value="<?= $site['type'] ?>">
                                            <input type="submit" name="add_facility" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 7) { ?>
            <?php
            $screening = $override->get3('screening', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($screening) { ?>
                                    <h1>Add New Screening</h1>
                                <?php } else { ?>
                                    <h1>Update Screening</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New Screening</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Screening</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Screeing Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="test_date" class="form-label">Date of Screening</label>
                                                        <input type="date" value="<?php if ($screening['screening_date']) {
                                                                                        print_r($screening['screening_date']);
                                                                                    } ?>" id="screening_date" name="screening_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="conset" class="form-label">Patient Conset?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="conset" id="conset<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['conset'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="results_date" class="form-label">Date of Conset</label>
                                                        <input type="date" value="<?php if ($screening) {
                                                                                        print_r($screening['conset_date']);
                                                                                    } ?>" id="conset_date" name="conset_date" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="ldct_results" class="form-label">Comments</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4" placeholder="Enter here" required>
                                                            <?php if ($screening['comments']) {
                                                                print_r($screening['comments']);
                                                            } ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_screening" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 8) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Region Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Region Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php $regions = $override->get('regions', 'id', $_GET['region_id']); ?>
                            <!-- right column -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Region</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type region..." onkeyup="fetchData()" value="<?php if ($regions['0']['name']) {
                                                                                                                                                                                        print_r($regions['0']['name']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="hidden" name="region_id" value="<?= $regions['0']['id'] ?>">
                                            <input type="submit" name="add_region" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Regions
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('regions', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $regions = $override->getWithLimit('regions', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($regions as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=24&region_id=<?= $value['id'] ?>" class="btn btn-info">Update</a>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=24&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=24&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=24&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 9) { ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>District Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">District Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $regions = $override->get('regions', 'id', $_GET['region_id']);
                            $districts = $override->get('districts', 'id', $_GET['district_id']);
                            ?>
                            <!-- right left -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">District</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region_id" name="region_id" class="form-control" required <?php if ($_GET['region_id']) {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } ?>>
                                                                <option value="<?= $regions[0]['id'] ?>"><?php if ($regions[0]['name']) {
                                                                                                                print_r($regions[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select region';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type district..." onkeyup="fetchData()" value="<?php if ($districts['0']['name']) {
                                                                                                                                                                                            print_r($districts['0']['name']);
                                                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="submit" name="add_district" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Districts
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('districts', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $districts = $override->getWithLimit('districts', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($districts as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $regions['name']; ?>
                                                        </td>

                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=25&region_id=<?= $value['region_id'] ?>&district_id=<?= $value['id'] ?>" class="btn btn-info">Update</a>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=25&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=25&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=25&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 10) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Wards Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Wards Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $regions = $override->get('regions', 'id', $_GET['region_id']);
                            $districts = $override->getNews('districts', 'region_id', $_GET['region_id'], 'id', $_GET['district_id']);
                            $wards = $override->get('wards', 'id', $_GET['ward_id']);
                            ?>
                            <!-- right left -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Ward</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="regions_id" name="region_id" class="form-control" required <?php if ($_GET['region_id']) {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } ?>>
                                                                <option value="<?= $regions[0]['id'] ?>"><?php if ($regions[0]['name']) {
                                                                                                                print_r($regions[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select region';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="districts_id" name="district_id" class="form-control" required <?php if ($_GET['district_id']) {
                                                                                                                                            echo 'disabled';
                                                                                                                                        } ?>>
                                                                <option value="<?= $districts[0]['id'] ?>"><?php if ($districts[0]['name']) {
                                                                                                                print_r($districts[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select District';
                                                                                                            } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type ward..." onkeyup="fetchData()" value="<?php if ($wards['0']['name']) {
                                                                                                                                                                                        print_r($wards['0']['name']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="submit" name="add_ward" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Wards
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('wards', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $ward = $override->getWithLimit('wards', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="search-results" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Ward Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($ward as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                    $districts = $override->get('districts', 'id', $value['district_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $regions['name']; ?>
                                                        </td>

                                                        <td class="table-user">
                                                            <?= $districts['name']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=26&region_id=<?= $value['region_id'] ?>&district_id=<?= $value['district_id'] ?>&ward_id=<?= $value['id'] ?>" class="btn btn-info">Update</a> <br><br>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Ward Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=26&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=26&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=26&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 11) { ?>
            <?php
            $costing = $override->get3('costing', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$costing) { ?>
                                    <h1>Add New Section 7: Patient Costing Data</h1>
                                <?php } else { ?>
                                    <h1>Update Section 7: Patient Costing Data</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$costing) { ?>
                                        <li class="breadcrumb-item active">Add New Section 7: Patient Costing Data</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Section 7: Patient Costing Data</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Most Recents Viroal Load Results</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($costing['visit_date']) {
                                                                                        print_r($costing['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="distance_km" class="form-label">How far does the participant live from the study site? </label>
                                                        <input type="number" value="<?php if ($costing['distance_km']) {
                                                                                        print_r($costing['distance_km']);
                                                                                    } ?>" id="distance_km" name="distance_km" min="0" max="1000" class="form-control" placeholder="Enter Number" required />
                                                    </div>
                                                    <span>(Provide Estimates in Kilometres)</span>
                                                </div>


                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="distance_hours" class="form-label">On average, how long did it take you to travel? </label>
                                                        <input type="number" value="<?php if ($costing['distance_hours']) {
                                                                                        print_r($costing['distance_hours']);
                                                                                    } ?>" id="distance_hours" name="distance_hours" min="0" max="1000" class="form-control" placeholder="Enter Number" required />
                                                    </div>
                                                    <span>(Record single journey in Hours) </span>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="distance_minutes" class="form-label">On average, how long did it take you to travel? </label>
                                                        <input type="number" value="<?php if ($costing['distance_km']) {
                                                                                        print_r($costing['distance_km']);
                                                                                    } ?>" id="distance_minutes" name="distance_minutes" min="0" max="1000" class="form-control" placeholder="Enter Number" required />
                                                    </div>
                                                    <span>(Record single journey in minutes) </span>
                                                </div>

                                                <div class="col-sm-3" id="trained_pivlo">
                                                    <label for="trained_pivlo" class="form-label">How did the participant get to this appointment?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('transportations', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="transport" id="transport<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['transport'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3" id="facility_change">
                                                    <label for="new_vl_date" class="form-label">Has the participant ever changed the health facility where they get ART from? <br><br>(Je, mshiriki amewahi kubadilisha kituo cha afya anakopata ART kutoka?)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="facility_change" id="facility_change<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['facility_change'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="reasons_facility">
                                                    <label for="tested_this_month" class="form-label">If Yes, what was the reason for changing?<br><br> (Kama Ndiyo, ni nini sababu ya kubadilisha?)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('reasons_facility', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="reasons_facility" id="reasons_facility<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['reasons_facility'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="accompany">
                                                    <label for="new_vl_date" class="form-label">Did anyone accompany you today on your visit? <br><br> (Je, kuna mtu yeyote aliyefuatana nawe leo kwenye ziara yako?)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="accompany" id="accompany<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['accompany'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="relation">
                                                    <label for="new_vl_date" class="form-label">What is their relation to you? <br><br> (Wana uhusiano gani na wewe?)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('relation', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="relation" id="relation<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['relation'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-3" id="occupation">
                                                    <label for="new_vl_date" class="form-label">What is their occupation? <br><br> (Je, kazi yao ni nini ? )</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('occupation', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="occupation" id="occupation<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['occupation'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="pay_money">
                                                    <label for="new_vl_date" class="form-label">Did you or the person who accompanied you (companion) pay money in relation to this visit? <br><br> (Je, wewe au mtu aliyeandamana nawe (mwenzi) mlilipa pesa kuhusiana na hudhurio hili)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="pay_money" id="pay_money<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['pay_money'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="pay_travel" class="form-label">On average, how much did you or your companion have to pay in total for travel for your visit? <br><br> (Kwa wastani, wewe au mwenzako mlipaswa kulipa kiasi gani kwa jumla kwa ajili ya safari ya hudhurio lenu?)</label>
                                                        <input type="number" value="<?php if ($costing['pay_travel']) {
                                                                                        print_r($costing['pay_travel']);
                                                                                    } ?>" id="pay_travel" name="pay_travel" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="pay_food" class="form-label">On average, how much did you or your companion have to pay in total for food during your visit?<br><br> (Kwa wastani, wewe au mwenzako mlipaswa kulipa kiasi gani kwa jumla kwa ajili ya chakula wakati wa hudhurio lenu?)</label>
                                                        <input type="number" value="<?php if ($costing['pay_food']) {
                                                                                        print_r($costing['pay_food']);
                                                                                    } ?>" id="pay_food" name="pay_food" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="pay_vl_testing" class="form-label">How much did you or your companion have to pay for your VL testing?<br><br> (Je, wewe au mwenzako mlilipa kiasi gani kwa ajili ya majaribio yako ya VL?)</label>
                                                        <input type="number" value="<?php if ($costing['pay_vl_testing']) {
                                                                                        print_r($costing['pay_vl_testing']);
                                                                                    } ?>" id="pay_vl_testing" name="pay_vl_testing" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="pay_other" class="form-label">Je, kuna gharama yoyote ambayo ulilipa tofauti na hizo ulizotaja hapo, kama ndio, ni shilingi ngapi? ( TSHS )</label>
                                                        <input type="number" value="<?php if ($costing['pay_other']) {
                                                                                        print_r($costing['pay_other']);
                                                                                    } ?>" id="pay_other" name="pay_other" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="pay_usajili" class="form-label">Usajili ( TSHS )</label>
                                                        <input type="number" value="<?php if ($costing['pay_usajili']) {
                                                                                        print_r($costing['pay_usajili']);
                                                                                    } ?>" id="pay_usajili" name="pay_usajili" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="pay_doctor" class="form-label">Kumuona daktari (Consultation) ( TSHS )</label>
                                                        <input type="number" value="<?php if ($costing['pay_doctor']) {
                                                                                        print_r($costing['pay_doctor']);
                                                                                    } ?>" id="pay_doctor" name="pay_doctor" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="pay_diagnostic" class="form-label">Vipimo (Diagnostic tests) ( TSHS )</label>
                                                        <input type="number" value="<?php if ($costing['pay_diagnostic']) {
                                                                                        print_r($costing['pay_diagnostic']);
                                                                                    } ?>" id="pay_diagnostic" name="pay_diagnostic" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="pay_medications" class="form-label">Dawa (Medications) ( TSHS )</label>
                                                        <input type="number" value="<?php if ($costing['pay_medications']) {
                                                                                        print_r($costing['pay_medications']);
                                                                                    } ?>" id="pay_medications" name="pay_medications" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="pay_medical" class="form-label">Gharama zingine za ziada kwa ajili ya matibabu (Any other direct medical costs) ( TSHS )</label>
                                                        <input type="number" value="<?php if ($costing['pay_medical']) {
                                                                                        print_r($costing['pay_medical']);
                                                                                    } ?>" id="pay_medical" name="pay_medical" min="0" max="100000000" class="form-control" placeholder="Enter amount in TSHS" required />
                                                    </div>
                                                </div>
                                            </div>                                            

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($individual['comments']) {
                                                                                                                                                            print_r($individual['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="individual_complete">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="individual_complete" id="recent_tb_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['individual_complete'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($individual['date_completed']) {
                                                                                        print_r($individual['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" min="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_individual" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 12) { ?>
            <?php
            $social_economic = $override->get3('social_economic', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$social_economic) { ?>
                                    <h1>Add New Section 8: Social Economic Status Form</h1>
                                <?php } else { ?>
                                    <h1>Update Section 8: Social Economic Status Form</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$social_economic) { ?>
                                        <li class="breadcrumb-item active">Add New Section 8: Social Economic Status Form</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Section 8: Social Economic Status Form</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Most Recents Viroal Load Results</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($social_economic['visit_date']) {
                                                                                        print_r($social_economic['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="previous_vl_date" class="form-label">Date of previous VL test</label>
                                                        <input type="date" value="<?php if ($social_economic['previous_vl_date']) {
                                                                                        print_r($social_economic['previous_vl_date']);
                                                                                    } ?>" id="previous_vl_date" name="previous_vl_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="recent_vl_results" class="form-label">Most recent VL test results before this month.</label>
                                                        <input type="number" value="<?php if ($individual['recent_vl_results']) {
                                                                                        print_r($individual['recent_vl_results']);
                                                                                    } ?>" id="recent_vl_results" name="recent_vl_results" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>copies/ul</span>
                                                </div>

                                                <div class="col-sm-3" id="trained_pivlo">
                                                    <label for="trained_pivlo" class="form-label">Was the patient trained for PIVLO before test?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="trained_pivlo" id="trained_pivlo<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['trained_pivlo'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">New Viroal Load Results</h3>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3" id="initiate_test_hcw">
                                                    <label for="trained_pivlo" class="form-label">Did he/she initiate the test to the HCW?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="initiate_test_hcw" id="initiate_test_hcw<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['initiate_test_hcw'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="tested_this_month">
                                                    <label for="tested_this_month" class="form-label">Did the patient got tested this month?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tested_this_month" id="tested_this_month<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['tested_this_month'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="new_vl_date" class="form-label">New VL test date</label>
                                                        <input type="date" value="<?php if ($individual['new_vl_date']) {
                                                                                        print_r($individual['new_vl_date']);
                                                                                    } ?>" id="new_vl_date" name="new_vl_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="new_vl_results" class="form-label">New VL test Results</label>
                                                        <input type="number" value="<?php if ($individual['new_vl_results']) {
                                                                                        print_r($individual['new_vl_results']);
                                                                                    } ?>" id="new_vl_results" name="new_vl_results" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">CD4 and TB Results</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="recent_cd4" class="form-label">Most recent CD4 count</label>
                                                        <input type="number" value="<?php if ($individual['recent_cd4']) {
                                                                                        print_r($individual['recent_cd4']);
                                                                                    } ?>" id="recent_cd4" name="recent_cd4" min="0" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="cd4_date" class="form-label">CD4 count test date</label>
                                                        <input type="date" value="<?php if ($individual['cd4_date']) {
                                                                                        print_r($individual['cd4_date']);
                                                                                    } ?>" id="cd4_date" name="cd4_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label for="recent_tb_results" class="form-label">Recent TB screening results</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="recent_tb_results" id="recent_tb_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['recent_tb_results'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="recent_tb_date_label" id="recent_tb_date_label" class="form-label">Tb test date</label>
                                                            <input type="date" value="<?php if ($individual['recent_tb_date']) {
                                                                                            print_r($individual['cd4_date']);
                                                                                        } ?>" id="recent_tb_date" name="recent_tb_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                            <div class="text-danger" id="recent_tb_date_error"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ART Services</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="date_art_treatment" class="form-label">3.1 When did you begin taking ART-Treatment?</label>
                                                        <input type="date" value="<?php if ($individual['date_art_treatment']) {
                                                                                        print_r($individual['date_art_treatment']);
                                                                                    } ?>" id="date_art_treatment" name="date_art_treatment" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date art treatment" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>Which antiretroviral therapy regimen is the patient currently on?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('art_regimes', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="art_regimen" id="art_regimen<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['art_regimen'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="art_regimen_other" id="art_regimen_other_label" class="form-label">Other ART Regime</label>
                                                            <input type="text" value="<?php if ($individual['art_regimen_other']) {
                                                                                            print_r($individual['art_regimen_other']);
                                                                                        } ?>" id="art_regimen_other" name="art_regimen_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4" id="first_line">
                                                    <label>First Line</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->getNews('art_regimes_specific', 'status', 1, 'regime_line', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="first_line" id="first_line<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['first_line'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="other_first_line" id="other_first_line_label" class="form-label">Other First Line Regime</label>
                                                            <input type="text" value="<?php if ($individual['other_first_line']) {
                                                                                            print_r($individual['other_first_line']);
                                                                                        } ?>" id="other_first_line" name="other_first_line" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4" id="second_line">
                                                    <label>Second Line</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->getNews('art_regimes_specific', 'status', 1, 'regime_line', 2) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="second_line" id="second_line<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['second_line'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="other_second_line" id="other_second_line_label" class="form-label">Other Second Line Regime</label>
                                                            <input type="text" value="<?php if ($individual['other_second_line']) {
                                                                                            print_r($individual['other_second_line']);
                                                                                        } ?>" id="other_second_line" name="other_second_line" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4" id="third_line">
                                                <label>Third line</label>
                                                <!-- checkbox -->
                                                <div class="row-form clearfix">
                                                    <div class="form-group">
                                                        <?php foreach ($override->getNews('art_regimes_specific', 'status', 1, 'regime_line', 3) as $value) { ?>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="third_line" id="third_line<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['third_line'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                <label class="form-check-label"><?= $value['name']; ?></label>
                                                            </div>
                                                        <?php } ?>
                                                        <label for="other_third_line" id="other_third_line_label" class="form-label">Other Second Line Regime</label>
                                                        <input type="text" value="<?php if ($individual['other_third_line']) {
                                                                                        print_r($individual['other_third_line']);
                                                                                    } ?>" id="other_third_line" name="other_third_line" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Section 3: Examination</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="weight" class="form-label">Weight (kg)</label>
                                                        <input type="number" value="<?php if ($individual['weight']) {
                                                                                        print_r($individual['weight']);
                                                                                    } ?>" id="weight" name="weight" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="height" class="form-label">Height (cm)</label>
                                                        <input type="number" value="<?php if ($individual['height']) {
                                                                                        print_r($individual['height']);
                                                                                    } ?>" id="height" name="height" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="systolic" class="form-label">Systolic blood pressure (mmHg)</label>
                                                        <input type="number" value="<?php if ($individual['systolic']) {
                                                                                        print_r($individual['systolic']);
                                                                                    } ?>" id="systolic" name="systolic" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>Blood pressure reading</span>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="diastolic" class="form-label">Diastolic blood pressure (mmHg)</label>
                                                        <input type="number" value="<?php if ($individual['diastolic']) {
                                                                                        print_r($individual['diastolic']);
                                                                                    } ?>" id="diastolic" name="diastolic" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>Blood pressure reading</span>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Next Visit And Chronic Diseases</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3" id="chronic_condition">
                                                    <label for="chronic_condition" class="form-label">Do the patient has other chronic condition? (Like Diabetes, High BP, renal etc)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="chronic_condition" id="chronic_condition<?= $value['id']; ?>" value="1" <?php if ($individual['chronic_condition'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label>Mention it:</label>
                                                            <textarea class="form-control" name="other_chronic" rows="3" placeholder="Type other here...">
                                                                <?php if ($kap['other_chronic']) {
                                                                    print_r($kap['other_chronic']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="matibabu_saratani">
                                                    <label>What was the reason for this visit?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('reasons', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="reasons" id="reasons<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['reasons'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="next_appointment">
                                                    <label for="next_appointment_schedule" class="form-label">Has the patient been scheduled for their next VL test appointment?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="next_appointment" id="next_appointment_schedule<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['next_appointment'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="next_date" class="form-label">Next appointment date</label>
                                                        <input type="date" value="<?php if ($individual['next_date']) {
                                                                                        print_r($individual['next_date']);
                                                                                    } ?>" id="next_date" name="next_date" min="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($individual['comments']) {
                                                                                                                                                            print_r($individual['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="individual_complete">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="individual_complete" id="recent_tb_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($individual['individual_complete'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($individual['date_completed']) {
                                                                                        print_r($individual['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" min="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_individual" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 13) { ?>

        <?php } elseif ($_GET['id'] == 14) { ?>


        <?php } elseif ($_GET['id'] == 15) { ?>

        <?php } elseif ($_GET['id'] == 16) { ?>


        <?php } elseif ($_GET['id'] == 17) { ?>

        <?php } elseif ($_GET['id'] == 18) { ?>

        <?php } elseif ($_GET['id'] == 19) { ?>

        <?php } elseif ($_GET['id'] == 20) { ?>

        <?php } elseif ($_GET['id'] == 21) { ?>

        <?php } elseif ($_GET['id'] == 22) { ?>

        <?php } elseif ($_GET['id'] == 23) { ?>
        <?php } elseif ($_GET['id'] == 24) { ?>
        <?php } elseif ($_GET['id'] == 25) { ?>
        <?php } elseif ($_GET['id'] == 26) { ?>
        <?php } elseif ($_GET['id'] == 27) { ?>
        <?php } elseif ($_GET['id'] == 28) { ?>

        <?php } ?>

        <?php include 'footer.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="../../dist/js/demo.js"></script> -->
    <!-- Page specific script -->


    <!-- clients Js -->
    <script src="myjs/add/clients/insurance.js"></script>
    <script src="myjs/add/clients/insurance_name.js"></script>
    <script src="myjs/add/clients/relation_patient.js"></script>
    <!-- <script src="myjs/add/clients/validate_hidden_with_values.js"></script>
    <script src="myjs/add/clients/validate_required_attribute.js"></script>
    <script src="myjs/add/clients/validate_required_radio_checkboxes.js"></script> -->



    <!-- HISTORY Js -->
    <script src="myjs/add/history/art_regimen.js"></script>
    <script src="myjs/add/history/tb.js"></script>
    <script src="myjs/add/history/first_line.js"></script>
    <script src="myjs/add/history/second_line.js"></script>
    <script src="myjs/add/history/third_line.js"></script>
    <script src="myjs/add/history"></script>



    <!-- economics format numbers Js -->
    <!-- <script src="myjs/add/economics/format_thousands/consultation.js"></script>
    <script src="myjs/add/economics/format_thousands/days.js"></script>
    <script src="myjs/add/economics/format_thousands/diagnostic.js"></script>
    <script src="myjs/add/economics/format_thousands/food_drinks.js"></script>
    <script src="myjs/add/economics/format_thousands/hours.js"></script>
    <script src="myjs/add/economics/format_thousands/medications.js"></script>
    <script src="myjs/add/economics/format_thousands/member_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/monthly_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/other_cost.js"></script>
    <script src="myjs/add/economics/format_thousands/other_medical_cost.js"></script>
    <script src="myjs/add/economics/format_thousands/registration.js"></script>
    <script src="myjs/add/economics/format_thousands/registration.js"></script>
    <script src="myjs/add/economics/format_thousands/support_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/transport.js"></script> -->





    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

            $('#regions_id').change(function() {
                var region_id = $(this).val();
                $.ajax({
                    url: "process.php?content=region_id",
                    method: "GET",
                    data: {
                        region_id: region_id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#districts_id').html(data);
                    }
                });
            });

            $('#region').change(function() {
                var region = $(this).val();
                $.ajax({
                    url: "process.php?content=region_id",
                    method: "GET",
                    data: {
                        region_id: region
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#district').html(data);
                    }
                });
            });

            $('#district').change(function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "process.php?content=district_id",
                    method: "GET",
                    data: {
                        district_id: district_id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#ward').html(data);
                    }
                });
            });

        })

        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End


        // $("#packs_per_day, #packs_per_day").on("input", function() {
        //     setTimeout(function() {
        //         var weight = $("#packs_per_day").val();
        //         var height = $("#packs_per_day").val() / 100; // Convert cm to m
        //         var bmi = weight / (height * height);
        //         $("#packs_per_year").text(bmi.toFixed(2));
        //     }, 1);
        // });
    </script>

</body>

</html>