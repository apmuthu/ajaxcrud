<?php

	/* you SHOULD edit the database details below; fill in your database info */

	#this is the info for your database connection
    ####################################################################################
    ##
	if (!isset($MYSQL_HOST))  $MYSQL_HOST  = "localhost";
	if (!isset($MYSQL_LOGIN)) $MYSQL_LOGIN = "root";
	if (!isset($MYSQL_PASS))  $MYSQL_PASS  = "";
	if (!isset($MYSQL_DB))    $MYSQL_DB    = "ajaxcrud_demos";
	##
	if (!isset($LOCAL_JS))    $LOCAL_JS    = FALSE; // FALSE for inclusion of remote js files
    ##
    ####################################################################################

	/********* THERE SHOULD BE LITTLE NEED TO EDIT BELOW THIS LINE *******/

	####################################################################################

	#a session variable is set by class for much of the CRUD functionality -- eg adding a row
    if (session_id() == "") session_start();

    #for pesky IIS configurations without silly notifications turned off
    error_reporting(E_ALL - E_NOTICE);

	$useMySQLi = true;
	if (!class_exists("mysqli")){
		$useMySQLi = false; //mysqli is not enabled on this server; fallback to using mysql
	}

	if ($useMySQLi){
		$mysqliConn = new mysqli($MYSQL_HOST, $MYSQL_LOGIN, $MYSQL_PASS, $MYSQL_DB);
		/* check connection */
		if (mysqli_connect_errno()) {
			//logError("Connect failed in getMysqli(): ", mysqli_connect_error());
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$mysqliConn->set_charset("utf8");
	}
	else{
		/*
		   use this connection if your hosting config does NOT support mysqli
		   this code was for mySQL connections; was replaced in v8.6 with mysqli
		*/

		$db = @mysql_connect($MYSQL_HOST,$MYSQL_LOGIN,$MYSQL_PASS);

		if(!$db){
			echo('Unable to authenticate user. <br />Error: <b>' . mysql_error() . "</b>");
			exit;
		}
		$connect = @mysql_select_db($MYSQL_DB);
		if (!$connect){
			echo('Unable to connect to db <br />Error: <b>' . mysql_error() . "</b>");
			exit;
		}
		mysql_query("SET NAMES 'utf8'");
		//mysql_query("SET character_set_results = 'utf8_general_ci', character_set_client = 'utf8_general_ci', character_set_connection = 'utf8_general_ci', character_set_database = 'utf8_general_ci', character_set_server = 'utf8_general_ci'", $db);
	}


	# what follows are custom database handling functions - required for the ajaxCRUD class
	# ...but these also may be helpful in your application(s) :-)
	if (!function_exists('q')) { // Gets all rows of the query for SELECTs and also executes other queries like UPDATE, INSERT and DELETE
		function q($q, $debug = 0, $assoc = false){
			global $mysqliConn, $useMySQLi;

			if ($useMySQLi){
				if (!($r = $mysqliConn->query($q))) {
					$errorMsg = "Mysql Error in preheader.php q(). The query was: " . $q . " and the possible mysqli error follows:" . $mysqliConn->error;
					//logError($errorMsg);
					exit("<p>$errorMsg</p>");
				}
			}
			else{
				//mysql connection; was replaced in v8.6 with mysqli
				$r = mysql_query($q);
				if(mysql_error()){
					echo mysql_error();
					echo "$q<br>";
				}
			}

			if($debug == 1){
				echo "<br>$q<br>";
			}

			if(stristr(substr($q,0,8),"delete") ||	stristr(substr($q,0,8),"insert") || stristr(substr($q,0,8),"update")){
				if ($useMySQLi){
					$affectedRows = $mysqliConn->affected_rows;
				}
				else{
					$affectedRows = mysql_affected_rows();
				}
				if ($affectedRows > 0){
					return true;
				}
				return false;
			}


			if ($useMySQLi){
				$numRows = $r->num_rows;
			}
			else{
				$numRows = mysql_num_rows($r);
			}
			if ($numRows > 1){
				if ($useMySQLi){
					while ($row = ($assoc) ? $r->fetch_array(MYSQLI_ASSOC) : $r->fetch_array()){
						$results[] = $row;
					}
				}
				else{
					while($row = mysql_fetch_array($r)){
						$results[] = $row;
					}
				}
			}
			else if ($numRows == 1){
				$results = array();
				if ($useMySQLi){
					$results[] = ($assoc) ? $r->fetch_array(MYSQLI_ASSOC) : $r->fetch_array();
				}
				else{
					$results[] = mysql_fetch_array($r);
				}
			}
			else{
				$results = array();
			}

			return $results;
		}
	}

	if (!function_exists('q1')) { // Gets the first field of the first and sole row
		function q1($q, $debug = 0){
			global $mysqliConn, $useMySQLi;

			if ($useMySQLi){
				if (!($r = $mysqliConn->query($q))) {
					$errorMsg = "Mysql Error in preheader.php q1(). The query was: " . $q . " and the possible mysqli error follows:" . $mysqliConn->error;
					//logError($errorMsg);
					exit($errorMsg);
				}
			}
			else{
				$r = mysql_query($q);
				if(mysql_error()){
					echo mysql_error();
					echo "<br>$q<br>";
				}
			}

			if($debug == 1){
				echo "<br>$q<br>";
			}

			if ($useMySQLi && isset($r)){
				$row = $r->fetch_array();
			}
			else{
				$row = @mysql_fetch_array($r);
			}

			if(count($row) == 2){
				return $row[0];
			}

			return $row;
		}
	}

	if (!function_exists('qr')) { // Gets the first row of the sole row
		function qr($q, $debug = 0){
			global $mysqliConn, $useMySQLi;

			if ($useMySQLi){
				if (!($r = $mysqliConn->query($q))) {
					$errorMsg = "Mysql Error in preheader.php qr(). The query was: " . $q . " and the possible mysqli error follows:" . $mysqliConn->error;
					exit("<p>$errorMsg</p>");
				}
			}
			else{
				$r = mysql_query($q);
				if(mysql_error()){
					echo mysql_error();
					echo "<br>$q<br>";
				}
			}

			if($debug == 1){
				echo "<br>$q<br>";
			}

			if(stristr(substr($q,0,8),"delete") ||	stristr(substr($q,0,8),"insert") || stristr(substr($q,0,8),"update")){
				if ($useMySQLi){
					$numberOfAffectedRows = $mysqliConn->affected_rows;
				}
				else{
					$numberOfAffectedRows = mysql_affected_rows();
				}

				if ($numberOfAffectedRows > 0) {
					return true;
				}
				return false;
			}

			if(stristr(substr($q,0,8),"create") || stristr(substr($q,0,8),"drop")){
				//added for executing create table statements; e.g. the example install script /examples/install.php
				return true;
			}

			$results = array();

			if ($useMySQLi){
				$results[] = $r->fetch_array();
			}
			else{
				$results[] = mysql_fetch_array($r);
			}

			$results = $results[0];

			return $results;
		}
	}
	
// Custom Functions for displaying tables from SQL by Ap.Muthu
// Use for static non sortable display of summary info, legends, lookup records, etc

	function showSQLRecord($selectSQL, $titles=Array(), $caption='') {
// Get single record [and titles] display code
		$row = qr($selectSQL);
		$content  = CHR(10) . "<table border='1' style='border-collapse: collapse;' class='ajaxCRUD'>";
		if($caption <> '')
			$content .= CHR(10) . "<caption><b>$caption</b></caption>";
		if (count($titles) > 0)
			$content .= showRow($titles, true);
		// Single Row
		$content .= showRow($row);
		$content .= '</table>' . CHR(10);
		return $content;
	}

	function showSQLRows($selectSQL, $titles=Array(), $caption='') {
// Get multiple records [and titles] display code
		$rows = q($selectSQL);
		$content  = CHR(10) . "<table border='1' style='border-collapse: collapse;' class='ajaxCRUD'>";
		if($caption <> '')
			$content .= CHR(10) . "<caption><b>$caption</b></caption>";
		if (count($titles) > 0)
			$content .= showRow($titles, true);
		// Multiple Rows
		foreach ($rows as $row) {
			$content .= showRow($row);
		}
		$content .= '</table>' . CHR(10);
		return $content;
	}

	function showRow($row, $isHead=false) {
// Get table cell fragment
		$tag = 'td';
		$ct  = 2;
		if ($isHead) {
			$tag = 'th';
			$ct  = 1;
		}
		$content .= CHR(10) . "<tr>";
		for ($i=0; $ct*$i < count($row); $i++) {
			$align = (is_numeric($row[$i]) ? "align='right'" : "");
			$content .= "<$tag $align>$row[$i]</$tag>";
		}
		$content .= CHR(10) . "</tr>";
		return $content;
	}

	function get_field_names($result) {
		$x = $result->fetch_fields();
		foreach($x as $fieldinfo)
			$y[] = $fieldinfo->name;
		return $y;
	}

	function get_select_options($options) {
		$RetOptions = '';
		foreach ($options as $v) {
			if (is_array($v))
				$RetOptions .= "\n<option value='$v[0]'>$v[1]</option>";
			else
				$RetOptions .= "\n<option>$v</option>";
		}
		return $RetOptions;
	}

?>