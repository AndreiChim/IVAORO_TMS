<?php

session_start();

include('config.php');

if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=$root_url/ivao_login.php");
}

$tbl_name = 'training_requests';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: ' . mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: ' . mysqli_error($con));

$summary = $_POST['summary'];
$summary = mysqli_real_escape_string($con,$summary);
$pros = $_POST['pros'];
$pros = mysqli_real_escape_string($con,$pros);
$cons = $_POST['cons'];
$cons = mysqli_real_escape_string($con,$cons);
$suggestions = $_POST['suggestions'];
$suggestions = mysqli_real_escape_string($con,$suggestions);
$tracking = $_POST['tracking'];

$time_end = date('d.m.Y H:i:s');


if(isset($_POST['file-report'])){
	$sql = "UPDATE $tbl_name SET ReportStatus = 'Filed', Summary = '$summary', Pros = '$pros', 
	Cons = '$cons', Suggestions = '$suggestions', Time_end = '$time_end' WHERE Tracking = '$tracking'";

	$result = mysqli_query($con,$sql);
    
    $sql = "SELECT * FROM $tbl_name WHERE Tracking = '$tracking'";
    
    $result = mysqli_query($con,$sql);
    $request = mysqli_fetch_array($result);
    
    $email = $request['Email'];
    $name = $request['Name'];
    
    $to = $email;
    $header = "From: IVAO ".$division_long." <".$mailbox.">" . "\r\n" . "Reply-To: ".$division."-TC@ivao.aero, ".$division."-TAC@ivao.aero, ".$division."-HQ@ivao.aero";
    $subject = "[Tracking number: " . $tracking . "] IVAO Training Report";

    $message =
"Hello ".$name."!

Your training has been completed and your trainer has filed a report. Please review it by accessing your personal profile at:

".$root_url."/myprofile.php

Should you have any questions or feedback regarding your training, please reply to this email. We will get back to you as soon as possible.

Kind regards,

IVAO ".$division_long." Training Department

---

You have received this email because you gave your consent to such usage of your email address by confirming a prompt before being able to access the features of our website: ".$root_url.". If you think you should not have been the recipient of such an email, please contact us by replying to it.
";

    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail($to, $subject, $message, $header);
    
    header("location:admin.php");
}

?>