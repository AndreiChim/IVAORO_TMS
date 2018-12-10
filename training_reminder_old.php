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
        fwrite($this->fp, "$time ($script_name) $message" . PHP_EOL);
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

// config.php
$host = 'localhost';
$username = 'ro-div_roivao';
$password = 'roivaoro123';
$db_name = 'ro-div_tms';

$con = mysqli_connect($host, $username, $password) or die('Cannot connect to database: '. mysqli_error($con));
mysqli_select_db($con,$db_name) or die('Cannot select database: '. mysqli_error($con));
$tbl_name = 'training_requests';
$sql = "SELECT * FROM $tbl_name";
$result = mysqli_query($con,$sql);
while($training_request = mysqli_fetch_array($result)){
	
    if($training_request['Chosen'] == 'YES'){
        $request_time = strtotime(substr($training_request['Deadlines1'], 0, 10));
		
        if($request_time - time() >= 32400 && $request_time - time() <= 54000){
						
            $to = stripslashes($training_request['Email']);
            $name = $training_request['Name'];
            $tracking = $training_request['Tracking'];
            $type1 = $training_request['Type1'];
            $type2 = $training_request['Type2'];
            $location = $training_request['Airport'];
            $trainer = $training_request['Trainer'];
            $deadlines1 = $training_request['Deadlines1'];
            $header = "From: IVAO Romania <tms@ro.ivao.aero>" . "\r\n" . "Reply-To: ro-tc@ivao.aero, ro-tac@ivao.aero, ro-hq@ivao.aero";
            $subject = "[Tracking number: " . $tracking . "] IVAO ".($type1 == "EXAM" ? "Exam": "Training")." Reminder";
            $message = 
"Hello ".$name."!

We would like to remind you of your following appointment for tomorrow:

".$deadlines1." UTC / ".$type2." - ".$type1." / Location: ".$location." /
Trainer: ".$trainer."

Please meet with the trainer at the set time and date on the IVAO Romania Discord server. If you haven't already joined the server, please use this invite link: https://discord.gg/xdwEPyr

If you are not able to make it to your ".($type1 == "EXAM" ? "exam": "training")." tomorrow, or have any questions, please reply to this email as soon as possible.

Kind regards,

IVAO Romania Training Department

---

You have received this email because you gave your consent to such usage of your email address by confirming a prompt before being able to access the features of our website: ro.ivao.aero/tms. If you think you should not have been the recipient of such an email, please contact us by replying to it.
";
            $message = wordwrap($message, 70);
            mail($to, $subject, $message, $header);
            
            $id = $training_request['ID'];
            // Logging class initialization
            $log = new Logging();

            // set path and name of log file (optional)
            $log->lfile('logs/sent_reminders.txt');

            // write message to the log file
            $log->lwrite("Training/Exam Reminder sent to member with VID $id - Request tracking number $tracking");

            // close log file
            $log->lclose();
        
		}
    
	}

}

?>