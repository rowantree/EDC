<?php
	include_once "OpenDb.php";
    if (session_id() == "") session_start();
    $postData = $_SESSION["RegData"];

	$db = OpenPDO();
	$db->beginTransaction();

    $fieldList = 'eventCode, amountDue, firstName, lastName, address, city, state, zipcode, email, phone, paymentType';
	$stmt = $db->prepare("INSERT INTO edc_event ($fieldList, regDate, reg_id) VALUES (:" .
        preg_replace('/,\s*/',',:',$fieldList) . ',current_timestamp(), :reg_id)');
    $stmt->bindValue(':eventCode', $postData['eventCode']);
    $stmt->bindValue(':amountDue', $postData['amountDue']);
    $stmt->bindValue(':firstName', $postData['firstName']);
    $stmt->bindValue(':lastName', $postData['lastName']);
    $stmt->bindValue(':address', $postData['address']);
    $stmt->bindValue(':city', $postData['city']);
    $stmt->bindValue(':state', $postData['state']);
    $stmt->bindValue(':zipcode', $postData['zipcode']);
    $stmt->bindValue(':email', $postData['email']);
    $stmt->bindValue(':phone', $postData['phone']);
    $stmt->bindValue(':paymentType', $postData['paymentType']);
    $stmt->bindValue(':reg_id', md5(uniqid(rand(),1)));


	ExecutePDO($stmt);
	$regNbr = $db->lastInsertId();
	$postData["regNbr"] = $regNbr;
    $_SESSION["RegData"] = $postData;

	$db->commit();

    TraceMsg("Data Has Been Recorded, RegNbr is $regNbr");


?>