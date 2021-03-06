<!-- Need to Do
1. Call DataAPI to pull all djApp tags 
2. Add Bootstrap to style
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;1,400;1,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./Assets/style.css">
    <title>Northeast Quiz</title>
</head>

<body style="background-color: F0F0F0">

    <nav class="navbar-dark bg-dark padding">

        <ul class="navbar-nav">
            <li class="nav-item">

                <a class="navbar-brand" href="/index.php">

                    <button type="button" class="btn btn-secondary navButton"> Home </button>


                </a>
            </li>

        </ul>

    </nav>

    <!-- <a href="/authorAPI.php">
        <button> Author API </button>
    </a> -->

    <div class="container-fluid">

        <section id="intro" class="card text-center moveDownFar">

            <h1 class="card-header title"> Would you like to test your knowledge?</h1>

            <div class="text-center card-body">
                <button id="yes" class="btn btn-outline-primary intro lightText">I think so..</button>
            </div>
        </section>

        <section id="content" class="hide card text-center moveDown">
            <h1 class="card-header darkText"> Choose a Topic</h1>

            <div class="card-body">

                <button type="button" name="topic" class="btn btn-outline-primary choice lightText" value="Geography">Geography</button>
                <button type="button" name="topic" class="btn btn-outline-warning choice lightText" value="Politics">Politics</button>
                <button type="button" name="topic" class="btn btn-outline-danger choice lightText" value="History">History</button>

            </div>


            <div class="card-header">
                <h1 class="darkText"> Choose a State</h1>
            </div>


            <div class="card-body">

                <button type="button" name="state" value="NY" class="btn btn-outline-info choice lightText">NY</button>
                <button type="button" name="state" value="NJ" class="btn btn-outline-danger choice lightText">NJ</button>
                <button type="button" name="state" value="PA" class="btn btn-outline-success choice lightText">PA</button>
                <button type="button" name="state" value="CT" class="btn btn-outline-warning choice lightText">CT</button>
                <button type="button" name="state" value="MA" class="btn btn-outline-dark choice lightText">MA</button>

            </div>

        </section>

        <div class="col d-flex justify-content-center moveDown">
            <form action="./itemsAssess.php" method="GET">
                <input type="text" id="topic" name="topic" class="hide">
                <input type="text" id="state" name="state" class="hide">
                <input type="submit" class="hide btnGlow btn btn-danger" id="submitBtn" value="beginTest">
            </form>
        </div>

    </div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="./Assets/index.js">
    //need to get values from button clicks to send to another file to make API call of ItemsAPI assessment player
</script>


</html>