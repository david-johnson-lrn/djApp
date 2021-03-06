<?php

$topic = $_GET['topic'];
$state = $_GET['state'];
$items = [];
$total_item_pool = [];

//Need to render ItemsAPI in Assess mode using specific tags.  First all djApp tags, then GET variable tags
require_once 'sdk/src/LearnositySdk/autoload.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Request\DataApi;
use LearnositySdk\Utils\Uuid;

$consumer_key = 'downloaddemo4o7M';
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

if (substr($_SERVER["HTTP_HOST"], 0, 9) === "localhost") {
    $domain = "localhost";
} else {
    $domain = $_SERVER["HTTP_HOST"];
}

//Security Object
$security = [
    'consumer_key' => $consumer_key,
    //'domain' => $_SERVER["HTTP_HOST"]
    'domain' => $domain
    //if error arises that items array needs at least one item, change domain to 'localhost"
];

$endpoint = 'https://data.learnosity.com/v2021.2.LTS/itembank/items';

//Request Data
$request_data = [
    //maybe I can create a loop to have the user select more than one topic per category
    'advanced_tags' => [
        'all' => [
            [
                'type' => 'djApp',
                'name' => 'djApp'
            ]
        ]
    ]
];

$lrnData = new DataApi();
$dataRequest = $lrnData->request($endpoint, $security, $consumer_secret, json_encode($request_data), $action);

$body = $dataRequest->getBody();

$dataAPI_response = json_decode($body, true);

if (count($dataAPI_response['data']) > 0) {
    for ($i = 0; $i < count($dataAPI_response['data']); $i++) {
        array_push($total_item_pool, $dataAPI_response['data'][$i]['reference']);
    }
}
//Compose test of choices incase additional options are not selected
$request_data_choice = [
    'advanced_tags' => [
        'all' => [
            [
                'type' => 'djApp',
                'name' => 'djApp'
            ], [
                "type" => 'djAppState',
                'name' => $state
            ],
            [
                "type" => 'djAppTopic',
                'name' => $topic
            ]
        ]
    ]
];

$lrnData = new DataApi();
$dataRequestChoice = $lrnData->request($endpoint, $security, $consumer_secret, json_encode($request_data_choice), $action);

$body_choice = $dataRequestChoice->getBody();

$dataAPI_response_choice = json_decode($body_choice, true);

//Create loop to push through reference names into array to serve up just in time assessment
if (count($dataAPI_response_choice['data']) > 0) {
    for ($i = 0; $i < count($dataAPI_response_choice['data']); $i++) {
        array_push($items, $dataAPI_response_choice['data'][$i]['reference']);
    }
}

//loop through total items array and remove the selected tags to avoid duplicate items selected in add item randomization
for ($i = 0; $i < 2; $i++) {
    $search = array_search($items[$i], $total_item_pool);

    unset($total_item_pool[$search]);
}

$session_id = Uuid::generate();
$activity_id = $session_id;

//Request object Just In Time Fixed Form Assessment, Need to feed Item Referenes

$request = [
    'user_id' => 'testTaker',
    'rendering_type' => 'assess',
    'name' => 'djApp Items API Assess Player',
    // 'state' => 'initial',
    'session_id' => $session_id,
    'activity_id' => $activity_id,
    'items' => $items, //<----- This is an array which dynamically adds reference names found in dataAPI pull
    'type' => 'submit_practice',
    'config' => [
        'title' => 'djApp Assess Player',
        'subtitle' => 'answer if you can',
        'regions' => 'main',
        'configuration' => [
            'responsive_regions' => true
        ]
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- Bootstrap 5 is causing the cloze block to change styling when clicked and dragged.  The heigh 100% on the lrn_btn_drag specificallt -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="./Assets/style.css">
    <title>Test Player</title>
</head>

<body>
    <div class="container-fluid">

        <nav class="navbar-dark bg-light padding">
            <ul class="navbar-nav">
                <li class="nav-item">

                    <a class="navbar-brand" href="./index.php">
                        <button type="button" class="btn btn-outline-info navButton"> Home</button>
                    </a>
                </li>
                <li class="nav-item">

                    <button type="button" id="add" class="btn btn-outline-info navButton"> add Item?</button>
                </li>
            </ul>
        </nav>

        <div id="nav" class="col d-flex justify-content-center moveDown"></div>

    </div>
    <div id="learnosity_assess"></div> <!-- This is where the test lives -->

    <script src="//items.learnosity.com?v2021.2.LTS"></script>

    <script>
        let itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, {
            readyListener: function() {
                console.log("Listener Fired");
                console.log("The state chosen was: <?php echo $state; ?> and topic chosen was: <?php echo $topic; ?>")

                let session = "<?php echo $session_id ?>";
                console.log(session)
                let allItems = Object.values(<?php echo json_encode($total_item_pool) ?>);
                let extraQ = [];
                let count = 2;
                let add = document.getElementById("add");

                add.addEventListener("click", function() {
                    console.log(allItems)
                    console.log("questions are now: " + count)

                    if (count >= 30) {
                        alert("You have a total of " + count + " questions.  30 is the most number of questions we can offer.")
                    } else {
                        console.log(allItems.length);
                        let number = parseInt(prompt("How many random questions would you like to add? Choose a number 1 through 28."));
                        if (number <= 28 && number <= allItems.length) {
                            count += parseInt(number);
                            console.log("total number of questions is now:" + count);

                            for (let i = 0; i < number; i++) {
                                let randomNumber = (Math.floor(Math.random() * allItems.length))
                                console.log(randomNumber);
                                extraQ.push(allItems[randomNumber])
                                allItems.splice(randomNumber, 1)
                            }
                            console.log(extraQ);

                            itemsApp.addItems({
                                items: extraQ,
                                removePreviousItems: false
                            })
                            extraQ = [];

                        } else {
                            alert("Invalid number.  There are only " + allItems.length + " questions left to choose from.")
                        }
                    }
                })

                itemsApp.on('test:submit', function() {
                    console.log("Test is done")
                    let add = document.getElementById("add");
                    add.classList.add("hide")
                })

                itemsApp.on('test:finished:submit', function() {
                    window.location.href =
                        "/reports.php?user=testTaker&session=" + session;
                    console.log(location.hostname);
                })

                itemsApp.on('item:pause', function() {
                    let add = document.getElementById("add").scrollIntoView();
                    console.log("Paused")

                })
            }
        })
    </script>

</body>

</html>