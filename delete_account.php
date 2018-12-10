<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}

include('config.php');
include('Logging.php');

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));

if($_GET['delete'] == 'yes'){
    $id = $_SESSION['id'];
    
    $tbl_name = 'users';
    $sql = "DELETE FROM $tbl_name WHERE ID = '$id'";
    $result = mysqli_query($con,$sql);
    
    $tbl_name = 'training_requests';
    $sql = "DELETE FROM $tbl_name WHERE ID = '$id'";
    $result = mysqli_query($con,$sql);
    
    $tbl_name = 'calendar_events';
    $sql = "DELETE FROM $tbl_name WHERE event_desc LIKE '%$id%'";
    $result = mysqli_query($con,$sql);
    
    $tbl_name = 'calendar_admins';
    $sql = "DELETE FROM $tbl_name WHERE admin_username = '$id'";
    $result = mysqli_query($con,$sql);
    
    $date = date('d.m.Y H:i:s');

    // Logging class initialization
    $log = new Logging();

    // set path and name of log file (optional)
    $log->lfile('logs/deletion.txt');

    // write message to the log file
    $log->lwrite("$id/DELETED from users/$date");
    $log->lwrite("$id/DELETED from training_requests/$date");
    $log->lwrite("$id/DELETED from calendar_events/$date");
    $log->lwrite("$id/DELETED from calendar_admins/$date");

    // close log file
    $log->lclose();
    
    header("location:logout.php");
}
?>

<html lang="en">
<head>
	<title>IVAO Romania TMS</title>
	<link rel="shortcut icon" href="http://www.ivao.aero/favicon.ico">
	<link rel="stylesheet" type="text/css" href="main.css">
    <script type="text/javascript">
            function getConfirmation(){
               var retVal = confirm("This will PERMANENTLY DELETE ALL INFORMATION stored about you by the IVAO Romania TMS! This CAN NOT be reversed if you haven't downloaded your data! Are you really sure you want to continue?");
               if( retVal == true ){
                  window.location.replace("delete_account.php?delete=yes");
                  return true;
               }
               else{
                  return false;
               }
            }
      </script>
</head>
<body>
<div id='container'>
<?php include('banner_menu.php'); ?>
<div id='header'>
	<h3>&nbsp Delete account</h3>
</div>
<div id='content'>
<br>
<fieldset>
    <legend>Delete Account</legend>
    <p>This will delete all the data concerning your person from the database of IVAO Romania. It will however NOT affect in any way the data stored in the main IVAO database.
    </p>
    <p>We recommend you go back to your profile page and download your data as an XML file in case you change your mind later.
    </p>
    <form id='go_back_deletion' action='myprofile.php' method='post'>
        <input class='submit' type='submit' name='submit' value='Go back!' />
    </form>
    <form>
        <input class='submit' type="button" value="PERMANENTLY DELETE ACCOUNT" onclick="getConfirmation();" />
    </form>
</fieldset>
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>