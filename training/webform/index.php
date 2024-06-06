<?php
$title = 'Web Form<br>Timbuktoo';
$form = true;

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (isset($_POST['captcha'], $_SESSION['captcha']) && md5($_POST['captcha']) == $_SESSION['captcha'])
   {
      unset($_POST['captcha'], $_SESSION['captcha']);
	$title = 'Web Form, Timbuktoo<br>Form Submission';
	$form = false;
   } else {
      echo '<strong>CAPTCHA verification failed.</strong><br>';
   }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="blurBg-false" style="background-color:#EBEBEB">

<?php
if ($form) {
?>
<link rel="stylesheet" href="../assets/formoid-solid-blue.css" type="text/css" />

<script type="text/javascript" src="../assets/jquery.min.js"></script>
<form class="formoid-solid-blue"
      enctype="multipart/form-data"
      style="background-color:#FFFFFF;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#34495E;max-width:480px;min-width:150px"
	  method="post">
<div class="title"><h2><center><?php echo $title; ?></center></h2></div>
	<div class="element-input"><label class="title"><span class="required">*</span> Applicant Name</label><div class="item-cont"><input class="large" type="text" name="Applicant" required="required" placeholder="Applicant Name"/><span class="icon-place"></span></div></div>
	<div class="element-date"><label class="title"><span class="required">*</span> Date of Birth (yyyy-mm-dd)</label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="DOB" required="required" placeholder="Date of Birth"/><span class="icon-place"></span></div></div>
	<div class="element-radio"><label class="title"><span class="required">*</span> Gender</label>
		<div class="column column1">
			<label><input type="radio" name="Gender" value="Female" required="required"/><span>Female</span></label>
			<label><input type="radio" name="Gender" value="Male" required="required"/><span>Male</span></label>
		</div><span class="clearfix"></span>
	</div>
<!--
	<div class="element-radio"><label class="title"><span class="required">*</span> Gender</label>
		<div class="column column2"><label><input type="radio" name="Gender" value="Female" required="required"/><span>Female</span></label></div><span class="clearfix"></span>
		<div class="column column2"><label><input type="radio" name="Gender" value="Male" required="required"/><span>Male</span></label></div><span class="clearfix"></span>
	</div>
-->
	<div class="element-select"><label class="title"><span class="required">*</span> Year 12th Passed</label><div class="item-cont"><div class="medium"><span>
	<select name="YearPass" required="required">
		<option value="2012">2012</option>
		<option value="2013">2013</option>
		<option value="2014">2014</option>
		<option value="2015">2015</option>
		<option value="2016">2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
		<option value="2020">2020</option>
		<option value="2021">2021</option>
	</select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-select"><label class="title"><span class="required">*</span> Branch</label><div class="item-cont"><div class="large"><span>
	<select name="Branch" required="required">
		<option value="Biology">Biology</option>
		<option value="Computer Science">Computer Science</option>
		<option value="Economics">Economics</option>
		<option value="Vocational">Vocational</option>
	</select>	<i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-input"><label class="title"><span class="required">*</span> Father's Name</label><div class="item-cont"><input class="large" type="text" name="FName" required="required" placeholder="Father;s Name"/><span class="icon-place"></span></div></div>
	<div class="element-input"><label class="title"><span class="required">*</span> Mother's Name</label><div class="item-cont"><input class="large" type="text" name="MName" required="required" placeholder="Mother's Name"/><span class="icon-place"></span></div></div>
	<div class="element-input"><label class="title"><span class="required">*</span> Location</label><div class="item-cont"><input class="large" type="text" name="Location" required="required" placeholder="Location"/><span class="icon-place"></span></div></div>
	<div class="element-input"><label class="title"><span class="required">*</span> Mobile</label><div class="item-cont"><input class="large" type="text" name="Mobile" pattern="[0-9]{10}" required="required" placeholder="Mobile"/><span class="icon-place"></span></div></div>
	<div class="element-email"><label class="title"> EMail</label><div class="item-cont"><input class="large" type="email" name="EMail" value="" placeholder="Email"/><span class="icon-place"></span></div></div>
	<div class="element-textarea" title="Job, Business"><label class="title">Remarks - Job, Business, Qualification</label><div class="item-cont"><textarea class="medium" name="Remarks" cols="20" rows="5" placeholder="Remarks"></textarea><span class="icon-place"></span></div></div>
<div id="wb_Captcha1">
<img src="./captcha1.php" alt="Click for new image" title="Click for new image" style="cursor:pointer;float:left;width:100px;height:38px;" onclick="this.src='captcha1.php?'+Math.random()">
<span><input type="text" id="Captcha1" style="margin-top:10px;width:calc(100% - 10px);height:35px;" name="captcha" value="" placeholder="Enter Above Captcha (click on Captcha to change)" spellcheck="false"></span>
</div>

	<div class="element-separator">
		<hr>
		<h3 class="section-break-title">Notes</h3>
	</div>
	<div class="element-textarea">
	<label class="title"></label>
	<div class="item-cont">
	<ul>
		<li>Contact Administrator for assistance @ +91-99999-99999</li>
	</ul>
	</div>
	</div>

<div class="submit"><input type="submit" name=""submit" value="Submit"/></div></form>
<!-- The following line must be here, after the form so that user locale does not change the date format, min and max for date type does not work -->
<script type="text/javascript" src="../assets/formoid-solid-blue.js"></script>


<?php
} else {
	// Process Form Data

/*
echo print_r($_POST, true);

Array
(
    [Applicant] => Alpha Beta
    [DOB] => 1997-05-15
    [Gender] => Female
    [YearPass] => 2015
    [Branch] => Economics
    [FName] => Father
    [MName] => Mother
    [Location] => Chennai
    [Mobile] => 9879879869
    [EMail] => alphabeta@gmail.com
    [Remarks] => Working as AC Mechanic
)

CREATE TABLE `webforms`.`webform` (
  `RegID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Applicant` varchar(60) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` enum('Female','Male') NOT NULL,
  `YearPass` smallint(5) unsigned NOT NULL,
  `Branch` enum('Biology','Computer Science','Economics','Vocational') NOT NULL,
  `FName` varchar(60) NOT NULL,
  `MName` varchar(60) NOT NULL,
  `Location` varchar(60) NOT NULL,
  `Mobile` varchar(25) NOT NULL,
  `EMail` varchar(60) DEFAULT NULL,
  `Remarks` text,
  PRIMARY KEY (`RegID`),
  UNIQUE KEY `ApplicantUnq` (`Applicant`,`DOB`,`Gender`,`YearPass`,`Branch`,`FName`,`MName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

*/

//$mysqliConn = new mysqli($MYSQL_HOST, $MYSQL_LOGIN, $MYSQL_PASS, $MYSQL_DB);

$mysqliConn = new mysqli('localhost', 'root', '', 'webforms');

/* check connection */
if (mysqli_connect_errno()) {
	//logError("Connect failed in getMysqli(): ", mysqli_connect_error());
	printf("DB Connect failed: %s\n", mysqli_connect_error())." Contact Administartor";
	exit();
}

$mysqliConn->set_charset("utf8");

// Sanitize all user input for SQL injection
foreach($_POST as $k => $v) {
	 $_POST[$k] = $mysqliConn->real_escape_string($v);
}

// Make sure that the existing variables do not overlap with DB field names
extract($_POST);

$sql = "INSERT INTO webforms.webform (RegID, RegDate, Applicant, DOB, Gender, YearPass, Branch, FName, MName, Location, Mobile, EMail, Remarks) 
        VALUES (NULL, NOW(), '$Applicant', '$DOB', '$Gender', '$YearPass', '$Branch', '$FName', '$MName', '$Location', '$Mobile', '$EMail', '$Remarks');";
//echo $sql;
//echo "<br>\n";
// INSERT INTO webforms.webform (RegID, RegDate, Applicant, DOB, Gender, YearPass, Branch, FName, MName, Location, Mobile, EMail, Remarks) VALUES (NULL, NOW(), 'Alpha Beta', '2000-01-31', 'Male', '2016', 'Computer Science', 'Father', 'Mother', 'Chennai', '9879879875', 'alphabeta@gmail.com', 'Working as AC Mechanic');

if (!($r = $mysqliConn->query($sql))) {
	$errorMsg = "Db Error. Contact Application Admin";
//	$errorMsg = "Mysql Error in query was: " . $sql . " and the possible mysqli error follows:" . $mysqliConn->error;
	//logError($errorMsg);
	exit($errorMsg);
}

echo "Thankyou for your submission.";

}

?>
</body>
</html>
