<?php

$error = $_GET['error'];

if($error == 1){
	$error = 'password';
}
else{
	$error = 'username';
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
	<h3> Login failed </h3>
</div>
<div id='content'>

<h4>Wrong <?php echo $error; ?>!</h4>
<h4>Go back and <a href='index.php?page=main_login'>try again</a>!</h4>

</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>