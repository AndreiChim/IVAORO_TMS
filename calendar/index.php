<?
require_once("includes/config.php");

if(!isset($installed))
{
	header("Location: install.php");
	exit;
}
else
{
	if(file_exists('install.php'))
	{
		header("Location: install.php");
		exit;
	}
}

$con = mysqli_connect ($DBHost, $DBUser, $DBPass) OR die (mysqli_error($con));
$db_select = mysqli_select_db($con,$DBName) or die (mysqli_error($con));
$db_table = $TBL_PR . "events";

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 

$time_start = getmicrotime();

IF(!isset($_GET['year'])){
    $_GET['year'] = date("Y");
}
IF(!isset($_GET['month'])){
    $_GET['month'] = date("n")+1;
}

$month = addslashes($_GET['month'] - 1);
$year = addslashes($_GET['year']);

$query = "SELECT event_id,event_title,event_day,event_time FROM $db_table WHERE event_month='$month' AND event_year='$year' ORDER BY event_time";
$query_result = mysqli_query($con,$query);
while ($info = mysqli_fetch_array($query_result))
{
    $day = $info['event_day'];
    $event_id = $info['event_id'];
    $events[$day][] = $info['event_id'];
    $event_info[$event_id]['0'] = $info['event_title']; //substr($info['event_title'], 0, 8);;
    $event_info[$event_id]['1'] = $info['event_time'];
}

$todays_date = date("j");
$todays_month = date("n");

$days_in_month = date ("t", mktime(0,0,0,$_GET['month'],0,$_GET['year']));
$first_day_of_month = date ("w", mktime(0,0,0,$_GET['month']-1,1,$_GET['year']));
$first_day_of_month = $first_day_of_month + 1;
$count_boxes = 0;
$days_so_far = 0;

IF($_GET['month'] == 13){
    $next_month = 2;
    $next_year = $_GET['year'] + 1;
} ELSE {
    $next_month = $_GET['month'] + 1;
    $next_year = $_GET['year'];
}

IF($_GET['month'] == 2){
    $prev_month = 13;
    $prev_year = $_GET['year'] - 1;
} ELSE {
    $prev_month = $_GET['month'] - 1;
    $prev_year = $_GET['year'];
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
<title>PHPCalendar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="images/cal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<div align="center"><span class="currentdate" style="color:#003399"><? echo "ATC Trainings and Exams in ".date ("F Y", mktime(0,0,0,$_GET['month']-1,1,$_GET['year'])); ?></span><br>
  <br>
</div>
<div align="center"><br>
  <table width="700" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td><div align="right"><a href="<? echo "index.php?month=$prev_month&amp;year=$prev_year"; ?>">&lt;&lt;</a></div></td>
      <td width="200"><div align="center">
            
          <select name="month" id="month" onChange="MM_jumpMenu('parent',this,0)">
            <?
			for ($i = 1; $i <= 12; $i++) {
				$link = $i+1;
				IF($_GET['month'] == $link){
					$selected = "selected";
				} ELSE {
					$selected = "";
				}
				echo "<option value=\"index.php?month=$link&amp;year=$_GET[year]\" $selected>" . date ("F", mktime(0,0,0,$i,1,$_GET['year'])) . "</option>\n";
			}
			?>
          </select>
          <select name="year" id="year" onChange="MM_jumpMenu('parent',this,0)">
		  <?
		  for ($i = 2014; $i <= 2021; $i++) {
		  	IF($i == $_GET['year']){
				$selected = "selected";
			} ELSE {
				$selected = "";
			}
		  	echo "<option value=\"index.php?month=$_GET[month]&amp;year=$i\" $selected>$i</option>\n";
		  }
		  ?>
          </select>
        </div></td>
      <td><div align="left"><a href="<? echo "index.php?month=$next_month&amp;year=$next_year"; ?>">&gt;&gt;</a></div></td>
    </tr>
  </table>
  <br>
</div>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1">
        <tr class="topdays"> 
          <td><div align="center">Sunday</div></td>
          <td><div align="center">Monday</div></td>
          <td><div align="center">Tuesday</div></td>
          <td><div align="center">Wednesday</div></td>
          <td><div align="center">Thursday</div></td>
          <td><div align="center">Friday</div></td>
          <td><div align="center">Saturday</div></td>
        </tr>
		<tr valign="top" bgcolor="#FFFFFF"> 
		<?
		for ($i = 1; $i <= $first_day_of_month-1; $i++) {
			$days_so_far = $days_so_far + 1;
			$count_boxes = $count_boxes + 1;
			echo "<td width=\"100\" height=\"100\" class=\"beforedayboxes\"></td>\n";
		}
		for ($i = 1; $i <= $days_in_month; $i++) {
   			$days_so_far = $days_so_far + 1;
    			$count_boxes = $count_boxes + 1;
			IF($_GET['month'] == $todays_month+1){
				IF($i == $todays_date){
					$class = "highlighteddayboxes";
				} ELSE {
					$class = "dayboxes";
				}
			} ELSE {
				IF($i == 1){
					$class = "highlighteddayboxes";
				} ELSE {
					$class = "dayboxes";
				}
			}
			echo "<td width=\"100\" height=\"100\" class=\"$class\">\n";
			$link_month = $_GET['month'] - 1;
			echo "<div align=\"right\"><span class=\"toprightnumber\">\n $i</a>&nbsp;</span></div>\n";
			IF(isset($events[$i])){
				echo "<div align=\"left\"><span class=\"eventinbox\">\n";
				while (list($key, $value) = each ($events[$i])) {
					echo "&nbsp;<a href=\"javascript:MM_openBrWindow('event.php?id=$value','','width=500,height=230');\">" . $event_info[$value]['1'] . " " . $event_info[$value]['0']  . "</a>\n<br>\n";
				}
				echo "</span></div>\n";
			}
			echo "</td>\n";
			IF(($count_boxes == 7) AND ($days_so_far != (($first_day_of_month-1) + $days_in_month))){
				$count_boxes = 0;
				echo "</TR><TR valign=\"top\">\n";
			}
		}
		$extra_boxes = 7 - $count_boxes;
		for ($i = 1; $i <= $extra_boxes; $i++) {
			echo "<td width=\"100\" height=\"100\" class=\"afterdayboxes\"></td>\n";
		}
		$time_end = getmicrotime();
		$time = round($time_end - $time_start, 3);
		?>
        </tr>
      </table></td>
  </tr>
</table>

<p align="center"><span class="footer"> Calendar &copy; 2008 
    <a href="http://www.kubelabs.com/php_calendar.php">Kubelabs.com</a><br>
    Adapted by Wilhelm Andrei Bubeneck (335177)
    <!--
    Script Execution Time: <? echo $time; ?></span><br><br>
    <a href="http://validator.w3.org/check/referer"><img border="0" src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01!" height="31" width="88"></a> 
<a href="http://jigsaw.w3.org/css-validator/check/referer"><img border="0" style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a></p> -->
</body>
</html>
