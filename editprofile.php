


<?php



/* Procedure
*********************************************

 * ----------- *
 * PHP Section *
 * ----------- *

Step 1: Perform Session Validation.

Step 2: Event to Process...
        Case 1 : Logout - perform session cleanup.
        Case 2 : Dashboard - redirect to Dashboard.
        Case 3 : Edit - Update the Information.
        

 * ------------ *
 * HTML Section *
 * ------------ *

Step 3: Display the HTML Components for...
        Case 1: Default Mode - Displays the saved information.
*********************************************
*/

error_reporting(0);
session_start();
include_once 'oesdb.php';
/************************** Step 1 *************************/
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout']))
{
    /************************** Step 2 - Case 1 *************************/
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    header('Location: index.php');

}
else if(isset($_REQUEST['dashboard'])){
     /************************** Step 2 - Case 2 *************************/
        //redirect to dashboard
     header('Location: stdwelcome.php');

    }else if(isset($_REQUEST['savem']))
{
      /************************** Step 2 - Case 3 *************************/
                //updating the modified values
    if(empty($_REQUEST['cname'])||empty ($_REQUEST['password'])||empty ($_REQUEST['email']))
    {
         $_GLOBALS['message']="Some of the required Fields are Empty.Therefore Nothing is Updated";
    }
    else
    {
     $query="update student set stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."', stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass'),emailid='".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."',contactno='".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."',address='".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."',city='".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."',pincode='".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."' where stdid='".$_REQUEST['student']."';";
     if(!@executeQuery($query))
        $_GLOBALS['message']=mysql_error();
     else
        $_GLOBALS['message']="Your Profile is Successfully Updated.";
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
	
	<!--title-->
    <title>PlaceMeant Exam</title>
	
	<!--CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/font.css" rel="stylesheet">
	<link href="css/prettyPhoto.css" rel="stylesheet">	
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">	
            <link rel="shortcut icon" href="images/P.jpg"></link>
    <script type="text/javascript" src="validate.js" ></script>
    <style>
        input[type=text],input[type=password]{
    width: 500px;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: none;
    border-bottom: 2px solid red;
    size: 50px;
    }
    input[type=text],input[type=password]:focus
    {
        background-color: lightgoldenrodyellow;
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
    </head>
    <body style="background-color: #222222">
        <form id="editprofile" action="editprofile.php" method="post">
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
                                    ?><li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                                    <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>
                                    <li><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('editprofile')" title="Save the changes"/></li>
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
                                <h3>Edit Student Profile</h3>
                                <hr class="title-border"></hr>

                                <?php
                                /*                                 * ************************ Step 3 - Case 1 ************************ */
                                // Default Mode - Displays the saved information.
                                $result = executeQuery("select stdid,stdname,DECODE(stdpassword,'oespass') as stdpass ,emailid,contactno,address,city,pincode from student where stdname='" . $_SESSION['stdname'] . "';");
                                if (mysql_num_rows($result) == 0) {
                                    header('Location: stdwelcome.php');
                                } else if ($r = mysql_fetch_array($result)) {
                                    //editing components
                                    ?>
                                    <table cellpadding="20" cellspacing="20"  >
                                         <tr>
                                            <th>Name</th>
                                            <td><input type="text" name="city" value="<?php echo htmlspecialchars_decode($r['city'], ENT_QUOTES); ?>" size="16" onkeyup="isalpha(this)"/></td>
                                        </tr>
                                        <tr>
                                            <th>Roll Number</th>
                                            <td><input type="hidden" name="student" value="<?php echo $r['stdid']; ?>"/><input type="text" name="pin" value="<?php echo htmlspecialchars_decode($r['pincode'], ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)" /></td>
                                        </tr>
                                        <tr>
                                            <th>User Name</th>
                                            <td><input type="text" name="cname" value="<?php echo htmlspecialchars_decode($r['stdname'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)"/></td>

                                        </tr>

                                        <tr>
                                            <th>Password</th>
                                            <td><input type="password" name="password" value="<?php echo htmlspecialchars_decode($r['stdpass'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)" /></td>

                                        </tr>

                                        <tr>
                                            <th>E-mail ID</th>
                                            <td><input type="text" name="email" value="<?php echo htmlspecialchars_decode($r['emailid'], ENT_QUOTES); ?>" size="16" /></td>
                                        </tr>
                                        <tr>
                                            <th>Contact No</th>
                                            <td><input type="text" name="contactno" value="<?php echo htmlspecialchars_decode($r['contactno'], ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)"/></td>
                                        </tr>

                                        <tr>
                                            <td>Department</td>
                                            <td>
                                                <select name="address">
                                                <option><?php echo htmlspecialchars_decode($r['address'], ENT_QUOTES); ?></option>
                                                <option>Information Technology</option>
                                                <option>Computer Science</option>
                                                <option>Electronics And Communications</option>
                                                <option>Electronics And Electrical</option>
                                                <option>Electronics And Instrumentation</option>
                                                <option>Mechanical</option>
                                                <option>Production</option>
                                                <option>Civil</option>
                                            </select>
                                            </td>
                                        </tr>
                                       

                                    </table>
                                    <?php
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
</html>
