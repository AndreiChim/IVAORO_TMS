<?php
session_start();

include("config.php");

if(isset($_GET['page'])){
			if($_GET['page'] == 'main_login' && isset($_SESSION['login'])){
				header("location:myprofile.php");
			}
		}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>IVAO <?php echo $division_long; ?> TMS</title>
	<link rel="shortcut icon" href="http://www.ivao.aero/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="main.css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div id="container">
	<?php
		include("banner_menu.php");
		if(isset($_GET['page'])){
			include($_GET['page'].'.php');
		}
		else{
			include("home.php");
		}
		include('footer.php');
	?>
<!-- This closes the "container" div -->
</div>
</body>
</html>