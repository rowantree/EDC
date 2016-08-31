<?php

try {
    if (!isset($_SESSION)) session_start();

    $fh = fopen("register.csv", "w");
    flock($fh, LOCK_EX);

    $data = $_SESSION["RegData"];

    $fields = explode(',',"event,amountDue,firstName,lastName,address,city,state,zipcode,email,phone,paymentType");

    $array = array();
    foreach($fields as $fieldName)
    {
        array_push($array, $data[$fieldName]);
    }

    $fileName = 'event_registration.csv';

    $createFile = !file_exists($fileName);

    $out = fopen($fileName, 'w');

    if ($createFile)
    {
        echo "File does not exist, so we'll create it<br>";
        fputcsv($out, $fields);
    }
    fputcsv($out, $array);
    fclose($out);


    echo "Data File Was Created";
}
catch (Exception $exc)
{
    echo "Caught Exception:" , $exc->getMessage(), "<br>";
}


?>