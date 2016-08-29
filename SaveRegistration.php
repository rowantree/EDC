<?php
	include_once "OpenDb.php";
    if (session_id() == "") session_start();
    $postData = $_SESSION["RegData"];

	$db = OpenPDO();
	$db->beginTransaction();

    $fieldList = 'eventCode, amountDue, firstName, lastName, address, city, state, zipcode, email, phone, paymentType';
	$stmt = $db->prepare("INSERT INTO edc_event ($fieldList, regDate) VALUES (:" .
        preg_replace('/,\s*/',',:',$fieldList) . ',current_timestamp())');
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

	ExecutePDO($stmt);
	$regNbr = $db->lastInsertId();

	$db->commit();

	echo "Data Has Been Recorded, RegNbr is $regNbr<br>";



/*
 * Subroutines
*/
function ExecutePDO($stmt)
{
	try
	{
		if (!$stmt->execute())
		{
			var_dump($stmt);
			echo "<font color=\"red\">Database Failure!</font>";
			echo "<font color=\"red\">", var_dump($stmt->errorInfo()), "</font>";
			exit;
		}
	}
	catch (Exception $e)
	{
		echo "<font color=\"red\">Database Error!</font>";
		echo $e->getMessage();
		error_log( Date(DATE_W3C) . '(SubmitRegister):' . $e->getMessage());
		exit;
	}
}

?>