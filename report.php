<?php

session_start();
if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php");
}
elseif($_SESSION['acces'] != 'ADMIN'){
	header("location:noaccess.php");
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
    <?php

    include('config.php');
    $tbl_name = 'training_requests';

    $con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
    mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));

    $tracking = $_GET['tracking'];

    $sql = "SELECT * FROM $tbl_name WHERE Tracking = '$tracking'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);

    ?>
<<<<<<< HEAD
    <h3>&nbsp; <?php if($_GET['submit'] == 'Modify Report') echo "Modify"; ?>Training Report&nbsp; #<?php echo $tracking; ?></h3>
=======
    <h3>&nbsp;<?php if($_GET['submit'] == 'Modify Report') echo "Modify"; ?>Training Report &nbsp;#<?php echo $tracking; ?></h3>
>>>>>>> origin/master
</div>
<div id='content'>
<br>
<form id='filereport' action='filereport.php' method='post'>
<?php

echo "
<table id='filereport' border='0'>
<tr>
			<td class='tablekey'>
				Tracking Number
			</td>
			<td class='tablevalue'>
				<a href='trainingdet.php?tracking=".$row['Tracking']."'>".$row['Tracking']."</a>
			</td>
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
				ID
			</td>
			<td class='tablevalue'>".
				$row['ID'].
			"</td>
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
				Email
			</td>
			<td class='tablevalue'>".
				stripslashes($row['Email']).
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Rating
			</td>
			<td class='tablevalue'>".
				$row['Rating'].
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Airport
			</td>
			<td class='tablevalue'>".
				$row['Airport'].
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
		<tr>";

?>
		<tr>
			<td class='tablekey'>
				Please write a summary of the training process.
			</td>
			<td class='tablevalue'>
				<textarea name='summary'><?php echo nl2br(stripslashes($row['Summary'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Pros
			</td>
			<td class='tablevalue'>
				<textarea name='pros'><?php echo nl2br(stripslashes($row['Pros'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Cons
			</td>
			<td class='tablevalue'>
				<textarea name='cons'><?php echo nl2br(stripslashes($row['Cons'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Suggestions
			</td>
			<td class='tablevalue'>
				<textarea name='suggestions'><?php echo nl2br(stripslashes($row['Suggestions'])); ?></textarea>
			</td>
		</tr>
</table>

<input type='hidden' name='tracking' <?php echo "value='".$tracking."'"; ?> />
<?php
if($_GET['submit'] == "Modify Report")
	echo "<input class='submit' type='submit' name='file-report' value='Modify Report!' />";
else
	echo "<input class='submit' type='submit' name='file-report' value='File Report!' />";
?>

</form>


</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>