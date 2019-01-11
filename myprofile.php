<?php

session_start();

include('config.php');

if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=$root_url/ivao_login.php");
}

if($_SESSION['member_dataprotection'] == 'NO'){
    header("location:member_dataprotection.php?target=myprofile");
}

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));
    
if(isset($_GET['id']) && $_SESSION['acces'] == 'ADMIN'){
    $id = $_GET['id'];
}
elseif(isset($_GET['id'])){
    header('location:noaccess.php');
}
else{
    $id = $_SESSION['id'];
}

$tbl_name = "users";
$sql = "SELECT * FROM $tbl_name WHERE ID = '$id'";
$result = mysqli_query($con,$sql) or die(mysqli_error($con));
$user = mysqli_fetch_array($result);
$name = $user['Name'];
$email = $user['Email'];
$rating = $user['Rating'];
$user_division = $user['Division'];
$acces = $user['Acces'];

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
	<h3>&nbsp <?php if($_SESSION['id'] == $id) echo 'My'; else echo 'User'; ?> Profile</h3>
</div>
<div id='content'>
<br>
<?php
    
if($acces == 'ADMIN'){
	echo "<a href='https://visualpharm.com/free-icons/admin%20settings%20male-595b40b85ba036ed117dbebc'><img class='rating' src='admin_icon.svg' alt='ADMIN'></a>";
}
else{
	echo "<a href='http://www.onlinewebfonts.com'><img class='rating' src='user_icon.svg' alt='USER'></a>";
}

if($_SESSION['id'] == $id){
    echo
        "<table id='myprofile' border='0'>
		<tr>
			<td class='tablekey'>
				VID
			</td>
			<td class='tablevalue'>".
        $id.
        "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Name
			</td>
			<td class='tablevalue'>".
        $name.
        "</td>
		</tr>
        <tr>
			<td class='tablekey'>
				Rating
			</td>
			<td class='tablevalue'>".
        $rating.
        "</td>
		</tr>
        <tr>
			<td class='tablekey'>
				Division
			</td>
			<td class='tablevalue'>".
        $user_division.
        "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Email
			</td>
			<td class='tablevalue'>".
        stripslashes($email).
        " (<a href='change_email.php'>change email</a>)</td>
		</tr>
	</table>";
}
else{
    echo
        "<table id='myprofile' border='0'>
		<tr>
			<td class='tablekey'>
				VID
			</td>
			<td class='tablevalue'>".
        $id.
        "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Name
			</td>
			<td class='tablevalue'>".
        $name.
        "</td>
		</tr>
        <tr>
			<td class='tablekey'>
				Rating
			</td>
			<td class='tablevalue'>".
        $rating.
        "</td>
		</tr>
        <tr>
			<td class='tablekey'>
				Division
			</td>
			<td class='tablevalue'>".
        $user_division.
        "</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Email
			</td>
			<td class='tablevalue'>".
        stripslashes($email).
        "</td>
		</tr>
	</table>";
}


// connection

$tbl_name = "training_requests";

$sql = "SELECT * FROM $tbl_name WHERE ID = '$id' AND Deadlines1 = 'NA'";

$result = mysqli_query($con,$sql) or die(mysqli_error($con));

$count_cancelable = mysqli_num_rows($result);

?>

<h4>Training History</h4>

<fieldset>
	<legend><span class='error'>Important information!</span></legend>
	<p><span class='error'>All times in the deadlines are UTC! If you do not agree with any of the proposals of the trainer, send an email to
		<a href='mailto:<?php echo $division; ?>-TC@ivao.aero'><?php echo $division; ?>-TC</a> requesting a deadline change. </span>
	</p>
    <p>
        <span class='error'>
            Please meet with the trainer at the set time and date on the IVAO <?php echo $division_long; ?> Discord server. If you haven't already joined the server, please use this invite link: <a href='<?php echo $discord_link; ?>' target="_blank"><?php echo $discord_link; ?></a>
        </span>
    </p>
</fieldset>
<br>

<table id='mytrainings' class='admintrainings'>
	<tr>
		<td class='tablekey'>
			Tracking Number
		</td>
		<td class='tablekey'>
			Type
		</td>
		<td class='tablekey'>
			Current Rating
		</td>
		<td class='tablekey'>
			Location
		</td>
		<td class='tablekey'>
			Appointment
		</td>
		<td class='tablekey'>
			Trainer
		</td>
		<td class='tablekey'>
			Report
		</td>
        <?php
        if($count_cancelable >= 1 && $_SESSION['id'] == $id){ ?>
        <td class='tablekey'>
            Actions
        </td>
        <?php 
        }
        $sql = "SELECT * FROM $tbl_name WHERE ID = '$id'";
        $result = mysqli_query($con,$sql) or die(mysqli_error($con));
        $count = mysqli_num_rows($result);
        ?>
	</tr>
	<?php
	if($count != 0){
		while($row = mysqli_fetch_array($result)){ ?>
		<tr>
			<td class='tablevalue'>
				<?php echo $row['Tracking']; $tracking = $row['Tracking']; ?>
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

				if($row['Chosen'] == 'NO'){
					if($deadlines1 != 'NA' && $deadlines2 != 'NA' && $deadlines3 != 'NA'){
						echo "<form id='choose_deadline' action='choose_deadline.php' method='post'><select class='deadline_select' name='deadline'>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "<option value='".$deadlines3."'>".$deadlines3."</option>";
						echo "</select>";
					}
					elseif($deadlines1 != 'NA' && $deadlines2 != 'NA'){
						echo "<form id='choose_deadline' action='choose_deadline.php' method='post'><select class='deadline_select' name='deadline'>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "<option value='".$deadlines2."'>".$deadlines2."</option>";
						echo "</select>";
					}
					elseif($deadlines1 != 'NA'){
						echo "<form id='choose_deadline' action='choose_deadline.php' method='post'><select class='deadline_select' name='deadline'>";
						echo "<option value='".$deadlines1."'>".$deadlines1."</option>";
						echo "</select>";
					}
					else{
						echo "<span class='pending'>Pending</pending>";
					}
					if($deadlines1 != 'NA'){
						if($_SESSION['id'] == $id){ echo "<input class='submit' type='submit' name='submit' value='Choose' />";}
						echo "<input type='hidden' name='tracking' value='".$tracking."' />
						<input type='hidden' name='type1' value='".$row['Type1']."' />
						<input type='hidden' name='type2' value='".$row['Type2']."' />
						<input type='hidden' name='name' value='".$row['Name']."' />
						<input type='hidden' name='trainer' value='".$row['Trainer']."' />
						<input type='hidden' name='airport' value='".$row['Airport']."' />
						</form>";
					}
				}
				else{
					echo $deadlines1;
				}
				?>
			</td>
			<td class='tablevalue'>
				<?php
				if($row['Trainer'] == 'NA'){
					echo "<span class='pending'>Pending</span>";
				}
				else{
					echo $row['Trainer'];
				}
				?>
			</td>
			<td class='tablevalue'>
				<?php
				if($row['ReportStatus'] == 'Filed'){
					echo "<a href='viewreport.php?tracking=".$tracking."'>Show</a>";
				}
				else{
					echo "<span class='pending'>".$row['ReportStatus']."</span>";
				}
				?>
            <td class='tablevalue'>
                <?php
                if($deadlines1 == 'NA' && $_SESSION['id'] == $id){
                    echo "<form id='myprofile_actions' action='choose_deadline.php' method='post'>
                    <input class='submit' type='submit' name='delete' value='Cancel' />
                    <input type='hidden' name='tracking' value='".$tracking."' />
                    </form>";
                }
                ?>
            </td>
		</tr>
		<?php
		}
	}
	elseif($_SESSION['id'] == $id){
		echo "<h4>You currently don't have any training records.</h4>";
	}
	else{
        echo "<h4>No training records.</h4>";
    }
	mysqli_close($con);
		?>
</table>

<br>
<?php
if($_SESSION['id'] == $id) {
?>
    <form id='download_info' action='download_info.php' method='post'>
        <input class='submit' type='submit' name='submit'
               value='Download my personal data from the IVAO <?php echo $division; ?> database!'/>
    </form>
    <form id='delete_account' action='delete_account.php' method='post'>
        <input class='submit' type='submit' name='submit'
               value='Delete my account from the IVAO <?php echo $division; ?> database!'/>
    </form>
<?php
}
?>
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>