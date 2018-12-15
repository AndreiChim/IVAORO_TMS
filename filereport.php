<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}

include('config.php');
$tbl_name = 'training_requests';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: ' . mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: ' . mysqli_error($con));

$summary = nl2br($_POST['summary']);
$summary = mysqli_real_escape_string($con,$summary);
$pros = nl2br($_POST['pros']);
$pros = mysqli_real_escape_string($con,$pros);
$cons = nl2br($_POST['cons']);
$cons = mysqli_real_escape_string($con,$cons);
$suggestions = nl2br($_POST['suggestions']);
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
        $header = "From: IVAO Romania <tms@ro.ivao.aero>" . "\r\n" . "Reply-To: ro-tc@ivao.aero, ro-tac@ivao.aero, ro-hq@ivao.aero";
        $subject = "[Tracking number: " . $tracking . "] IVAO Training Report";

        $message = 
"Hello ".$name."!

Your training has been completed and your trainer has filed a report. Please review it by accessing your personal profile at:

http://ro.ivao.aero/tms/myprofile.php

Should you have any questions or feedback regarding your training, please reply to this email. We will get back to you as soon as possible.

Kind regards,

IVAO Romania Training Department

---

You have received this email because you gave your consent to such usage of your email address by confirming a prompt before being able to access the features of our website: ro.ivao.aero/tms. If you think you should not have been the recipient of such an email, please contact us by replying to it.
";

    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail($to, $subject, $message, $header);
    
    header("location:admin.php");
}

?>