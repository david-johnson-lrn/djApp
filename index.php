<!-- Need to Do
1. Call DataAPI to pull all djApp tags 
2. Add Bootstrap to style
-->

<?php

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./Assets/style.css">
    <title>Document</title>
</head>

<body>

    <nav class="navbar navbar-dark bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/authorAPI.php">

                <button type="button" class="btn btn-outline-secondary"> AuthorAPI</button>


            </a>
            <a class="navbar-brand" href="./index.php">

                <button type="button" class="btn btn-outline-secondary"> Home</button>


            </a>

        </div>
    </nav>

    <!-- <a href="/authorAPI.php">
        <button> Author API </button>
    </a> -->

    <div class="container-fluid">

        <div class="col d-flex justify-content-center">

            <h1> Are you smarter than a Programmer?</h1>
        </div>

        <div class="col d-flex justify-content-center">

            <h1> Choose a Topic</h1>

        </div>

        <div class="col d-flex justify-content-center">


            <button type="button" name="topic" class="btn btn-outline-primary" value="Geography">Geography</button>
            <button type="button" name="topic" class="btn btn-outline-warning" value="Politics">Politics</button>
            <button type="button" name="topic" class="btn btn-outline-danger" value="History">History</button>



        </div>




        <h1> Choose a State</h1>




        <div class="col d-flex justify-content-center">

            <button type="button" name="state" value="NY" class="btn btn-outline-info">NY</button>
            <button type="button" name="state" value="NJ" class="btn btn-outline-danger">NJ</button>
            <button type="button" name="state" value="PA" class="btn btn-outline-success">PA</button>
            <button type="button" name="state" value="CT" class="btn btn-outline-warning">CT</button>
            <button type="button" name="state" value="MA" class="btn btn-outline-dark">MA</button>

        </div>





        <form action="./itemsAssess.php" method="GET">
            <input type="text" id="topic" name="topic" class="hide">
            <input type="text" id="state" name="state" class="hide">
            <input type="submit" class="hide" id="submitBtn" value="beginTest">
        </form>


    </div>










</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="./Assets/index.js">
    //need to get values from button clicks to send to another file to make API call of ItemsAPI assessment player
</script>


</html>