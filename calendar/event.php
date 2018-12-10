<?
require_once("includes/config.php");
$db_connection = mysql_connect ($DBHost, $DBUser, $DBPass) OR die (mysql_error());  
$db_select = mysql_select_db ($DBName) or die (mysql_error());
$db_table = $TBL_PR . "events";

$query = "SELECT * FROM $db_table WHERE event_id='$_GET[id]' LIMIT 1";
$query_result = mysql_query ($query);
while ($info = mysql_fetch_array($query_result)){
    $date = date ("l, jS F Y", mktime(0,0,0,$info['event_month'],$info['event_day'],$info['event_year']));
    $time_array = explode(":", $info['event_time']);
    $time = date ("H:i", mktime($time_array['0'],$time_array['1'],0,$info['event_month'],$info['event_day'],$info['event_year']))." UTC";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PHPCalendar - <? echo $info['event_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="images/cal.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="480" height="180" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100">
<table width="480" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td><span class="eventwhen"><u><? echo $date . " at " . $time; ?></u></span><br> 
            <br> <br> </td>
        </tr>
        <tr> 
          <td><span class="event">Event Title</span></td>
        </tr>
        <tr> 
          <td><span class="eventdetail"><? echo $info['event_title']; ?></span><br> 
            <br></td>
        </tr>
        <tr> 
          <td><span class="event">Event Description</span></td>
        </tr>
        <tr> 
          <td><span class="eventdetail"><? echo $info['event_desc']; ?></span><br></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom"><a href="event_delete.php?<? echo "day=$info[event_day]&month=$info[event_month]&year=$info[event_year]&id=$info[event_id]"; ?>">Delete</a></td>
  </tr>
</table>
</body>
</html>
<? } ?>