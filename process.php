<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

 if ($_GET['content'] == 'generic_name') {
    if ($_GET['getUid']) {
        $output = array();
        $project_id = $override->get('generic', 'id', $_GET['getUid']);
        foreach ($project_id as $name) {
            $output['maintainance'] = $name['maintainance'];
        }
        echo json_encode($output);
    }
}elseif($_GET['content'] == 'generic_id4'){
    $output = array();
    $all_generic = $override->get('medications', 'status', 1);
    foreach ($all_generic as $name) {
        $output[] = $name['name'];
    }
    echo json_encode($output);
} elseif ($_GET['content'] == 'generic_id5') {
    if ($_GET['getUid']) {
        $output = array();
        $project_id = $override->get('batch',  'status', 1);
        foreach ($project_id as $name) {
            // $output['name'] .= $name['name'];
            $output['category'] .= $name['category'];
            // $output['amount'] .= $name['amount'];
        }
        echo json_encode($output);
    }
} elseif ($_GET['content'] == 'generic_id6') {
    if ($_GET['getUid']) {
        $output = array();
        $project_id = $override->getNews('generic_location', 'generic_id', $_GET['getUid'], 'status', 1);
        foreach ($project_id as $name) {
            $output['notify_quantity'] .= $name['notify_quantity'];
        }
        echo json_encode($output);
    }
}
?>