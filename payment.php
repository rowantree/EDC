<?php
if (session_id() == "") session_start(); 
require_once("common.php");

// Compute the absolute path to this host
$host = 'http://' . $_SERVER['SERVER_NAME'];
if ( $_SERVER['SERVER_PORT'] != 80 ) $host .= ':' . $_SERVER['SERVER_PORT'];
$parts = explode('/',$_SERVER['REQUEST_URI']);
for($i=1; $i<count($parts)-1; ++$i ) {
	$host .= '/' . $parts[$i];
}

$data = $_SESSION["RegData"];

if ($data['paymentType'] == 'PayPal') // && !IsSet($_SESSION['token'])) {
{
	require_once ("paypalfunctions.php");
	// ==================================
	// PayPal Express Checkout Module
	// ==================================

	$paymentAmount = $data['amountDue'];
	$currencyCodeType = "USD";
	$paymentType = "Sale";
	$returnURL = "$host/PayPalPayment.php";
	$cancelURL = "$host/register.html#" . $data['eventPath'];
	$resArray = CallShortcutExpressCheckout ($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL);
	$ack = strtoupper($resArray["ACK"]);
	TraceMsg("payment.php: CallShortcutExpressCheckout returned $ack");
	if ($ack=="SUCCESS")
	{
		RedirectToPayPal ( $resArray["TOKEN"] );
	} 
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		
		echo "SetExpressCheckout API call failed.<br>";
		echo "Detailed Error Message: " . $ErrorLongMsg . '<br>';
		echo "Short Error Message: " . $ErrorShortMsg . '<br>';
		echo "Error Code: " . $ErrorCode . '<br>';
		echo "Error Severity Code: " . $ErrorSeverityCode . '<br>';
	}
}
else {
	echo "ERROR: Unknown payment type " . $data['paymentType'];
}
?>
