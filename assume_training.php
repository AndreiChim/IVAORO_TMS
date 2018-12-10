<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}

include('config.php');
$tbl_name = 'training_requests';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: ' . mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: ' . mysqli_error($con));

$trainer = $_SESSION['name'];
$tracking = $_POST['tracking'];

if(isset($_POST['assume'])){
	$sql = "UPDATE $tbl_name SET Trainer = '$trainer' WHERE Tracking = '$tracking'";
	$result = mysqli_query($con,$sql);
	header("location:admin.php");
}

if(isset($_POST['delete'])){
	$sql = "DELETE FROM $tbl_name WHERE Tracking = '$tracking'";
	$result = mysqli_query($con,$sql);
    $tbl_name = 'calendar_events';
	$sql = "DELETE FROM $tbl_name WHERE event_id = '$tracking'";
	$result = mysqli_query($con,$sql);
	header("location:admin.php");
}

if(isset($_POST['un-assume'])){
	$sql = "UPDATE $tbl_name SET Trainer = 'NA' WHERE Tracking = '$tracking'";
	$result = mysqli_query($con,$sql);
	header("location:admin.php");
}

if(isset($_POST['hide'])){
	$sql = "UPDATE $tbl_name SET Isvisible = 'NO' WHERE Tracking = '$tracking'";
	$result = mysqli_query($con,$sql);
	header("location:admin.php");
}

if(isset($_POST['cancel-deadline'])){
	$sql = "UPDATE $tbl_name SET Deadlines1 = 'NA', Deadlines2 = 'NA', Deadlines3 = 'NA',
	Chosen = 'NO' WHERE Tracking = '$tracking'";
	$result = mysqli_query($con,$sql);
	$tbl_name = 'calendar_events';
	$sql = "DELETE FROM $tbl_name WHERE event_id = '$tracking'";
	$result = mysqli_query($con,$sql);
	header("location:admin.php");
}

if(isset($_POST['file-report'])){
	header("location:report.php?tracking=".$tracking);
}

?>