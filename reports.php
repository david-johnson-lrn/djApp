<?php
require_once 'sdk/src/LearnositySdk/autoload.php';

use LearnositySdk\Request\Init;

//need to create $user variable and $session variable from the GET URL to plug in below

$consumer_key = 'downloaddemo4o7M';

$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

$security = [
    'consumer_key' => $consumer_key,
    'domain' => $_SERVER["HTTP_HOST"]
];

$session_id = $_GET['session'];
$user = $_GET['user'];

// echo $user, "<br>";
// echo $session_id;



$request = [
    'reports' => [
        [
            'id' => 'report1', //name of DOM HTML Hook
            'type' => 'sessions-summary-by-question',
            'user_id' => 'testTaker',
            'session_ids' => [
                $session_id
            ]
        ],
        [
            'id' => 'report2',
            'type' => 'sessions-summary-by-tag',
            'user_id' => $user,
            'hierarchy_reference' => 'djHierarchy',
            'session_ids' => [
                $session_id
            ]

        ],
        [
            'id' => 'report3',
            'type' => 'session-detail-by-item',
            'user_id' => $user,
            'session_id' => $session_id
            //, 'questions_api_init_options' => ['showCorrectAnswers' => true]

        ]

    ]
];

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./Assets/style.css">
    <title>How did you Do?</title>
</head>

<body>

    <nav class="navbar navbar-dark bg-light">
        <div class="container-fluid">

            <a class="navbar-brand" href="./index.php">

                <button type="button" class="btn btn-outline-secondary"> Home</button>


            </a>

        </div>
    </nav>

    <div class="container-fluid">
        <h1>Take a look at your results below!</h1>


        <div class="col d-flex justify-content-center">
            <h4>Report 1 "Sessions - Summary"</h4>
        </div>
        <span class="learnosity-report" id="report1"></span>
        <hr>

        <div class="col d-flex justify-content-center">
            <h4>Report 2 "Sessions - Summary - By - Tag"</h4>
        </div>
        <span class="learnosity-report" id="report2"></span>
        <hr>

        <div class="col d-flex justify-content-center">
            <h4>Report 3 "Sessions - Detail - By - Item"</h4>
        </div>
        <span class="learnosity-report" id="report3"></span>


    </div>

    <script src="//reports.learnosity.com"></script>

    <script>
        let lrnReports = LearnosityReports.init(<?php echo $signedRequest; ?>, {
            readyListener: function() {
                console.log("Report Listener Fired")
            }
        });
    </script>

</body>

</html>