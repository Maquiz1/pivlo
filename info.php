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

                            <!-- <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">e-CTMIS</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active"><?= $Tiltle; ?></li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?= $Tiltle; ?></h4>
                            </div> -->

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

                                                    $kap = 0;
                                                    $screening = 0;
                                                    $health_care = 0;
                                                    if ($_GET['interview'] == 1) {
                                                        $interview = 'kap';
                                                    } elseif ($_GET['interview'] == 2) {
                                                        $interview = 'screening';
                                                    } elseif ($_GET['interview'] == 3) {
                                                        $interview = 'health_care';
                                                    }
                                                    if ($override->getNews('clients', 'status', 1, $interview, 1, 'site_id', $user->data()->site_id)) {
                                                        foreach ($override->getNews3('clients', 'status', 1, $interview, 1, 'site_id', $user->data()->site_id) as $value) {
                                                            $yes_no = $override->get('yes_no', 'status', 1)[0];
                                                            $kap = $override->getNews('kap', 'status', 1, 'patient_id', $value['id'])[0];
                                                            $history = $override->getNews('history', 'status', 1, 'patient_id', $value['id'])[0];
                                                            $results = $override->getNews('results', 'status', 1, 'patient_id', $value['id'])[0];
                                                            $classification = $override->getNews('classification', 'status', 1, 'patient_id', $value['id'])[0];
                                                            $economic = $override->getNews('economic', 'status', 1, 'patient_id', $value['id'])[0];
                                                            $sites = $override->getNews('sites', 'status', 1, 'id', $value['site_id'])[0];
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
                                                                    <?= $sites['name']; ?>
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
                                                                    <!-- <a href="add.php?id=2&cid=<?= $value['id'] ?>&btn=View" class="text-reset fs-16 px-1"> <i class="ri-edit-circle-line"></i>View</a> -->
                                                                    <a href="add.php?id=2&cid=<?= $value['id'] ?>&btn=Update" class="text-reset fs-16 px-1"> <i class="ri-edit-box-line"></i>Update</a>

                                                                    <?php if ($_GET['interview'] == 1) { ?>
                                                                        <?php if ($kap['status']) {
                                                                            $btnKap = 'Update';
                                                                        ?>
                                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kap<?= $value['id'] ?>&btn=" .$btn>Update KAP</button>
                                                                        <?php   } else {
                                                                            $btnKap = 'Add';
                                                                        ?>
                                                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#kap<?= $value['id'] ?>&btn=" .$btn>Add KAP</button>
                                                                        <?php   } ?>

                                                                    <?php } ?>

                                                                    <?php if ($_GET['interview'] == 2) { ?>

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
                                                                            $btnC = 'Add';
                                                                        ?>
                                                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#classification<?= $value['id'] ?>&btn=" .$btnC>Add Classification</button>
                                                                        <?php   } elseif ($classification['status'] == 1) {
                                                                            $btnC = 'Update';
                                                                        ?>
                                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classification<?= $value['id'] ?>&btn=" .$btnC>Update Classification</button>
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

                                                                    <?php } ?>
                                                                    <a href="info.php?id=3&cid=<?= $value['id'] ?>&site_id=<?= $_GET['site_id']; ?>&interview=<?= $_GET['interview']; ?>&btn=<?= $_GET['btn']; ?>" class="btn btn-success">Clients Schedules</a>


                                                                    <!-- <a href="#delete_batch<?= $value['id'] ?>" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_batch<?= $value['id'] ?>">Delete</a> -->
                                                                </td>
                                                            </tr>
                                                            <div id="kap<?= $value['id'] ?>&btn=" .$btn class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">Sehemu ya 2; Uelewa juu ya Saratani ya mapafu. (Usimsomee machaguo)</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="interview_date" class="form-label">Interview Date</label>
                                                                                            <input type="date" value="<?php if ($kap) {
                                                                                                                            print_r($kap['interview_date']);
                                                                                                                        } ?>" id="interview_date" name="interview_date" class="form-control" placeholder="Enter interview date" required />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
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
                                                                                    <hr>
                                                                                    <div class="col-6">
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

                                                                                    <div class="col-6">
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
                                                                                    <hr>

                                                                                    <div class="col-6">
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
                                                                                    <hr>

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
                                                                                    <hr>

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
                                                                                    <hr>

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
                                                                                    <hr>

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

                                                                                    <div class="col-12">
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
                                                                                    <hr>
                                                                                    <div class="col-6">
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

                                                                                    <div class="col-6" id="uchunguzi_maana_other">
                                                                                        <div class="mb-3">
                                                                                            <label for="uchunguzi_maana_other" class="form-label">Taja ?</label>
                                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                                            print_r($kap['uchunguzi_maana_other']);
                                                                                                                        } ?>" name="uchunguzi_maana_other" class="form-control" placeholder="Ingiza vitu hatarishi" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

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
                                                                                    <hr>

                                                                                    <div class="col-12">
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
                                                                                    <hr>

                                                                                    <div class="col-6">
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

                                                                                    <div class="col-6" id="saratani_hatari_other">
                                                                                        <div class="mb-3">
                                                                                            <label for="saratani_hatari_other" class="form-label">Taja ?</label>
                                                                                            <input type="text" value="<?php if ($kap) {
                                                                                                                            print_r($kap['saratani_hatari_other']);
                                                                                                                        } ?>" name="saratani_hatari_other" class="form-control" placeholder="Ingiza saratani_vipimo_" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

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
                                                                                    <hr>

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
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $kap['id'] ?>">
                                                                                <input type="hidden" name="cid" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="btn" value="<?= $btnKap ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="add_kap" class="btn btn-primary" value="<?= $btnKap ?>">
                                                                            </div>
                                                                        </form>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
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
                                                                        </form>
                                                                    </div><!-- /.modal-content -->
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
                                                                        </form>
                                                                    </div><!-- /.modal-content -->
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
                                                                                            <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 1) as $cat) { ?>
                                                                                                - <label><?= $cat['name'] ?></label> <br>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
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
                                                                                    <div class="col-12">
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
                                                                                    <div class="col-12">
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
                                                                                    <div class="col-12">
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
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $classification['id'] ?>">
                                                                                <input type="hidden" name="cid" value="<?= $value['id'] ?>">
                                                                                <input type="hidden" name="btn" value="<?= $btnC ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="add_classification" class="btn btn-primary" value="<?= $btnC ?>Classification">
                                                                            </div>
                                                                        </form>
                                                                    </div><!-- /.modal-content -->
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
                                                                        </form>
                                                                    </div><!-- /.modal-content -->
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
                                                        <th>Visit Name</th>
                                                        <th>Expected Date</th>
                                                        <th>Visit Date</th>
                                                        <th>Site</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action 1</th>
                                                        <th class="text-center">Action 2</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($override->get('visit', 'patient_id', $_GET['cid'])) {
                                                        foreach ($override->get('visit', 'patient_id', $_GET['cid']) as $visit) {
                                                            $sites = $override->getNews('sites', 'status', 1, 'id', $visit['site_id'])[0];
                                                            $outcome = $override->getNews('outcome', 'status', 1, 'id', $visit['outcome'])[0];


                                                    ?>
                                                            <tr>
                                                                <td class="table-user">
                                                                    <?= $visit['visit_name']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $visit['expected_date']; ?>
                                                                </td>outcome
                                                                <td class="table-user">
                                                                    <?= $visit['visit_date']; ?>
                                                                </td>
                                                                <td class="table-user">
                                                                    <?= $sites['name']; ?>
                                                                </td>
                                                                <?php if ($visit['visit_status'] == 1) { ?>
                                                                    <td class="table-user">
                                                                        Done
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td class="table-user">
                                                                        Not Done
                                                                    </td>
                                                                <?php  } ?>
                                                                <td class="table-user">

                                                                    <?php if ($visit['visit_status'] == 0) {
                                                                        $btn = 'Add';
                                                                    ?>
                                                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#visit<?= $visit['id'] ?>&btn=" .$btn>Add Visit</button>
                                                                    <?php   } elseif ($visit['visit_status'] == 1) {
                                                                        $btn = 'Update';
                                                                    ?>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#visit<?= $visit['id'] ?>&btn=" .$btn>Update Visit</button>
                                                                    <?php   } else { ?>
                                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#visit<?= $visit['id'] ?>&btn=" .$btn>Missed Visit</button>

                                                                    <?php   } ?>

                                                                </td>
                                                                <td>
                                                                    <a href="info.php?id=5&cid=<?= $visit['patient_id'] ?>&visit_name=<?= $visit['visit_name'] ?>&sequence=<?= $visit['sequence'] ?>&site_id=<?= $_GET['site_id']; ?>&interview=<?= $_GET['interview']; ?>&btn=<?= $_GET['btn']; ?>" class="btn btn-success">Study Crfs</a>

                                                                </td>
                                                            </tr>
                                                            <div id="visit<?= $visit['id'] ?>&btn=" .$btn class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form id="validation" method="post">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="standard-modalLabel">Update PATIENT OUTCOME AFTER SCREENING</h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="visit_date" class="form-label">Date</label>
                                                                                            <input type="date" value="<?php if ($visit) {
                                                                                                                            print_r($visit['visit_date']);
                                                                                                                        } ?>" id="visit_date" name="visit_date" class="form-control" placeholder="Enter visit date" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="diagnosis" class="form-label">1.Patient Diagnosis if was scored Lung- RAD 4B:</label>
                                                                                            <textarea class="form-control" name="diagnosis" id="diagnosis" rows="5">
                                                                                            <?php if ($visit) {
                                                                                                print_r($visit['diagnosis']);
                                                                                            } ?>
                                                                                            </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="visit_status" class="form-label">Status</label>
                                                                                            <select name="visit_status" id="visit_status" class="form-select form-select-lg mb-3" required>
                                                                                                <option value="<?= $visit['visit_status'] ?>"><?php if ($visit) {
                                                                                                                                                    if ($visit['visit_status'] == 1) {
                                                                                                                                                        echo 'Atended';
                                                                                                                                                    } elseif ($visit['visit_status'] == 2) {
                                                                                                                                                        echo 'Not Atended';
                                                                                                                                                    }
                                                                                                                                                } else {
                                                                                                                                                    echo 'Select';
                                                                                                                                                } ?>
                                                                                                </option>
                                                                                                <option value="1">Atended</option>
                                                                                                <option value="2">Not Atended</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="mb-2">
                                                                                            <label for="outcome" class="form-label">2.Outcome</label>
                                                                                            <select id="outcome" name="outcome" class="form-select form-select-lg mb-3" required>
                                                                                                <option value="<?= $outcome['id'] ?>"><?php if ($visit) {
                                                                                                                                            print_r($outcome['name']);
                                                                                                                                        } else {
                                                                                                                                            echo 'Select outcome';
                                                                                                                                        } ?>
                                                                                                </option>
                                                                                                <?php foreach ($override->get('outcome', 'status', 1) as $out) { ?>
                                                                                                    <option value="<?= $out['id'] ?>"><?= $out['name'] ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="id" value="<?= $visit['id'] ?>">
                                                                                <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                                                                <input type="hidden" name="btn" value="<?= $btn ?>">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <input type="submit" name="add_visit" class="btn btn-primary" value="<?= $btn ?>Visit">
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
                        <?php

                        $kap = 0;
                        $screening = 0;
                        $health_care = 0;
                        if ($_GET['interview'] == 1) {
                            $interview = 'kap';
                        } elseif ($_GET['interview'] == 2) {
                            $interview = 'screening';
                        } elseif ($_GET['interview'] == 3) {
                            $interview = 'health_care';
                        }

                        ?>
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Lung Cancer</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Base UI</a></li>
                                            <li class="breadcrumb-item active">Clients</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Clients Interview Category</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <h4 class="mb-4 mt-2">
                                    Uchunguzi wa kansa ya mapafu katika kliniki ya huduma na kinga ya VVU; kukusanya takwimu za awali ili kuwezesha utekelezaji wa uchunguzi wa kansa ya mapafu katika huduma za VVU/UKIMWI nchini Tanzania.
                                </h4>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border-secondary border">
                                    <div class="card-body">
                                        <h5 class="card-title">KAP</h5>
                                        <p class="card-text">KAP Questionaire.</p>
                                        <a href="add.php?id=2&site_id=<?= $_GET['site_id']; ?>&interview=1&btn=Add" class="btn btn-secondary btn-sm">
                                            Add <span class="badge bg-light text-dark ms-1"><i class="ri-pencil-line"></i></span>
                                        </a>
                                        <a href="info.php?id=2&site_id=<?= $_GET['site_id']; ?>&interview=1&btn=Update" class="btn btn-info btn-sm">
                                            View <span class="badge bg-light text-dark ms-1"><?= $override->countData1('clients', 'status', 1, 'kap', 1, 'site_id', $user->data()->site_id); ?></span>
                                        </a>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-md-4">
                                <div class="card border-primary border">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">SCREENING</h5>
                                        <p class="card-text">SCREENING Questionaire.</p>
                                        <a href="add.php?id=2&site_id=<?= $_GET['site_id']; ?>&interview=2&btn=Add" class="btn btn-secondary btn-sm">
                                            Add <span class="badge bg-light text-dark ms-1"><i class="ri-pencil-line"></i></span>
                                        </a>
                                        <a href="info.php?id=2&site_id=<?= $_GET['site_id']; ?>&interview=2&btn=Update" class="btn btn-primary btn-sm">
                                            View <span class="badge bg-light text-dark ms-1"><?= $override->countData1('clients', 'status', 1, 'screening', 1, 'site_id', $user->data()->site_id); ?></span>
                                        </a>

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->



                            <div class="col-md-4">
                                <div class="card border-success border">
                                    <div class="card-body">
                                        <h5 class="card-title text-success">HEALTH CARE WORKERS</h5>
                                        <p class="card-text">HEALTH CARE WORKERS Questionaire.</p>

                                        <a href="add.php?id=2&site_id=<?= $_GET['site_id']; ?>&interview=3&btn=Add" class="btn btn-secondary btn-sm">
                                            Add <span class="badge bg-light text-dark ms-1"><i class="ri-pencil-line"></i></span>
                                        </a>
                                        <a href="info.php?id=2&site_id=<?= $_GET['site_id']; ?>&interview=3&btn=Update" class="btn btn-success btn-sm">View
                                            <span class="badge bg-light text-dark ms-1"><?= $override->countData1('clients', 'status', 1, 'health_care', 1, 'site_id', $user->data()->site_id); ?></span>
                                        </a>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->
                    <?php } elseif ($_GET['id'] == 5) { ?>
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Contact List</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Contact List</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="input-group">
                                            <input type="text" id="example-input1-group2" name="example-input1-group2" class="form-control" placeholder="Search">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary rounded-start-0"><i class="ri-search-line fs-16"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->


                        <div class="row">
                            <?php if ($_GET['sequence'] == 0 || $_GET['sequence'] == 1) { ?>
                                <?php
                                $kap = $override->getNews('kap', 'status', 1, 'patient_id', $_GET['cid']);
                                ?>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <div class="d-flex">
                                                    <a class="me-3" href="#">
                                                        <img class="avatar-md rounded-circle bx-s" src="assets/images/users/avatar-2.jpg" alt="">
                                                    </a>
                                                    <div class="info">
                                                        <h5 class="fs-18 my-1">KAP</h5>
                                                        <p class="text-muted fs-15">KAP</p>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <?php if (!$kap) { ?>
                                                        <a href="add.php?id=3&cid=<?= $_GET['cid']; ?>&visit_name=<?= $_GET['visit_name']; ?>&sequence=<?= $_GET['sequence']; ?>&site_id=<?= $_GET['site_id']; ?>&interview=<?= $_GET['interview']; ?>&btn=Add" class="btn btn-secondary btn-sm me-1 tooltips" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add"> <i class="ri-pencil-fill"></i> </a>
                                                    <?php } else { ?>
                                                        <a href="add.php?id=3&cid=<?= $_GET['cid']; ?>&visit_name=<?= $_GET['visit_name']; ?>&sequence=<?= $_GET['sequence']; ?>&site_id=<?= $_GET['site_id']; ?>&interview=<?= $_GET['interview']; ?>&btn=Update" class="btn btn-success btn-sm me-1 tooltips" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"> <i class="ri-pencil-fill"></i> </a>
                                                        <a href="#" class="btn btn-danger btn-sm tooltips" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"> <i class="ri-close-fill"></i> </a>
                                                    <?php } ?>
                                                </div>


                                            </div>

                                            <hr>

                                        </div>
                                        <!-- card-body -->
                                    </div>
                                    <!-- card -->
                                </div> <!-- end col -->
                            <?php }  ?>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="d-flex">
                                                <a class="me-3" href="#">
                                                    <img class="avatar-md rounded-circle bx-s" src="assets/images/users/avatar-2.jpg" alt="">
                                                </a>
                                                <div class="info">
                                                    <h5 class="fs-18 my-1">HISTORY</h5>
                                                    <p class="text-muted fs-15">HISTORY</p>
                                                </div>
                                            </div>
                                            <div class="">
                                                <a href="#" class="btn btn-success btn-sm me-1 tooltips" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"> <i class="ri-pencil-fill"></i> </a>
                                                <a href="#" class="btn btn-danger btn-sm tooltips" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"> <i class="ri-close-fill"></i> </a>
                                            </div>

                                            <?php if ($override->get3('kap', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])) { ?>
                                                <td><a href="add.php?id=7&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-success"> Change </a> </td>
                                            <?php } else { ?>
                                                <td><a href="add.php?id=7&cid=<?= $_GET['cid'] ?>&vid=<?= $_GET['vid'] ?>&vcode=<?= $_GET['vcode'] ?>&seq=<?= $_GET['seq'] ?>&sid=<?= $_GET['sid'] ?>&vday=<?= $_GET['vday'] ?>" class="btn btn-warning"> Add </a> </td>
                                            <?php } ?>


                                        </div>

                                        <hr>

                                    </div>
                                    <!-- card-body -->
                                </div>
                                <!-- card -->
                            </div> <!-- end col -->
                        </div>


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
    <script>
        function updateText1(val) {
            if (val == '96') {
                $('#vitu_hatarishi_other').show();
            } else {
                $('#vitu_hatarishi_other').hide();
            }
        }

        function updateText2(val) {
            if (val == '96') {
                $('#dalili_saratani_other').show();
            } else {
                $('#dalili_saratani_other').hide();
            }
        }

        function updateText3(val) {
            if (val == '96') {
                $('#saratani_vipimo_other').show();
            } else {
                $('#saratani_vipimo_other').hide();
            }
        }


        function updateText4(val) {
            if (val == '1') {
                $('#matibabu_saratani1').show();
                $('#matibabu1').show();
            } else {
                $('#matibabu_saratani1').hide();
                $('#matibabu1').hide();
            }
        }

        function updateText5(val) {
            if (val == '1') {
                $('#matibabu1').show();
            } else {
                $('#matibabu1').hide();
            }
        }


        function updateText6(val) {
            if (val == '96') {
                $('#matibabu_other').show();
            } else {
                $('#matibabu_other').hide();
            }
        }




        // function updateText(val) {
        //     var $el = document.getElementById("adv1");
        //     if (val == '1') {
        //         $el.value = "$ 750";
        //     } else {
        //         $el.value = "0";
        //     }
        // }

        // // $('p').hide();
        // $('#vitu_hatarishi_other').hide();
        // // $('#1').show();
        // $('select').change(function() {
        // $('vitu_hatarishi_other').hide();
        // var a = $(this).val();
        // $("#" + a).show();
        // })

        // $('#wait_ds').hide();
        // $('#region').change(function() {
        // var getUid = $(this).val();
        // $('#wait_ds').show();
        // $.ajax({
        // url: "process.php?cnt=region",
        // method: "GET",
        // data: {
        // getUid: getUid
        // },
        // success: function(data) {
        // $('#ds_data').html(data);
        // $('#wait_ds').hide();
        // }
        // });
        // });
    </script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/tables-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Oct 2023 15:58:35 GMT -->

</html>