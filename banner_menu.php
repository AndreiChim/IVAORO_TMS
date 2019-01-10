<!--
    <div id="under_construction">
        &nbsp;
		This website is still in a test phase! If you find any errors, please write a mail to <a href='mailto:ro-tc@ivao.aero'>RO-TC</a>
	</div>
-->
	<div id="banner">
		<img src="banner_main.jpg" alt="banner">
	</div>

	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<?php include('config.php');
			if(!isset($_SESSION['login'])){ ?>
				<!-- <li><a href="index.php?page=main_login">Login</a></li>
				<li><a href="index.php?page=registration">Register</a></li> -->
                <li><a href="http://login.ivao.aero/index.php?url=<?php echo $root_url; ?>/ivao_login.php">Login with IVAO</a></li>
			<?php } 
			else{ ?>
				<li><a href='myprofile.php'>My Profile</a></li>
				<li><a href='request_training.php'>Request Training</a></li>
				<?php
				if($_SESSION['acces'] == 'ADMIN'){ ?>
				<li><a href='admin.php'>Staff Only</a></li>
				<?php
				} ?>
				<li><a href="logout.php">Logout</a></li>
			<?php } ?>
		</ul>
	</nav>