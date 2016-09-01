<?php
	ob_start();
    if (!isset($_SESSION)) session_start();
    require_once("common.php");
 ?>
<html>
<body>
<?php

    $data = array();

	echo "<table border=1>";
	foreach( $_REQUEST as $key => $value )
	{
		echo "<tr><th>$key</th><td>$value</td></tr>";
		$data[$key] = $value;
	}
	echo "</table>";

    $_SESSION["RegData"] =  $data;

    $data = $_SESSION["RegData"];

    if (!isset($_SESSION['RegData']))
    {
        echo "No Session Data";
    }
    else {
        echo "Session Data Is Set<br>";
    }

    TraceMsg("confirm.php: $data[firstName] $data[lastName]");

    // this will set $regNbr
    include "SaveRegistration.php";
    TraceMsg("confirm.php: Saved To database $regNbr");

    if ($data['paymentType'] == 'PayPal') // && !IsSet($_SESSION['token'])) {
    {
        include "payment.php";
    }
    else
    {
        $_SESSION["SaveData"] = $data;
        $data = array();
        $_SESSION["RegData"] =  $data;
    }



?>
<a href="register.html#/taketina"><button type="button">Register Taketina</button></a>
<a href="register.html#/playshop"><button type="button">Register PlayShop</button></a>
<a href="submit.php"><button type="button">Submit</button></a>
<a href="cancel.php"><button type="button">Cancel</button></a>
</body>
</html>



