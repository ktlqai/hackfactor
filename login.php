<?php
	session_start();

	require_once("db_config.php");
	
	$email = $_POST["email"];
	$password = $_POST["password"];
	$sql = "SELECT * FROM user WHERE email=:email AND password=:password";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':email', $email);
	$statement->bindParam(':password', $password);
	$statement->execute();
	$rows = $statement->fetchAll();
	/*foreach($rows as $row){
		echo $row['id'] . " dashboard " . $row['email'] . "<br>";
	}*/
	//echo count($rows);
	if (count($rows) > 0) {
		$type = $rows[0]['type'];
		$id = $rows[0]['id'];
		$_SESSION['type'] = $type;
		$_SESSION['loginedid'] = $id;
		
		if ($type == 'admin') {
			header('Location: adminfactor.php');
		}
		else if ($type == 'user') {
			header('Location: userfactor.php');
		}
		else if ($type == 'school') {
			header('Location: schoolcourse.php');
		}
		else if ($type == 'company') {
			header('Location: companyjob.php');
		}
	}
	else {
		header('Location: index.php');
	}
	foreach($rows as $row){
		//echo $row['id'] . " dashboard " . $row['name'] . "<br>";
	}
	
	$statement->close();
	$pdo->close();
	
?>
