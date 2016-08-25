<?php
	session_start();
	include_once("common/common.php");
	if (!IsSet($_SESSION['RegData'])) 
	{
		echo "Can't find the information in the session";
		exit;
	}

	$data = $_SESSION['RegData'];
	if (isset($_REQUEST['token']))
	{
		$_SESSION['token'] = $_REQUEST['token'];
		$_SESSION['payer_id'] =	$_REQUEST['PayerID'];
	}

?>
<html>
<head>
	<title><?php echo $cfg->eventTitle;?> Registration</title>
	<link rel="stylesheet" href="register.css" type="text/css">
	<script>
	function submit() {
		document.location = "PayPalPayment.php";
	}
	</script>
</head>
<body>
<?php
	include $cfg->headerFile;
?>
<div id="confirm">
Ready to bill your PayPal account.
<br>
You will be charged <?php echo '$' . number_format($data['amountDue'],2); ?><br>
<input type="button" value="Complete my Registration" onClick="submit()">
</div>
</body>
