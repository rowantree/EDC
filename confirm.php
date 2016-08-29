<?php
    if (!isset($_SESSION))
     {
         session_start();
         echo "Session Started<br>";
     }

/*
	This is a comment
*/

    $data = array();

	echo "<table border=1>";
	foreach( $_REQUEST as $key => $value )
	{
		echo "<tr><th>$key</th><td>$value</td></tr>";
		$data[$key] = $value;
	}
	echo "</table>";

	foreach( $_REQUEST as $key => $value )
	{
	    echo "$key,";
	}
	echo "<BR>";

    $_SESSION["RegData"] =  $data;

    $data = $_SESSION["RegData"];

    if (!isset($_SESSION['RegData']))
    {
        echo "No Session Data";
    }
    else {
        echo "Session Data Is Set<br>";
    }




    if ($data['paymentType'] == 'PayPal') // && !IsSet($_SESSION['token'])) {
    {
        echo "Paypal Payment Option<br>";
        include "payment.php";
    }
    else
    {
        include "SaveRegistration.php";
    }
?>
<a href="register.html"><button type="button">Register</button></a>
<a href="submit.php"><button type="button">Submit</button></a>
<a href="cancel.php"><button type="button">Cancel</button></a>
