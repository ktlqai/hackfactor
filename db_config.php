<?php
	/*$config_db["dbname"] = 'ad_9c25f04445da041';
	$config_db["hostname"] = 'us-cdbr-iron-east-02.cleardb.net';
	$config_db["port"] = '3306';
	$config_db["username"] = 'bb7564e2aec886';
	$config_db["password"] = 'ea4c6ff9';*/

	$config_db["dbname"] = 'hackfactor';
	$config_db["hostname"] = 'localhost';
	$config_db["port"] = '3306';
	$config_db["username"] = 'root';
	$config_db["password"] = '';

	if ($services = getenv("VCAP_SERVICES")) {
		$services_json = json_decode($services, true);
		$config_db = $services_json["cleardb"][0]["credentials"];
		$config_db["dbname"] = "ad_85bd68f26d7a0ab";
	}
	
	$pdo = null;
	try {
		$servername = $config_db["hostname"];
		$myDB = $config_db["dbname"];
		$pdo = new PDO("mysql:host=$servername;dbname=$myDB", $config_db["username"], $config_db["password"]);
		// set the PDO error mode to exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully"; 
		}
	catch(PDOException $e)
		{
		echo "Connection failed: " . $e->getMessage();
		}
?>
