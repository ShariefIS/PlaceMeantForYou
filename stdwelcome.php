

<?php

error_reporting(0);
session_start();
        if(!isset($_SESSION['stdname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
                unset($_SESSION['stdname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: index.php');
        }
?>
<html>
    <head>
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Placement preperation platform for Engineering Graduates to crack interviews, By Mr. Mohammed Imran.">
    <meta name="author" content="Mr. Mohammed Imran">
	<!--title-->
    <title>PlaceMeant Exam</title>  
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/animate.css" rel="stylesheet"/>
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/font.css" rel="stylesheet" />
	<link href="css/prettyPhoto.css" rel="stylesheet" />	
	<link href="css/main.css" rel="stylesheet" />
	<link href="css/responsive.css" rel="stylesheet"/>
        <link rel="shortcut icon" href="images/P.jpg">
        <style>
                      input[type=submit]{
                          display: inline-block;
                          border-radius: 25px;
                          background-color: black;
                          color: #ffe401;
                          border: none;
                          text-align: center;
                          font-size: 18px;
                          padding: 10px;
                          width: 100px;
                          margin: 5px;    
                      }

                      .center {
                          margin: auto;
                          width: 100%;
                          border: 3px solid #73AD21;
                          padding: 10px;

                      }
                      .button1 {
                          display: inline-block;
                          border-radius: 25px;
                          background-color: black;
                          border: none;
                          text-align: center;
                          font-size: 22px;
                          padding: 20px;
                          width: 300px;
                          transition: all 0.5s;
                          cursor: pointer;
                          margin: 5px;
                      }

                      .button1 span {
                          cursor: pointer;
                          display: inline-block;
                          position: relative;
                          transition: 0.5s;
                      }

                      .button1 span:after {
                          content: '\00bb';
                          position: absolute;
                          opacity: 0;
                          top: 0;
                          right: -20px;
                          transition: 0.5s;
                      }

                      .button1:hover span {
                          padding-right: 25px;
                      }

                      .button1:hover span:after {
                          opacity: 1;
                          right: 0;
                      }

                  </style>
    </head>
    <body style="background-color: #222222">
        <form name="stdwelcome" action="stdwelcome.php" method="post">    
            <header id="navigation">
                <div style="background-color: #262626" class="navbar main-nav" role="banner">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="index.php">
                                <h1><img class="img-responsive" src="images/logo.png" alt="logo"></h1>
                            </a>                    
                        </div>	
                        <nav class="collapse navbar-collapse navbar-right">					
                            <ul class="nav navbar-nav">
                                <li class="scroll active"><a href="index.html">Home</a></li> 

                                <?php if (isset($_SESSION['stdname'])) { ?>
                                    <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                                <?php } ?>
                            </ul>					
                        </nav>
                    </div>
                </div>
            </header><!--/#navigation--> 
        </form>

        <?php
        if ($_GLOBALS['message']) {
            echo '<div style="position:absolute;top:120px;background-color: lightcoral;color:lightgray">' . $_GLOBALS['message'] . '</div>';
        }
        ?>

        <div id="service" class="padding-top padding-bottom">		
            <div class="container text-center">
                <div class="row section-title">
                    <div class="col-md-6 col-md-offset-3">
                        <br><h3>Welcome to Placement Mock Quiz !</h3>
                        <hr class="title-border"></hr>

                        <?php if (isset($_SESSION['stdname'])) { ?>
                            <div class="center">

                                <button class="button1"><a href="viewresult.php" alt="View Results" title="Click to View Results"><span>View Results</span></a></button> 
                                <button class="button1">    <a href="stdtest.php" alt="Take a New Test" title="Take a New Test" ><span>Take Test</span></a></button> 
                                <button class="button1">    <a href="editprofile.php?edit=edit" alt="Edit Your Profile" title="Click this to Edit Your Profile." ><span>Edit Your Profile</span></a></button> 

                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
        <footer id="footer">
            <div class="container text-center">
                <p>Mohammed Imran &copy; copyright  <a href="index.html">Place Meant For You</a> All rights reserved.</p>
            </div>		
        </footer>

    </body>
</html>
