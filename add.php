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
                // $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                try {

                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                    $age = $user->dateDiffYears(Input::get('date_registered'), Input::get('dob'));

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
                            'patient_phone' => Input::get('patient_phone'),
                            'supporter_name' => Input::get('supporter_name'),
                            'supporter_phone' => Input::get('supporter_phone'),
                            'relation_patient' => Input::get('relation_patient'),
                            'relation_patient_other' => Input::get('relation_patient_other'),
                            'district' => Input::get('district'),
                            'street' => Input::get('street'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => Input::get('head_household'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'pay_services' => Input::get('pay_services'),
                            'insurance_name_other' => Input::get('insurance_name_other'),
                            'interview_type' => Input::get('interview_type'),
                            'comments' => Input::get('comments'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['cid']);

                        $successMessage = 'Client Updated Successful';
                    } else {

                        $std_id = $override->getNews('study_id', 'site_id', $user->data()->site_id, 'status', 0)[0];

                        $user->createRecord('clients', array(
                            'date_registered' => Input::get('date_registered'),
                            'study_id' => $std_id['study_id'],
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
                            'relation_patient_other' => Input::get('relation_patient_other'),
                            'district' => Input::get('district'),
                            'street' => Input::get('street'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => Input::get('head_household'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'insurance_name_other' => Input::get('insurance_name_other'),
                            'pay_services' => Input::get('pay_services'),
                            'comments' => Input::get('comments'),
                            'interview_type' => Input::get('interview_type'),
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

                        $user->updateRecord('study_id', array(
                            'status' => 1,
                            'client_id' => $last_row['id'],
                        ), $std_id['id']);

                        $user->createRecord('visit', array(
                            'sequence' => 0,
                            'study_id' => $std_id['study_id'],
                            'visit_code' => 'RS',
                            'visit_name' => 'Registration & Screening',
                            'expected_date' => Input::get('date_registered'),
                            'visit_date' => '',
                            'visit_status' => 0,
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'patient_id' => $last_row['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                        ));

                        $successMessage = 'Client  Added Successful';
                    }
                    Redirect::to('info.php?id=3&status=7');
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
                $history = $override->getNews('kap', 'status', 1, 'patient_id', $_GET['cid']);
                if (!$kap) {
                    $user->createRecord('kap', array(
                        'study_id' => $_GET['study_id'],
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
                        'comments' => Input::get('comments'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));

                    $successMessage = 'Kap  Successful Added';
                } else {
                    $user->updateRecord('kap', array(
                        'interview_date' => Input::get('interview_date'),
                        'study_id' => $_GET['study_id'],
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
                        'comments' => Input::get('comments'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $kap[0]['id']);
                    $successMessage = 'Kap  Successful Updated';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
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
                'type_smoked' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $history = $override->getNews('history', 'status', 1, 'patient_id', $_GET['cid']);
                $date1 = Input::get('start_smoking');
                $packs = Input::get('packs_per_day');
                $eligible = 0;

                if (Input::get('ever_smoked') == 1) {
                    if (Input::get('currently_smoking') == 1) {
                        $date2 = date('Y', strtotime(Input::get('screening_date')));
                        if (Input::get('type_smoked') == 1) {
                            $years = $date2 - $date1;
                            $packs_year = $packs * $years;
                            if ($packs_year >= 20) {
                                $eligible = 1;
                            }
                        } elseif (Input::get('type_smoked') == 2) {
                            $years = $date2 - $date1;
                            $packs_year = ($packs / 20) * $years;
                            if ($packs_year >= 20) {
                                $eligible = 1;
                            }
                        }
                    } elseif (Input::get('currently_smoking') == 2) {
                        $date2 = Input::get('quit_smoking');
                        if (Input::get('type_smoked') == 1) {
                            $years = $date2 - $date1;
                            $packs_year = $packs * $years;
                            if ($packs_year >= 20) {
                                $eligible = 1;
                            }
                        } elseif (Input::get('type_smoked') == 2) {
                            $years = $date2 - $date1;
                            $packs_year = ($packs / 20) * $years;
                            if ($packs_year >= 20) {
                                $eligible = 1;
                            }
                        }
                    }
                }

                if (!$history) {
                    $user->createRecord('history', array(
                        'screening_date' => Input::get('screening_date'),
                        'study_id' => $_GET['study_id'],
                        'ever_smoked' => Input::get('ever_smoked'),
                        'start_smoking' => Input::get('start_smoking'),
                        'smoking_long' => Input::get('smoking_long'),
                        'type_smoked' => Input::get('type_smoked'),
                        'currently_smoking' => Input::get('currently_smoking'),
                        'quit_smoking' => Input::get('quit_smoking'),
                        'packs_per_day' => Input::get('packs_per_day'),
                        'packs_per_year' => $packs_year,
                        'eligible' => $eligible,
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));

                    if ($eligible) {
                        $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $user->data()->site_id, 1);
                    } else {
                        $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $user->data()->site_id, 0);
                    }

                    $user->updateRecord('clients', array(
                        'screened' => 1,
                        'eligible' => $eligible,
                    ), $_GET['cid']);

                    $successMessage = 'History  Successful Added';

                    Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                } else {
                    $user->updateRecord('history', array(
                        'screening_date' => Input::get('screening_date'),
                        'study_id' => $_GET['study_id'],
                        'ever_smoked' => Input::get('ever_smoked'),
                        'start_smoking' => Input::get('start_smoking'),
                        'smoking_long' => Input::get('smoking_long'),
                        'type_smoked' => Input::get('type_smoked'),
                        'currently_smoking' => Input::get('currently_smoking'),
                        'quit_smoking' => Input::get('quit_smoking'),
                        'packs_per_day' => Input::get('packs_per_day'),
                        'packs_per_year' => $packs_year,
                        'eligible' => $eligible,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $history[0]['id']);

                    if ($eligible) {
                        $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $user->data()->site_id, 1);
                    } else {
                        $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $user->data()->site_id, 0);
                    }
                }

                $user->updateRecord('clients', array(
                    'screened' => 1,
                    'eligible' => $eligible,
                ), $_GET['cid']);

                $successMessage = 'History  Successful Updated';

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
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
                $results = $override->get3('results', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($results) {
                    $user->updateRecord('results', array(
                        'results_date' => Input::get('results_date'),
                        'ldct_results' => Input::get('ldct_results'),
                        'rad_score' => Input::get('rad_score'),
                        'findings' => Input::get('findings'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $results[0]['id']);
                    $successMessage = 'Results  Successful Updated';
                } else {
                    $user->createRecord('results', array(
                        'results_date' => Input::get('results_date'),
                        'visit_code' => $_GET['visit_code'],
                        'study_id' => $_GET['study_id'],
                        'sequence' => $_GET['sequence'],
                        'ldct_results' => Input::get('ldct_results'),
                        'rad_score' => Input::get('rad_score'),
                        'findings' => Input::get('findings'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));

                    $user->updateRecord('clients', array(
                        'enrolled' => 1,
                    ), $_GET['cid']);

                    $successMessage = 'Results  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_classification')) {
            $validate = $validate->check($_POST, array(
                'classification_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                print_r($_POST);
                if (count(Input::get('category')) == 1) {
                    foreach (Input::get('category') as $value) {
                        $visit_code = '';
                        $visit_name = '';

                        if ($value == 1) {
                            $visit_code = 'M12';
                            $visit_name = 'Month 12';
                            $expected_date = date('Y-m-d', strtotime('+12 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 2) {
                            $visit_code = 'M12';
                            $visit_name = 'Month 12';
                            $expected_date = date('Y-m-d', strtotime('+12 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 3) {
                            $visit_code = 'M06';
                            $visit_name = 'Month 6';
                            $expected_date = date('Y-m-d', strtotime('+6 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 4) {
                            $visit_code = 'M03';
                            $visit_name = 'Month 3';
                            $expected_date = date('Y-m-d', strtotime('+3 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 5) {
                            $visit_code = 'RFT';
                            $visit_name = 'Referred';
                            $expected_date = date('Y-m-d', strtotime('+2 month', strtotime(Input::get('classification_date'))));
                        }
                    }


                    $classification = $override->get3('classification', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                    if ($classification) {
                        $user->updateRecord('classification', array(
                            'classification_date' => Input::get('classification_date'),
                            'category' => $value,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $classification[0]['id']);
                        $successMessage = 'Classification  Successful Updated';
                    } else {
                        $user->createRecord('classification', array(
                            'classification_date' => Input::get('classification_date'),
                            'visit_code' => $_GET['visit_code'],
                            'study_id' => $_GET['study_id'],
                            'sequence' => $_GET['sequence'],
                            'category' => $value,
                            'status' => 1,
                            'patient_id' => $_GET['cid'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                        ));


                        $successMessage = 'Classification  Successful Added';
                    }

                    if ($_GET['sequence'] == 1) {
                        $visit_id = $override->getNews('visit', 'patient_id', $_GET['cid'], 'sequence', 2);
                        if ($visit_id) {
                            $user->updateRecord('visit', array(
                                'expected_date' => $expected_date,
                                'visit_code' => $visit_code,
                                'visit_name' => $visit_name,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                            ), $visit_id[0]['id']);
                        } else {
                            $user->createRecord('visit', array(
                                'expected_date' => $expected_date,
                                'visit_date' => '',
                                'visit_code' => $visit_code,
                                'visit_name' => $visit_name,
                                'study_id' => $_GET['study_id'],
                                'sequence' => 2,
                                'visit_status' => 0,
                                'status' => 1,
                                'patient_id' => $_GET['cid'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $user->data()->site_id,
                            ));
                        }
                    }

                    Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
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
                $economic = $override->get3('economic', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($economic) {
                    $user->updateRecord('economic', array(
                        'economic_date' => Input::get('economic_date'),
                        'income_household' => Input::get('income_household'),
                        'income_patient' => Input::get('income_patient'),
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
                    ), $economic[0]['id']);
                    $successMessage = 'Economic  Successful Updated';
                } else {
                    $user->createRecord('economic', array(
                        'economic_date' => Input::get('economic_date'),
                        'visit_code' => $_GET['visit_code'],
                        'study_id' => $_GET['study_id'],
                        'sequence' => $_GET['sequence'],
                        'income_household' => Input::get('income_household'),
                        'income_patient' => Input::get('income_patient'),
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
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));
                    $successMessage = 'Economic  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_outcome')) {
            $validate = $validate->check($_POST, array(
                'outcome_date' => array(
                    'required' => true,
                ),
                'diagnosis' => array(
                    'required' => true,
                ),
                'outcome' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {

                $outcome = $override->get3('outcome', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($outcome) {
                    $user->updateRecord('outcome', array(
                        'outcome_date' => Input::get('outcome_date'),
                        'diagnosis' => Input::get('diagnosis'),
                        'outcome' => Input::get('outcome'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $outcome[0]['id']);

                    $successMessage = 'Outcome  Successful Updated';
                } else {
                    $user->createRecord('outcome', array(
                        'outcome_date' => Input::get('outcome_date'),
                        'visit_code' => $_GET['visit_code'],
                        'study_id' => $_GET['study_id'],
                        'sequence' => $_GET['sequence'],
                        'diagnosis' => Input::get('diagnosis'),
                        'outcome' => Input::get('outcome'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));
                    $successMessage = 'Outcome  Successful Added';
                }
                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_health_care_kap')) {
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
                $history = $override->getNews('kap', 'status', 1, 'patient_id', $_GET['cid']);
                if (!$kap) {
                    $user->createRecord('kap', array(
                        'study_id' => $_GET['study_id'],
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
                        'comments' => Input::get('comments'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $user->data()->site_id,
                    ));

                    $successMessage = 'Kap  Successful Added';
                } else {
                    $user->updateRecord('kap', array(
                        'interview_date' => Input::get('interview_date'),
                        'study_id' => $_GET['study_id'],
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
                        'comments' => Input::get('comments'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $kap[0]['id']);
                    $successMessage = 'Kap  Successful Updated';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
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
                            $district = $override->get('district', 'id', $clients['district'])[0];
                            $education = $override->get('education', 'id', $clients['education'])[0];
                            $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                            $insurance = $override->get('insurance', 'id', $clients['health_insurance'])[0];
                            $payments = $override->get('payments', 'id', $clients['pay_services'])[0];
                            $household = $override->get('household', 'id', $clients['head_household'])[0];
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
                                                            <input class="form-control" type="date" max="<?= date('Y-m-d'); ?>" name="date_registered" id="date_registered" value="<?php if ($clients['date_registered']) {
                                                                                                                                                                                        print_r($clients['date_registered']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Hospital ID ( CTC ID )</label>
                                                            <input class="form-control" type="text" minlength="14" maxlength="14" size="14" pattern=[0]{1}[0-9]{13} name="hospital_id" id="hospital_id" placeholder="Type CTC ID..." value="<?php if ($clients['hospital_id']) {
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
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="patient_phone" id="patient_phone" value="<?php if ($clients['patient_phone']) {
                                                                                                                                                                                                            print_r($clients['patient_phone']);
                                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>SEX</label>
                                                            <select class="form-control" name="sex" style="width: 100%;" required>
                                                                <option value="<?= $clients['sex'] ?>"><?php if ($clients['sex']) {
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
                                                            <input class="form-control" max="<?= date('Y-m-d'); ?>" type="date" name="dob" id="dob" style="width: 100%;" value="<?php if ($clients['dob']) {
                                                                                                                                                                                    print_r($clients['dob']);
                                                                                                                                                                                }  ?>" required />
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
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Mobile number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="supporter_phone" id="supporter_phone" value="<?php if ($clients['supporter_phone']) {
                                                                                                                                                                                                                print_r($clients['supporter_phone']);
                                                                                                                                                                                                            }  ?>" required />
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
                                                                <option value="<?= $relation['id'] ?>"><?php if ($relation['name']) {
                                                                                                            print_r($relation['name']);
                                                                                                        } else {
                                                                                                            echo 'Select pay';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('relation', 'status', 1) as $relation) { ?>
                                                                    <option value="<?= $relation['id'] ?>"><?= $relation['name'] ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="relation_patient_other">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Other relation patient other</label>
                                                            <input class="form-control" type="text" name="relation_patient_other" value="<?php if ($clients['relation_patient_other']) {
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
                                                                                                                                        }  ?>" required />
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
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Do you own health insurance?</label>
                                                            <select id="health_insurance" name="health_insurance" class="form-control" required>
                                                                <option value="<?= $clients['health_insurance'] ?>"><?php if ($clients['health_insurance']) {
                                                                                                                        if ($clients['health_insurance'] == 1) {
                                                                                                                            echo 'Yes';
                                                                                                                        } elseif ($clients['health_insurance'] == 2) {
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
                                                <div class="col-sm-4" id="pay_services">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>If no, how do you pay for your health care services</label>
                                                            <select name="pay_services" class="form-control">
                                                                <option value="<?= $payments['id'] ?>"><?php if ($clients['pay_services']) {
                                                                                                            print_r($payments['name']);
                                                                                                        } else {
                                                                                                            echo 'Select pay';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('payments', 'status', 1) as $payment) { ?>
                                                                    <option value="<?= $payment['id'] ?>"><?= $payment['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="insurance_name1">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Name of insurance:</label>
                                                            <select id="insurance_name" name="insurance_name" class="form-control">
                                                                <option value="<?= $insurance['id'] ?>"><?php if ($clients['insurance_name']) {
                                                                                                            print_r($insurance['name']);
                                                                                                        } else {
                                                                                                            echo 'Select pay';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('insurance', 'status', 1) as $insurance) { ?>
                                                                    <option value="<?= $insurance['id'] ?>"><?= $insurance['name'] ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="insurance_name_other">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Other Name of insurance:</label>
                                                            <input class="form-control" type="text" name="insurance_name_other" value="<?php if ($clients['insurance_name_other']) {
                                                                                                                                            print_r($clients['insurance_name_other']);
                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Type of Interview</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ANY OTHER COMENT OR REMARKS</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Type</label>
                                                            <select id="interview_type" name="interview_type" class="form-control" required>
                                                                <option value="<?= $clients['interview_type'] ?>"><?php if ($clients['interview_type']) {
                                                                                                                        if ($clients['interview_type'] == 1) {
                                                                                                                            echo 'Kap & Screening';
                                                                                                                        } elseif ($clients['interview_type'] == 2) {
                                                                                                                            echo 'Health Care Worker';
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        echo 'Select';
                                                                                                                    } ?>
                                                                </option>
                                                                <option value="1">Kap & Screening </option>
                                                                <option value="2">Health Care Worker </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
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
            $kap = $override->getNews('kap', 'status', 1, 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$kap) { ?>
                                    <h1>Add New KAP</h1>
                                <?php } else { ?>
                                    <h1>Update KAP</h1>
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
                                    <?php if (!$kap) { ?>
                                        <li class="breadcrumb-item active">Add New KAP</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update KAP</li>
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
                                        <h3 class="card-title">Sehemu ya 2: Uelewa juu ya Saratani ya mapafu. (Usimsomee machaguo)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="interview_date" class="form-label">Interview Date</label>
                                                        <input type="date" value="<?php if ($kap['interview_date']) {
                                                                                        print_r($kap['interview_date']);
                                                                                    } ?>" id="interview_date" name="interview_date" class="form-control" placeholder="Enter interview date" required />
                                                    </div>
                                                </div>

                                                <div class="col-9">
                                                    <div class="mb-2">
                                                        <label for="saratani_mapafu" class="form-label">1. Je, unaweza kuniambia nini maana ya ugonjwa wa Saratani ya mapafu? </label>
                                                        <select name="saratani_mapafu" id="saratani_mapafu" class="form-control" required>
                                                            <option value="<?= $kap['saratani_mapafu'] ?>"><?php if ($kap['saratani_mapafu']) {
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
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="uhusiano_saratani" class="form-label">2. Je, kuna uhusiano kati ya saratani ya mapafu na maambukizi ya Virusi vya UKIMWI? </label>
                                                        <select name="uhusiano_saratani" id="uhusiano_saratani" class="form-control" required>
                                                            <option value="<?= $kap['uhusiano_saratani'] ?>"><?php if ($kap['uhusiano_saratani']) {
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

                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="kusambazwa_saratani" class="form-label">3. Je, saratani ya mapafu inaweza kusambazwa kutoka kwa mtu mmoja kwenda kwa mtu mwingine? </label>
                                                        <select name="kusambazwa_saratani" id="kusambazwa_saratani" class="form-control" required>
                                                            <option value="<?= $kap['kusambazwa_saratani'] ?>"><?php if ($kap['kusambazwa_saratani']) {
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
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <!-- <label class="custom-control-label">4. Je, vitu gani hatarishi vinaweza kusababisha mtu kupata saratani ya mapafu? (Multiple answer)</label> -->

                                                    <!-- checkbox -->
                                                    <!-- <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="1" <?php if ($kap) {
                                                                                                                                                                            if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Uvutaji sigara.</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="2" <?php if ($kap) {
                                                                                                                                                                            if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Kufanya kazi kwenye migodi.</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="3" <?php if ($kap) {
                                                                                                                                                                            if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Kufanya kazi viwandani. (kiwanda cha bidhaa ya kemikali).</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="4" <?php if ($kap) {
                                                                                                                                                                            if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Kufanya kazi katika maeneo yenye hewa chafu sana.(highly air pollutes areas).</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="5" <?php if ($kap) {
                                                                                                                                                                            if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Mtu akiwa na saratani nyingine yeyote mwilini .</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="6" <?php if ($kap) {
                                                                                                                                                                            if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Kuwa na mtu kwenye familia mwenye historia ya saratani ya mapafu.</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="7" <?php if ($kap) {
                                                                                                                                                                            if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Kuwa na historia ya kupigwa mionzi ya kifua.</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="8" <?php if ($kap) {
                                                                                                                                                                            if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Kutumia uzazi wa mpango (vidonge vya majira).</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="96" <?php if ($kap) {
                                                                                                                                                                                if ($kap['vitu_hatarishi'] == 1) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?>>
                                                            <label for="vitu_hatarishi[]" class="custom-control-label">Other</label>
                                                        </div>
                                                    </div> -->
                                                    <div class="mb-3">
                                                        <label for="vitu_hatarishi" class="form-label">4. Je, vitu gani hatarishi vinaweza kusababisha mtu kupata saratani ya mapafu? (Multiple answer)</label>
                                                        <select name="vitu_hatarishi" id="vitu_hatarishi" class="form-control" required>
                                                            <option value="<?= $kap['vitu_hatarishi'] ?>"><?php if ($kap['vitu_hatarishi']) {
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
                                                                                                                    echo 'Nyinginezo';
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
                                                            <option value="96">Nyinginezo</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-6" id="vitu_hatarishi_other">
                                                    <div class="mb-3">
                                                        <label for="vitu_hatarishi_other" class="form-label">4. Taja ?</label>
                                                        <textarea class="form-control" name="vitu_hatarishi_other" rows="2" placeholder="Type other here..."><?php if ($kap['vitu_hatarishi_other']) {
                                                                                                                                                                    print_r($kap['vitu_hatarishi_other']);
                                                                                                                                                                }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="dalili_saratani" class="form-label">5. Je, mtu mwenye Saratani ya mapafu anakua na dalili zipi? (Multiple answer) </label>
                                                        <select name="dalili_saratani" id="dalili_saratani" class="form-control" required>
                                                            <option value="<?= $kap['dalili_saratani'] ?>"><?php if ($kap['dalili_saratani']) {
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
                                                                                                                    echo 'Nyingine';
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
                                                            <option value="96">Nyingine</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6" id="dalili_saratani_other">
                                                    <div class="mb-3">
                                                        <label for="dalili_saratani_other" class="form-label">5. Taja ?</label>
                                                        <textarea class="form-control" name="dalili_saratani_other" rows="2" placeholder="Type other here..."><?php if ($kap['dalili_saratani_other']) {
                                                                                                                                                                    print_r($kap['dalili_saratani_other']);
                                                                                                                                                                }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="saratani_vipimo" class="form-label">6. Kama mtu akigundulika ana saratani ya mapafu ,ni vipimo gani vinatakiwa kufanyika? (Multiple answer)</label>
                                                        <select name="saratani_vipimo" id="saratani_vipimo" class="form-control" required>
                                                            <option value="<?= $kap['saratani_vipimo'] ?>"><?php if ($kap['saratani_vipimo']) {
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
                                                                                                                    echo 'Zinginezo';
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
                                                            <option value="96">Zinginezo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="saratani_vipimo_other">
                                                    <div class="mb-3">
                                                        <label for="saratani_vipimo_other" class="form-label">6. Taja ?</label>
                                                        <textarea class="form-control" name="saratani_vipimo_other" rows="3" placeholder="Type other here..."><?php if ($kap['saratani_vipimo_other']) {
                                                                                                                                                                    print_r($kap['saratani_vipimo_other']);
                                                                                                                                                                }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="saratani_inatibika" class="form-label">7. Je, ugonjwa wa saratani ya mapafu unatibika?</label>
                                                        <select name="saratani_inatibika" id="saratani_inatibika2" class="form-control" required>
                                                            <option value="<?= $kap['saratani_inatibika'] ?>"><?php if ($kap['saratani_inatibika']) {
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

                                                <div class="col-8" id="matibabu_saratani2">
                                                    <div class="mb-3">
                                                        <label for="matibabu_saratani" class="form-label">8. Kama jibu ni ndio, Je unajua njia yoyote ya matibabu ya saratani ya mapafu?</label>
                                                        <select name="matibabu_saratani" id="matibabu_saratani1" class="form-control">
                                                            <option value="<?= $kap['matibabu_saratani'] ?>"><?php if ($kap['matibabu_saratani']) {
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
                                                        <select name="matibabu" id="matibabu2" class="form-control">
                                                            <option value="<?= $kap['matibabu'] ?>"><?php if ($kap['matibabu']) {
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
                                                                                                            echo 'Zinginezo';
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
                                                            <option value="96">Zinginezo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6" id="matibabu_other">
                                                    <div class="mb-3">
                                                        <label for="matibabu_other" class="form-label">9. Taja ?</label>
                                                        <textarea class="form-control" name="matibabu_other" rows="3" placeholder="Type other here..."><?php if ($kap['matibabu_other']) {
                                                                                                                                                            print_r($kap['matibabu_other']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Sehemu ya 3; Uchunguzi(Screening) wa saratani ya mapafu. (Usimusmoee machaguo)</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="saratani_uchunguzi" class="form-label">1. Je, umewahi kusikia chochote kuhusu uchunguzi wa saratani ya mapafu, inawezekana kwa kusoma mahali Fulani, kusikia kwenye vyombo vya habari au kusikia kutoka kituo cha kutolea huduma za Afya? </label>
                                                        <select name="saratani_uchunguzi" id="saratani_uchunguzi" class="form-control" required>
                                                            <option value="<?= $kap['saratani_uchunguzi'] ?>"><?php if ($kap['saratani_uchunguzi']) {
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

                                            </div>

                                            <hr>

                                            <div class="row">


                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="uchunguzi_maana" class="form-label">2. Nini maana ya uchunguzi wa saratani ya mapafu?</label>
                                                        <select name="uchunguzi_maana" id="uchunguzi_maana" class="form-control" required>
                                                            <option value="<?= $kap['uchunguzi_maana'] ?>"><?php if ($kap['uchunguzi_maana']) {
                                                                                                                if ($kap['uchunguzi_maana'] == 1) {
                                                                                                                    echo 'Uchunguzi wa saratani ya mapafu ni mchakato ambao hutumiwa kugundua uwepo wa saratani ya mapafu kwa watu wenye afya nzuri na wenye hatari kubwa ya kupata saratani ya mapafu.';
                                                                                                                } elseif ($kap['uchunguzi_maana'] == 2) {
                                                                                                                    echo 'Uchunguzi wa saratani ya mapafu ni mkakati wa uchunguzi wa saratani ya mapafu inayotumiwa kutambua saratani ya mapafu mapema kabla ya kuonyesha dalili ambapo ni hatua ya mwanzoni kabisa ambayo kuna uwezekano mkubwa wa kutibika.';
                                                                                                                } elseif ($kap['uchunguzi_maana'] == 3) {
                                                                                                                    echo 'Uchunguzi wa saratani ya mapafu ni kipimo cha kugundua saratani ya mapafu mapema kabla ya dalili kutokea.';
                                                                                                                } elseif ($kap['uchunguzi_maana'] == 99) {
                                                                                                                    echo 'Sijui';
                                                                                                                } elseif ($kap['uchunguzi_maana'] == 96) {
                                                                                                                    echo 'Nyinginezo';
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                            </option>
                                                            <option value="1">Uchunguzi wa saratani ya mapafu ni mchakato ambao hutumiwa kugundua uwepo wa saratani ya mapafu kwa watu wenye afya nzuri na wenye hatari kubwa ya kupata saratani ya mapafu.</option>
                                                            <option value="2">Uchunguzi wa saratani ya mapafu ni mkakati wa uchunguzi wa saratani ya mapafu inayotumiwa kutambua saratani ya mapafu mapema kabla ya kuonyesha dalili ambapo ni hatua ya mwanzoni kabisa ambayo kuna uwezekano mkubwa wa kutibika.</option>
                                                            <option value="3">Uchunguzi wa saratani ya mapafu ni kipimo cha kugundua saratani ya mapafu mapema kabla ya dalili kutokea.</option>
                                                            <option value="99">Sijui</option>
                                                            <option value="96">Nyinginezo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="uchunguzi_maana_other">
                                                    <div class=" mb-3">
                                                        <label for="uchunguzi_maana_other" class="form-label">2. Taja ?</label>
                                                        <textarea class="form-control" name="uchunguzi_maana_other" rows="2" placeholder="Type other here..."><?php if ($kap['uchunguzi_maana_other']) {
                                                                                                                                                                    print_r($kap['uchunguzi_maana_other']);
                                                                                                                                                                }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="uchunguzi_faida" class="form-label">3. Je, kuna faida gani ya kufanya uchunguzi wa saratani ya mapafu?</label>
                                                        <select name="uchunguzi_faida" id="uchunguzi_faida" class="form-control" onchange="updateText1(this.value)" required>
                                                            <option value="<?= $kap['uchunguzi_faida'] ?>"><?php if ($kap['uchunguzi_faida']) {
                                                                                                                if ($kap['uchunguzi_faida'] == 1) {
                                                                                                                    echo 'Utambuzi wa mapema ambao unaokoa maisha.';
                                                                                                                } elseif ($kap['uchunguzi_faida'] == 2) {
                                                                                                                    echo 'Kugundua saratani ya mapafu katika hatua ya awali wakati kuna uwezekano mkubwa wa kupona.';
                                                                                                                } elseif ($kap['uchunguzi_faida'] == 3) {
                                                                                                                    echo 'Hupunguza hatari ya kufa kwa saratani ya mapafu';
                                                                                                                } elseif ($kap['uchunguzi_faida'] == 99) {
                                                                                                                    echo 'Sijui.';
                                                                                                                } elseif ($kap['uchunguzi_faida'] == 96) {
                                                                                                                    echo 'Nyinginezo';
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                            </option>
                                                            <option value="1">Utambuzi wa mapema ambao unaokoa maisha.</option>
                                                            <option value="2">Kugundua saratani ya mapafu katika hatua ya awali wakati kuna uwezekano mkubwa wa kupona.</option>
                                                            <option value="3">Hupunguza hatari ya kufa kwa saratani ya mapafu.</option>
                                                            <option value="99">Sijui.</option>
                                                            <option value="96">Nyinginezo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="uchunguzi_faida_other">
                                                    <div class="mb-3">
                                                        <label for="uchunguzi_faida_other" class="form-label">3. Taja ?</label>
                                                        <textarea class="form-control" name="uchunguzi_faida_other" rows="2" placeholder="Type other here..."><?php if ($kap['uchunguzi_faida_other']) {
                                                                                                                                                                    print_r($kap['uchunguzi_faida_other']);
                                                                                                                                                                }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="uchunguzi_hatari" class="form-label">4. Je, kuna hatari zozote za kufanya uchunguzi wa saratani ya mapafu?</label>
                                                        <select name="uchunguzi_hatari" id="uchunguzi_hatari" class="form-control" required>
                                                            <option value="<?= $kap['uchunguzi_hatari'] ?>"><?php if ($kap['uchunguzi_hatari']) {
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
                                            </div>

                                            <hr>
                                            <div class="row" id="saratani_hatari1">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="saratani_hatari" class="form-label">5. Kama jibu hapo juu ni ndio, je ni hatari gani zinazoweza kutokana na kufanya uchunguzi wa saratani ya mapafu?</label>
                                                        <select name="saratani_hatari" id="saratani_hatari" class="form-control">
                                                            <option value="<?= $kap['saratani_hatari'] ?>"><?php if ($kap['saratani_hatari']) {
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
                                                                                                                    echo 'Nyinginezo';
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
                                                            <option value="96">Nyinyinezo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="saratani_hatari_other">
                                                    <div class="mb-3">
                                                        <label for="saratani_hatari_other" class="form-label">5. Taja ?</label>
                                                        <textarea class="form-control" name="saratani_hatari_other" rows="3" placeholder="Type other here..."><?php if ($kap['saratani_hatari_other']) {
                                                                                                                                                                    print_r($kap['saratani_hatari_other']);
                                                                                                                                                                }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="kundi" class="form-label">6. Je, ni kundi gani la watu linalofaa kufanyiwa uchunguzi wa saratani ya mapafu? (Multiple answer)</label>
                                                        <select name="kundi" id="kundi" class="form-control" required>
                                                            <option value="<?= $kap['kundi'] ?>"><?php if ($kap['kundi']) {
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
                                                                                                            echo 'Zinginezo';
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
                                                            <option value="96">Zinginezo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="kundi_other">
                                                    <div class="mb-3">
                                                        <label for="kundi_other" class="form-label">6. Taja ?</label>
                                                        <textarea class="form-control" name="kundi_other" rows="3" placeholder="Type other here..."><?php if ($kap['kundi_other']) {
                                                                                                                                                        print_r($kap['kundi_other']);
                                                                                                                                                    }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="ushawishi" class="form-label">7. Je! Unazani nani ana ushawishi mkubwa katika kutoa elimu ya ugonjwa wa Saratani ya Mapafu? (Multiple answer)</label>
                                                        <select name="ushawishi" id="ushawishi" class="form-control" required>
                                                            <option value="<?= $kap['ushawishi'] ?>"><?php if ($kap['ushawishi']) {
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
                                                                                                                echo 'Zinginezo';
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
                                                            <option value="96">Zinginezo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="ushawishi_other">
                                                    <div class="mb-3">
                                                        <label for="ushawishi_other" class="form-label">7. Taja ?</label>
                                                        <textarea class="form-control" name="ushawishi_other" rows="3" placeholder="Type other here..."><?php if ($kap['ushawishi_other']) {
                                                                                                                                                            print_r($kap['ushawishi_other']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-12" id="hitaji_elimu1">
                                                    <div class="mb-3">
                                                        <label for="hitaji_elimu" class="form-label">8. Je unahisi unahitaji taarifa/elimu Zaidi juu ya uchunguzi wa awali wa ugonjwa wa Saratani ya Mapafu na ugonjwa wenyewe kwa jumla?</label>
                                                        <select name="hitaji_elimu" id="hitaji_elimu" class="form-control">
                                                            <option value="<?= $kap['hitaji_elimu'] ?>"><?php if ($kap['hitaji_elimu']) {
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
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Sehemu ya 4; Mtazamo juu ya uchunguzi wa saratani ya mapafu</h3>
                                                </div>
                                            </div>

                                            <div class="card-header">
                                                <h3 class="card-title">Fikiria kuhusu uchunguzi wa saratani ya mapafu, unaweza kuniambia ni kwa kiasi gani unakubaliana na kila kauli zifuatazo?</h3>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="vifo" class="form-label">1. Fikiria kuhusu vifo vinavyotokea kwasababu ya Saratani; “Nisingependa kujua kama nina saratani ya mapafu”. </label>
                                                        <select name="vifo" id="vifo" class="form-control" required>
                                                            <option value="<?= $kap['vifo'] ?>"><?php if ($kap['vifo']) {
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

                                                <div class="col-8">
                                                    <div class="mb-3">
                                                        <label for="tayari_dalili" class="form-label">2. Fikiria jinsi dalili zinavyoonekana, “ Kwenda kwa daktari wangu mapema nikiwa tayari na dalili za ugonjwa wa saratani ya mapafu,akulete utofauti wowote wa mimi kupona saratani ya mapafu”. </label>
                                                        <select name="tayari_dalili" id="tayari_dalili" class="form-control" required>
                                                            <option value="<?= $kap['tayari_dalili'] ?>"><?php if ($kap['tayari_dalili']) {
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
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="mb-2">
                                                        <label for="saratani_kutibika" class="form-label">3. Fikiria jinsi dalili zinavyoonekana ; “Endapo saratani ya mapafu ikigundulika mapema, kuna uwezekano mkubwa wa kutibika”. </label>
                                                        <select name="saratani_kutibika" id="saratani_kutibika" class="form-control" required>
                                                            <option value="<?= $kap['saratani_kutibika'] ?>"><?php if ($kap['saratani_kutibika']) {
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
                                                <div class="col-7">
                                                    <div class="mb-2">
                                                        <label for="saratani_wasiwasi" class="form-label">4. “Ningependelea kutokwenda kufanya uchunguzi wa saratani ya mapafu kwa sababu nina wasiwasi juu ya kile kinachoweza kugundulika wakati wa uchunguzi wa saratani ya mapafu”. </label>
                                                        <select name="saratani_wasiwasi" id="saratani_wasiwasi" class="form-control" required>
                                                            <option value="<?= $kap['saratani_wasiwasi'] ?>"><?php if ($kap['saratani_wasiwasi']) {
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
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="saratani_umuhimu" class="form-label">5. “Sidhani kama kuna umuhimu wowote wa kwenda kufanya uchunguzi wa saratani ya mapafu kwa sababu haita athiri matokeo”. </label>
                                                        <select name="saratani_umuhimu" id="saratani_umuhimu" class="form-control" required>
                                                            <option value="<?= $kap['saratani_umuhimu'] ?>"><?php if ($kap['saratani_umuhimu']) {
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
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="saratani_kufa" class="form-label">6.“Kufanya uchunguzi wa saratani ya mapafu kunaweza kupunguza uwezekano wangu wa kufa kutokana na saratani ya mapafu.” </label>
                                                        <select name="saratani_kufa" id="saratani_kufa" class="form-control" required>
                                                            <option value="<?= $kap['saratani_kufa'] ?>"><?php if ($kap['saratani_kufa']) {
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

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="uchunguzi_haraka" class="form-label">7. “Endapo nitapata dalili zozote za awali za ugonjwa wa Saratani ya mapafu nitakwenda kwa ajili ya uchunguzi wa saratani ya mapafu haraka iwezekanavyo”. </label>
                                                        <select name="uchunguzi_haraka" id="uchunguzi_haraka" class="form-control" required>
                                                            <option value="<?= $kap['uchunguzi_haraka'] ?>"><?php if ($kap['uchunguzi_haraka']) {
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
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Sehemu ya 5; Utaratibu(Practice) juu ya uchunguzi wa saratani ya mapafu</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="wapi_matibabu" class="form-label">8. Je katika jamii yako, watu wakiumwa, huwa wanapendelea kwenda wapi kupata matibabu ?</label>
                                                        <select name="wapi_matibabu" id="wapi_matibabu" class="form-control" required>
                                                            <option value="<?= $kap['wapi_matibabu'] ?>"><?php if ($kap['wapi_matibabu']) {
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
                                                                                                                    echo 'Nyinginezo';
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
                                                            <option value="96">Nyinginezo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="wapi_matibabu_other">
                                                    <div class="mb-3">
                                                        <label for="wapi_matibabu_other" class="form-label">8. Taja ?</label>
                                                        <textarea class="form-control" name="wapi_matibabu_other" rows="2" placeholder="Type other here..."><?php if ($kap['wapi_matibabu_other']) {
                                                                                                                                                                print_r($kap['wapi_matibabu_other']);
                                                                                                                                                            }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="saratani_ushauri" class="form-label">9. Je! Wewe/watu katika jamii huwa wanakwenda kwenye vituo vya kutolea huduma za Afya kwa ajili ya ushauri kuhusu uchunguzi wa ugonjwa wa Saratani ya Mapafu?</label>
                                                        <select name="saratani_ushauri" id="saratani_ushauri" class="form-control" required>
                                                            <option value="<?= $kap['saratani_ushauri'] ?>"><?php if ($kap['saratani_ushauri']) {
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
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="saratani_ujumbe" class="form-label">10. Katika mwezi uliopita umesikia ujumbe wa afya kuhusu maswala ya uchunguzi wa awali wa Saratani ya mapafu?</label>
                                                        <select name="saratani_ujumbe" id="saratani_ujumbe" class="form-control" required>
                                                            <option value="<?= $kap['saratani_ujumbe'] ?>"><?php if ($kap['saratani_ujumbe']) {
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
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($kap['comments']) {
                                                                                                                                                            print_r($kap['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_kap" value="Submit" class="btn btn-primary">
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
            $history = $override->getNews('history', 'status', 1, 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$history) { ?>
                                    <h1>Add New HISTORY</h1>
                                <?php } else { ?>
                                    <h1>Update HISTORY</h1>
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
                                    <?php if (!$history) { ?>
                                        <li class="breadcrumb-item active">Add New HISTORY</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update HISTORY</li>
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
                                        <h3 class="card-title">Part B: Smoking history</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="screening_date" class="form-label">Screening date</label>
                                                        <input type="date" value="<?php if ($history['screening_date']) {
                                                                                        print_r($history['screening_date']);
                                                                                    } ?>" id="screening_date" name="screening_date" class="form-control" placeholder="Enter screening date" required />
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="ever_smoked" class="form-label">Have you ever smoked cigarette ?</label>
                                                        <select name="ever_smoked" id="ever_smoked" class="form-control" required>
                                                            <option value="<?= $history['ever_smoked'] ?>"><?php if ($history['ever_smoked']) {
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
                                            </div>


                                            <hr>
                                            <div id="ever_smoked1">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="start_smoking" class="form-label">When did you start smoking?</label>
                                                            <input type="number" value="<?php if ($history['start_smoking']) {
                                                                                            print_r($history['start_smoking']);
                                                                                        } ?>" min="1970" max="2024" id="start_smoking" name="start_smoking" class="form-control" placeholder="Enter Year" />
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="currently_smoking" class="form-label">Are you Currently Smoking ?</label>
                                                            <select name="currently_smoking" id="currently_smoking" class="form-control">
                                                                <option value="<?= $history['currently_smoking'] ?>"><?php if ($history['currently_smoking']) {
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
                                                </div>

                                            </div>


                                            <div id="ever_smoked2">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="type_smoked" class="form-label">Amount smoked per day in cigarette sticks/packs?</label>
                                                            <select name="type_smoked" id="type_smoked" class="form-control">
                                                                <option value="<?= $history['type_smoked'] ?>"><?php if ($history['type_smoked']) {
                                                                                                                    if ($history['type_smoked'] == 1) {
                                                                                                                        echo 'Packs';
                                                                                                                    } elseif ($history['type_smoked'] == 2) {
                                                                                                                        echo 'Cigarette';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                                </option>
                                                                <option value="1">Packs</option>
                                                                <option value="2">Cigarette</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6" id="quit_smoking">
                                                        <div class="mb-3">
                                                            <label for="quit_smoking" class="form-label">When did you quit smoking in years?</label>
                                                            <input type="number" value="<?php if ($history['quit_smoking']) {
                                                                                            print_r($history['quit_smoking']);
                                                                                        } ?>" min="1970" max="2024" name="quit_smoking" class="form-control" placeholder="Enter Year" />
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                            <hr>

                                            <div id="ever_smoked3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="packs_per_day" id="packs_per_day" class="form-label">
                                                                Number of packs per day
                                                            </label>
                                                            <label for="cigarette_per_day" id="cigarette_per_day" class="form-label">
                                                                Number of Cigarette per day
                                                            </label>
                                                            <input type="number" value="<?php if ($history['packs_per_day']) {
                                                                                            print_r($history['packs_per_day']);
                                                                                        } ?>" min="0" id="packs_per_day" name="packs_per_day" class="form-control" placeholder="Enter amount" />
                                                        </div>
                                                    </div>


                                                    <div class="col-6" id="packs_per_year">
                                                        <div class="mb-3">
                                                            <label for="packs_per_year" class="form-label">Number of Pack year</label>
                                                            <input type="number" value="<?php if ($history['packs_per_year']) {
                                                                                            print_r($history['packs_per_year']);
                                                                                        } ?>" min="0" id="packs_per_year" name="packs_per_year" class="form-control" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12" id="eligible">
                                                    <div class="mb-3">
                                                        <?php if ($history['eligible']) { ?>
                                                            <a class="btn btn-success">Client is Eligible</a>
                                                        <?php } else { ?>
                                                            <a class="btn btn-warning">Client is Not Eligible</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_history" value="Submit" class="btn btn-primary">
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
            $results = $override->get3('results', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($results) { ?>
                                    <h1>Add New test results</h1>
                                <?php } else { ?>
                                    <h1>Update test results</h1>
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
                                        <li class="breadcrumb-item active">Add New test results</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update test results</li>
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
                                        <h3 class="card-title">CRF2: Screeing test results using LDCT</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
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
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_results" value="Submit" class="btn btn-primary">
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
            <?php
            $classification = $override->get3('classification', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($classification) { ?>
                                    <h1>Add New LUNG- RADS CLASSIFICATION</h1>
                                <?php } else { ?>
                                    <h1>Update LUNG- RADS CLASSIFICATION</h1>
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
                                    <?php if ($classification) { ?>
                                        <li class="breadcrumb-item active">Add New LUNG- RADS CLASSIFICATION</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update LUNG- RADS CLASSIFICATION</li>
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
                                        <h3 class="card-title">LUNG- RADS CLASSIFICATION</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="classification_date" class="form-label">Clasification Date</label>
                                                        <input type="date" value="<?php if ($classification) {
                                                                                        print_r($classification['classification_date']);
                                                                                    } ?>" id="classification_date" name="classification_date" class="form-control" placeholder="Enter classification date" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="1" <?php if ($classification['category'] == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 1</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 1) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="2" <?php if ($classification['category'] == 2) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 2</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 2) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="3" <?php if ($classification['category'] == 3) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 3</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 3) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="4" <?php if ($classification['category'] == 4) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 4A</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 4) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="5" <?php if ($classification['category'] == 5) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 4B</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 5) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_classification" value="Submit" class="btn btn-primary">
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

        <?php } elseif ($_GET['id'] == 9) { ?>
            <?php
            $economic = $override->get3('economic', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($history) { ?>
                                    <h1>Add New CRF3</h1>
                                <?php } else { ?>
                                    <h1>Update CRF3</h1>
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
                                    <?php if ($history) { ?>
                                        <li class="breadcrumb-item active">Add New CRF3</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update CRF3</li>
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
                                        <h3 class="card-title">CRF3: Taarifa za kiuchumi (Wakati wa screening)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="economic_date" class="form-label">Tarehe</label>
                                                        <input type="date" value="<?php if ($economic['economic_date']) {
                                                                                        print_r($economic['economic_date']);
                                                                                    } ?>" id="economic_date" name="economic_date" class="form-control" placeholder="Enter economic date" required />
                                                    </div>
                                                </div>

                                                <div class="col-5">
                                                    <div class="mb-2">
                                                        <label for="income_household" class="form-label">Chanzo kikuu cha kipato cha mkuu wa kaya?</label>
                                                        <select class="form-control" id="income_household" name="income_household" style="width: 100%;" required>
                                                            <option value="<?= $economic['income_household'] ?>"><?php if ($economic['income_household']) {
                                                                                                                        if ($economic['income_household'] == 1) {
                                                                                                                            echo 'Msharaha kwa mwezi';
                                                                                                                        } elseif ($economic['income_household'] == 2) {
                                                                                                                            echo 'Posho kwa siku';
                                                                                                                        } elseif ($economic['income_household'] == 3) {
                                                                                                                            echo 'Pato kutokana na mauzo ya biashara';
                                                                                                                        } elseif ($economic['income_household'] == 4) {
                                                                                                                            echo 'Pato kutokana na mauzo ya mazao au mifugo';
                                                                                                                        } elseif ($economic['income_household'] == 5) {
                                                                                                                            echo 'Hana kipato';
                                                                                                                        } elseif ($economic['income_household'] == 6) {
                                                                                                                            echo 'Mstaafu';
                                                                                                                        } elseif ($economic['income_household'] == 96) {
                                                                                                                            echo 'Nyingine';
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        echo 'Select';
                                                                                                                    } ?>
                                                            </option>
                                                            <option value="1">Msharaha kwa mwezi</option>
                                                            <option value="2">Posho kwa siku</option>
                                                            <option value="3">Pato kutokana na mauzo ya biashara</option>
                                                            <option value="4">Pato kutokana na mauzo ya mazao au mifugo</option>
                                                            <option value="5">Hana kipato</option>
                                                            <option value="6">Mstaafu</option>
                                                            <option value="96">Nyingine</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4" id="income_household_other">
                                                    <div class="mb-3">
                                                        <label for="monthly_earn" class="form-label">Taja</label>
                                                        <textarea class="form-control" name="income_household_other" rows="2" placeholder="Type other here...">
                                                            <?php if ($economic['income_household_other']) {
                                                                print_r($economic['income_household_other']);
                                                            }  ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="income_patient" class="form-label">Chanzo kikuu cha mapato cha mgonjwa? </label>
                                                        <select class="form-control" id="income_patient" name="income_patient" style="width: 100%;" required>
                                                            <option value="<?= $economic['income_patient'] ?>"><?php if ($economic['income_patient']) {
                                                                                                                    if ($economic['income_patient'] == 1) {
                                                                                                                        echo 'Msharaha kwa mwezi';
                                                                                                                    } elseif ($economic['income_patient'] == 2) {
                                                                                                                        echo 'Posho kwa siku';
                                                                                                                    } elseif ($economic['income_patient'] == 3) {
                                                                                                                        echo 'Pato kutokana na mauzo ya biashara';
                                                                                                                    } elseif ($economic['income_patient'] == 4) {
                                                                                                                        echo 'Pato kutokana na mauzo ya mazao au mifugo';
                                                                                                                    } elseif ($economic['income_patient'] == 5) {
                                                                                                                        echo 'Hana kipato';
                                                                                                                    } elseif ($economic['income_patient'] == 6) {
                                                                                                                        echo 'Mstaafu';
                                                                                                                    } elseif ($economic['income_patient'] == 96) {
                                                                                                                        echo 'Nyingine';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                            </option>
                                                            <option value="1">Msharaha kwa mwezi</option>
                                                            <option value="2">Posho kwa siku</option>
                                                            <option value="3">Pato kutokana na mauzo ya biashara</option>
                                                            <option value="4">Pato kutokana na mauzo ya mazao au mifugo</option>
                                                            <option value="5">Hana kipato</option>
                                                            <option value="6">Mstaafu</option>
                                                            <option value="96">Nyingine</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6" id="income_patient_other">
                                                    <div class="mb-3">
                                                        <label for="income_patient_other" class="form-label">Taja</label>
                                                        <textarea class="form-control" name="income_patient_other" rows="2" placeholder="Type other here...">
                                                            <?php if ($economic['income_patient_other']) {
                                                                print_r($economic['income_patient_other']);
                                                            }  ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="monthly_earn" class="form-label">Je, unaingiza shilingi ngapi kwa mwezi kutoka kwenye vyanzo vyako vyote vya fedha? ( TSHS )</label>
                                                        <input type="number" value="<?php if ($economic['monthly_earn']) {
                                                                                        print_r($economic['monthly_earn']);
                                                                                    } ?>" min="0" max="100000000" id="monthly_earn" name="monthly_earn" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="member_earn" class="form-label">Kwa mwezi, ni kiasi gani wanakaya wenzako wanaingiza kutoka kwenye vyanzo vyote vya fedha? (kwa ujumla)? </label>
                                                        <input type="number" value="<?php if ($economic['member_earn']) {
                                                                                        print_r($economic['member_earn']);
                                                                                    } ?>" min="0" max="100000000" id="member_earn" name="member_earn" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="transport" class="form-label">Ulilipa kiasi gani kwa ajili ya usafiri ulipoenda hospitali kwa ajili ya kufanyiwa uchunguzi wa saratani ya mapafu? </label>
                                                        <input type="number" value="<?php if ($economic['transport']) {
                                                                                        print_r($economic['transport']);
                                                                                    } ?>" min="0" max="100000000" id="transport" name="transport" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="support_earn" class="form-label">Kama ulisindikizwa, alilipa fedha kiasi gani kwa ajili ya usafiri? </label>
                                                        <input type="number" value="<?php if ($economic['support_earn']) {
                                                                                        print_r($economic['support_earn']);
                                                                                    } ?>" min="0" max="100000000" id="support_earn" name="support_earn" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="food_drinks" class="form-label">Ulilipa fedha kiasi gani kwa ajili ya chakula na vinywaji? </label>
                                                        <input type="number" value="<?php if ($economic['food_drinks']) {
                                                                                        print_r($economic['food_drinks']);
                                                                                    } ?>" min="0" max="100000000" id="food_drinks" name="food_drinks" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="other_cost" class="form-label">Je, kuna gharama yoyote ambayo ulilipa tofauti na hizo ulizotaja hapo, kama ndio, ni shilingi ngapi? </label>
                                                        <input type="number" value="<?php if ($economic['other_cost']) {
                                                                                        print_r($economic['other_cost']);
                                                                                    } ?>" min="0" max="100000000" id="other_cost" name="other_cost" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Je, kwa mwezi, unapoteza muda kiasi gani unapotembelea kliniki?</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="days" class="form-label">Siku</label>
                                                        <input type="number" value="<?php if ($economic['days']) {
                                                                                        print_r($economic['days']);
                                                                                    } ?>" min="0" max="100" id="days" name="days" class="form-control" placeholder="Enter days" required />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="hours" class="form-label">Masaa</label>
                                                        <input type="number" value="<?php if ($economic['hours']) {
                                                                                        print_r($economic['hours']);
                                                                                    } ?>" min="0" max="100" id="hours" name="hours" class="form-control" placeholder="Enter hours" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title"> Je, ulilipa gharama kiasi gani kwa huduma zifuatazo?
                                                    </h3>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="registration" class="form-label">Usajili ( TSHS )</label>
                                                        <input type="number" value="<?php if ($economic['registration']) {
                                                                                        print_r($economic['registration']);
                                                                                    } ?>" min="0" max="100000000" id="registration" name="registration" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="consultation" class="form-label">Kumuona daktari (Consultation)_ ( TSHS )</label>
                                                        <input type="number" value="<?php if ($economic['consultation']) {
                                                                                        print_r($economic['consultation']);
                                                                                    } ?>" min="0" max="100000000" id="consultation" name="consultation" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="diagnostic" class="form-label">Vipimo (Diagnostic tests) ( TSHS )</label>
                                                        <input type="number" value="<?php if ($economic['diagnostic']) {
                                                                                        print_r($economic['diagnostic']);
                                                                                    } ?>" min="0" max="100000000" id="diagnostic" name="diagnostic" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="medications" class="form-label">Dawa (Medications) ( TSHS )</label>
                                                        <input type="number" value="<?php if ($economic['medications']) {
                                                                                        print_r($economic['medications']);
                                                                                    } ?>" min="0" max="100000000" id="medications" name="medications" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="other_medical_cost" class="form-label">Gharama zingine za ziada kwa ajili ya matibabu (Any other direct medical costs) ( TSHS )</label>
                                                        <input type="number" value="<?php if ($economic['other_medical_cost']) {
                                                                                        print_r($economic['other_medical_cost']);
                                                                                    } ?>" min="0" max="100000000" id="other_medical_cost" name="other_medical_cost" class="form-control" placeholder="Enter TSHS" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_economic" value="Submit" class="btn btn-primary">
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
        <?php } elseif ($_GET['id'] == 10) { ?>
            <?php
            $outcome = $override->get3('outcome', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($outcome) { ?>
                                    <h1>Add New outcome results</h1>
                                <?php } else { ?>
                                    <h1>Update outcome results</h1>
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
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New outcome results</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update outcome results</li>
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
                                        <h3 class="card-title">CRF 3: FOLLOW UP ( PATIENT OUTCOME AFTER SCREENING )</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="outcome_date" class="form-label">Date</label>
                                                        <input type="date" value="<?php if ($outcome) {
                                                                                        print_r($outcome['outcome_date']);
                                                                                    } ?>" id="outcome_date" name="outcome_date" class="form-control" placeholder="Enter outcome date" required />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <div class="row-form clearfix">
                                                            <!-- select -->
                                                            <div class="form-group">
                                                                <label>Patient Diagnosis if was scored Lung- RAD 4B</label>
                                                                <textarea class="form-control" name="diagnosis" rows="3" placeholder="Type diagnosis here...">
                                                                        <?php if ($outcome['diagnosis']) {
                                                                            print_r($outcome['diagnosis']);
                                                                        }  ?>
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="outcome" class="form-label">Outcome</label>
                                                        <select class="form-control" id="outcome" name="outcome" style="width: 100%;" required>
                                                            <option value="<?= $outcome['outcome'] ?>"><?php if ($outcome) {
                                                                                                            if ($outcome['outcome'] == 1) {
                                                                                                                echo 'Await another screening';
                                                                                                            } elseif ($outcome['outcome'] == 2) {
                                                                                                                echo 'On treatment';
                                                                                                            } elseif ($outcome['outcome'] == 3) {
                                                                                                                echo 'Recovered';
                                                                                                            } elseif ($outcome['outcome'] == 4) {
                                                                                                                echo 'Died';
                                                                                                            } elseif ($outcome['outcome'] == 5) {
                                                                                                                echo 'Unknown/Loss to follow up1';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                            </option>
                                                            <option value="1">Await another screening</option>
                                                            <option value="2">On treatment</option>
                                                            <option value="3">Recovered</option>
                                                            <option value="4">Died</option>
                                                            <option value="5">Unknown/Loss to follow up</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_outcome" value="Submit" class="btn btn-primary">
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

        <?php } elseif ($_GET['id'] == 11) { ?>
            <?php
            $kap = $override->getNews('kap', 'status', 1, 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$kap) { ?>
                                    <h1>Add New Health Care KAP</h1>
                                <?php } else { ?>
                                    <h1>Update Health Care KAP</h1>
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
                                    <?php if (!$kap) { ?>
                                        <li class="breadcrumb-item active">Add New Health Care KAP</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Health Care KAP</li>
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
                                        <h3 class="card-title">Health Care Kap</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="interview_date" class="form-label">Interview Date</label>
                                                        <input type="date" value="<?php if ($kap['interview_date']) {
                                                                                        print_r($kap['interview_date']);
                                                                                    } ?>" id="interview_date" name="interview_date" class="form-control" placeholder="Enter interview date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($kap['comments']) {
                                                                                                                                                            print_r($kap['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_health_care_kap" value="Submit" class="btn btn-primary">
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


    <!-- demographic Js -->
    <script src="myjs/add/clients/insurance.js"></script>
    <script src="myjs/add/clients/insurance_name.js"></script>
    <script src="myjs/add/clients/relation_patient.js"></script>

    <!-- KAP Js -->
    <script src="myjs/add/kap/dalili_saratani.js"></script>
    <script src="myjs/add/kap/kundi.js"></script>
    <script src="myjs/add/kap/matibabu.js"></script>
    <script src="myjs/add/kap/matibabu_saratani.js"></script>
    <script src="myjs/add/kap/saratani_hatari.js"></script>
    <script src="myjs/add/kap/saratani_inatibika.js"></script>
    <script src="myjs/add/kap/saratani_vipimo.js"></script>
    <script src="myjs/add/kap/uchunguzi_faida.js"></script>
    <script src="myjs/add/kap/uchunguzi_hatari.js"></script>
    <script src="myjs/add/kap/uchunguzi_maana.js"></script>
    <script src="myjs/add/kap/ushawishi.js"></script>
    <script src="myjs/add/kap/vitu_hatarishi.js"></script>
    <script src="myjs/add/kap/wapi_matibabu.js"></script>






    <!-- HISTORY Js -->
    <script src="myjs/add/history/currently_smoking.js"></script>
    <script src="myjs/add/history/ever_smoked.js"></script>
    <script src="myjs/add/history/type_smoked.js"></script>

    <!-- economics Js -->
    <script src="myjs/add/economics/household.js"></script>
    <script src="myjs/add/economics/patient.js"></script>






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