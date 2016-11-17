<?php
error_reporting(0);
session_start();
include_once '../oesdb.php';
/* * ************************ Step 1 ************************ */
if (!isset($_SESSION['tcname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_REQUEST['logout'])) {
    /*     * ************************ Step 2 - Case 1 ************************ */
    //Log out and redirect login page
    unset($_SESSION['tcname']);
    header('Location: index.php');
} else if (isset($_REQUEST['dashboard'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard
    header('Location: tcwelcome.php');
} else if (isset($_REQUEST['delete'])) {
    /*     * ************************ Step 2 - Case 3 ************************ */
    //deleting the selected Subjects
    unset($_REQUEST['delete']);
    $hasvar = false;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some session values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from subject where subid=$variable and tcid=" . $_SESSION['tcid'] . ";")) {
                if (mysql_errno () == 1451) //Children are dependent value
                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this subject, then first delete the tests that are conducted/dependent on this subject.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
        }
    }
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected Subject/s are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the subject/s to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    /*     * ************************ Step 2 - Case 4 ************************ */
    //updating the modified values
    if (empty($_REQUEST['subname']) || empty($_REQUEST['subdesc'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update subject set subname='" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "', subdesc='" . htmlspecialchars($_REQUEST['subdesc'], ENT_QUOTES) . "'where subid=" . $_REQUEST['subject'] . " and tcid=" . $_SESSION['tcid'] . ";";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Subject Information is Successfully Updated.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
    /*     * ************************ Step 2 - Case 5 ************************ */
    //Add the new Subject information in the database
    $result = executeQuery("select max(subid) as sub from subject");
    $r = mysql_fetch_array($result);
    if (is_null($r['sub']))
        $newstd = 1;
    else
        $newstd=$r['sub'] + 1;

    $result = executeQuery("select subname as sub from subject where subname='" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "' and tcid=" . $_SESSION['tcid'] . ";");
    // $_GLOBALS['message']=$newstd;
    if (empty($_REQUEST['subname']) || empty($_REQUEST['subdesc'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (mysql_num_rows($result) > 0) {
        $_GLOBALS['message'] = "Sorry Subject Already Exists.";
    } else {
        $query = "insert into subject values($newstd,'" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['subdesc'], ENT_QUOTES) . "'," . $_SESSION['tcid'] . ")";
        if (!@executeQuery($query)) {
            if (mysql_errno () == 1062) //duplicate value
                $_GLOBALS['message'] = "Given Subject Name voilates some constraints, please try with some other name.";
            else
                $_GLOBALS['message'] = mysql_error ();
        }
        else
            $_GLOBALS['message'] = "Successfully New Subject is Created.";
    }
    closedb();
}
?>
<html>
    <head>
        <title>OES-Manage Subjects</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/testhome.css"/>
        <script type="text/javascript" src="../validate.js" ></script>
    </head>
    <body>
<?php
if ($_GLOBALS['message']) {
    echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
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
            <form name="submng" action="submng.php" method="post">
                <div class="menubar">


                    <ul id="menu">
<?php
if (isset($_SESSION['tcname'])) {
// Navigations
?>
                        <li><input type="submit" value="LogOut" name="logout" class="btn" title="Log Out"/>&nbsp;&nbsp;&nbsp;</li>
                        <li><input type="submit" value="DashBoard" name="dashboard" class="btn" title="Dash Board"/>&nbsp;&nbsp;&nbsp;</li>

<?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="btn" title="Cancel"/>&nbsp;&nbsp;&nbsp;</li>
                        <li><input type="submit" value="Save" name="savea" class="btn" onClick="validatesubform('submng')" title="Save the Changes"/>&nbsp;&nbsp;&nbsp;</li>

<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="btn" title="Cancel"/>&nbsp;&nbsp;&nbsp;</li>
                        <li><input type="submit" value="Save" name="savem" class="btn" onClick="validatesubform('submng')" title="Save the changes"/>&nbsp;&nbsp;&nbsp;</li>

<?php
    } else {  //navigation for Default
?>
                        <li><input type="submit" value="Delete" name="delete" class="btn" title="Delete"/>&nbsp;&nbsp;&nbsp;</li>
                        <li><input type="submit" value="Add" name="add" class="btn" title="Add"/></li>
<?php }
} ?>
                    </ul>

                </div>
                <div id="secondmain">
<?php
if (isset($_SESSION['tcname'])) {

    if (isset($_REQUEST['add'])) {

        /*         * ************************ Step 3 - Case 1 ************************ */
        //Form for the new Subject
?>
                    <center>
                    <h2>Add New Subject</h2><hr><br>
                    <table>
                        <tr>
                            <td>Subject Name</td>
                            <td><input type="text" name="subname" value="" size="16" onKeyUp="isalphanum(this)" onBlur="if(this.value==''){alert('Subject Name is Empty');this.focus();this.value='';}"/></td>

                        </tr>

                        <tr>
                            <td>Subject Description</td>
                            <td><textarea name="subdesc" cols="20" rows="3" onBlur="if(this.value==''){alert('Subject Description is Empty');this.focus();this.value='';}"></textarea></td>
                        </tr>

                    </table><br>
                    <?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
<input type="submit" value="Cancel" name="cancel" class="btn" title="Cancel"/>&nbsp;&nbsp;
<input type="submit" value="Save" name="savea" class="btn" onClick="validatesubform('submng')" title="Save the Changes"/>


<?php } ?>
                    
                    </center>

<?php
    } else if (isset($_REQUEST['edit'])) {

        /*         * ************************ Step 3 - Case 2 ************************ */
        // To allow Editing Existing Subject.
        $result = executeQuery("select subid,subname,subdesc from subject where subname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "' and tcid=" . $_SESSION['tcid'] . ";");
        if (mysql_num_rows($result) == 0) {
            header('submng.php');
        } else if ($r = mysql_fetch_array($result)) {


            //editing components
?>
                    <center>
                    <h2>Update Subject</h2><hr><br>
                    <table>
                        <tr>
                            <td>Subject Name</td>
                            <td><input type="text" name="subname" value="<?php echo htmlspecialchars_decode($r['subname'], ENT_QUOTES); ?>" size="16" onKeyUp="isalphanum(this)"/></td>

                        </tr>
                        <tr>
                            <td>Subject Description</td>
                            <td><textarea name="subdesc" cols="20" rows="3"><?php echo htmlspecialchars_decode($r['subdesc'], ENT_QUOTES); ?></textarea><input type="hidden" name="subject" value="<?php echo $r['subid']; ?>"/></td>
                        </tr>
                    </table><br>
                    
                    <?php
if (isset($_REQUEST['edit'])) { 
?>
<input type="submit" value="Cancel" name="cancel" class="btn" title="Cancel"/>&nbsp;&nbsp;
<input type="submit" value="Save" name="savem" class="btn" onClick="validatesubform('submng')" title="Save the changes"/>

<?php
    }   //navigation for Default
?>
                    
                    </center>
<?php
                    closedb();
                }
            } else {

                /*                 * ************************ Step 3 - Case 3 ************************ */
                // Defualt Mode: Displays the Existing Subject/s, If any.
                $result = executeQuery("select * from subject where tcid=" . $_SESSION['tcid'] . " order by subid;");
                if (mysql_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Subjets Yet..!</h3>";
                } else {
                    $i = 0;
?>					<h2>Manage Subject</h2><hr><br>
                    <table width="940">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Subject Name</th>
                            <th>Subject Description</th>
                            <th>Edit</th>
                        </tr>
<?php
                    while ($r = mysql_fetch_array($result)) {
                        $i = $i + 1;
                        if ($i % 2 == 0) {
                            echo "<tr class=\"alt\">";
                        } else {
                            echo "<tr>";
                        }
                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['subid'] . "\" /></td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                        . "</td><td>" . htmlspecialchars_decode($r['subdesc'], ENT_QUOTES) . "</td>"
                        . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"submng.php?edit=" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
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
            <div id="footer">
                <p style="font-size:70%;color:#ffffff;"> Developed By-<b>Manjunath Baddi</b><br/> </p><p>Released under the GNU General Public License v.3</p>
            </div>
        </div>
    </body>
</html>

