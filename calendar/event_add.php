<?php
require_once("includes/config.php");

session_start();

$con = mysqli_connect ($DBHost, $DBUser, $DBPass) OR die (mysqli_error($con));
$db_select = mysqli_select_db($con,$DBName) or die (mysqli_error($con));

if($use_auth)
{
	if(!isset($_SESSION['admin_id']))
	{
		if ((!isset($_POST['USER'])) AND (!isset($_POST['PASS']))) {
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html lang="en">
		<head>
		<title>PHPCalendar - Add Event</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="images/cal.css" rel="stylesheet" type="text/css">
		</head>
		
		<body>
		<br><br>
		<form name="form1" method="post" action="event_add.php">
		  <table border="0" align="center" cellpadding="0" cellspacing="0">
			<tr> 
			  <td>Username:</td>
			</tr>
			<tr> 
			  <td><input name="USER" type="text" id="USER"></td>
			</tr>
			<tr> 
			  <td height="15">Password:</td>
			</tr>
			<tr> 
			  <td><input name="PASS" type="password" id="PASS"></td>
			</tr>
			<tr> 
			  <td height="50"><div align="center">
				  <input type="submit" name="Submit" value="           login           ">
				</div></td>
			</tr>
		  </table>
		<input type="hidden" name="day" id="day" value="<?php echo $_GET['day']; ?>">
		<input type="hidden" name="month" id="month" value="<?php echo $_GET['month']; ?>">
		<input type="hidden" name="year" id="year" value="<?php echo $_GET['year']; ?>">
		<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">
		</form>
		</body>
		</html>
		<?php
			exit;
		} 
		ELSE
		{
			$query = "SELECT admin_id FROM ".$TBL_PR."admins WHERE admin_username='".addslashes($_POST['USER'])."' AND admin_password='".addslashes(md5($_POST['PASS']))."' LIMIT 1";
			$query_result = mysqli_query($con,$query);
			while ($info = mysqli_fetch_array($query_result))
			{
				$admin_id = $info['admin_id'];
			}
		
			IF(isset($admin_id))
			{
				$_SESSION['admin_id'] = $admin_id;
			}
			ELSE
			{
				header("Location: event_add.php?day=".$_POST['day']."&month=".$_POST['month']."&year=".$_POST['year']."&id=" . $_POST['id']);
				exit;
			}
		}
	}
}

IF(isset($_POST['submit']))
{
	$db_table = $TBL_PR . "events";
	
	$_POST['description'] = substr($_POST['description'],0,500);
	$_POST['title'] = substr($_POST['title'],0,30);

	mysqli_query($con,"INSERT INTO $db_table ( `event_id` , `event_day` , `event_month` , `event_year` , `event_time` , `event_title` , `event_desc` ) VALUES ('', '".addslashes($_POST['day'])."', '".addslashes($_POST['month'])."', '".addslashes($_POST['year'])."', '".addslashes($_POST['hour'].":".$_POST['minute'])."', '".addslashes($_POST['title'])."', '".addslashes($_POST['description'])."')");
	$_POST['month'] = $_POST['month'] + 1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
<title>Easy Calendar - Add Event</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language='javascript' type="text/javascript">
<!--
 function redirect_to(where, closewin)
 {
 	opener.location= 'index.php?' + where;
 	
 	if (closewin == 1)
 	{
 		self.close();
 	}
 }
  //-->
 </script>
</head>
<body onLoad="javascript:redirect_to('month=<?php echo $_POST['month'].'&year='.$_POST['year']; ?>',1);">
</body>
</html>
<?php
}
ELSE 
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
<title>Calendar - Add Event</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="images/cal.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" method="post" action="">
  <table width="480" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Event Date</span><br> 
        <span class="addeventextrainfo">(MM/DD/YY)</span></td>
      <td height="40" valign="top"> <select name="month" id="month">
          <option value="1" <?php IF($_GET['month'] == "1"){ echo "selected"; } ?>>01</option>
          <option value="2" <?php IF($_GET['month'] == "2"){ echo "selected"; } ?>>02</option>
          <option value="3" <?php IF($_GET['month'] == "3"){ echo "selected"; } ?>>03</option>
          <option value="4" <?php IF($_GET['month'] == "4"){ echo "selected"; } ?>>04</option>
          <option value="5" <?php IF($_GET['month'] == "5"){ echo "selected"; } ?>>05</option>
          <option value="6" <?php IF($_GET['month'] == "6"){ echo "selected"; } ?>>06</option>
          <option value="7" <?php IF($_GET['month'] == "7"){ echo "selected"; } ?>>07</option>
          <option value="8" <?php IF($_GET['month'] == "8"){ echo "selected"; } ?>>08</option>
          <option value="9" <?php IF($_GET['month'] == "9"){ echo "selected"; } ?>>09</option>
          <option value="10" <?php IF($_GET['month'] == "10"){ echo "selected"; } ?>>10</option>
          <option value="11" <?php IF($_GET['month'] == "11"){ echo "selected"; } ?>>11</option>
          <option value="12" <?php IF($_GET['month'] == "12"){ echo "selected"; } ?>>12</option>
        </select> <select name="day" id="day">
          <option value="1" <?php IF($_GET['day'] == "1"){ echo "selected"; } ?>>01</option>
          <option value="2" <?php IF($_GET['day'] == "2"){ echo "selected"; } ?>>02</option>
          <option value="3" <?php IF($_GET['day'] == "3"){ echo "selected"; } ?>>03</option>
          <option value="4" <?php IF($_GET['day'] == "4"){ echo "selected"; } ?>>04</option>
          <option value="5" <?php IF($_GET['day'] == "5"){ echo "selected"; } ?>>05</option>
          <option value="6" <?php IF($_GET['day'] == "6"){ echo "selected"; } ?>>06</option>
          <option value="7" <?php IF($_GET['day'] == "7"){ echo "selected"; } ?>>07</option>
          <option value="8" <?php IF($_GET['day'] == "8"){ echo "selected"; } ?>>08</option>
          <option value="9" <?php IF($_GET['day'] == "9"){ echo "selected"; } ?>>09</option>
          <option value="10" <?php IF($_GET['day'] == "10"){ echo "selected"; } ?>>10</option>
          <option value="11" <?php IF($_GET['day'] == "11"){ echo "selected"; } ?>>11</option>
          <option value="12" <?php IF($_GET['day'] == "12"){ echo "selected"; } ?>>12</option>
          <option value="13" <?php IF($_GET['day'] == "13"){ echo "selected"; } ?>>13</option>
          <option value="14" <?php IF($_GET['day'] == "14"){ echo "selected"; } ?>>14</option>
          <option value="15" <?php IF($_GET['day'] == "15"){ echo "selected"; } ?>>15</option>
          <option value="16" <?php IF($_GET['day'] == "16"){ echo "selected"; } ?>>16</option>
          <option value="17" <?php IF($_GET['day'] == "17"){ echo "selected"; } ?>>17</option>
          <option value="18" <?php IF($_GET['day'] == "18"){ echo "selected"; } ?>>18</option>
          <option value="19" <?php IF($_GET['day'] == "19"){ echo "selected"; } ?>>19</option>
          <option value="20" <?php IF($_GET['day'] == "20"){ echo "selected"; } ?>>20</option>
          <option value="21" <?php IF($_GET['day'] == "21"){ echo "selected"; } ?>>21</option>
          <option value="22" <?php IF($_GET['day'] == "22"){ echo "selected"; } ?>>22</option>
          <option value="23" <?php IF($_GET['day'] == "23"){ echo "selected"; } ?>>23</option>
          <option value="24" <?php IF($_GET['day'] == "24"){ echo "selected"; } ?>>24</option>
          <option value="25" <?php IF($_GET['day'] == "25"){ echo "selected"; } ?>>25</option>
          <option value="26" <?php IF($_GET['day'] == "26"){ echo "selected"; } ?>>26</option>
          <option value="27" <?php IF($_GET['day'] == "27"){ echo "selected"; } ?>>27</option>
          <option value="28" <?php IF($_GET['day'] == "28"){ echo "selected"; } ?>>28</option>
          <option value="29" <?php IF($_GET['day'] == "29"){ echo "selected"; } ?>>29</option>
          <option value="30" <?php IF($_GET['day'] == "30"){ echo "selected"; } ?>>30</option>
          <option value="31" <?php IF($_GET['day'] == "31"){ echo "selected"; } ?>>31</option>
        </select> <select name="year" id="year">
          <option value="2014" <?php IF($_GET['year'] == "2014"){ echo "selected"; } ?>>2014</option>
          <option value="2015" <?php IF($_GET['year'] == "2015"){ echo "selected"; } ?>>2015</option>
          <option value="2016" <?php IF($_GET['year'] == "2016"){ echo "selected"; } ?>>2016</option>
          <option value="2017" <?php IF($_GET['year'] == "2017"){ echo "selected"; } ?>>2017</option>
          <option value="2018" <?php IF($_GET['year'] == "2018"){ echo "selected"; } ?>>2018</option>
          <option value="2019" <?php IF($_GET['year'] == "2019"){ echo "selected"; } ?>>2019</option>
          <option value="2020" <?php IF($_GET['year'] == "2020"){ echo "selected"; } ?>>2020</option>
          <option value="2021" <?php IF($_GET['year'] == "2020"){ echo "selected"; } ?>>2021</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Event Time</span><br> 
        <span class="addeventextrainfo">(24hr Format)</span></td>
      <td height="40" valign="top"> <input name="hour" type="text" id="hour" value="20" size="2" maxlength="2">
        : 
        <input name="minute" type="text" id="minute" value="00" size="2" maxlength="2"> 
      </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Event Title</span></td>
      <td height="40" valign="top"> <input name="title" type="text" id="title" size="20"> 
      </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Event Description</span></td>
      <td height="40" valign="top"> <textarea name="description" cols="18" rows="5" id="description"></textarea> 
      </td>
    </tr>
    <tr> 
      <td width="200">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input name="submit" type="submit" id="submit" value="Add Event"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php 
} 
?>