<?php

$headers = "";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$bccList = "stephen@rowantree.org, morwen@earthdrum.com";
$headers .= "Bcc: $bccList\r\n";
$headers .= "From: EDC Registration <stephen@rowantree.org>\r\n";

$msg = "<html>";
$msg .= "<table border=1>";
foreach( $data as $key => $value )
{
    $msg .= "<tr><th>$key</th><td>$value</td></tr>";
}
$msg .= "</table>";
$msg .= "</html>";

$emailAddr = "$data[firstName] $data[lastName] <$data[email]>";

$subject = "$data[eventCode] Registration for $data[firstName] $data[lastName] #$data[regNbr]";

if (!@mail( $emailAddr, $subject, $msg, $headers ) )
{
    $error = error_get_last();
    foreach( $error as $key => $value )
    {
        echo "[$key] $value<br>";
    }
	error_log("Failed to send email to $emailAddr", 3, 'error.log');
	echo "<br>eMail notice to $emailAddr could not be sent";
}

    echo $msg;
?>
