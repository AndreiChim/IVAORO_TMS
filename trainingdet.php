<?php

session_start();

include('config.php');

if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=$root_url/ivao_login.php");
}
elseif($_SESSION['acces'] != 'ADMIN'){
	header("location:noaccess.php");
}

?>

<html lang="en">
<head>
	<title>IVAO <?php echo $division_long; ?> TMS</title>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  	<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
  	<!-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="http://jqueryui.com/ui/i18n/jquery.ui.datepicker-fr.js"></script>
    <script src="jquery-ui-timepicker-addon.js"></script>
  	<script src="script.js"></script>
	<link rel="shortcut icon" href="http://www.ivao.aero/favicon.ico">
	<link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="timepicker.css">
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
	<style type="text/css">
		div.ui-datepicker{
 			font-size:85%;
		}
	</style>
</head>
<body>
<div id='container'>
<?php include('banner_menu.php'); ?>
<div id='header'>
<h3>&nbsp Training Details</h3>
</div>
<div id='content'>

<?php
$tbl_name = 'training_requests';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));

$tracking = $_GET['tracking'];

$sql = "SELECT * FROM $tbl_name WHERE Tracking = '$tracking'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

echo
	"<p><a href=admin.php>Return to the Admin Center...</a></p>
	<table id='trainingdet' border='0'>
		<tr>
			<td class='tablekey'>
				Tracking Number
			</td>
			<td class='tablevalue'>".
				$tracking.
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
			" (<a target='blank' href='myprofile.php?id=".$row['ID']."'>Show Training History</a>)</td>
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
			<td class='tablevalue'><a href='mailto:".
                stripslashes($row['Email']).
                "'>".
                stripslashes($row['Email']).
                "</a></td>
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
				Reason
			</td>
			<td class='tablevalue'>".
				stripslashes($row['Reason']).
			"</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Appointment
			</td>
			<td class='tablevalue'>";

			$deadlines1 = $row['Deadlines1'];
			$deadlines2 = $row['Deadlines2'];
			$deadlines3 = $row['Deadlines3'];
			$a = 2;
			$b = 2;

		if($row['Trainer'] == $_SESSION['name']){
			if($row['Chosen'] == 'NO'){
				if($deadlines1 == 'NA'){
					echo "<form id='propose_deadline' action='propose_deadline.php' method='post'>";
					echo "<input type='hidden' name='tracking' value='".$tracking."' />";
					echo "<input type='hidden' name='email' value='".$row['Email']."' />";
					echo "<input type='hidden' name='name' value='".$row['Name']."' />";
					echo "<span class='error'>Time is UTC!</span><br>";
					echo "<input class='datepicker' type='text' name='deadline1' /><br>";
					echo "<input class='datepicker' type='text' name='deadline2' /><br>";
					echo "<input class='datepicker' type='text' name='deadline3' /><br>";
					echo "<input class='submit' type='submit' name='submit' value='Propose Date(s)!' />
						</form>";
				}
				else{
					if($deadlines1 != 'NA' && $deadlines2 != 'NA' && $deadlines3 != 'NA'){
						echo "Proposed dates: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "<option value='".$deadlines3."'>".$deadlines3."</option>";
						echo "</select>";
					}
					elseif($deadlines1 != 'NA' && $deadlines2 != 'NA'){
						echo "Proposed dates: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "</select>";
					}
					else{
						echo "Proposed dates: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "</select>";
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
					echo "<span class='pending'>NA</span>";
				}
				else{
					if($deadlines1 != 'NA' && $deadlines2 != 'NA' && $deadlines3 != 'NA'){
						echo "Proposed dates: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "<option value='".$deadlines3."'>".$deadlines3."</option>";
						echo "</select>";
					}
					elseif($deadlines1 != 'NA' && $deadlines2 != 'NA'){
						echo "Proposed dates: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "</select>";
					}
					else{
						echo "Proposed dates: <select>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "</select>";
					}
				}
			}
			else{
				echo $deadlines1;
			}
		}
				
		echo "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Appointment Status
			</td>
			<td class='tablevalue'>";
			if($row['Chosen'] == 'YES'){
				echo "Set";
			}
			else{
				echo "<span class='pending'>Pending</span>";
			}
				
		echo "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Report Status
			</td>
			<td class='tablevalue'>";
			if($row['ReportStatus'] == 'Filed'){
					echo "Filed (<a href='viewreport.php?tracking=".$tracking."'>Show Report</a>)";
				}
				else{
					echo "<span class='pending'>".$row['ReportStatus']."</span>";
				}
		echo "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Received
			</td>
			<td class='tablevalue'>";
				echo $row['Time_start'];
		echo "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Completed
			</td>
			<td class='tablevalue'>";
				echo $row['Time_end'];
		echo "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Trainer
			</td>
			<td class='tablevalue'>";
			if($row['Trainer'] == 'NA')
				echo "<span class='pending'>Pending</span>";
			else
				echo $row['Trainer'];
		echo "</td>
		</tr>
	</table>";

?>

<form id='assume' action='assume_training.php' method='post'>
	<input type='hidden' name='tracking' <?php echo "value='".$tracking."'"?> />
	<?php
		if($row['Trainer'] == 'NA'){ ?>
			<input class='submit' type='submit' name='assume' value='Assume' />
		<?php
		}
		elseif($row['Trainer'] == $_SESSION['name']){
			if($deadlines1 != 'NA'){ 
				if($row['ReportStatus'] == 'Pending'){ 
					if($row['Chosen'] == 'YES'){ ?>
						<input class='submit' type='submit' name='file-report' value='File Report' />
					<?php
					}
					?>
					<input class='submit' type='submit' name='cancel-deadline' value='Cancel Appointment' />
				<?php
				}
			}
			?>
			<input class='submit' type='submit' name='un-assume' value='Release' />
			<input class='submit' type='submit' name='delete' value='Delete' />
            <input class='submit' type='submit' name='hide' value='Hide' />
		<?php
		}
		else{
			echo '';
		}
		?>
</form>

</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>