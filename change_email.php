<?php

session_start();

include('config.php');

if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=$root_url/tms/ivao_login.php");
}

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));

if(isset($_POST['submit'])){
    if($_POST['email'] != ''){
        $id = $_SESSION['id'];
        $email = $_POST['email'];
        $sql = "UPDATE users SET Email = '$email' WHERE ID = '$id'";
        $result = mysqli_query($con,$sql);
        $_SESSION['email'] = $email;
        $success = '1';
    }
    else{
        $error = '1';
    }
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
	<h3>&nbsp Change email address</h3>
</div>
<div id='content'>
<br>
<?php
if($error == '1'){
    echo "<h4>Please enter an email address!</h4>";
}
elseif($success == '1'){
    echo "<h4>Email successfully changed!</h4><h4><a href='myprofile.php'>Return to profile page...</a></h4>";
}
?>
<fieldset>
    <legend>Email change</legend>
    <form id="change_email_form" action="change_email.php" method="post">
        New email address <input type="text" name="email" id="change_email" /> <input class='submit' type="submit" name="submit" value="Submit" />
    </form>
</fieldset>
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>