TRAINING MANAGEMENT SYSTEM (TMS) v2.0

for the Romanian Division of the 
International Virtual Aviation Organisation (ro.ivao.aero)

===============================================================================

Live version: https://ro.ivao.aero/tms

Author: Wilhelm Andrei Bubeneck

Contact: wilhelm.andrei.bubeneck@ivao.aero

Please send me an email if you have any questions.

===============================================================================

PROVIDED AS IS WITHOUT ANY WARRANTY! USE AT YOUR OWN RISK!

===============================================================================

LICENSE: Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)

===============================================================================

Configuration instructions for use in other IVAO divisions:

1. Upload all the files and folders from this repository to your server.

2. Create a new MySQL database on your server and upload the example 
database provided ("db.sql").

3. Change "config.php_model" to "config.php" and modify the variables within to 
suit your setup. 

4. Setup a chronjob to run "training_reminder.php" daily at 12z. You should be able to
run the website with full functionality at this point.

5. Modify "banner_main.jpg".

6. Change the information text on the homepage located in "home.php".

7. Change the training locations and/or training types in "request_training.php".

8. If need be, change the texts of the automated emails in "request.php",
"propose_deadline.php", "training_reminder.php" and "filereport.php".

9. You should be ready to go! Logs are located in the logs folder within the root
of your TMS folder.
