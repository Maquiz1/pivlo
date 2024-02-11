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
        if (Input::get('add_client')) {
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
                ),
            ));
            if ($validate->passed()) {
                $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                $age = 20;

                try {
                    $clients = $override->get('clients', 'id', $_GET['cid']);


                    if (!$clients) {

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
                            'comments' => Input::get('comments'),
                            // 'client_category' => $client_category,
                            'kap' => Input::get('kap'),
                            'screening' => Input::get('screening'),
                            'health_care' => Input::get('health_care'),
                            'complete_status' => 0,
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
                            'visit_status' => 1,
                            'status' => 1,
                            'patient_id' => $last_row['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                        ));

                        $successMessage = 'Client  Added Successful';
                    } else {
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
                            // 'client_category' => $client_category,
                            'kap' => Input::get('kap'),
                            'screening' => Input::get('screening'),
                            'health_care' => Input::get('health_care'),
                            'comments' => Input::get('comments'),
                            'complete_status' => 0,
                            'complete_on' => date('Y-m-d H:i:s'),
                            'complete_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['cid']);

                        $successMessage = 'Client Updated Successful';
                    }
                    // $interview = $_GET['interview'];
                    // Redirect::to('info.php?id=2&site_id=' . $user->data()->site_id . '&interview=' . $interview);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_kap')) {
            // print_r($_POST);
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
                        'sequence' => $_GET['sequence'],
                        'visit_name' => $_GET['visit_name'],
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
                        'category' => 0,
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

                Redirect::to('info.php?id=3&cid=' . $_GET['cid'] . '&site_id=' . $user->data()->site_id . '&interview=' . $interview . '&btn=' . $_GET['btn']);
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
    <title>Lung Cancer Database | Add Page</title>

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
        <?php } elseif ($_GET['id'] == 2) { ?>
        <?php } elseif ($_GET['id'] == 3) { ?>
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
                                    <li class="breadcrumb-item"><a href="index1.php">
                                            < Back</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=1">
                                            Go to list > </a>
                                    </li>

                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
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
                            $sex = $override->get('sex', 'id', $clients['sex'])[0];
                            $district = $override->get('district', 'id', $clients['district'])[0];
                            $education = $override->get('education', 'id', $clients['education'])[0];
                            $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                            $yes_no = $override->get('yes_no', 'id', $clients['health_insurance'])[0];
                            $payments = $override->get('payments', 'id', $clients['pay_services'])[0];
                            $household = $override->get('household', 'id', $clients['head_household'])[0];
                            // $kap = $override->get('household', 'id', $clients['kap'])[0];
                            // $screening = $override->get('household', 'id', $clients['screening'])[0];
                            // $health_care = $override->get('household', 'id', $clients['health_care'])[0];

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
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Registration Date:</label>
                                                            <input class="form-control" type="date" name="date_registered" id="date_registered" value="<?php if ($clients['date_registered']) {
                                                                                                                                                            print_r($clients['date_registered']);
                                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Hospital ID ( CTC ID )</label>
                                                            <input class="form-control" type="number" min="0" max="14" name="hospital_id" id="hospital_id" placeholder="Type CTC ID..." value="<?php if ($clients['hospital_id']) {
                                                                                                                                                                                                    print_r($clients['hospital_id']);
                                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Phone Number</label>
                                                            <input class="form-control" type="text" name="patient_phone" id="patient_phone" value="<?php if ($clients['patient_phone']) {
                                                                                                                                                        print_r($clients['patient_phone']);
                                                                                                                                                    }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>SEX</label>
                                                            <select class="form-control" name="sex" style="width: 100%;" required>
                                                                <option value="<?= $clients['sex'] ?>"><?php if ($clients) {
                                                                                                            if ($clients['sex'] == 1) {
                                                                                                                echo 'Male';
                                                                                                            } elseif ($clients['sex'] == 2) {
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

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of birth:</label>
                                                            <input class="form-control" type="date" name="dob" id="dob" style="width: 100%;" value="<?php if ($clients['dob']) {
                                                                                                                                                        print_r($clients['dob']);
                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">treatment supporter or next of kin</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Name:</label>
                                                            <input class="form-control" type="text" name="supporter_name" id="supporter_name" value="<?php if ($clients['supporter_name']) {
                                                                                                                                                            print_r($clients['supporter_name']);
                                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Mobile number</label>
                                                            <input class="form-control" type="text" name="supporter_phone" id="supporter_phone" value="<?php if ($clients['supporter_phone']) {
                                                                                                                                                            print_r($clients['supporter_phone']);
                                                                                                                                                        }  ?>" />
                                                        </div>
                                                        <span>Example: 0700 000 111</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Relation to patient</label>
                                                            <select name="relation_patient" id="relation_patient" class="form-control" required>
                                                                <option value="<?= $clients['relation_patient'] ?>"><?php if ($clients) {
                                                                                                                        if ($clients['relation_patient'] == 1) {
                                                                                                                            echo 'Mzazi';
                                                                                                                        } elseif ($clients['relation_patient'] == 2) {
                                                                                                                            echo 'Kaka / Dada';
                                                                                                                        } elseif ($clients['relation_patient'] == 3) {
                                                                                                                            echo 'Mwenza (Mume / Mke / )';
                                                                                                                        } elseif ($clients['relation_patient'] == 4) {
                                                                                                                            echo 'Ndugu wengine';
                                                                                                                        } elseif ($clients['relation_patient'] == 5) {
                                                                                                                            echo 'Rafiki';
                                                                                                                        } elseif ($clients['relation_patient'] == 96) {
                                                                                                                            echo 'Wengine';
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        echo 'Select';
                                                                                                                    } ?>
                                                                </option>
                                                                <option value="1"> Mzazi</option>
                                                                <option value="2">Kaka / Dada</option>
                                                                <option value="3">Mwenza (Mume / Mke / )</option>
                                                                <option value="4">Ndugu wengine</option>
                                                                <option value="5">Rafiki</option>
                                                                <option value="96">Wengine</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Other relation patient other</label>
                                                            <input class="form-control" type="text" name="relation_patient_other" id="relation_patient_other" value="<?php if ($clients['relation_patient_other']) {
                                                                                                                                                                            print_r($clients['relation_patient_other']);
                                                                                                                                                                        }  ?>" />
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
                                                            <label>District</label>
                                                            <select id="district" name="district" class="form-control" required>
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
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Residence street</label>
                                                            <input class="form-control" type="text" name="street" id="street" value="<?php if ($clients['street']) {
                                                                                                                                            print_r($clients['street']);
                                                                                                                                        }  ?>" />
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
                                                <div class="col-sm-4" id="exposure">
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
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Do you own health insurance?</label>
                                                            <select id="health_insurance" name="health_insurance" class="form-control" required>
                                                                <option value="<?= $yes_no['id'] ?>"><?php if ($clients) {
                                                                                                            print_r($yes_no['name']);
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
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
                                                            <label>Name of insurance:</label>
                                                            <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="<?php if ($clients['insurance_name']) {
                                                                                                                                                            print_r($clients['insurance_name']);
                                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>If no, how do you pay for your health care services</label>
                                                            <select name="pay_services" class="form-control">
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
                                                </div>
                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Type of Interview</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>KAP ?</label>
                                                            <select id="kap" name="kap" class="form-control" required>
                                                                <option value="<?= $clients['kap'] ?>"><?php if ($clients['kap']) {
                                                                                                            if ($clients['kap'] == 1) {
                                                                                                                echo 'Yes';
                                                                                                            } elseif ($clients['kap'] == 2) {
                                                                                                                echo 'No';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
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
                                                            <label>SCREENING ?</label>
                                                            <select id="screening" name="screening" class="form-control" required>
                                                                <option value="<?= $clients['screening'] ?>"><?php if ($clients['screening']) {
                                                                                                            if ($clients['screening'] == 1) {
                                                                                                                echo 'Yes';
                                                                                                            } elseif ($clients['screening'] == 2) {
                                                                                                                echo 'No';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
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
                                                            <label>HEALTH CARE WORKER ?</label>
                                                            <select id="health_care" name="health_care" class="form-control" required>
                                                                <option value="<?= $clients['health_care'] ?>"><?php if ($clients['health_care']) {
                                                                                                            if ($clients['health_care'] == 1) {
                                                                                                                echo 'Yes';
                                                                                                            } elseif ($clients['kap'] == 2) {
                                                                                                                echo 'No';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="hidden" name="id" value="<?= $clients['id']; ?>" />
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

        <?php } elseif ($_GET['id'] == 6) { ?>

        <?php } elseif ($_GET['id'] == 7) { ?>

        <?php } elseif ($_GET['id'] == 8) { ?>

        <?php } elseif ($_GET['id'] == 9) { ?>

        <?php } elseif ($_GET['id'] == 10) { ?>

        <?php } elseif ($_GET['id'] == 11) { ?>

        <?php } elseif ($_GET['id'] == 12) { ?>

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

    <!-- Vital Signs Js -->
    <script src="myjs/add/clients.js"></script>

    <!-- demographic Js -->
    <script src="myjs/add/demographic/demographic.js"></script>


    <!-- Vital Signs Js -->
    <script src="myjs/add/vital.js"></script>

    <!-- Medications Js -->
    <script src="myjs/add/medications/basal_changed.js"></script>
    <script src="myjs/add/medications/prandial_changed.js"></script>
    <script src="myjs/add/medications/fluid_restriction.js"></script>
    <script src="myjs/add/medications/support.js"></script>
    <script src="myjs/add/medications/cardiology.js"></script>
    <script src="myjs/add/medications/referrals.js"></script>
    <script src="myjs/add/medications/social_support.js"></script>
    <script src="myjs/add/medications/transfusion.js"></script>
    <script src="myjs/add/medications/vaccination.js"></script>
    <script src="myjs/add/medications/completed.js"></script>
    <!-- <script src="myjs/add/medications/medication.js"></script> -->
    <!-- <script src="myjs/add/medications/medication2.js"></script> -->



    <!-- History Js -->

    <script src="myjs/add/history/cardiovascular.js"></script>
    <script src="myjs/add/history/retinopathy.js"></script>
    <script src="myjs/add/history/alcohol.js"></script>
    <script src="myjs/add/history/alcohol_type.js"></script>
    <script src="myjs/add/history/art.js"></script>
    <script src="myjs/add/history/blood_transfusion.js"></script>
    <script src="myjs/add/history/hepatitis.js"></script>
    <script src="myjs/add/history/history_other.js"></script>
    <script src="myjs/add/history/hiv.js"></script>
    <script src="myjs/add/history/neuropathy.js"></script>
    <script src="myjs/add/history/other_complication.js"></script>
    <script src="myjs/add/history/pvd.js"></script>
    <script src="myjs/add/history/renal.js"></script>
    <script src="myjs/add/history/sexual_dysfunction.js"></script>
    <script src="myjs/add/history/smoking.js"></script>
    <script src="myjs/add/history/stroke_tia.js"></script>
    <script src="myjs/add/history/surgery.js"></script>
    <script src="myjs/add/history/surgery_type.js"></script>
    <script src="myjs/add/history/tb.js"></script>


    <!-- Symptoms Js -->


    <script src="myjs/add/symptoms/abnorminal_pain.js"></script>
    <script src="myjs/add/symptoms/chest_pain.js"></script>
    <script src="myjs/add/symptoms/foot_exam.js"></script>
    <script src="myjs/add/symptoms/foot_exam_finding.js"></script>
    <script src="myjs/add/symptoms/headache.js"></script>
    <script src="myjs/add/symptoms/hypoglycemia_severe.js"></script>
    <script src="myjs/add/symptoms/joints.js"></script>
    <script src="myjs/add/symptoms/lower_arms.js"></script>
    <script src="myjs/add/symptoms/lungs.js"></script>
    <script src="myjs/add/symptoms/other_pain.js"></script>
    <script src="myjs/add/symptoms/other_symptoms.js"></script>
    <script src="myjs/add/symptoms/upper_arms.js"></script>
    <script src="myjs/add/symptoms/waist.js"></script>

    <!-- Results Js -->

    <script src="myjs/add/results/confirmatory_test.js"></script>
    <script src="myjs/add/results/ecg.js"></script>
    <script src="myjs/add/results/ecg_performed.js"></script>
    <script src="myjs/add/results/echo_other.js"></script>
    <script src="myjs/add/results/echo_performed.js"></script>
    <script src="myjs/add/results/scd_done.js"></script>
    <script src="myjs/add/results/scd_test.js"></script>


    <!-- hospitalizations Js -->

    <script src="myjs/add/hospitalizations/hospitalizations.js"></script>
    <script src="myjs/add/hospitalizations/hydroxyurea.js"></script>
    <script src="myjs/add/hospitalizations/injection_sites.js"></script>
    <script src="myjs/add/hospitalizations/opioid.js"></script>
    <script src="myjs/add/hospitalizations/ncd_hospitalizations.js"></script>
    <script src="myjs/add/hospitalizations"></script>


    <!-- hospitalization_details Js -->

    <script src="myjs/add/hospitalization_details/hospitalization_ncd.js"></script>

    <!-- Diagnosis, Complications & Comorbidities Js -->

    <script src="myjs/add/diagnosis_complications_comorbidities/diagns_changed.js"></script>
    <script src="myjs/add/diagnosis_complications_comorbidities/diagns_specify.js"></script>
    <script src="myjs/add/diagnosis_complications_comorbidities/new_complications.js"></script>
    <script src="myjs/add/diagnosis_complications_comorbidities/new_ncd_diagnosis.js"></script>
    <script src="myjs/add/diagnosis_complications_comorbidities/other_complications.js"></script>
    <script src="myjs/add/diagnosis_complications_comorbidities"></script>


    <!-- RISKS Js -->

    <script src="myjs/add/risks/risk_art.js"></script>
    <script src="myjs/add/risks/risk_hiv.js"></script>
    <script src="myjs/add/risks/risk_tb.js"></script>
    <script src="myjs/add/risks"></script>


    <!-- LAB DETAILS Js -->

    <script src="myjs/add/lab_details/cardiac_surgery.js"></script>
    <script src="myjs/add/lab_details/chemistry_test.js"></script>
    <script src="myjs/add/lab_details/chemistry_test2.js"></script>
    <script src="myjs/add/lab_details/hematology_test.js"></script>
    <script src="myjs/add/lab_details/hematology_test.js"></script>
    <script src="myjs/add/lab_details/lab_Other.js"></script>
    <script src="myjs/add/lab_details/other_lab_diabetes.js"></script>

    <!-- CARDIACS Js -->

    <script src="myjs/add/cardiac/arrhythmia.js"></script>
    <script src="myjs/add/cardiac/cardiomyopathy.js"></script>
    <script src="myjs/add/cardiac/congenital.js"></script>
    <script src="myjs/add/cardiac/diagnosis_other.js"></script>
    <script src="myjs/add/cardiac/heart_failure.js"></script>
    <script src="myjs/add/cardiac/heumatic.js"></script>
    <script src="myjs/add/cardiac/pericardial.js"></script>
    <script src="myjs/add/cardiac/stroke.js"></script>
    <script src="myjs/add/cardiac/sub_arrhythmia.js"></script>
    <script src="myjs/add/cardiac/sub_cardiomyopathy.js"></script>
    <script src="myjs/add/cardiac/sub_congenital.js"></script>
    <script src="myjs/add/cardiac/sub_heumatic.js"></script>
    <script src="myjs/add/cardiac/sub_pericardial.js"></script>
    <script src="myjs/add/cardiac/sub_thromboembolic.js"></script>
    <script src="myjs/add/cardiac/thromboembolic.js"></script>

    <!-- DIABETIC Js -->

    <script src="myjs/add/diabetic/diagnosis_other.js"></script>
    <script src="myjs/add/diabetic/hypertension.js"></script>

    <!-- SICKLE CELL Js -->

    <script src="myjs/add/sickle_cell/diagnosis.js"></script>

    <!-- SUMMARY Js -->

    <script src="myjs/add/summary/cause_death.js"></script>
    <script src="myjs/add/summary/diagnosis_summary.js"></script>
    <script src="myjs/add/summary/outcome.js"></script>
    <script src="myjs/add/summary/transfer_out.js"></script>



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



        function add_Medication() {
            var table = document.getElementById("medication_list");
            var row = table.insertRow();
            var medication_type = row.insertCell(0);
            var medication_action = row.insertCell(1);
            var medication_dose = row.insertCell(2);
            var medication_units = row.insertCell(3);


            // Assuming the data is passed from PHP
            medication_type.innerHTML = '<select class="form-control select2" name="medication_type[]" id="medication_type[]" style="width: 100%;"><option value="">Select</option><?php foreach ($override->get('medications', 'status', 1) as $medication) { ?><option value="<?= $medication['id']; ?>"><?= $medication['name']; ?></option> <?php } ?></select>';
            medication_action.innerHTML = '<select class="form-control" name="medication_action[]" id="medication_action[]" style="width: 100%;"><option value="">Select</option><option value="1">Continue</option><option value="2">Start</option><option value="3">Stop</option><option value="4">Not Eligible</option></select>';
            medication_dose.innerHTML = '<input class="form-control" type="text" name="medication_dose[]">';
            medication_units.innerHTML = '<input class="form-control"  type="text" name="medication_units[]">';

        }

        // Remove row
        document.addEventListener("click", function(e) {
            if (e.target && e.target.classList.contains("remove-row")) {
                var row = e.target.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }
        });
    </script>

</body>

</html>