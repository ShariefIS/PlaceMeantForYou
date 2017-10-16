

<?php
/* Procedure
 * ********************************************

 * ----------- *
 * PHP Section *
 * ----------- *
  Step 1: Event to Process...
  Case 1 : Submit - Add the new Student to the System.

 * ------------ *
 * HTML Section *
 * ------------ *
  Step 2: Display the Html page to receive the required information.

 * ********************************************
 */

error_reporting(0);
session_start();
include_once 'oesdb.php';

if (isset($_REQUEST['stdsubmit'])) {
    /*     * *************************** Step 1 : Case 1 *************************** */
    //Add the new user information in the database
    $result = executeQuery("select max(stdid) as std from student");
    $r = mysql_fetch_array($result);
    if (is_null($r['std']))
        $newstd = 1;
    else
        $newstd = $r['std'] + 1;

    $result = executeQuery("select stdname as std from student where stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "';");

    // $_GLOBALS['message']=$newstd;
    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (mysql_num_rows($result) > 0) {
        $_GLOBALS['message'] = "Sorry the User Name is Not Available Try with Some Other name.";
    } else {
        $query = "insert into student (`stdid`, `stdname`, `stdpassword`, `emailid`, `contactno`, `address`, `city`, `pincode`) values($newstd,'" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "',ENCODE('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','oespass'),'" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "')";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else {
            $success = true;
            $_GLOBALS['message'] = "Successfully Your Account is Created.Click <a href=\"index.php\">Here</a> to LogIn";
            // header('Location: index.php');
        }
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
    <link rel="shortcut icon" href="images/P.jpg">

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
input[type=submit],input[type=reset]{
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
    <body style="background: #222222;">

        <header id="navigation">
            <div  class="navbar main-nav" role="banner">
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
                            <li ><a href="index.php">Back</a></li> 
                            <?php
                            if (isset($_SESSION['stdname'])) {
                                header('Location: stdwelcome.php');
                            } else {
                                /*                                 * *************************** Step 2 *************************** */
                                ?>
                                <li><a href="register.php" title="Click here  to Register">Register</a></li>
                            <?php } ?> </ul>					
                    </nav>
                </div>
            </div>
        </header><!--/#navigation--> 
        <?php
        if ($_GLOBALS['message']) {
            echo '<div style="background-color: lightcoral;color:lightgray">' . $_GLOBALS['message'] . '</div>';
        }
        ?>
        
        <div id="service" class="padding-top padding-bottom">		
            <div class="container text-center">
                <div class="row section-title">
                    <div class="col-md-6 col-md-offset-3">
                        <?php if (!$success): ?>

                            <h3>New User Registration</h3>
                        <?php endif; ?>
                        <hr class="title-border"></hr>
                        <?php
                        if ($success) {
                            echo "<div style=\"background-color:lightcoral;\"><br><h2 style=\"text-align:center;color:#0000ff;\">Thank You For Registering with PlaceMeant For You.<br/><a href=\"index.php\">Login Now</a></h2><br></div>";
                        } else {
                            /*                             * *************************** Step 2 *************************** */
                            ?>
                            <form id="admloginform"  action="register.php" method="post" onsubmit="return validateform('admloginform');">
                                <table cellpadding="20" cellspacing="20" style="text-align:left;" >

                                    <tr>
                                        <td>Student Full Name</td>
                                        <td><input type="text" name="city" value="" size="16" /></td>
                                    </tr><tr>
                                        <td>User Name</td>
                                        <td><input type="text" name="cname" value="" size="16" onkeyup="isalphanum(this)"/></td>

                                    </tr>

                                    <tr>
                                        <td>Password</td>
                                        <td><input type="password" name="password" value="" size="16" onkeyup="isalphanum(this)" /></td>

                                    </tr>
                                    <tr>
                                        <td>Re-type Password</td>
                                        <td><input type="password" name="repass" value="" size="16" onkeyup="isalphanum(this)" /></td>

                                    </tr>
                                    <tr>
                                        <td>E-mail ID</td>
                                        <td><input type="text" name="email" value="" size="16" /></td>
                                    </tr>
                                    <tr>
                                        <td>Roll Number</td>
                                        <td><input type="text" name="pin" value="" size="16"  maxlength="12" onkeyup="isnum(this)" /></td>
                                    </tr>
                                    <tr>
                                        <td>Contact No</td>
                                        <td><input type="text" name="contactno" value="" size="16" onkeyup="isnum(this)"/></td>
                                    </tr>

                                    <tr>
                                        <td>Department</td>
                                        <td><select name="address">
                                                <option></option>
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


                                    <tr>
                                        <td style="text-align:right;"><input type="submit" name="stdsubmit" value="Register" class="subbtn" /></td>
                                        <td><input type="reset" name="reset" value="Reset" class="subbtn"/></td>
                                    </tr>
                                </table>
                            </form>
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

