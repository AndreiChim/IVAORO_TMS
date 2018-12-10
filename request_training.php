<?php

session_start();

if($_SESSION['login'] == ''){
	header('location:http://login.ivao.aero/index.php?url=http://ro.ivao.aero/tms/ivao_login.php');
}

if($_SESSION['member_dataprotection'] == 'NO'){
    header("location:member_dataprotection.php?target=request_training");
}

?>

<html>
<head>
	<title>IVAO Romania TMS</title>
	<link rel="shortcut icon" href="http://www.ivao.aero/favicon.ico">
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<div id='container'>
<?php include('banner_menu.php'); ?>
<div id='header'>
<h3>&nbsp Request a training or make an exam appointment</h3>
</div>
<div id='content'>
<?php
if(($_SESSION['atc_rating'] == '' || $_SESSION['atc_rating'] == 'AS1' || $_SESSION['atc_rating'] == 'AS2' || $_SESSION['atc_rating'] == 'AS3') && $_SESSION['division'] != 'RO'){
  echo "<h4>You are not a member of the Romanian division and your ATC rating is too low to request a Guest Controller Approval. At the moment we can not offer you any services.</h4>";
}
else{
?>
<h4>Here you can make a request that's going to be assigned to one of our trainers.</h4>

<form id='request_training' action='request.php' method='post'>
<table id='training_container' border='1'>
	<tr>
		<td style='text-align:center;'>
            <?php if($_SESSION['division'] != 'RO'){ ?>
            <label>
                <input type='radio' name='training_type1' value='practical' checked /> Practical Training
            </label>
            <?php } else{ ?>
            <label>
                <input type='radio' name='training_type1' value='practical' /> Practical Training &nbsp
            </label>
            <label>
                <input type='radio' name='training_type1' value='theoretical' /> Theoretical Training &nbsp
            </label>
            <label>
                <input type='radio' name='training_type1' value='EXAM' /> Practical Exam
            </label>
            <?php } ?>
		</td>
	</tr>
	<tr>
	<td>
	<table id='request_training_table' border='0'>
		<tr>
			<td class='tablekey'>
				Type
			</td>
			<td class='tablevalue'>
				<select class='type2' name='training_type2'>
                    <?php if($_SESSION['division'] != 'RO'){ ?>
                    <option value='GCA training'>Guest Controller Approval (GCA) - Training</option>
                    <option value='GCA checkout'>Guest Controller Approval (GCA) - Checkout</option>
                    <?php } else{ 
                        $atc_rating = $_SESSION['atc_rating'];
                        $pilot_rating = $_SESSION['pilot_rating'];
                        switch($atc_rating){
                            case "AS1":
                                echo "<option value='First Time as ATC on IVAO'>First Time as ATC on IVAO</option>";
                                break;
                            case "AS2":
                                echo "<option value='First Time as ATC on IVAO'>First Time as ATC on IVAO</option>";
                                break;
                            case "AS3":
                                echo "<option value='ADC'>Aerodrome Controller (ADC)</option>";
                                break;
                            case "ADC":
                                echo "<option value='APC'>Approach Controller (APC)</option>";
                                break;
                            case "APC":
                                echo "<option value='ACC'>Area Controller (ACC)</option>";
                                break;
                            case "ACC":
                                echo "<option value='SEC'>Senior Controller (SEC)</option>";
                                break;
                            case "SEC":
                                echo "<option value='Phraseology practice'>Phraseology practice</option>";
                                break;
                            default:
                                break;
                        }
                        switch($pilot_rating){
                            case "FS1":
                                echo "<option value='First Flight on IVAO'>First Flight on IVAO</option>";
                                break;
                            case "FS2":
                                echo "<option value='First Flight on IVAO'>First Flight on IVAO</option>";
                                break;
                            case "FS3":
                                echo "<option value='PP'>Private Pilot (PP)</option>";
                                break;
                            case "PP":
                                echo "<option value='SPP'>Senior Private Pilot (SPP)</option>";
                                break;
                            case "SPP":
                                echo "<option value='CP'>Commercial Pilot (CP)</option>";
                                break;
                            case "CP":
                                echo "<option value='ATP'>Airline Transport Pilot (ATP)</option>";
                                break;
                            default:
                                break;
                        }
                        if($atc_rating != "" && $atc_rating == 'AS1'){
                            echo "<option value='Introduction to phraseology'>Introduction to phraseology</option>";
                        }
                        elseif($pilot_rating != "" && $pilot_rating == 'FS1'){
                            echo "<option value='Introduction to phraseology'>Introduction to phraseology</option>";
                        }
                        if($atc_rating != "" && $atc_rating != "AS1"){
                            echo "<option value='Phraseology practice'>Phraseology practice</option>";
                        }
                        elseif($pilot_rating != "" && $pilot_rating != "FS1"){
                            echo "<option value='Phraseology practice'>Phraseology practice</option>";
                        }
                        if($atc_rating != "" && $atc_rating != "AS1" && $atc_rating != "AS2" && $atc_rating != "AS3"){
                            echo "<option value='Advanced ATC topics'>Advanced ATC topics</option>";
                        }
                        if($pilot_rating != "" && $pilot_rating != "FS1" && $pilot_rating != "FS2" && $pilot_rating != "FS3"){
                            echo "<option value='Advanced flying topics'>Advanced flying topics</option>";
                        }
                    } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class='tablekey'>
				ID
			</td>
			<td class='tablevalue'>
				<input type='text' name='id' <?php echo "value='".$_SESSION['id']."'"; ?> disabled />
			</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Name
			</td>
			<td class='tablevalue'>
				<input type='text' name='name' <?php echo "value='".$_SESSION['name']."'"; ?> disabled />
			</td>
		</tr>
        <tr>
			<td class='tablekey'>
				Current Rating
			</td>
			<td class='tablevalue'>
				<input type='text' name='rating' <?php echo "value='".$_SESSION['rating']."'"; ?> disabled />
		</tr>
		<tr>
			<td class='tablekey'>
				Email
			</td>
			<td class='tablevalue'>
				<input type='text' name='email' <?php if(!empty($_SESSION['email'])){ echo "value='".$_SESSION['email']."'";} ?> />
			</td>
		</tr>	
		<tr>
			<td class='tablekey'>
				Training Location
			</td>
			<td class='tablevalue'>
				<select class='type2' name='airport'>
                    <?php if($_SESSION['division'] != 'RO'){ ?>
                    <option value='LROP (TWR)'>LROP_TWR - Otopeni Tower</option>
                    <option value='LROP (APP)'>LROP_APP - Bucharest Approach</option>
                    <option value='LRBB (CTR)'>LRBB_CTR - Bucharest Radar</option>
                    <?php } else{ ?>
					<option value='LROP'>LROP - Bucharest (Henri Coanda)</option>
					<option value='LRTR'>LRTR - Timisoara (Traian Vuia)</option>
					<option value='LRCK'>LRCK - Constanta (Mihail Kogalniceanu)</option>
					<option value='LRCL'>LRCL - Cluj Napoca</option>
					<option value='LRBB'>LRBB - Bucharest FIR</option>
                    <?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class='tablekey'>
				Please explain the reason of your request and provide your availability in the next weeks.
			</td>
			<td class='tablevalue'>
				<textarea name='reason'></textarea>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	<tr>
		<td>
			<input class='submit' type='submit' name='submit' value='Submit your request!' />
		</td>
	</tr>
</table>
</form>

<?php
}
?>    

</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>