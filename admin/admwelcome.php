<?php
error_reporting(E_ALL);
/********************* Step 1 *****************************/
session_start();
        if(!isset($_SESSION['admname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
           unset($_SESSION['admname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: index.php');
        }
?>

<html>
    <head>
        <title>OES-DashBoard</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/testhome.css"/>
    </head>
    <body>
        <?php
       /********************* Step 2 *****************************/
        if(isset($_GLOBALS['message'])) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
        <div id="container">
            <div class="header">
                <div id="logo">
	<div align="center">
    
    <img src="../images/logo.png" width="274" height="90" />
    online test
  	
    </div>
    </div>
            </div>
            <div class="menubar">

                <form name="admwelcome" action="admwelcome.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['admname'])){ ?>
                        <li><input type="submit" value="LogOut" name="logout" class="btn" title="Log Out"/></li>
                        <?php } ?>
                    </ul>
                </form>
            </div>
            <div id="main">
                <?php if(isset($_SESSION['admname'])){ ?>
		<center><table width="782">
        <tr>
        <td width="391" height="160" align="center" valign="middle" pa><a href="usermng.php" alt="Manage Users"><img src="../images/muser.jpg" width="117" height="106"/><br>Manage User</a></td>
        <td width="366" align="center" valign="middle"><a href="submng.php"><img src="../images/msub.png" width="117" height="106"/><br/>Manage Subject</a></td>
        </tr>
        <tr>
        <td height="160" align="center" valign="middle"><a href="testmng.php?forpq=true"><img src="../images/pques.jpg" width="117" height="106"/><br/>Prepare Question</a></td>
        <td align="center" valign="middle"><a href="testmng.php"/><img src="../images/test.jpg"/ width="117" height="106"><br/>Manage Test</td>
        </tr>
        <tr align="center" valign="middle">
        <td height="160" width="391"><a href="rsltmng.php"><img src="../images/mresult.jpg" width="117" height="106"/><br/>Manage Result</a></td>
        </tr>
        </table></center>
               <!-- <div class="topimg">
                  

                    <map name="oesnav">
                        <area shape="circle" coords="150,120,70" href="usermng.php" alt="Manage Users" title="This takes you to User Management Section" />
                        <area shape="circle" coords="450,120,70" href="submng.php" alt="Manage Subjects" title="This takes you to Subjects Management Section" />
                        <area shape="circle" coords="299,249,60" href="rsltmng.php" alt="Manage Test Results" title="Click this to view Test Results." />
                        <area shape="circle" coords="150,375,70" href="testmng.php?forpq=true" alt="Prepare Questions" title="Click this to prepare Questions for the Test" />
                        <area shape="circle" coords="450,375,70" href="testmng.php" alt="Manage Tests" title="This takes you to Tests Management Section" />
                    </map>
                </div>-->
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
