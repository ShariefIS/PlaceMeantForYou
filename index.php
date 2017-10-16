



 <?php
 /* Procedure
*********************************************

 * ----------- *
 * PHP Section *
 * ----------- *
Step 1: Event to Process...
        Case 1 : Register - redirect to Registration Page.
        Case 2 : Authenticate
       

 * ------------ *
 * HTML Section *
 * ------------ *
Step 2: Display the Html page to receive Authentication Parameters(Name & Password).

*********************************************
*/
 
      error_reporting(0);
      session_start();
      include_once 'oesdb.php';
/***************************** Step 1 : Case 1 ****************************/
 //redirect to registration page
      if(isset($_REQUEST['register']))
      {
            header('Location: register.php');
      }
      else if($_REQUEST['stdsubmit'])
      {
/***************************** Step 1 : Case 2 ****************************/
 //Perform Authentication
          $result=executeQuery("select *,DECODE(stdpassword,'oespass') as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass')");
          if(mysql_num_rows($result)>0)
          {

              $r=mysql_fetch_array($result);
             /* $str2="accepted";
              if(strcmp(htmlspecialchars_decode($r['status'],ENT_QUOTES), $str2)==0)
              {*/
                if(strcmp(htmlspecialchars_decode($r['std'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                  $_SESSION['stdname']=htmlspecialchars_decode($r['stdname'],ENT_QUOTES);
                  $_SESSION['stdid']=$r['stdid'];
                  unset($_GLOBALS['message']);
                  header('Location: stdwelcome.php');
              }else
          {
              $_GLOBALS['message']="Check Your user name and Password.";
          }
  
              /*}
                else {
                 $_GLOBALS['message']="Your account needs to be activated.";   
                }*/
          }
          else
          {
              $_GLOBALS['message']="Check Your user name and Password.";
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/font.css" rel="stylesheet">
	<link href="css/prettyPhoto.css" rel="stylesheet">	
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">	
	
    <!--[if lt IE 9]>
	    <script src="js/html5shiv.js"></script>
	    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/P.jpg">
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
                         <?php if(isset($_SESSION['stdname'])){
                          header('Location: stdwelcome.php');}else{  
                          /***************************** Step 2 ****************************/
                        ?>
<li><a href="register.php" title="Click here  to Register">Register</a></li>
                        <?php } ?> </ul>					
                </nav>
            </div>
        </div>
    </header><!--/#navigation--> 
<?php

        if($_GLOBALS['message'])
        {
         echo '<div style="position:absolute;top:100px;background-color: lightcoral;color:lightgray">'.$_GLOBALS['message'].'</div>';
        }
      ?>
    <style>input[type=text],input[type=password]{
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: none;
    border-bottom: 2px solid red;
    size: 35px;
    }
    input[type=text],[type=password]:focus {
    background-color: lightblue;
}
    </style>
  <div id="service" class="padding-top padding-bottom">		
		<div class="container text-center">
			<div class="row section-title">
				<div class="col-md-6 col-md-offset-3">
					<h3>LogIN</h3>
                                        <hr class="title-border"></hr>
					 <form id="stdloginform" action="index.php" method="post">
        
         <table cellpadding="30" cellspacing="10">
              <tr>
                  <td><label>User Name &nbsp; :</label></td>
                  <td><input type="text" tabindex="1" name="name" value="" size="16" /></td>

              </tr>
              <tr>
                  <td><label>Password&nbsp; :</label></td>
                  <td><input type="password" tabindex="2" name="password" value="" size="16" /></td>
              </tr>

              <tr>
                  <td>New? &nbsp; &nbsp; <a style="color: goldenrod" href="register.php" title="Click here  to Register">Register</a></td>
                  <td colspan="2">
                      <input type="submit" tabindex="3" value="Log-IN" name="stdsubmit" />
                  </td><td></td>
              </tr>
            </table>
     </form> 
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
