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
        } elseif (Input::get('add_demographic')) {
            $validate = $validate->check($_POST, array(
                'date_registered' => array(
                    'required' => true,
                ),
                // 'firstname' => array(
                //     'required' => true,
                // ),
                // 'middlename' => array(
                //     'required' => true,
                // ),
                // 'lastname' => array(
                //     'required' => true,
                // ),
                // 'gender' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                $age = 20;

                try {
                    $kap = 0;
                    $screening = 0;
                    $health_care = 0;
                    if ($_GET['interview'] == 1) {
                        $kap = 1;
                        $client_category = 1;
                    } elseif ($_GET['interview'] == 2) {
                        $screening = 1;
                        $client_category = 1;
                    } elseif ($_GET['interview'] == 3) {
                        $health_care = 1;
                        $client_category = 2;
                    }
                    if (Input::get('btn') == 'Add') {
                        $user->createRecord('clients', array(
                            'date_registered' => Input::get('date_registered'),
                            'study_id' => '',
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'hospital_id' => Input::get('hospital_id'),
                            'patient_phone' => Input::get('patient_phone'),
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
                            'client_category' => $client_category,
                            'kap' => $kap,
                            'screening' => $screening,
                            'health_care' => $health_care,
                            'complete_status' => Input::get('complete_status'),
                            'complete_on' => date('Y-m-d H:i:s'),
                            'complete_id' => $user->data()->id,
                            'status' => 1,
                            'screened' => 0,
                            'eligible' => 0,
                            'enrolled' => 0,
                            'end_study' => 0,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                        ));

                        $last_row = $override->lastRow('clients', 'id')[0];

                        $user->createRecord('visit', array(
                            'visit_name' => 'Registration',
                            'expected_date' => date('Y-m-d'),
                            'visit_date' => '',
                            'outcome' => 0,
                            'visit_status' => 0,
                            'diagnosis' => '',
                            'category' => 0,
                            'status' => 1,
                            'patient_id' => $last_row['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                        ));

                        $successMessage = 'Demographic  Added Successful';
                    } elseif (Input::get('btn') == 'Update') {
                        $user->updateRecord('clients', array(
                            'date_registered' => Input::get('date_registered'),
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'hospital_id' => Input::get('hospital_id'),
                            'patient_phone' => Input::get('patient_phone'),
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
                            'client_category' => $client_category,
                            'comments' => Input::get('comments'),
                            'complete_status' => Input::get('complete_status'),
                            'complete_on' => date('Y-m-d H:i:s'),
                            'complete_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), Input::get('id'));

                        if ($_GET['interview'] == 1) {
                            $user->updateRecord('clients', array(
                                'kap' => $kap,
                            ), Input::get('id'));
                        }


                        if ($_GET['interview'] == 2) {
                            $user->updateRecord('clients', array(
                                'screening' => $screening,
                            ), Input::get('id'));
                        }

                        if ($_GET['interview'] == 3) {
                            $user->updateRecord('clients', array(
                                'health_care' => $health_care,
                            ), Input::get('id'));
                        }

                        $successMessage = 'Demographic Updated Successful';
                    }
                    // info.php?id=2&site_id=1&interview=1
                    $interview = $_GET['interview'];
                    Redirect::to('info.php?id=2&site_id=' . $user->data()->site_id . '&interview=' . $interview);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_kap')) {
            $validate = $validate->check($_POST, array(
                'interview_date' => array(
                    'required' => true,
                ),
                'saratani_mapafu' => array(
                    'required' => true,
                ),
                'uhusiano_saratani' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                if (Input::get('btn') == 'Add') {
                    $user->createRecord('kap', array(
                        'interview_date' => Input::get('interview_date'),
                        'saratani_mapafu' => Input::get('saratani_mapafu'),
                        'uhusiano_saratani' => Input::get('uhusiano_saratani'),
                        'kusambazwa_saratani' => Input::get('kusambazwa_saratani'),
                        'vitu_hatarishi' => Input::get('vitu_hatarishi'),
                        'vitu_hatarishi_other' => Input::get('vitu_hatarishi_other'),
                        'dalili_saratani' => Input::get('dalili_saratani'),
                        'dalili_saratani_other' => Input::get('dalili_saratani_other'),
                        'saratani_vipimo' => Input::get('saratani_vipimo'),
                        'saratani_vipimo_other' => Input::get('saratani_vipimo_other'),
                        'saratani_inatibika' => Input::get('saratani_inatibika'),
                        'matibabu_saratani' => Input::get('matibabu_saratani'),
                        'matibabu' => Input::get('matibabu'),
                        'matibabu_other' => Input::get('matibabu_other'),
                        'saratani_uchunguzi' => Input::get('saratani_uchunguzi'),
                        'uchunguzi_maana' => Input::get('uchunguzi_maana'),
                        'uchunguzi_maana_other' => Input::get('uchunguzi_maana_other'),
                        'uchunguzi_faida' => Input::get('uchunguzi_faida'),
                        'uchunguzi_faida_other' => Input::get('uchunguzi_faida_other'),
                        'uchunguzi_hatari' => Input::get('uchunguzi_hatari'),
                        'uchunguzi_hatari_other' => Input::get('uchunguzi_hatari_other'),
                        'saratani_hatari' => Input::get('saratani_hatari'),
                        'saratani_hatari_other' => Input::get('saratani_hatari_other'),
                        'kundi' => Input::get('kundi'),
                        'kundi_other' => Input::get('kundi_other'),
                        'ushawishi' => Input::get('ushawishi'),
                        'ushawishi_other' => Input::get('ushawishi_other'),
                        'hitaji_elimu' => Input::get('hitaji_elimu'),
                        'vifo' => Input::get('vifo'),
                        'tayari_dalili' => Input::get('tayari_dalili'),
                        'saratani_kutibika' => Input::get('saratani_kutibika'),
                        'saratani_wasiwasi' => Input::get('saratani_wasiwasi'),
                        'saratani_umuhimu' => Input::get('saratani_umuhimu'),
                        'saratani_kufa' => Input::get('saratani_kufa'),
                        'uchunguzi_haraka' => Input::get('uchunguzi_haraka'),
                        'wapi_matibabu' => Input::get('wapi_matibabu'),
                        'wapi_matibabu_other' => Input::get('wapi_matibabu_other'),
                        'saratani_ushauri' => Input::get('saratani_ushauri'),
                        'saratani_ujumbe' => Input::get('saratani_ujumbe'),
                        'eligible' => 1,
                        'status' => 1,
                        'patient_id' => Input::get('cid'),
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));

                    $user->createRecord('visit', array(
                        'visit_name' => 'Month 0',
                        'classification_date' => '',
                        'expected_date' => date('Y-m-d'),
                        'visit_date' => '',
                        'outcome' => 0,
                        'visit_status' => 0,
                        'diagnosis' => '',
                        'category' => '',
                        'status' => 1,
                        'patient_id' => Input::get('cid'),
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));

                    $successMessage = 'Kap  Successful Added';
                } elseif (Input::get('btn') == 'Update') {
                    $user->updateRecord('kap', array(
                        'interview_date' => Input::get('interview_date'),
                        'saratani_mapafu' => Input::get('saratani_mapafu'),
                        'uhusiano_saratani' => Input::get('uhusiano_saratani'),
                        'kusambazwa_saratani' => Input::get('kusambazwa_saratani'),
                        'vitu_hatarishi' => Input::get('vitu_hatarishi'),
                        'vitu_hatarishi_other' => Input::get('vitu_hatarishi_other'),
                        'dalili_saratani' => Input::get('dalili_saratani'),
                        'dalili_saratani_other' => Input::get('dalili_saratani_other'),
                        'saratani_vipimo' => Input::get('saratani_vipimo'),
                        'saratani_vipimo_other' => Input::get('saratani_vipimo_other'),
                        'saratani_inatibika' => Input::get('saratani_inatibika'),
                        'matibabu_saratani' => Input::get('matibabu_saratani'),
                        'matibabu' => Input::get('matibabu'),
                        'matibabu_other' => Input::get('matibabu_other'),
                        'saratani_uchunguzi' => Input::get('saratani_uchunguzi'),
                        'uchunguzi_maana' => Input::get('uchunguzi_maana'),
                        'uchunguzi_maana_other' => Input::get('uchunguzi_maana_other'),
                        'uchunguzi_faida' => Input::get('uchunguzi_faida'),
                        'uchunguzi_faida_other' => Input::get('uchunguzi_faida_other'),
                        'uchunguzi_hatari' => Input::get('uchunguzi_hatari'),
                        'uchunguzi_hatari_other' => Input::get('uchunguzi_hatari_other'),
                        'saratani_hatari' => Input::get('saratani_hatari'),
                        'saratani_hatari_other' => Input::get('saratani_hatari_other'),
                        'kundi' => Input::get('kundi'),
                        'kundi_other' => Input::get('kundi_other'),
                        'ushawishi' => Input::get('ushawishi'),
                        'ushawishi_other' => Input::get('ushawishi_other'),
                        'hitaji_elimu' => Input::get('hitaji_elimu'),
                        'vifo' => Input::get('vifo'),
                        'tayari_dalili' => Input::get('tayari_dalili'),
                        'saratani_kutibika' => Input::get('saratani_kutibika'),
                        'saratani_wasiwasi' => Input::get('saratani_wasiwasi'),
                        'saratani_umuhimu' => Input::get('saratani_umuhimu'),
                        'saratani_kufa' => Input::get('saratani_kufa'),
                        'uchunguzi_haraka' => Input::get('uchunguzi_haraka'),
                        'wapi_matibabu' => Input::get('wapi_matibabu'),
                        'wapi_matibabu_other' => Input::get('wapi_matibabu_other'),
                        'saratani_ushauri' => Input::get('saratani_ushauri'),
                        'saratani_ujumbe' => Input::get('saratani_ujumbe'),
                        'eligible' => 1,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), Input::get('id'));
                    $successMessage = 'Kap  Successful Updated';
                }
            } else {
                $pageError = $validate->errors();
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

                    $user->createRecord('visit', array(
                        'visit_name' => 'Month 0',
                        'classification_date' => '',
                        'expected_date' => date('Y-m-d'),
                        'visit_date' => '',
                        'outcome' => 0,
                        'visit_status' => 0,
                        'diagnosis' => '',
                        'category' => '',
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

                            if ($value == 1) {
                                $visit = 'Month 12';
                                $expected_date = date('Y-m-d', strtotime('+12 month', strtotime(Input::get('classification_date'))));
                            } elseif ($value == 2) {
                                $visit = 'Month 12';
                                $expected_date = date('Y-m-d', strtotime('+12 month', strtotime(Input::get('classification_date'))));
                            } elseif ($value == 3) {
                                $visit = 'Month 6';
                                $expected_date = date('Y-m-d', strtotime('+6 month', strtotime(Input::get('classification_date'))));
                            } elseif ($value == 4) {
                                $visit = 'Month 3';
                                $expected_date = date('Y-m-d', strtotime('+3 month', strtotime(Input::get('classification_date'))));
                            } elseif ($value == 5) {
                                $visit = 'Referred';
                                $expected_date = 'N / A';
                            }

                            $user->createRecord('visit', array(
                                'visit_name' => $visit,
                                'classification_date' => Input::get('classification_date'),
                                'expected_date' => $expected_date,
                                'visit_date' => '',
                                'outcome' => 0,
                                'visit_status' => 0,
                                'diagnosis' => Input::get('diagnosis'),
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
        } elseif (Input::get('add_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                // 'category' => array(
                //     'required' => true,
                // ),
            ));

            if ($validate->passed()) {
                $user->updateRecord('visit', array(
                    'visit_date' => Input::get('visit_date'),
                    'visit_status' => Input::get('visit_status'),
                    'diagnosis' => Input::get('diagnosis'),
                    'outcome' => Input::get('outcome'),
                    'status' => 1,
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
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
                    <!-- <div class="row">
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
                    </div> -->
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
                        // if ($_GET['btn'] == 'Add' & $_GET['status'] == 1) {
                        //     $last = $override->lastRow2('clients', 'status', 1, 'id')[0];
                        //     $cid = $last['id'];
                        // } elseif ($_GET['btn'] == 'Update') {
                        //     $cid = $_GET['cid'];
                        // }
                        $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                        $sex = $override->get('sex', 'id', $clients['sex'])[0];
                        $district = $override->get('district', 'id', $clients['district'])[0];
                        $education = $override->get('education', 'id', $clients['education'])[0];
                        $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                        $yes_no = $override->get('yes_no', 'id', $clients['health_insurance'])[0];
                        $payments = $override->get('payments', 'id', $clients['pay_services'])[0];
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
                                                        <span class="d-none d-sm-inline">Part A: Demographics </span>
                                                    </a>
                                                </li>
                                                <!-- <li class="nav-item" data-target-form="#profileForm">
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
                                                </li> -->
                                            </ul>


                                            <div class="tab-content mb-0 b-0">
                                                <div class="tab-pane" id="first">
                                                    <form id="accountForm" method="post" class="form-horizontal">
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
                                                                        <input type="date" value="<?php if ($clients) {
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
                                                                    <label class="col-md-3 col-form-label" for="street">Residence street</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" value="<?php if ($clients) {
                                                                                                        print_r($clients['street']);
                                                                                                    } ?>" id="street" name="street" class="form-control" placeholder="Enter Residence name" required>
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
                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="head_household">Who is the head of your household?</label>
                                                                    <div class="col-md-9">
                                                                        <select id="head_household" name="head_household" class="form-select form-select-lg mb-3" required>
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
                                                                        <select id="pay_services" name="pay_services" class="form-select form-select-lg mb-3" required>
                                                                            <option value="<?= $payments['id'] ?>"><?php if ($clients) {
                                                                                                                        print_r($payments['name']);
                                                                                                                    } else {
                                                                                                                        echo 'Select pay';
                                                                                                                    } ?>
                                                                            </option>
                                                                            <?php foreach ($override->get('payments', 'status', 1) as $value) { ?>
                                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
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

                                                                <div class="row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="complete_status">Completed ?</label>
                                                                    <div class="col-md-9">
                                                                        <select id="complete_status" name="complete_status" class="form-select form-select-lg mb-3" required>
                                                                            <option value="<?= $yes_no['id'] ?>"><?php if ($clients) {
                                                                                                                        print_r($yes_no['name']);
                                                                                                                    } else {
                                                                                                                        echo 'Select status';
                                                                                                                    } ?>
                                                                            </option>
                                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                        <input type="hidden" name="id" value="<?= $clients['id']; ?>" />
                                                        <input type="submit" name="add_demographic" value="<?= $_GET['btn']; ?>" class="btn btn-info" />
                                                    </form>
                                                    <?php if ($clients['status']) { ?>
                                                        <!-- <ul class="list-inline wizard mb-0">
                                                            <li class="next list-inline-item float-end">
                                                                <a href="javascript:void(0);" class="btn btn-info">Add Demographics 2 <i class="ri-arrow-right-line ms-1"></i></a>
                                                            </li>
                                                        </ul> -->
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <!-- tab-content -->
                                        </div> <!-- end #rootwizard-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    <?php } elseif ($_GET['id'] == 3) { ?>

                        <div class="content-page">
                            <div class="content">

                                <!-- Start Content-->
                                <div class="container-fluid">

                                    <!-- start page title -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="page-title-box">
                                                <div class="page-title-right">
                                                    <ol class="breadcrumb m-0">
                                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                                        <li class="breadcrumb-item active">Form Elements</li>
                                                    </ol>
                                                </div>
                                                <h4 class="page-title">KAP</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end page title -->

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="header-title">
                                                        Sehemu ya 2; Uelewa juu ya Saratani ya mapafu. (Usimsomee machaguo)
                                                    </h4>
                                                    <h4 class="modal-title" id="standard-modalLabel"></h4>

                                                    <p class="text-muted mb-0">
                                                        JINA LA PARTICIPANTS
                                                        <!-- <code>text</code>, <code>password</code>, <code>datetime</code>,
                                                        <code>datetime-local</code>, <code>date</code>, <code>month</code>,
                                                        <code>time</code>, <code>week</code>, <code>number</code>, <code>email</code>,
                                                        <code>url</code>, <code>search</code>, <code>tel</code>, and <code>color</code>. -->
                                                    </p>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <form id="validation" method="post">
                                                            <!-- <div class="row">
                                                                <div class="col-lg-4">

                                                                    <div class="mb-3">
                                                                        <label for="simpleinput" class="form-label">Text</label>
                                                                        <input type="text" id="simpleinput" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">

                                                                    <div class="mb-3">
                                                                        <label for="example-email" class="form-label">Email</label>
                                                                        <input type="email" id="example-email" name="example-email" class="form-control" placeholder="Email">
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4">

                                                                    <div class="mb-0">
                                                                        <label for="example-helping" class="form-label">Helping text</label>
                                                                        <input type="text" id="example-helping" class="form-control" placeholder="Helping text">
                                                                        <span class="help-block"><small>A block of help text that breaks
                                                                                onto a new line and may extend beyond one
                                                                                line.</small></span>
                                                                    </div>
                                                                </div>
                                                            </div> -->
                                                            <!-- end row -->


                                                            <div class="row">

                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="mb-2">
                                                                            <label for="interview_date" class="form-label">Interview Date</label>
                                                                            <input type="date" value="<?php if ($kap) {
                                                                                                            print_r($kap['interview_date']);
                                                                                                        } ?>" id="interview_date" name="interview_date" class="form-control" placeholder="Enter interview date" required />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-4">
                                                                        <div class="mb-2">
                                                                            <label for="saratani_mapafu" class="form-label">1. Je, unaweza kuniambia nini maana ya ugonjwa wa Saratani ya mapafu? </label>
                                                                            <select name="saratani_mapafu" id="saratani_mapafu" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['saratani_mapafu'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['saratani_mapafu'] == 1) {
                                                                                                                                        echo 'Ugonjwa wa saratani ya mapafu ni ugonjwa ambao unatokea endapo seli za mapafu zinazaliana bila mpangilio maalum, na unaweza ukasambaa kwenye tezi za mwili na sehemu zinginezo.';
                                                                                                                                    } elseif ($kap['saratani_mapafu'] == 2) {
                                                                                                                                        echo 'Wagonjwa wenye saratani ya mapafu hawaonyeshi dalili zozote wakati wa hatua za mwanzoni za ugonjwa.';
                                                                                                                                    } elseif ($kap['saratani_mapafu'] == 3) {
                                                                                                                                        echo 'Sina uhakika nini maana ya ugonjwa wa saratani ya mapafu.';
                                                                                                                                    } elseif ($kap['saratani_mapafu'] == 4) {
                                                                                                                                        echo 'Sijawahi kusikia kitu chochote juu ya ugonjwa wa saratani ya mapafu.';
                                                                                                                                    } elseif ($kap['saratani_mapafu'] == 99) {
                                                                                                                                        echo 'Sijui';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">a. Ugonjwa wa saratani ya mapafu ni ugonjwa ambao unatokea endapo seli za mapafu zinazaliana bila mpangilio maalum, na unaweza ukasambaa kwenye tezi za mwili na sehemu zinginezo.</option>
                                                                                <option value="2">b. Wagonjwa wenye saratani ya mapafu hawaonyeshi dalili zozote wakati wa hatua za mwanzoni za ugonjwa.</option>
                                                                                <option value="3">c. Sina uhakika nini maana ya ugonjwa wa saratani ya mapafu.</option>
                                                                                <option value="4">d. Sijawahi kusikia kitu chochote juu ya ugonjwa wa saratani ya mapafu.</option>
                                                                                <option value="99">e. Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="mb-3">
                                                                            <label for="uhusiano_saratani" class="form-label">2. Je, kuna uhusiano kati ya saratani ya mapafu na maambukizi ya Virusi vya UKIMWI? </label>
                                                                            <select name="uhusiano_saratani" id="uhusiano_saratani" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['uhusiano_saratani'] ?>"><?php if ($kap) {
                                                                                                                                        if ($kap['uhusiano_saratani'] == 1) {
                                                                                                                                            echo 'Ndio';
                                                                                                                                        } elseif ($kap['uhusiano_saratani'] == 2) {
                                                                                                                                            echo 'Hapana';
                                                                                                                                        } elseif ($kap['uhusiano_saratani'] == 99) {
                                                                                                                                            echo 'Sijui';
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        echo 'Select';
                                                                                                                                    } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <div class="mb-3">
                                                                            <label for="kusambazwa_saratani" class="form-label">3. Je, saratani ya mapafu inaweza kusambazwa kutoka kwa mtu mmoja kwenda kwa mtu mwingine? </label>
                                                                            <select name="kusambazwa_saratani" id="kusambazwa_saratani" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['kusambazwa_saratani'] ?>"><?php if ($kap) {
                                                                                                                                        if ($kap['kusambazwa_saratani'] == 1) {
                                                                                                                                            echo 'Ndio';
                                                                                                                                        } elseif ($kap['kusambazwa_saratani'] == 2) {
                                                                                                                                            echo 'Hapana';
                                                                                                                                        } elseif ($kap['kusambazwa_saratani'] == 99) {
                                                                                                                                            echo 'Sijui';
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        echo 'Select';
                                                                                                                                    } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-3">
                                                                        <div class="mb-3">
                                                                            <label for="vitu_hatarishi" class="form-label">4. Je, vitu gani hatarishi vinaweza kusababisha mtu kupata saratani ya mapafu? (Multiple answer)</label>
                                                                            <select name="vitu_hatarishi" id="vitu_hatarishi" class="form-select form-select-lg mb-3" onchange="updateText1(this.value)" required>
                                                                                <option value="<?= $kap['vitu_hatarishi'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                        echo 'Uvutaji sigara.';
                                                                                                                                    } elseif ($kap['vitu_hatarishi'] == 2) {
                                                                                                                                        echo 'Kufanya kazi kwenye migodi.';
                                                                                                                                    } elseif ($kap['vitu_hatarishi'] == 3) {
                                                                                                                                        echo 'Kufanya kazi viwandani. (kiwanda cha bidhaa ya kemikali).';
                                                                                                                                    } elseif ($kap['vitu_hatarishi'] == 4) {
                                                                                                                                        echo 'Kufanya kazi katika maeneo yenye hewa chafu sana.(highly air pollutes areas).';
                                                                                                                                    } elseif ($kap['vitu_hatarishi'] == 5) {
                                                                                                                                        echo 'Mtu akiwa na saratani nyingine yeyote mwilini .';
                                                                                                                                    } elseif ($kap['vitu_hatarishi'] == 6) {
                                                                                                                                        echo 'Kuwa na mtu kwenye familia mwenye historia ya saratani ya mapafu.';
                                                                                                                                    } elseif ($kap['vitu_hatarishi'] == 7) {
                                                                                                                                        echo 'Kuwa na historia ya kupigwa mionzi ya kifua.';
                                                                                                                                    } elseif ($kap['vitu_hatarishi'] == 8) {
                                                                                                                                        echo 'Kutumia uzazi wa mpango (vidonge vya majira).';
                                                                                                                                    } elseif ($kap['vitu_hatarishi'] == 96) {
                                                                                                                                        echo 'Nyinginezo, Taja: ________________';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Uvutaji sigara</option>
                                                                                <option value="2">Kufanya kazi kwenye migodi</option>
                                                                                <option value="3">Kufanya kazi viwandani. (kiwanda cha bidhaa ya kemikali).</option>
                                                                                <option value="4">Kufanya kazi katika maeneo yenye hewa chafu sana.(highly air pollutes areas)..</option>
                                                                                <option value="5">Mtu akiwa na saratani nyingine yeyote mwilini ..</option>
                                                                                <option value="6">Kuwa na mtu kwenye familia mwenye historia ya saratani ya mapafu..</option>
                                                                                <option value="7">Kuwa na historia ya kupigwa mionzi ya kifua..</option>
                                                                                <option value="8">Kutumia uzazi wa mpango (vidonge vya majira)..</option>
                                                                                <option value="96">Nyinginezo, Taja: ________________.</option>
                                                                            </select>
                                                                            <!-- <input name="adv1" type="text" id="adv1" value="" /> -->
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6" id="vitu_hatarishi_other">
                                                                        <div class="mb-3">
                                                                            <label for="vitu_hatarishi_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['vitu_hatarishi_other']);
                                                                                                        } ?>" name="vitu_hatarishi_other" class="form-control" placeholder="Ingiza vitu hatarishi" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label for="dalili_saratani" class="form-label">5. Je, mtu mwenye Saratani ya mapafu anakua na dalili zipi? (Multiple answer) </label>
                                                                            <select name="dalili_saratani" id="dalili_saratani" class="form-select form-select-lg mb-3" onchange="updateText2(this.value)" required>
                                                                                <option value="<?= $kap['dalili_saratani'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['dalili_saratani'] == 1) {
                                                                                                                                        echo 'Kikohozi cha Zaidi ya  wiki 2 au 3.';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 2) {
                                                                                                                                        echo 'Kikohozi cha muda mrefu kinachozidi kuwa kibaya.';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 3) {
                                                                                                                                        echo 'Kukohoa damu au makohozi yenye rangi ya kutu (spit or phlegm).';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 4) {
                                                                                                                                        echo 'Magonjwa ya mara kwa mara ya kifua kama bronchitis, pneumonia etc.';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 5) {
                                                                                                                                        echo 'Maumivu ya kifua yanayoongezeka wakati wa kupumua au kukohoa.';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 6) {
                                                                                                                                        echo 'Kupumua kwa shida (Persistent breathlessness).';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 7) {
                                                                                                                                        echo 'Uchovu wa mara kwa mara au r lack of energy.';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 8) {
                                                                                                                                        echo 'Kutoa kisauti wakati wa kupumua (Wheezing).';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 9) {
                                                                                                                                        echo 'Kukosa pumzi (Shortness of breath).';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 10) {
                                                                                                                                        echo 'Kupungua uzito kusiko na sababu.';
                                                                                                                                    } elseif ($kap['dalili_saratani'] == 96) {
                                                                                                                                        echo 'Nyingine, taja: ________________';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Kikohozi cha Zaidi ya wiki 2 au 3.</option>
                                                                                <option value="2">Kikohozi cha muda mrefu kinachozidi kuwa kibaya.</option>
                                                                                <option value="3">Kukohoa damu au makohozi yenye rangi ya kutu (spit or phlegm).</option>
                                                                                <option value="4">Magonjwa ya mara kwa mara ya kifua kama bronchitis, pneumonia etc.</option>
                                                                                <option value="5">Maumivu ya kifua yanayoongezeka wakati wa kupumua au kukohoa.</option>
                                                                                <option value="6">Kupumua kwa shida (Persistent breathlessness).</option>
                                                                                <option value="7">Uchovu wa mara kwa mara au r lack of energy.</option>
                                                                                <option value="8">Kutoa kisauti wakati wa kupumua (Wheezing).</option>
                                                                                <option value="9">Kukosa pumzi (Shortness of breath).</option>
                                                                                <option value="10">Kupungua uzito kusiko na sababu.</option>
                                                                                <option value="96">Nyingine, taja: ________________</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6" id="dalili_saratani_other">
                                                                        <div class="mb-3">
                                                                            <label for="dalili_saratani_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['dalili_saratani_other']);
                                                                                                        } ?>" name="dalili_saratani_other" class="form-control" placeholder="Ingiza dalili_saratani" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label for="saratani_vipimo" class="form-label">6. Kama mtu akigundulika ana saratani ya mapafu ,ni vipimo gani vinatakiwa kufanyika? (Multiple answer)</label>
                                                                            <select name="saratani_vipimo" id="saratani_vipimo" class="form-select form-select-lg mb-3" onchange="updateText3(this.value)" required>
                                                                                <option value="<?= $kap['saratani_vipimo'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['saratani_vipimo'] == 1) {
                                                                                                                                        echo 'Vipimo vya damu.';
                                                                                                                                    } elseif ($kap['saratani_vipimo'] == 2) {
                                                                                                                                        echo 'Picha ya kifua (Chest X-ray).';
                                                                                                                                    } elseif ($kap['saratani_vipimo'] == 3) {
                                                                                                                                        echo 'CT scan ya kifua';
                                                                                                                                    } elseif ($kap['saratani_vipimo'] == 4) {
                                                                                                                                        echo 'Kutoa kinyama kwenye mapafu (Lung Biopsy).';
                                                                                                                                    } elseif ($kap['saratani_vipimo'] == 99) {
                                                                                                                                        echo 'Sijui';
                                                                                                                                    } elseif ($kap['saratani_vipimo'] == 96) {
                                                                                                                                        echo 'Zinginezo, taja: ________________';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Vipimo vya damu</option>
                                                                                <option value="2">Picha ya kifua (Chest X-ray)</option>
                                                                                <option value="3">CT scan ya kifua</option>
                                                                                <option value="4">Kutoa kinyama kwenye mapafu (Lung Biopsy)</option>
                                                                                <option value="99">Sijui</option>
                                                                                <option value="96">Zinginezo, taja: ________________</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6" id="saratani_vipimo_other">
                                                                        <div class="mb-3">
                                                                            <label for="saratani_vipimo_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['saratani_vipimo_other']);
                                                                                                        } ?>" name="saratani_vipimo_other" class="form-control" placeholder="Ingiza saratani_vipimo_" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label for="saratani_inatibika" class="form-label">7. Je, ugonjwa wa saratani ya mapafu unatibika?</label>
                                                                            <select name="saratani_inatibika" id="saratani_inatibika" class="form-select form-select-lg mb-3" onchange="updateText4(this.value)" required>
                                                                                <option value="<?= $kap['saratani_inatibika'] ?>"><?php if ($kap) {
                                                                                                                                        if ($kap['saratani_inatibika'] == 1) {
                                                                                                                                            echo 'Ndio';
                                                                                                                                        } elseif ($kap['saratani_inatibika'] == 2) {
                                                                                                                                            echo 'Hapana';
                                                                                                                                        } elseif ($kap['saratani_inatibika'] == 99) {
                                                                                                                                            echo 'Sijui';
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        echo 'Select';
                                                                                                                                    } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6" id="matibabu_saratani1">
                                                                        <div class="mb-3">
                                                                            <label for="matibabu_saratani" class="form-label">8. Kama jibu ni ndio, Je unajua njia yoyote ya matibabu ya saratani ya mapafu?</label>
                                                                            <select name="matibabu_saratani" id="matibabu_saratani" class="form-select form-select-lg mb-3" onchange="updateText5(this.value)">
                                                                                <option value="<?= $kap['matibabu_saratani'] ?>"><?php if ($kap) {
                                                                                                                                        if ($kap['matibabu_saratani'] == 1) {
                                                                                                                                            echo 'Ndio';
                                                                                                                                        } elseif ($kap['matibabu_saratani'] == 2) {
                                                                                                                                            echo 'Hapana';
                                                                                                                                        } elseif ($kap['matibabu_saratani'] == 99) {
                                                                                                                                            echo 'Sijui';
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        echo 'Select';
                                                                                                                                    } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-6" id="matibabu1">
                                                                        <div class="mb-3">
                                                                            <label for="matibabu" class="form-label">9. Kama jibu ni ndio, je ni njia gani za matibabu ya saratani ya mapafu unazozijua? Zitaje.. (Multiple answer)</label>
                                                                            <select name="matibabu" id="matibabu" class="form-select form-select-lg mb-3" onchange="updateText6(this.value)">
                                                                                <option value="<?= $kap['matibabu'] ?>"><?php if ($kap) {
                                                                                                                            if ($kap['matibabu'] == 1) {
                                                                                                                                echo 'Upasuaji';
                                                                                                                            } elseif ($kap['matibabu'] == 2) {
                                                                                                                                echo 'Tiba kemikali (Chemotherapy).';
                                                                                                                            } elseif ($kap['matibabu'] == 3) {
                                                                                                                                echo 'Tiba ya mionzi (Radiotherapy).';
                                                                                                                            } elseif ($kap['matibabu'] == 4) {
                                                                                                                                echo 'Tiba ya kinga (Immunotherapy).';
                                                                                                                            } elseif ($kap['matibabu'] == 5) {
                                                                                                                                echo 'Kizuizi cha Tyrosine Kinase (Tyrosine kinase inhibitor).';
                                                                                                                            } elseif ($kap['matibabu'] == 6) {
                                                                                                                                echo 'Tiba inayolengwa na kinga. (Immune target therapy).';
                                                                                                                            } elseif ($kap['matibabu'] == 99) {
                                                                                                                                echo 'Sijui';
                                                                                                                            } elseif ($kap['matibabu'] == 96) {
                                                                                                                                echo 'Zinginezo: Taja ________________';
                                                                                                                            }
                                                                                                                        } else {
                                                                                                                            echo 'Select';
                                                                                                                        } ?>
                                                                                </option>
                                                                                <option value="1">Upasuaji</option>
                                                                                <option value="2">Tiba kemikali (Chemotherapy)</option>
                                                                                <option value="3">Tiba ya mionzi (Radiotherapy).</option>
                                                                                <option value="4">Tiba ya kinga (Immunotherapy).</option>
                                                                                <option value="5">Kizuizi cha Tyrosine Kinase (Tyrosine kinase inhibitor).</option>
                                                                                <option value="6">Tiba inayolengwa na kinga. (Immune target therapy).</option>
                                                                                <option value="99">Sijui</option>
                                                                                <option value="96">Zinginezo: Taja ________________</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6" id="matibabu_other">
                                                                        <div class="mb-3">
                                                                            <label for="matibabu_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['matibabu_other']);
                                                                                                        } ?>" name="matibabu_other" class="form-control" placeholder="Ingiza matibabu" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <h4 class="modal-title" id="standard-modalLabel">Sehemu ya 3; Uchunguzi(Screening) wa saratani ya mapafu. (Usimusmoee machaguo)</h4>
                                                                <hr>

                                                                <div class="row">

                                                                    <div class="col-4">
                                                                        <div class="mb-2">
                                                                            <label for="saratani_uchunguzi" class="form-label">1. Je, umewahi kusikia chochote kuhusu uchunguzi wa saratani ya mapafu, inawezekana kwa kusoma mahali Fulani, kusikia kwenye vyombo vya habari au kusikia kutoka kituo cha kutolea huduma za Afya? </label>
                                                                            <select name="saratani_uchunguzi" id="saratani_uchunguzi" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['saratani_uchunguzi'] ?>"><?php if ($kap) {
                                                                                                                                        if ($kap['saratani_uchunguzi'] == 1) {
                                                                                                                                            echo 'Ndio';
                                                                                                                                        } elseif ($kap['saratani_uchunguzi'] == 2) {
                                                                                                                                            echo 'Hapana';
                                                                                                                                        } elseif ($kap['saratani_uchunguzi'] == 99) {
                                                                                                                                            echo 'Sijui';
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        echo 'Select';
                                                                                                                                    } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="mb-3">
                                                                            <label for="uchunguzi_maana" class="form-label">2. Nini maana ya uchunguzi wa saratani ya mapafu?</label>
                                                                            <select name="uchunguzi_maana" id="uchunguzi_maana" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['uchunguzi_maana'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['uchunguzi_maana'] == 1) {
                                                                                                                                        echo 'Uchunguzi wa saratani ya mapafu ni mchakato ambao hutumiwa kugundua uwepo wa saratani ya mapafu kwa watu wenye afya nzuri na wenye hatari kubwa ya kupata saratani ya mapafu.';
                                                                                                                                    } elseif ($kap['uchunguzi_maana'] == 2) {
                                                                                                                                        echo 'Uchunguzi wa saratani ya mapafu ni mkakati wa uchunguzi wa saratani ya mapafu inayotumiwa kutambua saratani ya mapafu mapema kabla ya kuonyesha dalili ambapo ni hatua ya mwanzoni kabisa ambayo kuna uwezekano mkubwa wa kutibika.';
                                                                                                                                    } elseif ($kap['uchunguzi_maana'] == 3) {
                                                                                                                                        echo 'Uchunguzi wa saratani ya mapafu ni kipimo cha kugundua saratani ya mapafu mapema kabla ya dalili kutokea.';
                                                                                                                                    } elseif ($kap['uchunguzi_maana'] == 99) {
                                                                                                                                        echo 'Sijui';
                                                                                                                                    } elseif ($kap['uchunguzi_maana'] == 96) {
                                                                                                                                        echo 'Nyinginezo, Taja; ________________';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Uchunguzi wa saratani ya mapafu ni mchakato ambao hutumiwa kugundua uwepo wa saratani ya mapafu kwa watu wenye afya nzuri na wenye hatari kubwa ya kupata saratani ya mapafu.</option>
                                                                                <option value="2">Uchunguzi wa saratani ya mapafu ni mkakati wa uchunguzi wa saratani ya mapafu inayotumiwa kutambua saratani ya mapafu mapema kabla ya kuonyesha dalili ambapo ni hatua ya mwanzoni kabisa ambayo kuna uwezekano mkubwa wa kutibika.</option>
                                                                                <option value="3">Uchunguzi wa saratani ya mapafu ni kipimo cha kugundua saratani ya mapafu mapema kabla ya dalili kutokea.</option>
                                                                                <option value="99">Sijui</option>
                                                                                <option value="96">Nyinginezo, Taja; ________________</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-4" id="uchunguzi_maana_other">
                                                                        <div class="mb-3">
                                                                            <label for="uchunguzi_maana_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['uchunguzi_maana_other']);
                                                                                                        } ?>" name="uchunguzi_maana_other" class="form-control" placeholder="Ingiza vitu hatarishi" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <hr>

                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label for="uchunguzi_faida" class="form-label">3. Je, kuna faida gani ya kufanya uchunguzi wa saratani ya mapafu?</label>
                                                                            <select name="uchunguzi_faida" id="uchunguzi_faida" class="form-select form-select-lg mb-3" onchange="updateText1(this.value)" required>
                                                                                <option value="<?= $kap['uchunguzi_faida'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['uchunguzi_faida'] == 1) {
                                                                                                                                        echo 'Utambuzi wa mapema ambao unaokoa maisha.';
                                                                                                                                    } elseif ($kap['uchunguzi_faida'] == 2) {
                                                                                                                                        echo 'Kugundua saratani ya mapafu katika hatua ya awali wakati kuna uwezekano mkubwa wa kupona.';
                                                                                                                                    } elseif ($kap['uchunguzi_faida'] == 3) {
                                                                                                                                        echo 'Hupunguza hatari ya kufa kwa saratani ya mapafu';
                                                                                                                                    } elseif ($kap['uchunguzi_faida'] == 99) {
                                                                                                                                        echo 'Sijui.';
                                                                                                                                    } elseif ($kap['uchunguzi_faida'] == 96) {
                                                                                                                                        echo 'Nyinginezo, Taja: ________________';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Utambuzi wa mapema ambao unaokoa maisha.</option>
                                                                                <option value="2">Kugundua saratani ya mapafu katika hatua ya awali wakati kuna uwezekano mkubwa wa kupona.</option>
                                                                                <option value="3">Hupunguza hatari ya kufa kwa saratani ya mapafu.</option>
                                                                                <option value="99">Sijui.</option>
                                                                                <option value="96">Nyinginezo, Taja: ________________.</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6" id="uchunguzi_faida_other">
                                                                        <div class="mb-3">
                                                                            <label for="uchunguzi_faida_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['uchunguzi_faida_other']);
                                                                                                        } ?>" name="uchunguzi_faida_other" class="form-control" placeholder="Ingiza vitu hatarishi" />
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <hr>

                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="mb-3">
                                                                            <label for="uchunguzi_hatari" class="form-label">4. Je, kuna hatari zozote za kufanya uchunguzi wa saratani ya mapafu?</label>
                                                                            <select name="uchunguzi_hatari" id="uchunguzi_hatari" class="form-select form-select-lg mb-3" onchange="updateText4(this.value)" required>
                                                                                <option value="<?= $kap['uchunguzi_hatari'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['uchunguzi_hatari'] == 1) {
                                                                                                                                        echo 'Ndio';
                                                                                                                                    } elseif ($kap['uchunguzi_hatari'] == 2) {
                                                                                                                                        echo 'Hapana';
                                                                                                                                    } elseif ($kap['uchunguzi_hatari'] == 99) {
                                                                                                                                        echo 'Sijui';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-4">
                                                                        <div class="mb-3">
                                                                            <label for="saratani_hatari" class="form-label">5. Kama jibu hapo juu ni ndio, je ni hatari gani zinazoweza kutokana na kufanya uchunguzi wa saratani ya mapafu?</label>
                                                                            <select name="saratani_hatari" id="saratani_hatari" class="form-select form-select-lg mb-3" onchange="updateText4(this.value)" required>
                                                                                <option value="<?= $kap['saratani_hatari'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['saratani_hatari'] == 1) {
                                                                                                                                        echo 'Hatari ya kupata mionzi mwilini, kwa kuwa inatumia skana ya LDCT.';
                                                                                                                                    } elseif ($kap['saratani_hatari'] == 2) {
                                                                                                                                        echo 'Uwoga Madaktari wanaweza wakagundua magonjwa mengine yanayofanana na  saratani ya mapafu ambayo siyo saratani ya mapafu (False positives).';
                                                                                                                                    } elseif ($kap['saratani_hatari'] == 3) {
                                                                                                                                        echo 'Unaweza kupata uvimbe vidogo vidogo ambavyo ni saratani zinazokua polepole ambazo hazitakuletea madhara.(';
                                                                                                                                    } elseif ($kap['saratani_hatari'] == 4) {
                                                                                                                                        echo 'Msongo wa mawaso(Pychological distress)';
                                                                                                                                    } elseif ($kap['saratani_hatari'] == 5) {
                                                                                                                                        echo 'Uchunguzi wa kupita kiasi (Overdiagnosis)';
                                                                                                                                    } elseif ($kap['saratani_hatari'] == 99) {
                                                                                                                                        echo 'Sijui.';
                                                                                                                                    } elseif ($kap['saratani_hatari'] == 96) {
                                                                                                                                        echo 'Nyinginezo, Taja: ________________';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Uwoga Madaktari wanaweza wakagundua magonjwa mengine yanayofanana na saratani ya mapafu ambayo siyo saratani ya mapafu (False positives).</option>
                                                                                <option value="3">Unaweza kupata uvimbe vidogo vidogo ambavyo ni saratani zinazokua polepole ambazo hazitakuletea madhara.(</option>
                                                                                <option value="4">Msongo wa mawaso(Pychological distress)</option>
                                                                                <option value="5">Uchunguzi wa kupita kiasi (Overdiagnosis)</option>
                                                                                <option value="99">Sijui</option>
                                                                                <option value="96">Nyinyinezo: Taja ________________.</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-4" id="saratani_hatari_other">
                                                                        <div class="mb-3">
                                                                            <label for="saratani_hatari_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['saratani_hatari_other']);
                                                                                                        } ?>" name="saratani_hatari_other" class="form-control" placeholder="Ingiza saratani_vipimo_" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <hr>

                                                                <div class="row">

                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label for="kundi" class="form-label">6. Je, ni kundi gani la watu linalofaa kufanyiwa uchunguzi wa saratani ya mapafu? (Multiple answer)</label>
                                                                            <select name="kundi" id="kundi" class="form-select form-select-lg mb-3" onchange="updateText3(this.value)" required>
                                                                                <option value="<?= $kap['kundi'] ?>"><?php if ($kap) {
                                                                                                                            if ($kap['kundi'] == 1) {
                                                                                                                                echo 'Wazee(Zaidi ya miaka 45) ambao wanavuta sigara kwa sasa, au walivuta sigara zamani.';
                                                                                                                            } elseif ($kap['kundi'] == 2) {
                                                                                                                                echo 'Vijana (chini ya miaka 45) ambao wamevuta sigara kwa miaka mingi.';
                                                                                                                            } elseif ($kap['kundi'] == 3) {
                                                                                                                                echo 'Vijana (chini ya miaka 45)  waliowahi kuvuta sana sigara lakini wakaacha.';
                                                                                                                            } elseif ($kap['kundi'] == 4) {
                                                                                                                                echo 'Watu ambao wana historia ya kuugua saratani kwenye familia zao.';
                                                                                                                            } elseif ($kap['kundi'] == 5) {
                                                                                                                                echo 'Watu wenye viashiria vya saratani ya mapafu';
                                                                                                                            } elseif ($kap['kundi'] == 6) {
                                                                                                                                echo 'Watu wenye afya njema.';
                                                                                                                            } elseif ($kap['kundi'] == 99) {
                                                                                                                                echo 'Sijui';
                                                                                                                            } elseif ($kap['kundi'] == 96) {
                                                                                                                                echo 'Zinginezo, taja: ________________';
                                                                                                                            }
                                                                                                                        } else {
                                                                                                                            echo 'Select';
                                                                                                                        } ?>
                                                                                </option>
                                                                                <option value="1">Wazee(Zaidi ya miaka 45) ambao wanavuta sigara kwa sasa, au walivuta sigara zamani.</option>
                                                                                <option value="2">Vijana (chini ya miaka 45) ambao wamevuta sigara kwa miaka mingi.</option>
                                                                                <option value="3">Vijana (chini ya miaka 45) waliowahi kuvuta sana sigara lakini wakaacha.</option>
                                                                                <option value="4">Watu ambao wana historia ya kuugua saratani kwenye familia zao.</option>
                                                                                <option value="5">Watu wenye viashiria vya saratani ya mapafu</option>
                                                                                <option value="6">Watu wenye afya njema.</option>
                                                                                <option value="99">Sijui</option>
                                                                                <option value="96">Zinginezo, taja: ________________</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6" id="kundi_other">
                                                                        <div class="mb-3">
                                                                            <label for="kundi_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['kundi_other']);
                                                                                                        } ?>" name="kundi_other" class="form-control" placeholder="Ingiza saratani_vipimo_" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <hr>

                                                                <div class="row">

                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label for="ushawishi" class="form-label">7. Je! Unazani nani ana ushawishi mkubwa katika kutoa elimu ya ugonjwa wa Saratani ya Mapafu? (Multiple answer)</label>
                                                                            <select name="ushawishi" id="ushawishi" class="form-select form-select-lg mb-3" onchange="updateText4(this.value)" required>
                                                                                <option value="<?= $kap['ushawishi'] ?>"><?php if ($kap) {
                                                                                                                                if ($kap['ushawishi'] == 1) {
                                                                                                                                    echo 'Watoa huduma ya Afya ngazi ya jamii (CHWs).';
                                                                                                                                } elseif ($kap['ushawishi'] == 2) {
                                                                                                                                    echo 'Wataalamu wa Afya.';
                                                                                                                                } elseif ($kap['ushawishi'] == 3) {
                                                                                                                                    echo 'Watu waliopona ugonjwa wa saratani ya mapafu.';
                                                                                                                                } elseif ($kap['ushawishi'] == 4) {
                                                                                                                                    echo 'Viongozi wa Dini.';
                                                                                                                                } elseif ($kap['ushawishi'] == 5) {
                                                                                                                                    echo 'Waganga wa jadi/jamii/Ukoo';
                                                                                                                                } elseif ($kap['ushawishi'] == 6) {
                                                                                                                                    echo 'Viongozi wa jamii/mtaa/kijiji.';
                                                                                                                                } elseif ($kap['ushawishi'] == 7) {
                                                                                                                                    echo 'Serikali';
                                                                                                                                } elseif ($kap['ushawishi'] == 96) {
                                                                                                                                    echo 'Zinginezo, taja: ________________';
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                echo 'Select';
                                                                                                                            } ?>
                                                                                </option>
                                                                                <option value="1">Watoa huduma ya Afya ngazi ya jamii (CHWs).</option>
                                                                                <option value="2">Wataalamu wa Afya.</option>
                                                                                <option value="3">Watu waliopona ugonjwa wa saratani ya mapafu.</option>
                                                                                <option value="4">Viongozi wa Dini.</option>
                                                                                <option value="5">Waganga wa jadi/jamii/Ukoo</option>
                                                                                <option value="6">Viongozi wa jamii/mtaa/kijiji.</option>
                                                                                <option value="7">Serikali</option>
                                                                                <option value="96">Zinginezo, taja: ________________</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>

                                                                    <div class="col-6" id="ushawishi_other">
                                                                        <div class="mb-3">
                                                                            <label for="ushawishi_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['ushawishi_other']);
                                                                                                        } ?>" name="ushawishi_other" class="form-control" placeholder="Ingiza matibabu" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <div class="row">
                                                                    <div class="col-12" id="hitaji_elimu1">
                                                                        <div class="mb-3">
                                                                            <label for="hitaji_elimu" class="form-label">8. Je unahisi unahitaji taarifa/elimu Zaidi juu ya uchunguzi wa awali wa ugonjwa wa Saratani ya Mapafu na ugonjwa wenyewe kwa jumla?</label>
                                                                            <select name="hitaji_elimu" id="hitaji_elimu" class="form-select form-select-lg mb-3" onchange="updateText5(this.value)">
                                                                                <option value="<?= $kap['hitaji_elimu'] ?>"><?php if ($kap) {
                                                                                                                                if ($kap['hitaji_elimu'] == 1) {
                                                                                                                                    echo 'Ndio';
                                                                                                                                } elseif ($kap['hitaji_elimu'] == 2) {
                                                                                                                                    echo 'Hapana';
                                                                                                                                } elseif ($kap['hitaji_elimu'] == 99) {
                                                                                                                                    echo 'Sijui';
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                echo 'Select';
                                                                                                                            } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                </div>

                                                                <h4 class="modal-title" id="standard-modalLabel">Sehemu ya 4; Mtazamo juu ya uchunguzi wa saratani ya mapafu</h4>
                                                                <hr>
                                                                <p>Fikiria kuhusu uchunguzi wa saratani ya mapafu, unaweza kuniambia ni kwa kiasi gani unakubaliana na kila kauli zifuatazo?</p>

                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="mb-2">
                                                                            <label for="vifo" class="form-label">1. Fikiria kuhusu vifo vinavyotokea kwasababu ya Saratani; “Nisingependa kujua kama nina saratani ya mapafu”. </label>
                                                                            <select name="vifo" id="vifo" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['vifo'] ?>"><?php if ($kap) {
                                                                                                                        if ($kap['vifo'] == 1) {
                                                                                                                            echo 'Nakubali sana.';
                                                                                                                        } elseif ($kap['vifo'] == 2) {
                                                                                                                            echo 'Nakubali';
                                                                                                                        } elseif ($kap['vifo'] == 3) {
                                                                                                                            echo 'Kawaida';
                                                                                                                        } elseif ($kap['vifo'] == 4) {
                                                                                                                            echo 'Sikubali kabisa.';
                                                                                                                        } elseif ($kap['vifo'] == 5) {
                                                                                                                            echo 'Sikubali';
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        echo 'Select';
                                                                                                                    } ?>
                                                                                </option>
                                                                                <option value="1">Nakubali sana.</option>
                                                                                <option value="2">Nakubali</option>
                                                                                <option value="3">Kawaida</option>
                                                                                <option value="4">Sikubali kabisa.</option>
                                                                                <option value="5">Sikubali</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6">
                                                                        <div class="mb-2">
                                                                            <label for="tayari_dalili" class="form-label">2. Fikiria jinsi dalili zinavyoonekana, “ Kwenda kwa daktari wangu mapema nikiwa tayari na dalili za ugonjwa wa saratani ya mapafu,akulete utofauti wowote wa mimi kupona saratani ya mapafu”. </label>
                                                                            <select name="tayari_dalili" id="tayari_dalili" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['tayari_dalili'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['tayari_dalili'] == 1) {
                                                                                                                                        echo 'Nakubali sana.';
                                                                                                                                    } elseif ($kap['tayari_dalili'] == 2) {
                                                                                                                                        echo 'Nakubali';
                                                                                                                                    } elseif ($kap['tayari_dalili'] == 3) {
                                                                                                                                        echo 'Kawaida';
                                                                                                                                    } elseif ($kap['tayari_dalili'] == 4) {
                                                                                                                                        echo 'Sikubali kabisa.';
                                                                                                                                    } elseif ($kap['tayari_dalili'] == 5) {
                                                                                                                                        echo 'Sikubali';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Nakubali sana.</option>
                                                                                <option value="2">Nakubali</option>
                                                                                <option value="3">Kawaida</option>
                                                                                <option value="4">Sikubali kabisa.</option>
                                                                                <option value="5">Sikubali</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-6">
                                                                        <div class="mb-2">
                                                                            <label for="saratani_kutibika" class="form-label">3. Fikiria jinsi dalili zinavyoonekana ; “Endapo saratani ya mapafu ikigundulika mapema, kuna uwezekano mkubwa wa kutibika”. </label>
                                                                            <select name="saratani_kutibika" id="saratani_kutibika" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['saratani_kutibika'] ?>"><?php if ($kap) {
                                                                                                                                        if ($kap['saratani_kutibika'] == 1) {
                                                                                                                                            echo 'Nakubali sana.';
                                                                                                                                        } elseif ($kap['saratani_kutibika'] == 2) {
                                                                                                                                            echo 'Nakubali';
                                                                                                                                        } elseif ($kap['saratani_kutibika'] == 3) {
                                                                                                                                            echo 'Kawaida';
                                                                                                                                        } elseif ($kap['saratani_kutibika'] == 4) {
                                                                                                                                            echo 'Sikubali kabisa.';
                                                                                                                                        } elseif ($kap['saratani_kutibika'] == 5) {
                                                                                                                                            echo 'Sikubali';
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        echo 'Select';
                                                                                                                                    } ?>
                                                                                </option>
                                                                                <option value="1">Nakubali sana.</option>
                                                                                <option value="2">Nakubali</option>
                                                                                <option value="3">Kawaida</option>
                                                                                <option value="4">Sikubali kabisa.</option>
                                                                                <option value="5">Sikubali</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="mb-2">
                                                                            <label for="saratani_wasiwasi" class="form-label">4. “Ningependelea kutokwenda kufanya uchunguzi wa saratani ya mapafu kwa sababu nina wasiwasi juu ya kile kinachoweza kugundulika wakati wa uchunguzi wa saratani ya mapafu”. </label>
                                                                            <select name="saratani_wasiwasi" id="saratani_wasiwasi" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['saratani_wasiwasi'] ?>"><?php if ($kap) {
                                                                                                                                        if ($kap['saratani_wasiwasi'] == 1) {
                                                                                                                                            echo 'Nakubali sana.';
                                                                                                                                        } elseif ($kap['saratani_wasiwasi'] == 2) {
                                                                                                                                            echo 'Nakubali';
                                                                                                                                        } elseif ($kap['saratani_wasiwasi'] == 3) {
                                                                                                                                            echo 'Kawaida';
                                                                                                                                        } elseif ($kap['saratani_wasiwasi'] == 4) {
                                                                                                                                            echo 'Sikubali kabisa.';
                                                                                                                                        } elseif ($kap['saratani_wasiwasi'] == 5) {
                                                                                                                                            echo 'Sikubali';
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        echo 'Select';
                                                                                                                                    } ?>
                                                                                </option>
                                                                                <option value="1">Nakubali sana.</option>
                                                                                <option value="2">Nakubali</option>
                                                                                <option value="3">Kawaida</option>
                                                                                <option value="4">Sikubali kabisa.</option>
                                                                                <option value="5">Sikubali</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <hr>
                                                                    <div class="col-6">
                                                                        <div class="mb-2">
                                                                            <label for="saratani_umuhimu" class="form-label">5. “Sidhani kama kuna umuhimu wowote wa kwenda kufanya uchunguzi wa saratani ya mapafu kwa sababu haita athiri matokeo”. </label>
                                                                            <select name="saratani_umuhimu" id="saratani_umuhimu" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['saratani_umuhimu'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['saratani_umuhimu'] == 1) {
                                                                                                                                        echo 'Nakubali sana.';
                                                                                                                                    } elseif ($kap['saratani_umuhimu'] == 2) {
                                                                                                                                        echo 'Nakubali';
                                                                                                                                    } elseif ($kap['saratani_umuhimu'] == 3) {
                                                                                                                                        echo 'Kawaida';
                                                                                                                                    } elseif ($kap['saratani_umuhimu'] == 4) {
                                                                                                                                        echo 'Sikubali kabisa.';
                                                                                                                                    } elseif ($kap['saratani_umuhimu'] == 5) {
                                                                                                                                        echo 'Sikubali';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Nakubali sana.</option>
                                                                                <option value="2">Nakubali</option>
                                                                                <option value="3">Kawaida</option>
                                                                                <option value="4">Sikubali kabisa.</option>
                                                                                <option value="5">Sikubali</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="mb-2">
                                                                            <label for="saratani_kufa" class="form-label">6.“Kufanya uchunguzi wa saratani ya mapafu kunaweza kupunguza uwezekano wangu wa kufa kutokana na saratani ya mapafu.” </label>
                                                                            <select name="saratani_kufa" id="saratani_kufa" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['saratani_kufa'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['saratani_kufa'] == 1) {
                                                                                                                                        echo 'Nakubali sana.';
                                                                                                                                    } elseif ($kap['saratani_kufa'] == 2) {
                                                                                                                                        echo 'Nakubali';
                                                                                                                                    } elseif ($kap['saratani_kufa'] == 3) {
                                                                                                                                        echo 'Kawaida';
                                                                                                                                    } elseif ($kap['saratani_kufa'] == 4) {
                                                                                                                                        echo 'Sikubali kabisa.';
                                                                                                                                    } elseif ($kap['saratani_kufa'] == 5) {
                                                                                                                                        echo 'Sikubali';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Nakubali sana.</option>
                                                                                <option value="2">Nakubali</option>
                                                                                <option value="3">Kawaida</option>
                                                                                <option value="4">Sikubali kabisa.</option>
                                                                                <option value="5">Sikubali</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <hr>

                                                                    <div class="col-12">
                                                                        <div class="mb-2">
                                                                            <label for="uchunguzi_haraka" class="form-label">7. “Endapo nitapata dalili zozote za awali za ugonjwa wa Saratani ya mapafu nitakwenda kwa ajili ya uchunguzi wa saratani ya mapafu haraka iwezekanavyo”. </label>
                                                                            <select name="uchunguzi_haraka" id="uchunguzi_haraka" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['uchunguzi_haraka'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['uchunguzi_haraka'] == 1) {
                                                                                                                                        echo 'Nakubali sana.';
                                                                                                                                    } elseif ($kap['uchunguzi_haraka'] == 2) {
                                                                                                                                        echo 'Nakubali';
                                                                                                                                    } elseif ($kap['uchunguzi_haraka'] == 3) {
                                                                                                                                        echo 'Kawaida';
                                                                                                                                    } elseif ($kap['uchunguzi_haraka'] == 4) {
                                                                                                                                        echo 'Sikubali kabisa.';
                                                                                                                                    } elseif ($kap['uchunguzi_haraka'] == 5) {
                                                                                                                                        echo 'Sikubali';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Nakubali sana.</option>
                                                                                <option value="2">Nakubali</option>
                                                                                <option value="3">Kawaida</option>
                                                                                <option value="4">Sikubali kabisa.</option>
                                                                                <option value="5">Sikubali</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                </div>

                                                                <hr>

                                                                <h4 class="modal-title" id="standard-modalLabel">Sehemu ya 5; Utaratibu(Practice) juu ya uchunguzi wa saratani ya mapafu.</h4>
                                                                <hr>

                                                                <div class="row">
                                                                    <hr>
                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label for="wapi_matibabu" class="form-label">8. Je katika jamii yako, watu wakiumwa, huwa wanapendelea kwenda wapi kupata matibabu ?</label>
                                                                            <select name="wapi_matibabu" id="wapi_matibabu" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['wapi_matibabu'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['wapi_matibabu'] == 1) {
                                                                                                                                        echo 'Kituo cha afya kilichopo karibu.';
                                                                                                                                    } elseif ($kap['wapi_matibabu'] == 2) {
                                                                                                                                        echo 'Mganga wa jadi.';
                                                                                                                                    } elseif ($kap['wapi_matibabu'] == 3) {
                                                                                                                                        echo 'Kanisani/msikitini.';
                                                                                                                                    } elseif ($kap['wapi_matibabu'] == 4) {
                                                                                                                                        echo 'Duka la Dawa.';
                                                                                                                                    } elseif ($kap['wapi_matibabu'] == 5) {
                                                                                                                                        echo 'Kituo cha tiba asili.';
                                                                                                                                    } elseif ($kap['wapi_matibabu'] == 6) {
                                                                                                                                        echo 'Wanajitibu wenyewe.';
                                                                                                                                    } elseif ($kap['wapi_matibabu'] == 99) {
                                                                                                                                        echo 'Sijui';
                                                                                                                                    } elseif ($kap['wapi_matibabu'] == 96) {
                                                                                                                                        echo 'Nyinginezo, Taja; ________________';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Kituo cha afya kilichopo karibu.</option>
                                                                                <option value="2">Mganga wa jadi.</option>
                                                                                <option value="3">Kanisani/msikitini.</option>
                                                                                <option value="4">Duka la Dawa.</option>
                                                                                <option value="5">Kituo cha tiba asili.</option>
                                                                                <option value="6">Wanajitibu wenyewe.</option>
                                                                                <option value="99">Sijui</option>
                                                                                <option value="96">Nyinginezo, Taja; ________________</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6" id="wapi_matibabu_other">
                                                                        <div class="mb-3">
                                                                            <label for="wapi_matibabu_other" class="form-label">Taja ?</label>
                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                            print_r($kap['wapi_matibabu_other']);
                                                                                                        } ?>" name="wapi_matibabu_other" class="form-control" placeholder="Ingiza vitu hatarishi" />
                                                                        </div>
                                                                    </div>
                                                                    <hr>

                                                                    <div class="col-6">
                                                                        <div class="mb-2">
                                                                            <label for="saratani_ushauri" class="form-label">9. Je! Wewe/watu katika jamii huwa wanakwenda kwenye vituo vya kutolea huduma za Afya kwa ajili ya ushauri kuhusu uchunguzi wa ugonjwa wa Saratani ya Mapafu?</label>
                                                                            <select name="saratani_ushauri" id="saratani_ushauri" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['saratani_ushauri'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['saratani_ushauri'] == 1) {
                                                                                                                                        echo 'Ndio';
                                                                                                                                    } elseif ($kap['saratani_ushauri'] == 2) {
                                                                                                                                        echo 'Hapana';
                                                                                                                                    } elseif ($kap['saratani_ushauri'] == 99) {
                                                                                                                                        echo 'Sijui';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-6">
                                                                        <div class="mb-2">
                                                                            <label for="saratani_ujumbe" class="form-label">10. Katika mwezi uliopita umesikia ujumbe wa afya kuhusu maswala ya uchunguzi wa awali wa Saratani ya mapafu?</label>
                                                                            <select name="saratani_ujumbe" id="saratani_ujumbe" class="form-select form-select-lg mb-3" required>
                                                                                <option value="<?= $kap['saratani_ujumbe'] ?>"><?php if ($kap) {
                                                                                                                                    if ($kap['saratani_ujumbe'] == 1) {
                                                                                                                                        echo 'Ndio';
                                                                                                                                    } elseif ($kap['saratani_ujumbe'] == 2) {
                                                                                                                                        echo 'Hapana';
                                                                                                                                    } elseif ($kap['saratani_ujumbe'] == 99) {
                                                                                                                                        echo 'Sijui';
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo 'Select';
                                                                                                                                } ?>
                                                                                </option>
                                                                                <option value="1">Ndio</option>
                                                                                <option value="2">Hapana</option>
                                                                                <option value="99">Sijui</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                                <!-- <div> -->
                                                                <input type="hidden" name="id" value="<?= $kap['id'] ?>">
                                                                <input type="hidden" name="cid" value="<?= $value['id'] ?>">
                                                                <input type="hidden" name="btn" value="<?= $btnKap ?>">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <input type="submit" name="add_kap" class="btn btn-primary" value="Add">
                                                                <!-- </div> -->

                                                            </div> <!-- end row -->

                                                        </form>
                                                    </div>
                                                    <!-- end row-->
                                                </div> <!-- end card-body -->
                                            </div> <!-- end card -->
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div>
                            </div>
                        </div>


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