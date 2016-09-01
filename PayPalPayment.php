<?php
if (session_id() == "") session_start();
/*
 *  This is called on return from PayPal when the user has completed the process
 */
require_once("common.php");

	require_once ("paypalfunctions.php");

	if (!IsSet($_SESSION['RegData']))
	{
		TraceMsg("PayPalPayment.php: Can't find the information in the session");
		echo "Can't find the information in the session";
		exit;
	}

	if (!isset($_REQUEST['token']))
	{
	    TraceMsg("PayPalPayment.php: Can't find the PayPal Token in the request");
	    echo "Can't find the PayPal Token in the request";
	    exit;
	}

    $data = $_SESSION['RegData'];
    $_SESSION['token'] = $_REQUEST['token'];
    $_SESSION['payer_id'] =	$_REQUEST['PayerID'];
	$_SESSION['paymentType'] = 'Sale';

	$token = $_SESSION['token'];

    if (!array_key_exists('amountDue',$data))
    {
        TraceMsg("PayPalPayment: Error: Could not find amount due in the data block");
        echo "Could not find amount due in the data block";
        exit;
    }

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
	TraceMsg("PayPalPayment.php: ConfirmPayment returned $ack");
	if( $ack == "SUCCESS" )
	{
		$transactionId		= $resArray["TRANSACTIONID"];
	    /*
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
		*/

		TraceMsg("PayPalPayment: " . json_encode($resArray));

        include_once "OpenDb.php";
        $db = OpenPDO();
        $stmt = $db->prepare("UPDATE edc_event SET transactionId=:transactionID WHERE edc_event_id=:regNbr");
        $stmt->bindValue(':transactionID', $transactionId);
        $stmt->bindValue(':regNbr', $data['regNbr']);
        ExecutePDO($stmt);

        include_once "Finalize.php";

	}
	else  
	{
		TraceMsg("PayPalPayment(ERROR): " . json_encode($resArray));

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
