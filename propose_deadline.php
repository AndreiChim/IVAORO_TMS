<?php

session_start();

include('config.php');

if($_SESSION['login'] == ''){
	header("location:http://login.ivao.aero/index.php?url=$root_url/ivao_login.php");
}

$tbl_name = 'training_requests';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: ' . mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: ' . mysqli_error($con));

$deadlines1 = $_POST['deadline1'];
$deadlines2 = $_POST['deadline2'];
$deadlines3 = $_POST['deadline3'];
$tracking = $_POST['tracking'];
$email = $_POST['email'];
$name = $_POST['name'];

$sql = "SELECT * FROM $tbl_name WHERE Tracking = '$tracking'";
$result = mysqli_query($con,$sql);
$training_request = mysqli_fetch_array($result);
$type1 = $training_request['Type1'];

if($_POST['deadline1'] == '' && $_POST['deadline2'] == '' && $_POST['deadline3'] == ''){
    echo "<h4>Please enter at least one date! <a href='trainingdet.php?tracking=".$tracking."'>Go back...</a></h4>";
}
else{
    if(isset($_POST['submit'])){
        if($deadlines1 != ''){
            $sql = "UPDATE $tbl_name SET Deadlines1 = '$deadlines1' WHERE Tracking = '$tracking'";
            $result = mysqli_query($con,$sql);
            header("location:admin.php");
        }
        else{
            echo "<h4>Please enter at least a deadline! <a href='trainingdet.php?tracking=".$tracking."'>Go back...</a></h4>";
        }
        if($deadlines2 != ''){
            $sql = "UPDATE $tbl_name SET Deadlines2 = '$deadlines2' WHERE Tracking = '$tracking'";
            $result = mysqli_query($con,$sql);
            header("location:admin.php");
        }
        if($deadlines3 != ''){
            $sql = "UPDATE $tbl_name SET Deadlines3 = '$deadlines3' WHERE Tracking = '$tracking'";
            $result = mysqli_query($con,$sql);
            header("location:admin.php");
        }
        $to = $email;
        $header = "From: IVAO ".$division_long." <".$mailbox.">" . "\r\n" . "Reply-To: ".$division."-TC@ivao.aero, ".$division."-TAC@ivao.aero, ".$division."-HQ@ivao.aero";
        $subject = "[Tracking number: " . $tracking . "] IVAO ".($type1 == "EXAM" ? "Exam": "Training")." Deadline";

        $message = 
"Hello ".$name."!

We are informing you that one of our ".($type1 == "EXAM" ? "examiners": "trainers")." has assumed your request and proposed to you the following available dates for your ".($type1 == "EXAM" ? "exam": "training").":

- ".$deadlines1." UTC
".
($deadlines2 != '' ? "- $deadlines2 UTC
": "").
($deadlines3 != '' ? "- $deadlines3 UTC
": "")."
You should go to the following link, log in with your credentials and choose the time and date most appropriate for you.

".$root_url."/myprofile.php

If you do not agree with any of the proposals of the ".($type1 == "EXAM" ? "examiner": "trainer").", reply to this email requesting a new proposal. Please also keep in mind that after you've chosen a date for your session it cannot be changed except with a good reason.

Should you have any questions regarding your ".($type1 == "EXAM" ? "exam": "training")." request, please reply to this email. We will get back to you as soon as possible.

Kind regards,

IVAO ".$division_long." Training Department

---

You have received this email because you gave your consent to such usage of your email address by confirming a prompt before being able to access the features of our website: ".$root_url.". If you think you should not have been the recipient of such an email, please contact us by replying to it.
";

        // message lines should not exceed 70 characters (PHP rule), so wrap it
        $message = wordwrap($message, 70);
        // send mail
        mail($to, $subject, $message, $header);
    }
    mysqli_close($con);

}

?>