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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHARTJS</title>
    <style type="text/css">
        .chartBox {
            width: 700px;
        }
    </style>
</head>

<body>
    <?php
    $barchart = $override->getData('barchart');
    $revenue = array();
    foreach ($barchart as $value) {
        $revenue[] = $value['revenue'];
    }
    print_r($revenue);


    ?>



    <div class="chartBox">
        <canvas id="myChart"></canvas>
        <!-- <canvas id="myChart" width="400" height="400"></canvas> -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        // SETUP BLOCK

        console.log(<?php echo json_encode($revenue) ?>)
        const data = {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255,99,132,0.2)',
                    'rgba(54,162,235,0.2)',
                    'rgba(255,206,86,0.2)',
                    'rgba(75,192,192,0.2)',
                    'rgba(153,102,255,0.2)',
                    'rgba(255,159,64,0.2)',
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54,162,235,1)',
                    'rgba(255,206,86,1)',
                    'rgba(75,192,192,1)',
                    'rgba(153,102,255,1)',
                    'rgba(255,159,64,1)',
                ],
                borderWidth: 1
            }]
        }
        //CONFIG BLOCK
        const config = {
            type: 'bar',
            data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }

        //RENDER BLOCK
        const myChart = new Chart(document.getElementById('myChart'), config);
    </script>

</body>

</html>