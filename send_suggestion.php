<html lang="en">
<head>
<title>IVAO Romania TMS</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<div id="container">
<?php
include("banner_menu.php");
?>
<div id="content">
<?php
if(isset($_POST['submit'])){
	$subject = "Suggestion for the TMS";
	$message = $_POST['suggestion'];
	$from = $_POST['mail'];
	$headers = "From: " . $from;
	$to = "wilhelm.andrei.bubeneck@ivao.aero";
	$send_suggestion = mail($to, $subject, $message, $headers);
	// check if sent
	if($send_suggestion == true){
		echo "<h4>We've received your message! Thank you!</h4>";
	}
	else{
		echo "<h4>Error! Message not sent succesfully! Please try again!</h4>";
	}
}
?>
<h4><a href="index.php?page=home">Return to the main page...</a></h4>
</div>
<?php
include("footer.php")
?>
</div>
</body>
</html>