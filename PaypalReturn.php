<?php
	session_start();
	if (IsSet($_SESSION['RegData'])) {
		$data = $_SESSION['RegData'];
		if (isset($_REQUEST['token']))
		{
			$_SESSION['token'] = $_REQUEST['token'];
			$_SESSION['payer_id'] =	$_REQUEST['PayerID'];
		}
		require_once("confirm.php");
	} else {
		echo "Can't find the information in the session";
	}
?>
