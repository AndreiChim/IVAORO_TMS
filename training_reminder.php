<?php
// Logging.php
class Logging {
    // declare log file and file pointer as private properties
    private $log_file, $fp;
    // set log file (path and name)
    public function lfile($path) {
        $this->log_file = $path;
    }
    // write message to the log file
    public function lwrite($message) {
        // if file pointer doesn't exist, then open log file
        if (!is_resource($this->fp)) {
            $this->lopen();
        }
        // define script name
        $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        // define current time and suppress E_WARNING if using the system TZ settings
        // (don't forget to set the INI setting date.timezone)
        $time = @date('[d/M/Y:H:i:s]');
        // write current time, script name and message to the log file
        fwrite($this->fp, "$time $message" . PHP_EOL);
    }
    // close log file (it's always a good idea to close a file when you're done with it)
    public function lclose() {
        fclose($this->fp);
    }
    // open log file (private method)
    private function lopen() {
        // in case of Windows set default log file
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $log_file_default = 'c:/php/logfile.txt';
        }
        // set default log file for Linux and other systems
        else {
            $log_file_default = '/tmp/logfile.txt';
        }
        // define log file from lfile method or use previously set default
        $lfile = $this->log_file ? $this->log_file : $log_file_default;
        // open log file for writing only and place file pointer at the end of the file
        // (if the file does not exist, try to create it)
        $this->fp = fopen($lfile, 'a') or exit("Can't open $lfile!");
    }
}

// Logging class initialization
$log = new Logging();

// set path and name of log file (optional)
$log->lfile(getcwd().'/httpdocs/tms/logs/sent_reminders.txt');


// config.php
include ('config.php');

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));

$sql = "SELECT * FROM `training_requests` WHERE DATE(STR_TO_DATE(Deadlines1,'%d.%m.%Y %H:%i')) = DATE(DATE_ADD(NOW(), INTERVAL 1 DAY)) AND Chosen = 'YES'";
$result = mysqli_query($con,$sql);

echo (mysqli_num_rows($result));

// write message to the log file
$log->lwrite(mysqli_num_rows($result) . " mails to send today " . date("Y-m-d"));

while($training_request = mysqli_fetch_array($result)){
	
            $to = stripslashes($training_request['Email']);
            $name = $training_request['Name'];
            $tracking = $training_request['Tracking'];
            $type1 = $training_request['Type1'];
            $type2 = $training_request['Type2'];
            $location = $training_request['Airport'];
            $trainer = $training_request['Trainer'];
            $deadlines1 = $training_request['Deadlines1'];
            $header = "From: IVAO ".$division_long." <".$mailbox.">" . "\r\n" . "Reply-To: ".$division."-TC@ivao.aero\r\n";
            $header.= "MIME-Version: 1.0\r\n";
            $header.= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
            $header.= "X-Priority: 1\r\n";
            $subject = "[Tracking number: " . $tracking . "] IVAO ".($type1 == "EXAM" ? "Exam": "Training")." Reminder";
            $message = 
"Hello ".$name."!

We would like to remind you of your following appointment for tomorrow:

".$deadlines1." UTC / ".$type2." - ".$type1." / Location: ".$location." /
Trainer: ".$trainer."

Please meet with the trainer at the set time and date on the IVAO .".$division_long." Discord server. If you haven't already joined the server, please use this invite link: ".$discord_link."

If you are not able to make it to your ".($type1 == "EXAM" ? "exam": "training")." tomorrow, or have any questions, please reply to this email as soon as possible.

Kind regards,

IVAO ".$division_long." Training Department

---

You have received this email because you gave your consent to such usage of your email address by confirming a prompt before being able to access the features of our website: ".$root_url.". If you think you should not have been the recipient of such an email, please contact us by replying to it.";
            
			$message = wordwrap($message, 75);
            $id = $training_request['ID'];
			
			if(@mail($to, $subject, $message, $header)){
				// write message to the log file
				$log->lwrite("    - Training/Exam Reminder sent to member with VID $id - Request tracking number $tracking - Sent");
			}else{
			 // write message to the log file
            $log->lwrite("    - Training/Exam Reminder sent to member with VID $id - Request tracking number $tracking - Not Sent");
			}
	

}
// close log file
$log->lclose();
?>