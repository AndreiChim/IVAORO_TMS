<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}

include('config.php');
$tbl_name = 'training_requests';

$con = mysql_connect($host, $username, $password) or die('Cannot connect to database: ' . mysql_error());
mysql_select_db($db_name, $con) or die('Cannot select database: ' . mysql_error());

if(isset($_POST['deadline'])){
    $deadline = $_POST['deadline'];
}
if(isset($_POST['tracking'])){
    $tracking = $_POST['tracking'];
}
if(isset($_POST['type1'])){
    $type1 = $_POST['type1'];
}
if(isset($_POST['type2'])){
    $type2 = $_POST['type2'];
}
if(isset($_POST['name'])){
    $name = $_POST['name'];
}
if(isset($_POST['trainer'])){
    $trainer = $_POST['trainer'];
}
if(isset($_POST['airport'])){
    $airport = $_POST['airport'];
}

if(isset($_POST['delete'])){
    $sql = "DELETE FROM $tbl_name WHERE Tracking = '$tracking'";
	$result = mysql_query($sql);
    $tbl_name = 'calendar_events';
	$sql = "DELETE FROM $tbl_name WHERE event_id = '$tracking'";
	$result = mysql_query($sql);
	header("location:myprofile.php");
}

if(isset($_POST['submit'])){
	$sql = "UPDATE $tbl_name SET Deadlines1 = '$deadline' WHERE Tracking = '$tracking'";
	$result = mysql_query($sql);
	$sql = "UPDATE $tbl_name SET Chosen = 'YES' WHERE Tracking ='$tracking'";
	$result = mysql_query($sql);
	
	//ADD EVENT TO CALENDAR
    if(($type1 == 'practical' || $type1 == 'EXAM') && ($type2 == 'First Time as ATC on IVAO' || $type2 == 'ADC' || $type2 == 'APC' || $type2 == 'ACC' || $type2 == 'SEC' || $type2 == 'GCA training' || $type2 == 'GCA checkout' || $type2 == 'Advanced ATC topics')){
        $deadline = explode(" ",$deadline);
        $date = explode(".", $deadline[0]);


        switch ($type2) {
            case 'Introduction to IVAO':
                $rating = "<img src='https://ivao.aero/data/images/ratings/pilot/2.gif'>";			
                break;

            case 'First Flight on IVAO':
                $rating = "<img src='https://ivao.aero/data/images/ratings/pilot/2.gif'>";
                break;

            case 'First Time as ATC on IVAO':
                $rating = "<img src='https://ivao.aero/data/images/ratings/atc/2.gif'>";
                break;

            case 'Introduction to phraseology':
                $rating = "<img src='https://ivao.aero/data/images/ratings/pilot/2.gif'>";
                break;
                
            case 'Phraseology practice':
                if($_SESSION['atc_rating'] == 'ADC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/5.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'APC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/6.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'ACC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/7.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'SEC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/8.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'SAI'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/9.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'CAI'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/10.gif'>";
                }
                break;

            case 'ADC':
                $rating = "<img src='https://ivao.aero/data/images/ratings/atc/5.gif'>";
                break;

            case 'APC':
                $rating = "<img src='https://ivao.aero/data/images/ratings/atc/6.gif'>";
                break;

            case 'ACC':
                $rating = "<img src='https://ivao.aero/data/images/ratings/atc/7.gif'>";
                break;

            case 'SEC':
                $rating = "<img src='https://ivao.aero/data/images/ratings/atc/8.gif'>";
                break;

            case 'PP':
                $rating = "<img src='https://ivao.aero/data/images/ratings/pilot/5.gif'>";
                break;

            case 'SPP':
                $rating = "<img src='https://ivao.aero/data/images/ratings/pilot/6.gif'>";
                break;

            case 'CP':
                $rating = "<img src='https://ivao.aero/data/images/ratings/pilot/7.gif'>";
                break;

            case 'ATP':
                $rating = "<img src='https://ivao.aero/data/images/ratings/pilot/8.gif'>";
                break;

            case 'Advanced ATC topics':
                if($_SESSION['atc_rating'] == 'ADC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/5.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'APC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/6.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'ACC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/7.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'SEC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/8.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'SAI'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/9.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'CAI'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/10.gif'>";
                }
                break;

            case 'Advanced Flying topics':
                $rating = "<img src='https://ivao.aero/data/images/ratings/pilot/7.gif'>";
                break;

            case 'GCA training':
                if($_SESSION['atc_rating'] == 'ADC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/5.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'APC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/6.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'ACC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/7.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'SEC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/8.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'SAI'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/9.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'CAI'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/10.gif'>";
                }
                break;
                
            case 'GCA checkout':
                if($_SESSION['atc_rating'] == 'ADC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/5.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'APC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/6.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'ACC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/7.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'SEC'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/8.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'SAI'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/9.gif'>";
                }
                elseif($_SESSION['atc_rating'] == 'CAI'){
                    $rating = "<img src='https://ivao.aero/data/images/ratings/atc/10.gif'>";
                }
                break;

            default:
                $rating = "<img src='https://ivao.aero/data/images/ratings/atc/1.gif'>";
                break;
        }

        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        $time = $deadline[1];
        if($type1 == 'EXAM'){
            $title = "<b>EXAM</b> <br /><br /> ".$rating;
        }
        else{
            $title = "Training <br /><br /> ".$rating;
        }

        $tbl_name = "users";
        $sql = "SELECT * FROM $tbl_name WHERE Name = '$trainer'";
        $result = mysql_query($sql);
        $trainer = mysql_fetch_array($result);
        $trainer_id = $trainer['ID'];
        $id = $_SESSION['id'];

        $tbl_name = "calendar_events";

        $title = mysql_real_escape_string($title);
        $description = "Type: ".$type2." <br /> Person: <a target='blank' href='https://ivao.aero/members/person/details.asp?id=".$id."'>".$id."</a> <br /> Trainer: <a target='blank' href='https://ivao.aero/members/person/details.asp?id=".$trainer_id."'>".$trainer_id."</a> <br /> Location: ".$airport;
        $description = mysql_real_escape_string($description);

        mysql_query("INSERT INTO $tbl_name ( `event_id` , `event_day` , `event_month` , `event_year` , `event_time` , `event_title` , `event_desc` ) VALUES ('$tracking', '$day', '$month', '$year', '$time', '$title', '$description')") or die(mysql_error());
    }
	
	header("location:myprofile.php");
}

?>