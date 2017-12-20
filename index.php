<?php
session_Start();
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Home</title>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" >
        <link rel="stylesheet" href="CSS/no_dashboard_css_template.css"> 
        <link rel="stylesheet" href= "CSS/HomePageSpecifics.css">

    </head>

    <body>



        <!-- NAVIGATION BAR -->     

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <img id="logo" src="logo.png">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a> 
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="LoginPage.php">Log in</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Main CONTAINER part of the page WHERE MOST PAGE CONTENT WILL GO -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1> Welcome to Engineering Careers </h2>
                        <p> Welcome! We are a platform for potential employees and event Hosts, bringing a bridge between the two. Sign up or Log in to view all the events available to you. Perhaps you are interested in hosting an event? then please click I'm hosting an event!</p>
                </div>
                <div class="col-lg-4">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="Images/Career_Fair-1.jpg" alt="First slide">
                                <!--Image file taken from https://www.luc.edu/career/careerfairsandevents/-->
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="Images/C.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="Images/B.jpg" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>    
            <div class="row">
                <h2>New to Engineering Careers? Sign up below!</h2>

            </div>

            <div class="row" id="optiontitle">
                <h2>Which one are you?</h2>
            </div>
            <div class="row">
                <div class="col" id="potemp">
                    <button type="button" class="btn btn-dark"><a href='CreatePotentialEmployee.php'>I'm a potential Employee!</a></button>
                </div>
                <div class="col" id="hostsi">
                    <button type="button" class="btn btn-dark"><a href='CreateHostUser.php'>I'm Hosting a Career Event!</a></button>
                </div>
            </div>

        </div>

        <!-- EMPLOYEE SIGN UP AREA END -->
        <script>

        </script>
        <!-- Optional JavaScript -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" ></script>

    </body>
</html>