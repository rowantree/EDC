<?php
	ob_start();
    if (!isset($_SESSION)) session_start();
    require_once("common.php");
 ?>
<html>
<body>
<?php

    $data = $_REQUEST;
    if (array_key_exists('PHPSESSID',$data)) unset($data['PHPSESSID']);

	//echo "<table border=1>";
	/*
	foreach( $_REQUEST as $key => $value )
	{
		//echo "<tr><th>$key</th><td>$value</td></tr>";
		$data[$key] = $value;
	}
	*/
	//echo "</table>";

	TraceMsg("Request:" . json_encode($_REQUEST));

    $_SESSION["RegData"] =  $data;

    $data = $_SESSION["RegData"];

    if (!isset($_SESSION['RegData']))
    {
        TraceMsg("ERROR: No Session Data");
        echo "No Session Data";
        exit;
    }

    TraceMsg("confirm.php: $data[firstName] $data[lastName]");

    // this will set $regNbr
    include "SaveRegistration.php";
    TraceMsg("confirm.php: Saved To database $regNbr");
    $data = $_SESSION["RegData"];

    if ($data['paymentType'] == 'PayPal') // && !IsSet($_SESSION['token'])) {
    {
        include "payment.php";
    }
    else
    {
        header("Location: Finalize.php");
    }
?>
</body>
</html>



