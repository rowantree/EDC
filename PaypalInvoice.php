<?php
if (session_id() == "") session_start();
require_once("common.php");

	if (!IsSet($_SESSION['RegData']))
	{
		TraceMsg("PaypalInvoice.php: Can't find the information in the session");
		echo "Can't find the information in the session";
		exit;
	}

	$data = $_SESSION['RegData'];
	if (isset($_REQUEST['token']))
	{
		$_SESSION['token'] = $_REQUEST['token'];
		$_SESSION['payer_id'] =	$_REQUEST['PayerID'];
	}

	TraceMsg("PaypalInvoice.php: token=$_SESSION[token] payer_id=$_SESSION[payer_id]");

?>
<html>
<head>
	<title><?php echo $data["EventCode"];?> Registration</title>
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
