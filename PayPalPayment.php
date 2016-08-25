<?php
	session_start();

	require_once ("paypalfunctions.php");
	if (IsSet($_SESSION['RegData'])) {
		$data = $_SESSION['RegData'];
	} else {
		echo "Can't find the information in the session";
		exit;
	}

	$_SESSION['paymentType'] = 'Sale';
	$token = $_SESSION['token'];
	$finalPaymentAmount =  $data['amountDue'];
	/*
	'------------------------------------
	' Calls the DoExpressCheckoutPayment API call
	'
	' The ConfirmPayment function is defined in the file PayPalFunctions.jsp,
	' that is included at the top of this file.
	'-------------------------------------------------
	*/

	$resArray = ConfirmPayment ( $finalPaymentAmount );
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" )
	{
		$transactionId		= $resArray["TRANSACTIONID"];
		$transactionType 	= $resArray["TRANSACTIONTYPE"];
		$paymentType		= $resArray["PAYMENTTYPE"];
		$orderTime 			= $resArray["ORDERTIME"];
		$paypalAmount		= $resArray["AMT"];
		$currencyCode		= $resArray["CURRENCYCODE"];
		$feeAmt				= IsSet($resArray["FEEAMT"]) ?  $resArray["FEEAMT"] : 0;
		$settleAmt			= IsSet($resArray["SETTLEAMT"]) ? $resArray["SETTLEAMT"] : null;
		$taxAmt				= IsSet($resArray["TAXAMT"]) ? $resArray["TAXAMT"] : null;
		$exchangeRate		= IsSet($resArray["EXCHANGERATE"]) ? $resArray["EXCHANGERATE"] : null;
		$paymentStatus	    = IsSet($resArray["PAYMENTSTATUS"]) ? $resArray["PAYMENTSTATUS"] : null; 
		$pendingReason	    = IsSet($resArray["PENDINGREASON"]) ? $resArray["PENDINGREASON"] : null;  
		$reasonCode		    = IsSet($resArray["REASONCODE"]) ? $resArray["REASONCODE"] : null;   

		require_once("SubmitRegister.php");
	}
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		
		echo "GetExpressCheckoutDetails API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
		
?>
