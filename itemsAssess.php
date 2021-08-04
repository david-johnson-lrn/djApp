<?php

$topic = $_GET['topic'];
$state = $_GET['state'];
$items = [];

echo "Your topic is {$topic} and you picked {$state} as your state";

//Need to render ItemsAPI in Assess mode using specific tags.  First all djApp tags, then GET variable tags
require_once 'sdk/src/LearnositySdk/autoload.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Request\DataApi;
use LearnositySdk\Utils\Uuid;

$consumer_key = 'downloaddemo4o7M';
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

//Security Object
$security = [
    'consumer_key' => $consumer_key,
    'domain' => 'localhost'
];

$endpoint = 'https://data.learnosity.com/v2021.2.LTS/itembank/items';

//Request Data
$request_data = [
    'advanced_tags' => [
        'all' => [
            [
                'type' => 'djApp',
                'name' => 'djApp'
            ],
            [
                "type" => 'djAppState',
                'name' => $state
            ],
            [
                "type" => 'djAppTopic',
                'name' => $topic
            ]
            //can I add another all option and use a variable for the ;name' and 'topic'?
        ]
    ]
    //could enter either parameter here or potentially another all
];

$lrnData = new DataApi();
$dataRequest = $lrnData->request($endpoint, $security, $consumer_secret, json_encode($request_data), $action);

$body = $dataRequest->getBody();

$dataAPI_response = json_decode($body, true);


?>
<pre>
<?php
print_r($dataAPI_response);
?>

</pre>

<?php

// var_dump($dataAPI_response);


if (count($dataAPI_response['data']) > 0) {
    for ($i = 0; $i < count($dataAPI_response['data']); $i++) {
        array_push($items, $dataAPI_response['data'][$i]['reference']);
    }
}

// var_dump($items);



//Create loop to push through reference names into array to serve up just in time assessment

$session_id = Uuid::generate();
$activity_id = $session_id;

//Request object Just In Time Fixed Form Assessment, Need to feed Item Referenes
$request = [
    'user_id' => 'testTaker',
    'rendering_type' => 'assess',
    'name' => 'djApp Items API Assess Player',
    'session_id' => $session_id,
    'activity_id' => $activity_id,
    'items' => $items, //<----- This is an array which dynamically adds reference names found in dataAPI pull using the loop on line 70
    'type' => 'submit_practice',
    'config' => [
        'title' => 'djApp Asses Player',
        'subtitle' => 'answer if you can'
    ]


];

$Init = new Init('items', $security, $consumer_secret, $request);

$signedRequest = $Init->generate();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Test Player</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-light">
        <div class="container-fluid">

            <a class="navbar-brand" href="./index.php">

                <button type="button" class="btn btn-outline-secondary"> Home</button>


            </a>

        </div>
    </nav>


    <div id="learnosity_assess"></div> <!-- This is where the test lives -->

    <script src="//items.learnosity.com?v2021.2.LTS"></script>

    <script>
        let itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, {
            readyListener: function() {
                console.log("Listener Fired");

            }
        })
    </script>

</body>

</html>