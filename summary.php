

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
    //
     header('Location: stdwelcome.php');

    }
    else if(isset($_REQUEST['change']))
    {
        //redirect to testconducter
       
       $_SESSION['qn']=substr($_REQUEST['change'],7);
       header('Location: testconducter.php');

    }
    else if(isset($_REQUEST['finalsubmit'])){
    //redirect to dashboard
    //
     header('Location: testack.php');

    }
     else if(isset($_REQUEST['fs'])){
    //redirect to dashboard
    //
     header('Location: testack.php');

    }

   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
  <head><meta charset="utf-8">
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
                          width: 150px;
                          margin: 5px;    
                      }
                      table {
                          border-collapse: collapse;
                          width: 100%;
                          background-color: whitesmoke;
                      }

                      th, td {
                          padding: 8px;
                          text-align: left;
                          border-bottom: 1px solid #ddd;
                      }

</style>
            
    <script type="text/javascript" src="validate.js" ></script>
    <script type="text/javascript" src="cdtimer.js" ></script>
    <script type="text/javascript" >
    <!--
        <?php
                $elapsed=time()-strtotime($_SESSION['starttime']);
                if(((int)$elapsed/60)<(int)$_SESSION['duration'])
                {
                    $result=executeQuery("select TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%H') as hour,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%i') as min,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%s') as sec from studenttest where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid'].";");
                    if($rslt=mysql_fetch_array($result))
                    {
                     echo "var hour=".$rslt['hour'].";";
                     echo "var min=".$rslt['min'].";";
                     echo "var sec=".$rslt['sec'].";";
                    }
                    else
                    {
                        $_GLOBALS['message']="Try Again";
                    }
                    closedb();
                }
                else
                {
                    echo "var sec=01;var min=00;var hour=00;";
                }
        ?>

    -->
    </script>


    </head>
    <body style="background-color: #222222">
        <form id="summary" action="summary.php" method="post">
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

                                <?php
                                if (isset($_SESSION['stdname'])) {
                                    // Navigations
                                    ?>
                                </ul>					
                            </nav>
                        </div>
                    </div>
                </header><!--/#navigation--> 


                <?php
                if ($_GLOBALS['message']) {
                    echo '<div style="position:absolute;top:120px;background-color: lightcoral;color:lightgray">' . $_GLOBALS['message'] . '</div>';
                }
                ?>
                <div id="service" class="padding-top padding-bottom">		
                    <div class="container text-center">
                        <div class="row section-title">
                            <br>
                                <h3>Test Summary</h3>
                                <hr class="title-border"></hr>
                                <table border="0" width="100%" >
                                    <tr>
                                        <th style="width:40%;">Time Remaining :<h3 style="color: #222222"><span style="color: #f9c803" id="timer" class="timerclass"></span></h3></th>

                                    </tr>
                                </table>
                                <?php
                                $result = executeQuery("select * from studentquestion where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . " order by qnid ;");
                                if (mysql_num_rows($result) == 0) {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Please Try Again.</h3>";
                                } else {
                                    //editing components
                                    ?>
                                    <table cellpadding="30" cellspacing="10" >
                                        <tr>
                                            <th>Question No</th>
                                            <th>Status</th>
                                            <th>Change Your Answer</th>
                                        </tr>
        <?php
        while ($r = mysql_fetch_array($result)) {
            $i = $i + 1;
            if ($i % 2 == 0) {
                echo "<tr class=\"alt\">";
            } else {
                echo "<tr>";
            }
            echo "<td>" . $r['qnid'] . "</td>";
            if (strcmp(htmlspecialchars_decode($r['answered'], ENT_QUOTES), "unanswered") == 0 || strcmp(htmlspecialchars_decode($r['answered'], ENT_QUOTES), "review") == 0) {
                echo "<td style=\"text-transform:uppercase;color:#ff0000;\">" . htmlspecialchars_decode($r['answered'], ENT_QUOTES) . "</td>";
            } else {
                echo "<td style=\"text-transform:uppercase\">" . htmlspecialchars_decode($r['answered'], ENT_QUOTES) . "</td>";
            }
            echo"<td><input type=\"submit\" value=\"Change " . $r['qnid'] . "\" name=\"change\" class=\"ssubbtn\" /></td></tr>";
        }
        ?>
                                        <tr>
                                            <td colspan="3" style="text-align:center;"><input type="submit" name="finalsubmit" value="Final Submit" class="subbtn"/></td>
                                        </tr>
                                    </table>
                                        <?php
                                    }
                                    closedb();
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

