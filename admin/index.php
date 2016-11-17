<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'oesdb.php';
if(isset($_REQUEST['admsubmit']))
{
$result=executeQuery("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and admpassword='".md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES))."'");
//$result=mysql_query("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'])."' and admpassword='".md5(htmlspecialchars($_REQUEST['password']))."'");
if(mysql_num_rows($result)>0)
{
$r=mysql_fetch_array($result);
if(strcmp($r['admpassword'],md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
{
$_SESSION['admname']=htmlspecialchars_decode($r['admname'],ENT_QUOTES);
//unset($_GLOBALS['message']);
error_reporting(E_ALL);
ini_set('display_errors', 'On');
header('Location: admwelcome.php');
}else
{
$_GLOBALS['message']="Check Your user name and Password.";
}
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
<title>Administrator Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/testhome.css" />
</head>
<body>

<?php
if(isset($_GLOBALS['message']))
{
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
<div id="main">
<div class="admin_login">
<center><h2><font color="#1A8CCE">Admin Login</font></h2>
<form id="indexform" action="index.php" method="post">
<table>
<tr>
<td width="82" height="45">Username</td>
<td width="162"><input type="text" name="name" value="" size="16" /></td>
</tr>
<tr>
<td height="45"> Password</td>
<td><input type="password" name="password" value="" size="16" /></td>
</tr>
<tr>
<td colspan="2">
<center>
<input type="submit" value="Log In" name="admsubmit" class="btn" /></center></td>
</tr>
</table>
</form>
</center>
</div>
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