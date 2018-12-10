<?
require_once("includes/config.php");

session_start();

$db_connection = mysql_connect ($DBHost, $DBUser, $DBPass) OR die (mysql_error());  
$db_select = mysql_select_db ($DBName) or die (mysql_error());

$db_table = $TBL_PR . "events";

if ((!isset($_POST['USER'])) AND (!isset($_POST['PASS']))) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PHPCalendar - Delete Event</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="images/cal.css" rel="stylesheet" type="text/css">
</head>

<body>
<br><br>
<form name="form1" method="post" action="">
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
<input type="hidden" name="day" id="day" value="<? echo $_GET['day']; ?>">
<input type="hidden" name="month" id="month" value="<? echo $_GET['month']; ?>">
<input type="hidden" name="year" id="year" value="<? echo $_GET['year']; ?>">
<input type="hidden" name="id" id="id" value="<? echo $_GET['id']; ?>">
</form>
</body>
</html>
<?
} 
ELSE
{
	$query = "SELECT admin_id FROM ".$TBL_PR."admins WHERE admin_username='".addslashes($_POST['USER'])."' AND admin_password='".addslashes(md5($_POST['PASS']))."' LIMIT 1";
	$query_result = mysql_query ($query);
	while ($info = mysql_fetch_array($query_result))
	{
		$admin_id = $info['admin_id'];
	}

	IF(isset($admin_id))
	{
		mysql_query("DELETE FROM $db_table WHERE event_id='".addslashes($_POST['id'])."' LIMIT 1");
		$_POST['month'] = $_POST['month'] + 1;
        ?>
                    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
                    <html>
                    <head>
                    <title>Calendar - Delete Event</title>
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
                    <body onLoad="javascript:redirect_to('month=<? echo $_POST['month']."&year=".$_POST['year']; ?>',1);">
                    </body>
                    </html>
		<?
		exit;
	}
	ELSE
	{
		header("Location: event_delete.php?day=".$_POST['day']."&month=".$_POST['month']."&year=".$_POST['year']."&id=".$_POST['id']);
		exit;
	}
}
?>