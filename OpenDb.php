<?php
	// $Id: OpenDb.php 67 2015-11-14 03:44:34Z stephen $

$DbSettings = new stdClass();

$DbSettings->host = 'localhost';
$DbSettings->username = 'rowan_RosReg';
$DbSettings->password = 'eBssEzAjvpCU';
$DbSettings->DbName = 'rowan_RitesRegistration';

$DbSettings->host = 'ustwpres404';
$DbSettings->username = 'root';
$DbSettings->password = 'vepru6Wa';
$DbSettings->DbName = 'edc';

	function LinkDb()
	{
		$link = new mysqli("localhost", "hhgReg", 'T*X$c9;an1Kb', "rites");
		return $link;
	}

	function OpenPDO()
	{
		global $dbName, $DbSettings;
		if ($dbName == '') $dbName=$DbSettings->DbName;
		try 
		{
			$db = new PDO("mysql:host=$DbSettings->host;dbname=$dbName", $DbSettings->username , $DbSettings->password);
		}
		catch (Exception $e) 
		{
			echo "<font color=\"red\">Could not connect to db!</font>";
			error_log( Date(DATE_W3C) . ':' . $e->getMessage());
			/*
			$fp = fopen('error.err', 'a+');
			fwrite($fp, Date(DATE_W3C) . ':' . $e->getMessage() . "\n");
			fclose($fp);
			*/
			exit;
		}
		return $db;
	}

	function OpenDbConnection() {

		global $db;
		global $title;
		global $prefix;
		global $dbName;
        global $DbSettings;

		if (!ISSET($dbName) ) $dbName=$DbSettings->DbName;

		$db = mysql_connect($DbSettings->host, $DbSettings->username, $DbSettings->password, $dbName);

		if ( !$db ) {
			echo "<font color=\"red\">Could not connect to db!</font>";
			echo mysql_error();
			exit;
		}
		$result = mysql_select_db($dbName,$db);
		//$result = mysql_select_db("rowantre_RitesRegistration",$db);
		if ( !$result ) {
			echo "<font color=\"red\">Could not open the db!</font>";
			echo mysql_error();
			exit;
		}

		$result = mysql_query("SELECT user_id FROM users",$db);
	}

	function ConnectToDb() {

		global $userid;
		global $admin;

		OpenDbConnection();
		$admin = isset($_COOKIE["admin"]) ? $_COOKIE["admin"] : false;
		$userid = isset($_COOKIE["userid"]) ? $_COOKIE["userid"] : '';

	}


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
function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}



?>
