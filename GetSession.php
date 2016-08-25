<?php
    header('Content-type: application/json');
    //$date = date('Y-m-d H:i:s');
    //echo "Process has been cancelled.: $date";
    if (!isset($_SESSION))
     {
         session_start();
     }

    if (!isset($_SESSION['RegData']))
    {
        $data = array();
        $data['json_error_code'] = "NO INFO";
        echo json_encode($data);
        exit;
    }

    $data = $_SESSION["RegData"];

/*
	foreach( $data as $key => $value )
	{
		echo "$key=$value;";
		$data[$key] = $value;
	}

	echo $data;
*/
    echo json_encode($data);



?>