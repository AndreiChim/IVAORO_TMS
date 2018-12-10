<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}
elseif($_SESSION['acces'] != 'ADMIN'){
	header("location:noaccess.php");
}

$target = $_GET['target'];
$header = "location:$target.php";

if($_SESSION['admin_dataprotection'] == 'YES'){
    header("location:admin.php");
}

include('config.php');
include('Logging.php');

$con = mysql_connect($host, $username, $password) or die('Cannot connect to database: '. mysql_error());
mysql_select_db($db_name) or die('Cannot select database: '. mysql_error());

if(isset($_POST['submit'])){
    if($_POST['dataprotection_agreement'] == "YES" && $error != '1'){
        $id = $_SESSION['id'];
        $date = date('d.m.Y H:i:s');
        $sql = "UPDATE users SET admin_dataprotection = 'YES', admin_dataprotection_timestamp = '$date' WHERE ID = '$id'";
        $result = mysql_query($sql);
        $_SESSION['admin_dataprotection'] = 'YES';
        // Logging class initialization
        $log = new Logging();

        // set path and name of log file (optional)
        $log->lfile('logs/admin_dataprotection.txt');

        // write message to the log file
        $log->lwrite("$id/YES/$date");

        // close log file
        $log->lclose();
        header('location:admin.php');
    }
    else{
        $error = '1';
    }
}

?>

<html>
<head>
	<title>IVAO Romania TMS</title>
	<link rel="shortcut icon" href="http://www.ivao.aero/favicon.ico">
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<div id='container'>
<?php include('banner_menu.php'); ?>
<div id='header'>
	<h3>&nbsp Staff Access - Data Protection</h3>
</div>
<div id='content'>
<br>
<?php if($error == '1'){
    echo "<h4>You have to give your consent in order to continue!</h4>";
}
?>
<fieldset>
    <legend>Data protection agreement</legend>
    <form id="dataprotection_form" action="admin_dataprotection.php?target=<?php echo $target; ?>" method="post">
        <label>
            <input type="checkbox" name="dataprotection_agreement" id="dataprotection_agreement" value="YES" /> I agree to follow the IVAO Rules and Regulations regarding Data Protection and Privacy when handling the confidential information displayed in the IVAO Romania TMS administration pages. I will never disclose this information to any Third Party.
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