<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}

$target = $_GET['target'];
$header = "location:$target.php";

if($_SESSION['member_dataprotection'] == 'YES'){
    header($header);
}

include('config.php');
include('Logging.php');

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));

if(isset($_POST['submit'])){
    if($_POST['dataprotection_agreement'] == "YES"){
        $id = $_SESSION['id'];
        $date = date('d.m.Y H:i:s');
        $sql = "UPDATE users SET member_dataprotection = 'YES', member_dataprotection_timestamp = '$date' WHERE ID = '$id'";
        $result = mysqli_query($con,$sql);
        $_SESSION['member_dataprotection'] = 'YES';
        // Logging class initialization
        $log = new Logging();

        // set path and name of log file (optional)
        $log->lfile('logs/member_dataprotection.txt');

        // write message to the log file
        $log->lwrite("$id/YES/$date");

        // close log file
        $log->lclose();
        header($header);
    }
    else{
        $error = '1';
    }
}

?>

<html lang="en">
<head>
	<title>IVAO Romania TMS</title>
	<link rel="shortcut icon" href="http://www.ivao.aero/favicon.ico">
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<div id='container'>
<?php include('banner_menu.php'); ?>
<div id='header'>
	<h3>&nbsp Data Protection and Privacy</h3>
</div>
<div id='content'>
<br>
<?php
if($error == '1'){
    echo "<h4>You have to give your consent in order to continue!</h4>";
}
?>
<fieldset>
    <legend>Data protection agreement</legend>
    <form id="dataprotection_form_member" action="member_dataprotection.php?target=<?php echo $target; ?>" method="post">
        <label>
            <input type="checkbox" name="dataprotection_agreement" id="dataprotection_agreement" value="YES" /> I consent to the storage and processing by IVAO Romania of the data received from IVAO (Full Name, ATC/pilot ratings, division), my email address given as part of a training request, as well as of the training history that resulted or will result from using the tools offered on this website, according to the IVAO Rules and Regulations regarding Data Protection and Privacy. This data will never be released to any Third Party.<br>
            <b>I also consent to receiving (automated) emails concerning the requests I made or will make on this website.</b><br>
            Note: You will have the option to download your personal information stored in the IVAO Romania database and to delete all said information (including this consent) at your discretion after you confirm this prompt.
        </label>
        <br>
        <input class='submit' type="submit" name="submit" value="Submit" />
    </form>
</fieldset>
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>