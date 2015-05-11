<?php
/**
 * /system/email-settings.php
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
include("../_includes/start-session.inc.php");
include("../_includes/init.inc.php");
include(DIR_INC . "head.inc.php");
include(DIR_INC . "software.inc.php");
include(DIR_INC . "config.inc.php");
include(DIR_INC . "database.inc.php");
include(DIR_INC . "auth/auth-check.inc.php");
require_once(DIR_INC . "classes/Autoloader.class.php");

spl_autoload_register('DomainMOD\Autoloader::classAutoloader');

$error = new DomainMOD\Error();
$time = new DomainMOD\Timestamp();

$page_title = "Email Settings";
$software_section = "system-email-settings";

$new_expiration_email = $_POST['new_expiration_email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$sql = "UPDATE user_settings
			SET expiration_emails = '$new_expiration_email',
				update_time = '" . $time->time() . "'
			WHERE user_id = '" . $_SESSION['user_id'] . "'";
	$result = mysqli_query($connection, $sql) or $error->outputOldSqlError($connection);

	$_SESSION['expiration_email'] = $new_expiration_email;

	$_SESSION['result_message'] .= "Your Email Settings were updated<BR>";

	header("Location: index.php");
	exit;

} else {

	$sql = "SELECT expiration_emails
			FROM user_settings
			WHERE user_id = '" . $_SESSION['user_id'] . "'";
	$result = mysqli_query($connection, $sql) or $error->outputOldSqlError($connection);
	
	while ($row = mysqli_fetch_object($result)) {
		
		$new_expiration_email = $row->expiration_emails;

	}

}
?>
<?php include(DIR_INC . "doctype.inc.php"); ?>
<html>
<head>
<title><?php echo $software_title . " :: " . $page_title; ?></title>
<?php include(DIR_INC . "layout/head-tags.inc.php"); ?>
</head>
<body>
<?php include(DIR_INC . "layout/header.inc.php"); ?>
<form name="email_settings_form" method="post">
<strong>Subscribe to Domain & SSL Certificate expiration emails?</strong>&nbsp;
<select name="new_expiration_email">
<option value="1"<?php if ($new_expiration_email == "1") echo " selected"; ?>>Yes</option>
<option value="0"<?php if ($new_expiration_email == "0") echo " selected"; ?>>No</option>
</select>
<BR><BR>
<input type="submit" name="button" value="Update Email Settings&raquo;">
</form>
<?php include(DIR_INC . "layout/footer.inc.php"); ?>
</body>
</html>
