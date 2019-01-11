<?php

session_start();

include('config.php');

if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=$root_url/ivao_login.php");
}

?>

<html lang="en">
<head>
	<title>IVAO <?php echo $division_long; ?> TMS</title>
	<link rel="shortcut icon" href="http://www.ivao.aero/favicon.ico">
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<div id='container'>
<?php include('banner_menu.php'); ?>
<div id='header'>
<h3>&nbsp Training Report</h3>
</div>
<div id='content'>

<?php
$tracking = $_GET['tracking'];

if($_SESSION['acces'] == 'ADMIN'){
	echo "<p><a href='trainingdet.php?tracking=$tracking'>Return to Training Details...</a></p>";
}
else{
	echo "<p><a href='myprofile.php'>Return to your profile page...</a></p>";
}

$tbl_name = 'training_requests';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));

$sql = "SELECT * FROM $tbl_name WHERE Tracking = '$tracking'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

echo "
<table id='filereport' border='0'>
<tr>
			<td class='tablekey'>
				Tracking Number
			</td>
			<td class='tablevalue'>".
                $row['Tracking'].
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Type
			</td>
			<td class='tablevalue'>".
				$row['Type2']." - ".$row['Type1'].
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				VID
			</td>
			<td class='tablevalue'><a target='blank' href='https://ivao.aero/members/person/details.asp?id=".
				$row['ID'].
			"'>".
				$row['ID'].
			"</a></td>
		</tr>
		<tr>
			<td class='tablekey'>
				Name
			</td>
			<td class='tablevalue'>".
				$row['Name'].
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Current Rating
			</td>
			<td class='tablevalue'>".
                $row['Rating'].
            "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Email
			</td>
			<td class='tablevalue'>".
				stripslashes($row['Email']).
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Location
			</td>
			<td class='tablevalue'>".
				$row['Airport'].
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Appointment
			</td>
			<td class='tablevalue'>".
                $row['Deadlines1'].
            "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Trainer
			</td>
			<td class='tablevalue'>".
				$row['Trainer'].
			"</td>
		</tr>
		<tr>
		<tr>
			<td class='tablekey'>
				Summary
			</td>
			<td class='tablevalue'>".
				nl2br(stripslashes($row['Summary'])).
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Pros
			</td>
			<td class='tablevalue'>".
				nl2br(stripslashes($row['Pros'])).
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Cons
			</td>
			<td class='tablevalue'>".
				nl2br(stripslashes($row['Cons'])).
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Suggestions
			</td>
			<td class='tablevalue'>".
				nl2br(stripslashes($row['Suggestions'])).
			"</td>
		</tr>
</table>";

if($_SESSION['acces'] == 'ADMIN'){ ?>

<form action="report.php" method='get'>
	<input type='hidden' name='tracking' value='<?php echo $row['Tracking'] ?>' />
    <input class='submit' type="submit" name='submit' value="Modify Report!" />
</form>

<?php } ?>

</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>