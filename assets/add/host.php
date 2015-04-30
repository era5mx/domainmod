<?php
/**
 * /assets/add/host.php
 *
 * This file is part of DomainMOD, an open source domain and internet asset manager.
 * Copyright (C) 2010-2015 Greg Chetcuti <greg@chetcuti.com>
 *
 * Project: http://domainmod.org   Author: http://chetcuti.com
 *
 * DomainMOD is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * DomainMOD is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with DomainMOD. If not, see
 * http://www.gnu.org/licenses/.
 *
 */
?>
<?php
include("../../_includes/start-session.inc.php");
include("../../_includes/config.inc.php");
include("../../_includes/database.inc.php");
include("../../_includes/software.inc.php");
include("../../_includes/auth/auth-check.inc.php");
include("../../_includes/timestamps/current-timestamp.inc.php");
include("../../_includes/classes/Error.class.php");

$error = new DomainMOD\Error();

$page_title = "Adding A New Web Host";
$software_section = "hosting-add";

// Form Variables
$new_host = $_POST['new_host'];
$new_url = $_POST['new_url'];
$new_notes = $_POST['new_notes'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($new_host != "" && $new_url != "") {
		
		$sql = "INSERT INTO hosting 
				(name, url, notes, insert_time) VALUES 
				('" . mysqli_real_escape_string($connection, $new_host) . "', '" . mysqli_real_escape_string($connection, $new_url) . "', '" . mysqli_real_escape_string($connection, $new_notes) . "', '" . $current_timestamp . "')";
		$result = mysqli_query($connection, $sql) or $error->outputOldSqlError($connection);
		
		$_SESSION['result_message'] = "Web Host <font class=\"highlight\">" . $new_host . "</font> Added<BR>";
		
		header("Location: ../hosting.php");
		exit;

	} else {
	
		if ($new_host == "") $_SESSION['result_message'] .= "Please enter the web host name<BR>";
		if ($new_url == "") $_SESSION['result_message'] .= "Please enter the web host's URL<BR>";

	}

}
?>
<?php include("../../_includes/doctype.inc.php"); ?>
<html>
<head>
<title><?php echo $software_title . " :: " . $page_title; ?></title>
<?php include("../../_includes/layout/head-tags.inc.php"); ?>
</head>
<body onLoad="document.forms[0].elements[0].focus()";>
<?php include("../../_includes/layout/header.inc.php"); ?>
<form name="add_host_form" method="post" action="host.php">
<strong>Web Host Name (100)</strong><a title="Required Field"><font class="default_highlight"><strong>*</strong></font></a><BR><BR>
<input name="new_host" type="text" value="<?php echo $new_host; ?>" size="50" maxlength="100">
<BR><BR>
<strong>Web Host's URL (100)</strong><a title="Required Field"><font class="default_highlight"><strong>*</strong></font></a><BR><BR>
<input name="new_url" type="text" value="<?php echo $new_url; ?>" size="50" maxlength="100">
<BR><BR>
<strong>Notes</strong><BR><BR>
<textarea name="new_notes" cols="60" rows="5"><?php echo $new_notes; ?></textarea>
<BR><BR>
<input type="submit" name="button" value="Add This Web Host &raquo;">
</form>
<?php include("../../_includes/layout/footer.inc.php"); ?>
</body>
</html>
