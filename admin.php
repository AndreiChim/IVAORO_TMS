<?php

session_start();

if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php");
}
elseif($_SESSION['acces'] != 'ADMIN'){
	header("location:noaccess.php");
}

if($_SESSION['admin_dataprotection'] == 'NO'){
    header("location:admin_dataprotection.php?target=admin");
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
<h3>&nbsp Admin Center</h3>
</div>
<div id='content'>
<h4>Here you can administrate the TMS.</h4>

<?php

include('config.php');
$tbl_name = 'training_requests';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));

$sql = "SELECT * FROM $tbl_name WHERE ReportStatus = 'Pending'";

$result = mysqli_query($con,$sql) or die(mysqli_error($con));

?>

<h4>Active Training Requests</h4>

<table id='mytrainings' class='admintrainings'>
	<tr>
		<td class='tablekey'>
			Tracking Number
		</td>
		<td class='tablekey'>
			Type
		</td>
		<td class='tablekey'>
			Rating
		</td>
		<td class='tablekey'>
			Airport
		</td>
		<td class='tablekey'>
			Deadline
		</td>
		<td class='tablekey'>
			Actions
		</td>
	</tr>
	<?php
	while($row = mysqli_fetch_array($result)){
		if($row['Isvisible'] == 'YES'){?>
	<tr>
		<td class='tablevalue'>
			<?php echo "<a href='trainingdet.php?tracking=".$row['Tracking']."'>".$row['Tracking']."</a>";
			$tracking = $row['Tracking']; ?>
		</td>
		<td class='tablevalue' style="width:100px;">
			<?php echo $row['Type2']." - ".$row['Type1']; ?>
		</td>
		<td class='tablevalue'>
			<?php echo $row['Rating']; ?>
		</td>
		<td class='tablevalue'>
			<?php echo $row['Airport']; ?>
		</td>
		<td class='tablevalue'>
		<?php
		$deadlines1 = $row['Deadlines1'];
		$deadlines2 = $row['Deadlines2'];
		$deadlines3 = $row['Deadlines3'];

 		if($row['Trainer'] == $_SESSION['name']){
			if($row['Chosen'] == 'NO'){
				if($deadlines1 == 'NA' && $deadlines2 == 'NA' && $deadlines3 == 'NA'){
					echo "<a href='trainingdet.php?tracking=".$tracking."'><span class='pending'>Propose deadline!</span></a>";
				}
				else{
					if($deadlines1 != 'NA' && $deadlines2 != 'NA' && $deadlines3 != 'NA'){
						echo "Proposed deadlines: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "<option value='".$deadlines3."'>".$deadlines3."</option>";
						echo "</select>";
					}
					elseif($deadlines1 != 'NA' && $deadlines2 != 'NA'){
						echo "Proposed deadlines: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "</select>";
					}
					elseif($deadlines1 != 'NA'){
						echo "Proposed deadlines: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "</select>";
					}
					else{
						echo "ERROR. Contact the administrator!";
					}
				}
			}
			else{
				echo $deadlines1;
			}
		}
		elseif($row['Trainer'] == 'NA'){
			echo "<span class='pending'>Please assume the request first!</span>";
		}
		else{
			if($row['Chosen'] == 'NO'){
				if($deadlines1 == 'NA'){
					echo "<span class='pending'>Pending</span>";
				}
				else{
					if($deadlines1 != 'NA' && $deadlines2 != 'NA' && $deadlines3 != 'NA'){
						echo "Proposed deadlines: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "<option value='".$deadlines3."'>".$deadlines3."</option>";
						echo "</select>";
					}
					elseif($deadlines1 != 'NA' && $deadlines2 != 'NA'){
						echo "Proposed deadlines: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "</select>";
					}
					else{
						echo "Proposed deadlines: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "</select>";
					}
				}
			}
			else{
				echo $deadlines1;
			}
		}
		?>

		</td>
		<td class='tablevalue'>
			<form id='assume' action='assume_training.php' method='post'>
				<input type='hidden' name='tracking' <?php echo "value='".$tracking."'"?> />
				<?php
				if($row['Trainer'] == 'NA'){ ?>
				<input class='submit' type='submit' name='assume' value='Assume' />
				<?php
				}
				elseif($row['Trainer'] == $_SESSION['name']){
                if($row['Chosen'] == 'YES' && $row['ReportStatus'] == 'Pending'){?>
                <input class='submit' type='submit' name='file-report' value='File Report' />
                <?php }
                if($row['Deadlines1'] != 'NA'){ ?>
                <input class='submit' type='submit' name='cancel-deadline' value='Cancel' />
                <?php }
                if($row['Deadlines1'] == 'NA'){ ?>
				<input class='submit' type='submit' name='un-assume' value='Release' />
				<?php
				}
                }
				else{
					echo $row['Trainer'];
				}
				?>
			</form>
		</td>
	</tr>
	<?php
	}
}
	?>
</table>

<?php
$sql = "SELECT * FROM $tbl_name WHERE ReportStatus = 'Filed'";

$result = mysqli_query($con,$sql) or die(mysqli_error($con));
?>

<!-- SECOND TABLE -->

<h4>Recently completed trainings</h4>

<table id='mytrainings' class='admintrainings' border = '0'>
	<tr>
		<td class='tablekey'>
			Tracking Number
		</td>
		<td class='tablekey'>
			Type
		</td>
		<td class='tablekey'>
			Rating
		</td>
		<td class='tablekey'>
			Airport
		</td>
		<td class='tablekey'>
			Deadline
		</td>
		<td class='tablekey'>
			Actions
		</td>
	</tr>
	<?php
	while($row = mysqli_fetch_array($result)){
		if($row['Isvisible'] == 'YES'){ ?>
	<tr>
		<td class='tablevalue'>
			<?php echo "<a href='trainingdet.php?tracking=".$row['Tracking']."'>".$row['Tracking']."</a>";
			$tracking = $row['Tracking']; ?>
		</td>
		<td class='tablevalue' style="width:100px;">
			<?php echo $row['Type2']." - ".$row['Type1']; ?>
		</td>
		<td class='tablevalue'>
			<?php echo $row['Rating']; ?>
		</td>
		<td class='tablevalue'>
			<?php echo $row['Airport']; ?>
		</td>
		<td class='tablevalue'>
		<?php
		$deadlines1 = $row['Deadlines1'];
		echo $deadlines1;
		?>

		</td>
		<td class='tablevalue'>
			<form id='assume' action='assume_training.php' method='post'>
				<input type='hidden' name='tracking' <?php echo "value='".$tracking."'"?> />
				<input class='submit' type='submit' name='hide' value='Hide' />
			</form>
		</td>
	</tr>
	<?php
	}
}
	?>
</table>

</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>