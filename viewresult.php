<?php
error_reporting(0);
session_start();
include_once 'oesdb.php';
$result = executeQuery("SET time_zone = '+5:30'");
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout'])) {
    //Log out and redirect login page
        unset($_SESSION['stdname']);
        header('Location: index.php');

    }
    else if(isset($_REQUEST['back'])) {
        //redirect to View Result

            header('Location: viewresult.php');

        }
        else if(isset($_REQUEST['dashboard'])) {
        //redirect to dashboard

            header('Location: stdwelcome.php');

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
	
	<!--title-->
    <title>PlaceMeant Exam</title>
	
	<!--CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/font.css" rel="stylesheet">
	<link href="css/prettyPhoto.css" rel="stylesheet">	
	<link href="css/main.css" rel="stylesheet">
            <link href="css/responsive.css" rel="stylesheet"></link>
            <script type="text/javascript" src="validate.js" ></script>
            <script>
	$(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });

    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>
          <style>
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
    <link rel="shortcut icon" href="images/P.jpg">
  </head>

    <body style="background-color: #222222">
        <form id="summary" action="viewresult.php" method="post">
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
                                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                                        <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>
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
                            <h3>View Results Details</h3>
                            <hr class="title-border"></hr>
                            <?php
                            if (isset($_REQUEST['details'])) {
                                $result = executeQuery("select s.stdname,t.testname,sub.subname,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as stime,TIMEDIFF(st.endtime,st.starttime) as dur,(select sum(marks) from question where testid=" . $_REQUEST['details'] . ") as tm,IFNULL((select sum(q.marks) from studentquestion as sq, question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=" . $_SESSION['stdid'] . " and sq.testid=" . $_REQUEST['details'] . "),0) as om from student as s,test as t, subject as sub,studenttest as st where s.stdid=st.stdid and st.testid=t.testid and t.subid=sub.subid and st.stdid=" . $_SESSION['stdid'] . " and st.testid=" . $_REQUEST['details'] . ";");
                                if (mysql_num_rows($result) != 0) {

                                    $r = mysql_fetch_array($result);
                                    ?>

                                    <table cellpadding="20" cellspacing="30" border="0" >
                                        <tr>
                                            <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Test Summary</h3></td>
                                        </tr>

                                        <tr>
                                            <td>Student Name</td>
                                            <td><?php echo htmlspecialchars_decode($r['stdname'], ENT_QUOTES); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Test</td>
                                            <td><?php echo htmlspecialchars_decode($r['testname'], ENT_QUOTES); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Subject</td>
                                            <td><?php echo htmlspecialchars_decode($r['subname'], ENT_QUOTES); ?></td>
                                        </tr>
                                        <tr>
                                            <td >Date and Time</td>
                                            <td><?php echo $r['stime']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Test Duration</td>
                                            <td><?php echo $r['dur']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Max. Marks</td>
                                            <td><?php echo $r['tm']; ?></td>
                                        </tr><tr>
                                            <td>Pass Percentage </td>
                                            <td><?php echo "75%"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Obtained Marks</td>
                                            <td><?php echo $r['om']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Percentage</td>
                                            <td><?php echo (($r['om'] / $r['tm']) * 100) . " %"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Result </td>
                                            <td><?php
                                                if ((($r['om'] / $r['tm']) * 100) < 75) {
                                                    echo '<p style="color:red">Failed</p>';
                                                    echo '<br><b>Remarks</b>';
                                                    echo '<br><p>You havent reached the passing score , Prepare well !!<br>Advice you to check the concepts of the question where you went wrong.<br>As these are your weaknesses and try to change those weaknesses into strenghts by practicing those concepts. </p>';
                                                } else {
                                                    echo '<p style="color:green">Passed</p>';
                                                    echo '<br><b>Remarks</b>';
                                                    echo '<br><p>Good Score All the Best for Future test and Interviews.</p>';
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" ><hr style="color:#ff0000;border-width:2px;"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Test Information in Detail</h3></td>
                                        </tr>

                                    </table>
                                    <?php
                                    $result1 = executeQuery("select q.eimg as eimg,q.exp as expl,q.img as img,q.qnid as questionid,q.question as quest,q.correctanswer as ca,sq.answered as status,sq.stdanswer as sa from studentquestion as sq,question as q where q.qnid=sq.qnid and sq.testid=q.testid and sq.testid=" . $_REQUEST['details'] . " and sq.stdid=" . $_SESSION['stdid'] . " order by q.qnid;");

                                    /* if(mysql_num_rows($result1)==0) {
                                      echo"<h3 style=\"color:#0000cc;text-align:center;\">1.Sorry because of some problems Individual questions Cannot be displayed.</h3>";
                                      }
                                      else { */
                                    ?>
                                    <table cellpadding="30" cellspacing="10" >
                                        <tr>
                                            <th>Q. No</th>
                                            <th>Question</th>
                                            <th>Correct Answer</th>
                                            <th>Explanation</th>
                                            <th>Your Answer</th>
                                            <th>Score</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        <?php
                                        while ($r1 = mysql_fetch_array($result1)) {

                                            if (is_null($r1['sa']))
                                                $r1['sa'] = "question"; //any valid field of question
                                            $result2 = executeQuery("select " . $r1['ca'] . " as corans,IF('" . $r1['status'] . "'='answered',(select " . $r1['sa'] . " from question where qnid=" . $r1['questionid'] . " and testid=" . $_REQUEST['details'] . "),'unanswered') as stdans, IF('" . $r1['status'] . "'='answered',IFNULL((select q.marks from question as q, studentquestion as sq where q.qnid=sq.qnid and q.testid=sq.testid and q.correctanswer=sq.stdanswer and sq.stdid=" . $_SESSION['stdid'] . " and q.qnid=" . $r1['questionid'] . " and q.testid=" . $_REQUEST['details'] . "),0),0) as stdmarks from question where qnid=" . $r1['questionid'] . " and testid=" . $_REQUEST['details'] . ";");

                                            if ($r2 = mysql_fetch_array($result2)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $r1['questionid']; ?></td>
                                                    <td style="text-align:justify"><?php
                                                        echo htmlspecialchars_decode($r1['quest'], ENT_QUOTES);
                                                        if ($r1['img'] != NULL) {
                                                            echo '<br><img src="data:image/jpeg;base64,' . base64_encode($r1['img']) . '" width="300" height="200"/>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars_decode($r2['corans'], ENT_QUOTES); ?></td>
                                                    <td style="text-align:justify"><?php
                                                        echo htmlspecialchars_decode($r1['expl'], ENT_QUOTES);
                                                        if ($r1['eimg'] != NULL) {
                                                            echo '<br><img src="data:image/jpeg;base64,' . base64_encode($r1['eimg']) . '" width="300" height="200"/>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars_decode($r2['stdans'], ENT_QUOTES); ?></td>
                                                    <td><?php echo $r2['stdmarks']; ?></td>
                                                    <?php
                                                    if ($r2['stdmarks'] == 0) {
                                                        echo"<td class=\"tddata\"><img src=\"images/wrong.png\" title=\"Wrong Answer\" height=\"30\" width=\"40\" alt=\"Wrong Answer\" /></td>";
                                                    } else {
                                                        echo"<td class=\"tddata\"><img src=\"images/correct.png\" title=\"Correct Answer\" height=\"30\" width=\"40\" alt=\"Correct Answer\" /></td>";
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                            } else {
                                                // echo"<h3 style=\"color:#0000cc;text-align:center;\">Sorry because of some problems Individual questions Cannot be displayed.</h3>".mysql_error();
                                            }
                                        }

                                        // }
                                    } else {
                                        echo"<h3 style=\"color:#0000cc;text-align:center;\">Something went wrong. Please logout and Try again.</h3>" . mysql_error();
                                    }
                                    ?>
                                </table>
                                <?php
                            } else {


                                $result = executeQuery("select st.*,t.testname,t.testdesc,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as startt from studenttest as st,test as t where t.testid=st.testid and st.stdid=" . $_SESSION['stdid'] . " and st.status='over' order by st.testid;");
                                if (mysql_num_rows($result) == 0) {
                                    echo"<div style=\"background-color:lightcoral;\"><br><h3 style=\"color:#0000cc;text-align:center;background-color:lightcoral;\">I Think You Haven't Attempted Any Exams Yet..! <br><br>Please Try Again After Your Write The Exam.</h3><br></div>";
                                } else {
                                    //editing components
                                    ?>
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>Date and Time</th>
                                            <th>Test Name</th>
                                            <th>Max. Marks</th>
                                            <th>Obtained Marks</th>
                                            <th>Percentage</th>
                                            <th>Details</th>
                                        </tr>
                                        <?php
                                        while ($r = mysql_fetch_array($result)) {
                                            $i = $i + 1;
                                            $om = 0;
                                            $tm = 0;
                                            $result1 = executeQuery("select sum(q.marks) as om from studentquestion as sq, question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=" . $_SESSION['stdid'] . " and sq.testid=" . $r['testid'] . " order by sq.testid;");
                                            $r1 = mysql_fetch_array($result1);
                                            $result2 = executeQuery("select sum(marks) as tm from question where testid=" . $r['testid'] . ";");
                                            $r2 = mysql_fetch_array($result2);
                                            if ($i % 2 == 0) {
                                                echo "<tr class=\"alt\">";
                                            } else {
                                                echo "<tr>";
                                            }
                                            echo "<td>" . $r['startt'] . "</td><td>" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . " : " . htmlspecialchars_decode($r['testdesc'], ENT_QUOTES) . "</td>";
                                            if (is_null($r2['tm'])) {
                                                $tm = 0;
                                                echo "<td>$tm</td>";
                                            } else {
                                                $tm = $r2['tm'];
                                                echo "<td>$tm</td>";
                                            }
                                            if (is_null($r1['om'])) {
                                                $om = 0;
                                                echo "<td>$om</td>";
                                            } else {
                                                $om = $r1['om'];
                                                echo "<td>$om</td>";
                                            }
                                            if ($tm == 0) {
                                                echo "<td>0</td>";
                                            } else {
                                                echo "<td>" . (($om / $tm) * 100) . " %</td>";
                                            }
                                            echo"<td class=\"tddata\"><a title=\"Details\" href=\"viewresult.php?details=" . $r['testid'] . "\"><img src=\"images/detail.png\" height=\"30\" width=\"40\" alt=\"Details\" /></a></td></tr>";
                                        }
                                        ?>

                                    </table>
                                    <?php
                                }
                            }
                            closedb();
                        }
                        ?>

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

