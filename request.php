<?php

session_start();

include('config.php');

if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=$root_url/ivao_login.php");
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
<h3>&nbsp Request a training</h3>
</div>
<div id='content'>

<?php

$tbl_name = 'training_requests';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: ' . mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: ' . mysqli_error($con));

$id = $_SESSION['id'];
$name = $_SESSION['name'];
$email = $_POST['email'];
$type1 = $_POST['training_type1'];
$type2 = $_POST['training_type2'];
$rating = $_SESSION['rating'];
$airport = $_POST['airport'];
$reason = $_POST['reason'];
$reason = nl2br($reason);

$time_start = date('d.m.Y H:i:s');

$reason = mysqli_real_escape_string($con,$reason);
$email = mysqli_real_escape_string($con,$email);

if(isset($_POST['submit'])){
	if(empty($type1) || empty($type2) || empty($airport) || empty($reason) || empty($email)){
		echo "<h4>Please fill in all the fields!</h4>";
		echo "<h4><a href='javascript:history.go(-1)'>Return to the previous page...</a></h4>";
	}
	else{
		$sql = "INSERT INTO $tbl_name (ID, Name, Email, Type1, Type2, Rating, Airport, Reason, Time_start)
			VALUES ('$id', '$name', '$email', '$type1', '$type2', '$rating', '$airport', '$reason', '$time_start')";
		$result = mysqli_query($con,$sql) or die(mysqli_error($con));
        
        $sql = "SELECT * FROM $tbl_name WHERE ID = '$id' AND Time_start = '$time_start'";
        $result = mysqli_query($con,$sql);
        $training_request = mysqli_fetch_array($result);
        $tracking = $training_request['Tracking'];

        $tbl_name = 'users';
        $sql = "UPDATE $tbl_name SET Email = '$email' WHERE ID = '$id'";
        $result = mysqli_query($con,$sql);
        $_SESSION['email'] = $email;

        $to = $email;
        $header = "From: IVAO ".$division_long." <".$mailbox.">" . "\r\n" . "Reply-To: ".$division."-TC@ivao.aero\r\n";
        $header.= "MIME-Version: 1.0\r\n";
        $header.= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $header.= "X-Priority: 1\r\n";
        if($type1 == "EXAM"){
            $subject = "[Tracking number: " . $tracking . "] IVAO Practical Exam Scheduling: $type2";

        $message = 
"Hello ".$name."!

Thank you for your interest in a practical exam! Your request has been registered and soon one of our examiners will assume it and propose available dates. 

IMPORTANT: Make sure you have requested the exam on the IVAO main website at

https://www.ivao.aero/training/exam/status.asp

or else we will refuse to process your exam deadline request here.

If you do not want to perform this exam anymore or if you made this request by mistake, you can go to your profile page at

".$root_url."/myprofile.php

and cancel it. Be aware you can only cancel a request by yourself before a trainer has proposed deadlines.

IMPORTANT: If you wish to cancel a request already made on the IVAO main website, you need to write an email to ro-tc@ivao.aero requesting a cancellation.

While you are waiting for your exam, you should browse the relevant exam briefing available at

https://www.ivao.aero/ViewDocument.aspx?Path=/training:atc:ratings or
https://www.ivao.aero/ViewDocument.aspx?Path=/training:pilot:ratings

and the available documentation at

https://www.ivao.aero/training/atc/TOC_documents.asp or
https://www.ivao.aero/training/pilot/TOC_documents.asp

Should you have any questions regarding your practical exam, please reply to this email. We will get back to you as soon as possible.

Kind regards,

IVAO ".$division_long." Training Department

---

You have received this email because you gave your consent to such usage of your email address by confirming a prompt before being able to access the features of our website: ".$root_url.". If you think you should not have been the recipient of such an email, please contact us by replying to it.
";
        }
        else{
            $subject = "[Tracking number: " . $tracking . "] IVAO Training Request: $type2 - $type1";

        $message = 
"Hello ".$name."!

Thank you for your interest in a training session with us! Your request has been registered and soon one of our trainers will assume it and propose available dates.

If you do not want to perform this training anymore or if you made this request by mistake, you can go to your profile page at

".$root_url."myprofile.php

and cancel it. Be aware you can only cancel a request by yourself before a trainer has proposed deadlines. After that you will need to contact us by replying to this email and provide a good reason.

While you are waiting for your training, you should browse the relevant documentation available at

http://mediawiki.ivao.aero/index.php?title=Training_Documentation and
http://ro.ivao.aero

in order to familiarize yourself with the skills you are going to practice during the session.

Should you have any questions regarding your training request, please reply to this email. We will get back to you as soon as possible.

Kind regards,

IVAO ".$division_long." Training Department

---

You have received this email because you gave your consent to such usage of your email address by confirming a prompt before being able to access the features of our website: ".$root_url.". If you think you should not have been the recipient of such an email, please contact us by replying to it.
";
        }

        // message lines should not exceed 70 characters (PHP rule), so wrap it
        $message = wordwrap($message, 70);
        // send mail
        mail($to, $subject, $message, $header);

        // Send email notification to all division training staff when a new request comes in
        $subject = "[Tracking number: $tracking] NEW TMS REQUEST";
        $message = "
Hello!

A new request has been submitted in the TMS. Please go to the admin page and assume it if you are available.

Tracking number: $tracking
Type: $type2 - $type1
Member: $name ($id)
Current rating: $rating
Training Location: $airport

Comment: $reason

---

This email was sent to all $division division trainers. If you would like us to stop sending you such reminders, please reply to this email.
";
        $message = wordwrap($message, 70);
        $training_staff_emails = array('ro-tc@ivao.aero', 'ro-tac@ivao.aero', 'ro-ta1@ivao.aero', 'ro-adir@ivao.aero', 'ro-t01@ivao.aero', 'ro-t02@ivao.aero');
        foreach($training_staff_emails as $to){
            mail($to, $subject, $message, $header);
        }

        
		echo "<h4>Your training request has been processed.</h4>
		 <h4>A trainer will contact you shortly.</h4>
		 <h4><a href='myprofile.php'>Return to your profile</a></h4>";
	}
}

?>

</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>