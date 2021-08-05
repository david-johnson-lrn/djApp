<?php

require_once 'sdk/src/LearnositySdk/autoload.php';

use LearnositySdk\Request\Init;

$consumer_key = 'downloaddemo4o7M';
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

$security = [
    'consumer_key' => $consumer_key,
    'domain' => 'localhost'
];

$request = [
    'mode' => 'item_list',
    'config' => [
        'item_edit' => [
            'item' => [
                'save' => true,
                'reference' => [
                    'edit' => true,
                    'show' => true
                ]
            ]
        ]
    ],
    'user' => [
        'id' => 'dj'
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);

$signed_request = $Init->generate();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuthorAPI Edit</title>
</head>

<body>


    <div id="learnosity-author"></div>


    <script src="//authorapi.learnosity.com?v2020.2.LTS"></script>
    <script>
        let authorApp = LearnosityAuthor.init(<?php echo $signed_request; ?>, {
            readyListener: function() {
                console.log("ready listener fired");

                // authorApp.on('save', function(e) {

                //     authorApp.setItemTags([{
                //         "type": 'djApp',
                //         'name': 'djApp'
                //     }])


                // }); 
                //commented out because each time I save it is overwriting my tags added from the Author Site


            }
        })
    </script>
    <a href="/index.php"><button>Home</button></a>


</body>

</html>