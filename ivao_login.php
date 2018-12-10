<?php

include('config.php');
$tbl_name = 'users';

//connect to mysql
$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: ' . mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: ' . mysqli_error($con));

if($_GET['IVAOTOKEN'] && $_GET['IVAOTOKEN'] !== 'error') {
    $token = $_GET['IVAOTOKEN'];
    //login via API successful -> get data from IVAO
    $xml = simplexml_load_file('http://login.ivao.aero/api.php?token='.$_GET['IVAOTOKEN']);
	if($xml[0]->result == 1) {
		//Success! A user has been found!
        //check if user already in our own database
        $id = $xml[0]->vid;
        $sql = "SELECT * FROM $tbl_name WHERE ID = '$id'";
        $result = mysqli_query($con,$sql, $con);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        
        if($count == 1){
            $atc_rating = $xml[0]->ratingatc;
            $pilot_rating = $xml[0]->ratingpilot;
            
            switch($atc_rating){
                case 1:
                    $atc_rating = "";
                    break;
                case 2:
                    $atc_rating = "AS1";
                    break;
                case 3:
                    $atc_rating = "AS2";
                    break;
                case 4:
                    $atc_rating = "AS3";
                    break;
                case 5:
                    $atc_rating = "ADC";
                    break;
                case 6:
                    $atc_rating = "APC";
                    break;
                case 7:
                    $atc_rating = "ACC";
                    break;
                case 8:
                    $atc_rating = "SEC";
                    break;
                case 9:
                    $atc_rating = "SAI";
                    break;
                case 10:
                    $atc_rating = "CAI";
                    break;
            }
            switch($pilot_rating){
                case 1:
                    $pilot_rating = "";
                    break;
                case 2:
                    $pilot_rating = "FS1";
                    break;
                case 3:
                    $pilot_rating = "FS2";
                    break;
                case 4:
                    $pilot_rating = "FS3";
                    break;
                case 5:
                    $pilot_rating = "PP";
                    break;
                case 6:
                    $pilot_rating = "SPP";
                    break;
                case 7:
                    $pilot_rating = "CP";
                    break;
                case 8:
                    $pilot_rating = "ATP";
                    break;
                case 9:
                    $pilot_rating = "SFI";
                    break;
                case 10:
                    $pilot_rating = "CFI";
                    break;
            }
            
            if($atc_rating == ''){
                $rating = $pilot_rating;
            }
            elseif($pilot_rating == ''){
                $rating = $atc_rating;
            }
            else{
                $rating = $atc_rating . '/' . $pilot_rating;
            }
            
            if($rating != stripslashes($row['Rating'])){
                $sql = "UPDATE $tbl_name SET Rating = '$rating' WHERE ID = '$id'";
                $result = mysqli_query($con,$sql);
            }
            
            $division = utf8_decode($xml[0]->division);
            if($division != $row['Division']){
                $sql = "UPDATE $tbl_name SET Division = '$division' WHERE ID = '$id'";
                $result = mysqli_query($con,$sql);
            }

            $staff = utf8_decode($xml[0]->staff);
            $staff_positions = explode(":", $staff);
            $acces = "USER";
            $test = "";
            foreach($staff_positions as $staff_position){
                if($staff_position == "RO-DIR" || $staff_position == "RO-ADIR" || $staff_position == "RO-TC" ||
                    $staff_position == "RO-TAC" || $staff_position == "RO-TA1" || $staff_position == "RO-WM" ||
                    $staff_position == "RO-AWM"){
                    $acces = "ADMIN";
                }

            }
            if($acces != $row['Acces']) {
                $sql = "UPDATE $tbl_name SET Acces = '$acces' WHERE ID = '$id'";
                $result = mysqli_query($con,$sql);
            }

            session_start();
            $_SESSION['login'] = '1';
            $_SESSION['id'] = stripslashes($id);
            $_SESSION['user'] = stripslashes($row['Name']);
            $_SESSION['name'] = stripslashes($row['Name']);
            $_SESSION['rating'] = $rating;
            $_SESSION['atc_rating'] = $atc_rating;
            $_SESSION['pilot_rating'] = $pilot_rating;
            $_SESSION['division'] = $division;
            $_SESSION['email'] = stripslashes($row['Email']);
            $_SESSION['acces'] = $acces;
            $_SESSION['admin_dataprotection'] = stripslashes($row['admin_dataprotection']);
            $_SESSION['member_dataprotection'] = stripslashes($row['member_dataprotection']);
            header("location:myprofile.php");
        }
        else{
            $name = utf8_decode($xml[0]->firstname)." ".utf8_decode($xml[0]->lastname);
            $atc_rating = $xml[0]->ratingatc;
            $pilot_rating = $xml[0]->ratingpilot;
            $division = utf8_decode($xml[0]->division);
            $staff = utf8_decode($xml[0]->staff);
            $staff_positions = explode(":", $staff);
            $acces = "USER";
            foreach($staff_positions as $staff_position){
                if($staff_position == "RO-DIR" || $staff_position == "RO-ADIR" || $staff_position == "RO-TC" ||
                    $staff_position == "RO-TAC" || $staff_position == "RO-TA1" || $staff_position == "RO-WM" ||
                    $staff_position == "RO-AWM"){
                    $acces = "ADMIN";
                }
            }
            
            switch($atc_rating){
                case 1:
                    $atc_rating = "";
                    break;
                case 2:
                    $atc_rating = "AS1";
                    break;
                case 3:
                    $atc_rating = "AS2";
                    break;
                case 4:
                    $atc_rating = "AS3";
                    break;
                case 5:
                    $atc_rating = "ADC";
                    break;
                case 6:
                    $atc_rating = "APC";
                    break;
                case 7:
                    $atc_rating = "ACC";
                    break;
                case 8:
                    $atc_rating = "SEC";
                    break;
                case 9:
                    $atc_rating = "SAI";
                    break;
                case 10:
                    $atc_rating = "CAI";
                    break;
            }
            switch($pilot_rating){
                case 1:
                    $pilot_rating = "";
                    break;
                case 2:
                    $pilot_rating = "FS1";
                    break;
                case 3:
                    $pilot_rating = "FS2";
                    break;
                case 4:
                    $pilot_rating = "FS3";
                    break;
                case 5:
                    $pilot_rating = "PP";
                    break;
                case 6:
                    $pilot_rating = "SPP";
                    break;
                case 7:
                    $pilot_rating = "CP";
                    break;
                case 8:
                    $pilot_rating = "ATP";
                    break;
                case 9:
                    $pilot_rating = "SFI";
                    break;
                case 10:
                    $pilot_rating = "CFI";
                    break;
            }
            
            if($atc_rating == ''){
                $rating = $pilot_rating;
            }
            elseif($pilot_rating == ''){
                $rating = $atc_rating;
            }
            else{
                $rating = $atc_rating . '/' . $pilot_rating;
            }
            
            $sql = "INSERT INTO $tbl_name (ID, Name, Rating, Division, Acces) VALUES ('$id', '$name', '$rating', '$division', '$acces')";
            $result = mysqli_query($con,$sql);
            
            header("location:ivao_login.php?IVAOTOKEN=$token");
        }
	} 
    else{
		header('Location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
    }
}
elseif($_GET['IVAOTOKEN'] == 'error') {
	die('This domain is not allowed to use the Login API! Contact the System Adminstrator!');
}
else{
    header('location: index.php');
}

mysqli_close($con);

?>