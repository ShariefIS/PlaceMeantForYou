


<?php

error_reporting(0);
session_start();
include_once 'oesdb.php';
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout']))
{
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    header('Location: index.php');

}
else if(isset($_REQUEST['dashboard'])){
    //redirect to dashboard
   
     header('Location: stdwelcome.php');

}
if(isset($_SESSION['starttime']))
{
    unset($_SESSION['starttime']);
    unset($_SESSION['endtime']);
    unset($_SESSION['tqn']);
    unset($_SESSION['qn']);
    unset($_SESSION['duration']);
    executeQuery("update studenttest set status='over' where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].";");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Placement preperation platform for Engineering Graduates to crack interviews, By Mr. Mohammed Imran.">
    <meta name="author" content="Mr. Mohammed Imran">
	<!--title-->
	<!--title-->
    <title>PlaceMeant Exam</title>
	
	<!--CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/animate.css" rel="stylesheet"/>
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/font.css" rel="stylesheet" />
	<link href="css/prettyPhoto.css" rel="stylesheet" />	
	<link href="css/main.css" rel="stylesheet" />
	<link href="css/responsive.css" rel="stylesheet"/>	
    
    <script type="text/javascript" src="validate.js" ></script>
    </head>
      <body style="background-color: #222222">
          <?php
          if ($_GLOBALS['message']) {
              echo '<div style="position:absolute;top:120px;background-color: lightcoral;color:lightgray">' . $_GLOBALS['message'] . '</div>';
          }
          ?>
          <header id="navigation">
              <div style="background-color: #101010" class="navbar main-nav" role="banner">
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
                              <?php
                              if (isset($_SESSION['stdname'])) {
                                  // Navigations
                                  ?>
                                  <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                                  <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>

                              </ul>					
                          </nav>
                      </div>
                  </div>
              </header><!--/#navigation--> 

              <div id="service" class="padding-top padding-bottom">		
                  <div class="container text-center">
                      <div class="row section-title">
                          <br>
                              <h3>Congratulations Text Completed !</h3>
                              <hr class="title-border"></hr>

                              <div style="background-color:lightcoral;"><br><h3 style="color:#0000cc;text-align:center;">Your answers are Successfully Submitted. <br><br></br>To view the Results <b><a href="viewresult.php">Click Here</a></b> </h3><br></div>          <?php
                          }
                          ?>
                  </div>
              </div>
          </div>

          </form>
          <footer id="footer">
              <div class="container text-center">
                  <p>Mohammed Imran &copy; copyright  <a href="index.html">Place Meant For You</a> All rights reserved.</p>
              </div>		
          </footer>
      </body>
</html>

