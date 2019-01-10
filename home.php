<?php include("config.php"); ?>
<div id="header">
		<h3>&nbsp; Welcome to the IVAO <?php echo $division_long; ?> Training Management System (TMS)</h3>
	</div>

	<div id="content">
		<h4>In this system, you can request a training 
			and check the status of your requested training.
		</h4>
		<h4>
			After completing your training, you will be able to review the training report submitted by the trainer.
			This will enable you to always have a complete overview of your own training history. <br><br>
			If you have any questions about trainings, exams or GCA, do not hesitate to contact our training department: <br>
			<a href='mailto:ro-tc@ivao.aero'>ro-tc@ivao.aero</a> <i>Wilhelm Andrei Bubeneck</i> <br>
			<a href='mailto:ro-tac@ivao.aero'>ro-tac@ivao.aero</a> <i>Udo Korbanka</i> <br><br>
            <a href='mailto:ro-ta1@ivao.aero'>ro-ta1@ivao.aero</a> <i>Lucian Cristea</i> <br><br>
			For questions about this system, contact 
			<a href='mailto:ro-tc@ivao.aero'>ro-tc@ivao.aero</a>.
		</h4>
		<h4>
			Enjoy!
		</h4>

		<div id='calendar_frame'>
			<iframe src='calendar/index.php' style='width:960px; height:760px; border-style: none;'>
			</iframe>
		</div>


<!--		<fieldset id='opinion'>
			<legend>Do you like this website?</legend>
			<form action="http://localhost/website/testpage.php" method="post">
				<input type="radio" name="like" value="yes"/>Yes
				<br>
				<input type="radio" name="like" value="no"/>No
				<br>
				First name:<input type="text" name="name"/>
				<br>
				<input class='submit' type="submit" name="submit" value="Submit!"/>
			</form>
		</fieldset>

This closes the "content" div -->
	</div>