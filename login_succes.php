<?php

session_start();
if($_SESSION['login'] == ''){
	header("location:index.php?page=main_login");
}
else{
	header("refresh:3;url=myprofile.php");
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
<div id='content'>

<h4>Login successful!</h4>

<p>You will be redirected to your profile page in 3 seconds.</p>
<p>To access the page immediately click <a href="myprofile.php">here</a></p>

</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>