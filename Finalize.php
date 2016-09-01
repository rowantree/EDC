<?php
	ob_start();
    if (!isset($_SESSION)) session_start();
    require_once("common.php");

	if (!IsSet($_SESSION['RegData']))
	{
		TraceMsg("Finalize.php: Can't find the information in the session");
		echo "Can't find the information in the session";
		exit;
	}
    $data = $_SESSION['RegData'];

    include "sendEmail.php";
    echo "Your registration has been received<br>";

    echo "<a href=\"register.html#$data[eventPath]\"><button type=\"button\">Register Another Person</button></a>";
    echo '&nbsp;<a href="http://www.earthdrum.com"><button type="button">Return to Earthdrum Councel</button></a>';

    $_SESSION["SaveData"] = $data;
    unset($_SESSION["RegData"]);
?>