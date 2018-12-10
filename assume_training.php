<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}

include('config.php');
$tbl_name = 'training_requests';

$con = mysql_connect($host, $username, $password) or die('Cannot connect to database: ' . mysql_error());
mysql_select_db($db_name, $con) or die('Cannot select database: ' . mysql_error());

$trainer = $_SESSION['name'];
$tracking = $_POST['tracking'];

if(isset($_POST['assume'])){
	$sql = "UPDATE $tbl_name SET Trainer = '$trainer' WHERE Tracking = '$tracking'";
	$result = mysql_query($sql);
	header("location:admin.php");
}

if(isset($_POST['delete'])){
	$sql = "DELETE FROM $tbl_name WHERE Tracking = '$tracking'";
	$result = mysql_query($sql);
    $tbl_name = 'calendar_events';
	$sql = "DELETE FROM $tbl_name WHERE event_id = '$tracking'";
	$result = mysql_query($sql);
	header("location:admin.php");
}

if(isset($_POST['un-assume'])){
	$sql = "UPDATE $tbl_name SET Trainer = 'NA' WHERE Tracking = '$tracking'";
	$result = mysql_query($sql);
	header("location:admin.php");
}

if(isset($_POST['hide'])){
	$sql = "UPDATE $tbl_name SET Isvisible = 'NO' WHERE Tracking = '$tracking'";
	$result = mysql_query($sql);
	header("location:admin.php");
}

if(isset($_POST['cancel-deadline'])){
	$sql = "UPDATE $tbl_name SET Deadlines1 = 'NA', Deadlines2 = 'NA', Deadlines3 = 'NA',
	Chosen = 'NO' WHERE Tracking = '$tracking'";
	$result = mysql_query($sql);
	$tbl_name = 'calendar_events';
	$sql = "DELETE FROM $tbl_name WHERE event_id = '$tracking'";
	$result = mysql_query($sql);
	header("location:admin.php");
}

if(isset($_POST['file-report'])){
	header("location:report.php?tracking=".$tracking);
}

?>