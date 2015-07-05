<?php
	require_once("db_config.php");
	
	if (isset($_POST["add"])) {
		$name = $_POST["name"];
		$sql = "INSERT INTO factor (name) VALUES (:name)";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':name', $name);
		$statement->execute();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Factor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<div class="wrapper">
		<?php require_once('header.php'); ?>
	
		<form method="post" action="adminfactor.php">
			<table>
				<tr>
					<td colspan="2">Add factor HERE</td>
					
				</tr>
				<tr>
					<td>Name</td>
					<td><input type="text" value="" name="name"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Add" name="add"></td>
				</tr>
			</table>
		</form>
		
		
		
		<table>
				<tr>
					<td colspan="2">List factors HERE</td>
					
				</tr>
				<tr>
					<td>Id</td>
					<td>Name</td>
				</tr>
				<?php
					$sql = "SELECT * FROM factor";
					$statement = $pdo->prepare($sql);
					$statement->execute();
					$rows = $statement->fetchAll();
					
					foreach($rows as $row) {
				?>
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['name']; ?></td>
				</tr>
					<?php } ?>
			</table>
	<div>
</body>
</html>
