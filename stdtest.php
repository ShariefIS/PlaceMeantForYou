


<?php

error_reporting(0);
session_start();
include_once 'oesdb.php';
if (!isset($_SESSION['stdname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_SESSION['starttime'])) {
    header('Location: testconducter.php');
} else if (isset($_REQUEST['logout'])) {
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    header('Location: index.php');
} else if (isset($_REQUEST['dashboard'])) {
    //redirect to dashboard
    //
    header('Location: stdwelcome.php');
} else if (isset($_REQUEST['starttest'])) {
    //Prepare the parameters needed for Test Conducter and redirect to test conducter
    if (!empty($_REQUEST['tc'])) {
        $result = executeQuery("select DECODE(testcode,'oespass') as tcode from test where testid=" . $_SESSION['testid'] . ";");

        if ($r = mysql_fetch_array($result)) {
            if (strcmp(htmlspecialchars_decode($r['tcode'], ENT_QUOTES), htmlspecialchars($_REQUEST['tc'], ENT_QUOTES)) != 0) {
                $display = true;
                $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
            } else {
                //now prepare parameters for Test Conducter and redirect to it.
                //first step: Insert the questions into table

                $result = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid;");
                if (mysql_num_rows($result) == 0) {
                    $_GLOBALS['message'] = "Tests questions cannot be selected.Please Try after some time!";
                } else {
                  //  executeQuery("COMMIT");
                    $error = false;
                //    executeQuery("delimiter |");
                 /*   if (!executeQuery("create event " . $_SESSION['stdname'] . time() . "
ON SCHEDULE AT (select endtime from studenttest where stdid=" . $_SESSION['stdid'] . " and testid=" . $_SESSION['testid'] . ") + INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE
DO update studenttest set correctlyanswered=(select count(*) from studentquestion as sq,question as q where sq.qnid=q.qnid and sq.testid=q.testid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=" . $_SESSION['stdid'] . " and sq.testid=" . $_SESSION['testid'] . "),status='over' where stdid=" . $_SESSION['stdid'] . " and testid=" . $_SESSION['testid'] . "|"))
                        $_GLOBALS['message'] = "error" . mysql_error();
                    executeQuery("delimiter ;");*/
                    if (!executeQuery("insert into studenttest values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE),0,'inprogress')"))
                        $_GLOBALS['message'] = "error" . mysql_error();
                    else {
                        while ($r = mysql_fetch_array($result)) {
                            if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL)")) {
                                $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                                $error = true;
                            }
                        }
                        if ($error == true) {
                      //      executeQuery("rollback;");
                        } else {
                            $result = executeQuery("select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";");
                            $r = mysql_fetch_array($result);
                            $_SESSION['tqn'] = htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES);
                            $_SESSION['duration'] = htmlspecialchars_decode($r['duration'], ENT_QUOTES);
                            $result = executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . ";");
                            $r = mysql_fetch_array($result);
                            $_SESSION['starttime'] = $r['startt'];
                            $_SESSION['endtime'] = $r['endt'];
                            $_SESSION['qn'] = 1;
                            header('Location: testconducter.php');
                        }
                    }
                }
            }
        } else {
            $display = true;
            $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
        }
    } else {
        $display = true;
        $_GLOBALS['message'] = "Enter the Test Code First!";
    }
} else if (isset($_REQUEST['testcode'])) {
    //test code preparation
    if ($r = mysql_fetch_array($result = executeQuery("select testid from test where testname='" . htmlspecialchars($_REQUEST['testcode'], ENT_QUOTES) . "';"))) {
        $_SESSION['testname'] = $_REQUEST['testcode'];
        $_SESSION['testid'] = $r['testid'];
    }
} else if (isset($_REQUEST['savem'])) {
    //updating the modified values
    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','oespass'),emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . $_REQUEST['student'] . "';";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Your Profile is Successfully Updated.";
    }
    closedb();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
       <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Placement preperation platform for Engineering Graduates to crack interviews, By Mr. Mohammed Imran.">
    <meta name="author" content="Mr. Mohammed Imran">
        <style>
            .help
{
    background-color:#ff99cc;
    color:#ffffff;
    font-size:0.6em;
    font-weight:bolder;
    padding:2%;

}
  .pmsg{
font: italic 2em/1em   "Verdana";
width:98.8%;
margin:0;
padding:2px 5px 2px 5px;
 text-transform: uppercase;
text-align: center;
margin: 0;
color: #e7ce00;
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

tr:hover{background-color:#ffd633}
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
        </style>
	<!--title-->
    <title>PlaceMeant Exam</title>
	
	<!--CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/animate.css" rel="stylesheet"/>
    <link href="css/font-awesome.min.css" rel="stylesheet"/>
    <link href="css/font.css" rel="stylesheet"/>
	<link href="css/prettyPhoto.css" rel="stylesheet"/>	
	<link href="css/main.css" rel="stylesheet"/>
	<link href="css/responsive.css" rel="stylesheet"/>	
	<link rel="shortcut icon" href="images/P.jpg"/>
        <script type="text/javascript" src="validate.js" ></script>
    </head>
    <body style="background-color: #222222">
        <form id="stdtest" action="stdtest.php" method="post">
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
                                    if (isset($_REQUEST['details'])) {
                                        ?>
                                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                                        <li><input type="submit" value="Back" name="back" class="subbtn" title="View Results"/></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>
                                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                                        <?php
                                    }
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
                                <h3>Welcome to Placement Mock Quiz !</h3>
                                <hr class="title-border"></hr>


                                <?php
                                if (isset($_REQUEST['testcode'])) {
                                    echo "<div class=\"pmsg\" style=\"text-align:center;\">What is the Code of " . $_SESSION['testname'] . " ? </div>";
                                } else {
                                    echo "<div class=\"pmsg\" style=\"text-align:center;\">Offered Tests</div>";
                                }
                                ?>
                                <?php
                                if (isset($_REQUEST['testcode']) || $display == true) {
                                    ?>
                                <br><table cellpadding="30" cellspacing="10" style="background-color: whitesmoke;">
                                        <tr>
                                            <td>Enter Test Code</td>
                                            <td><input type="text" tabindex="1" name="tc" value="" size="16" /></td>
                                            <td><div class="help"><b>Note:</b><br/>Once you press start test<br/>button timer will be started</div></td>
                                        </tr>
                                        <tr>
                                            <td>&nbs&nbsp;</td>
                                            <td colspan="3">
                                                <input type="submit" tabindex="3" value="Start Test" name="starttest" class="subbtn" />
                                            </td>
                                        </tr>
                                    </table>


                                    <?php
                                } else {
                                    $result = executeQuery("select t.*,s.subname from test as t, subject as s where s.subid=t.subid and CURRENT_TIMESTAMP<t.testto and t.totalquestions=(select count(*) from question where testid=t.testid) and NOT EXISTS(select stdid,testid from studenttest where testid=t.testid and stdid=" . $_SESSION['stdid'] . ");");
                                    if (mysql_num_rows($result) == 0) {
                                        echo"<div style=\"background-color:lightcoral;\"><br><h3 style=\"color:#0000cc;text-align:center;\">Sorry...! For this moment,<br><br>You have not Offered to take any tests.</h3><br></div>";
                                    } else {
                                        //editing components
                                        ?>
                                        <br><table cellpadding="30" cellspacing="10" style="background-color: whitesmoke;">
                                            <tr>
                                                <th>Test Name</th>
                                                <th>Test Description</th>
                                                <th>Subject Name</th>
                                                <th>Duration</th>
                                                <th>Total Questions</th>
                                                <th>Take Test</th>
                                            </tr>
                                            <?php
                                            while ($r = mysql_fetch_array($result)) {
                                                $i = $i + 1;
                                                if ($i % 2 == 0) {
                                                    echo "<tr class=\"alt\">";
                                                } else {
                                                    echo "<tr>";
                                                }
                                                echo "<td>" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['testdesc'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                                                . "</td><td>" . htmlspecialchars_decode($r['duration'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES) . "</td>"
                                                . "<td class=\"tddata\"><a title=\"Start Test\" href=\"stdtest.php?testcode=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"><img src=\"images/starttest.png\" height=\"30\" width=\"40\" alt=\"Start Test\" /></a></td></tr>";
                                            }
                                            ?>
                                        </table>
                                        <?php
                                    }
                                    closedb();
                                }
                            }
                            ?>

                    </div>

                    </form>
                    <footer id="footer">
                        <div class="container text-center">
                            <p>Mohammed Imran &copy; copyright  <a href="index.html">Place Meant For You</a> All rights reserved.</p>
                        </div>		
                    </footer>
    </body>
<</html>

