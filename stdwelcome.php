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
        <title>OES-DashBoard</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="css/testhome.css"/>
    </head>
    <body>
        <?php
       
        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
        <div id="container">
           <div class="header">
                <div id="logo">
	<div align="center">
    
    <img src="../test_demo/img/logo.png" width="274" height="90" />
    online test
  	</div>
    </div>
            </div>
            <div class="menubar">

                <form name="stdwelcome" action="stdwelcome.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['stdname'])){ ?>
                        <li><input type="submit" value="LogOut" name="logout" class="btn" title="Log Out"/></li>
                        <?php } ?>
                    </ul>
                </form>
            </div>
            <div id="secondmain">
                <?php if(isset($_SESSION['stdname'])){ ?>
                <div class="topimg">
                  <p><img height="500" width="600" style="border:none;"  src="images/stdwelcome.jpg" alt="image"  usemap="#oesnav" /></p>

                    <map name="oesnav">
                        <area shape="circle" coords="150,120,70" href="viewresult.php" alt="View Results" title="Click to View Results" />
                        <area shape="circle" coords="450,120,70" href="stdtest.php" alt="Take a New Test" title="Take a New Test" />
                        <area shape="circle" coords="300,250,60" href="editprofile.php?edit=edit" alt="Edit Your Profile" title="Click this to Edit Your Profile." />
                        <area shape="circle" coords="150,375,70" href="practicetest.php" alt="Practice Test" title="Click to take a Practice Test" />
                        <area shape="circle" coords="450,375,70" href="resumetest.php" alt="Resume Test" title="Click this to Resume Your Pending Tests." />
                    </map>
                </div>
                
                <?php }?>

            </div>

           <div id="footer">
<center>
  <h3>Design By CapsLOCK<br /></h3>
    <font color="#fffff" face="Comic Sans MS, cursive">copyright © 2013 All Right Reserved</font>  
  </center>
      </div>
      </div>
  </body>
</html>
