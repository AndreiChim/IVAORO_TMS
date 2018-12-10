<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}

if($_SESSION['member_dataprotection'] == 'NO'){
    header("location:member_dataprotection.php?target=download_info");
}

include('config.php');

$con = mysql_connect($host, $username, $password) or die('Cannot connect to database: '. mysql_error());
mysql_select_db($db_name) or die('Cannot select database: '. mysql_error());

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=mydetails.txt");


if(isset($_POST['submit'])){
    $id = $_SESSION['id'];
    $tbl_name = "users";
    $sql = "SELECT * FROM $tbl_name WHERE ID = '$id'";
    $result = mysql_query($sql) or die(mysql_error());
    $user = mysql_fetch_array($result);
    
    $name = $user['Name'];
    $email = $user['Email'];
    $rating = $user['Rating'];
    $division = $user['Division'];
    $acces = $user['Acces'];
    $admin_dataprotection = $user['admin_dataprotection'];
    $admin_dataprotection_timestamp = $user['admin_dataprotection_timestamp'];
    $member_dataprotection = $user['member_dataprotection'];
    $member_dataprotection_timestamp = $user['member_dataprotection_timestamp'];
    
    $date = date('d.m.Y H:i:s');
    
    $xml = 
        "<?xml version='1.0' encoding='UTF-8'?>
<xml>
    <document_version>
        <download_date>".$date."</download_date>
    </document_version>
    <users>
        <user>
            <id>".$id."</id>
            <name>".$name."</name>
            <email>".$email."</email>
            <rating>".$rating."</rating>
            <division>".$division."</division>
            <access>".$acces."</access>
            <admin_dataprotection>".$admin_dataprotection."</admin_dataprotection>
            <admin_dataprotection_timestamp>".$admin_dataprotection_timestamp."</admin_dataprotection_timestamp>
            <member_dataprotection>".$member_dataprotection."</member_dataprotection>
            <member_dataprotection_timestamp>".$member_dataprotection_timestamp."</member_dataprotection_timestamp>
        </user>
    </users>";
    
    $tbl_name = 'training_requests';
    $sql = "SELECT * FROM $tbl_name WHERE ID = '$id'";
    $result = mysql_query($sql);
    $xml = $xml."
    <training_requests>";
    while($training_request = mysql_fetch_array($result)){
        $xml = $xml."
        <training_request>
            <tracking>".$training_request['Tracking']."</tracking>
            <id>".$training_request['Tracking']."</id>
            <name>".$training_request['Name']."</name>
            <email>".$training_request['Email']."</email>
            <type1>".$training_request['Type1']."</type1>
            <type2>".$training_request['Type2']."</type2>
            <rating>".$training_request['Rating']."</rating>
            <airport>".$training_request['Airport']."</airport>
            <reason>".$training_request['Reason']."</reason>]
            <deadlines1>".$training_request['Deadlines1']."</deadlines1>
            <deadlines2>".$training_request['Deadlines2']."</deadlines2>
            <deadlines3>".$training_request['Deadlines3']."</deadlines3>
            <chosen>".$training_request['Chosen']."</chosen>
            <trainer>".$training_request['Trainer']."</trainer>
            <reportstatus>".$training_request['ReportStatus']."</reportstatus>
            <summary>".$training_request['Summary']."</summary>
            <pros>".$training_request['Pros']."</pros>
            <cons>".$training_request['Cons']."</cons>
            <suggestions>".$training_request['Suggestions']."</suggestions>
            <time_start>".$training_request['Time_start']."</time_start>
            <time_end>".$training_request['Time_end']."</time_end>
            <isvisible>".$training_request['Isvisible']."</isvisible>
        </training_request>";
    }
    $xml = $xml."
    </training_requests>";
    
    $tbl_name = 'calendar_events';
    $sql = "SELECT * FROM $tbl_name WHERE event_desc LIKE '%$id%'";
    $result = mysql_query($sql);
    $xml = $xml."
    <calendar_events>";
    while($calendar_event = mysql_fetch_array($result)){
        $xml = $xml."
        <calendar_event>
            <event_id>".$calendar_event['event_id']."</event_id>
            <event_day>".$calendar_event['event_day']."</event_day>
            <event_month>".$calendar_event['event_month']."</event_month>
            <event_year>".$calendar_event['event_year']."</event_year>
            <event_time>".$calendar_event['event_time']."</event_time>
            <event_title>".$calendar_event['event_title']."</event_title>
            <event_description>".$calendar_event['event_desc']."</event_description>
        </calendar_event>";
    }
    $xml = $xml."
    </calendar_events>";
        
    $tbl_name = 'calendar_admins';
    $sql = "SELECT * FROM $tbl_name WHERE admin_username = '$id'";
    $result = mysql_query($sql);
    $xml = $xml."
    <calendar_admins>";
    while($calendar_admin = mysql_fetch_array($result)){
        $xml = $xml."
        <calendar_admin>
            <admin_id>".$calendar_admin['admin_id']."</admin_id>
            <admin_username>".$calendar_admin['admin_username']."</admin_username>
        <calendar_admin>";
    }
    $xml = $xml."
    </calendar_admins>";
    
    $xml = $xml."
</xml>";
    
    echo $xml;
}
else{
    header("location:myprofile.php");
}

?>