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
			If you have any questions about trainings, exams or GCA, do not hesitate to contact our training department:
        </h4>
        <br><br>
        <table>
            <tr>
                <td class="tablekey">
                    Name
                </td>
                <td class="tablekey">
                    ATC Rating
                </td>
                <td class="tablekey">
                    Pilot Rating
                </td>
                <td class="tablekey">
                    Staff Position
                </td>
                <td class="tablekey">
                    Roles
                </td>
                <td class="tablekey">
                    Email
                </td>
            </tr>
            <tr>
                <td class="tablevalue">
                    Andrei Bubeneck
                </td>
                <td class="tablevalue">
                    ACC
                </td>
                <td class="tablevalue">
                    ATP
                </td>
                <td class="tablevalue">
                    RO-DIR/RO-TC
                </td>
                <td class="tablevalue">
                    Examiner/Trainer
                </td>
                <td class="tablevalue">
                    ro-tc@ivao.aero
                </td>
            </tr>
            <tr>
                <td class="tablevalue">
                    Nicolae Podaru
                </td>
                <td class="tablevalue">
                    ADC
                </td>
                <td class="tablevalue">
                    SPP
                </td>
                <td class="tablevalue">
                    RO-ADIR
                </td>
                <td class="tablevalue">
                    Examiner/Trainer
                </td>
                <td class="tablevalue">
                    ro-adir@ivao.aero
                </td>
            </tr>
            <tr>
                <td class="tablevalue">
                    Udo Korbanka
                </td>
                <td class="tablevalue">
                    ACC
                </td>
                <td class="tablevalue">
                    PP
                </td>
                <td class="tablevalue">
                    RO-TAC
                </td>
                <td class="tablevalue">
                    Examiner/Trainer
                </td>
                <td class="tablevalue">
                    ro-tac@ivao.aero
                </td>
            </tr>
            <tr>
                <td class="tablevalue">
                    Lucian Cristea
                </td>
                <td class="tablevalue">
                    APC
                </td>
                <td class="tablevalue">
                    CP
                </td>
                <td class="tablevalue">
                    RO-TA1
                </td>
                <td class="tablevalue">
                    Examiner/Trainer
                </td>
                <td class="tablevalue">
                    ro-ta1@ivao.aero
                </td>
            </tr>
            <tr>
                <td class="tablevalue">
                    Ionut Trisca
                </td>
                <td class="tablevalue">
                    ADC
                </td>
                <td class="tablevalue">
                    PP
                </td>
                <td class="tablevalue">
                    RO-T01
                </td>
                <td class="tablevalue">
                    Trainer
                </td>
                <td class="tablevalue">
                    ro-t01@ivao.aero
                </td>
            </tr>
        </table>
        <!--
            RO-TC <a href='mailto:ro-tc@ivao.aero'>Wilhelm Andrei Bubeneck</a><br>
			RO-TAC <a href='mailto:ro-tac@ivao.aero'>Udo Korbanka</a><br>
            RO-TA1 <a href='mailto:ro-ta1@ivao.aero'>Lucian Cristea</a><br>
            RO-T01 <a href='mailto:ro-t01@ivao.aero'>Ionut Trisca</a><br>
        -->
            <br>
			For questions about this system, contact 
			<a href='mailto:ro-tc@ivao.aero'>ro-tc@ivao.aero</a>.
		<h4>
			Enjoy!
		</h4>
        <h4>
            <a href="https://<?php echo $division; ?>.ivao.aero">Return to the main division website...</a>
        </h4>

		<div id='calendar_frame'>
			<iframe src='calendar/index.php' style='width:960px; height:660px; border-style: none;'>
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