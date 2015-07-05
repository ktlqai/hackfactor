<?php
	session_start();
	
	require_once("db_config.php");
	
	if (isset($_POST["add"])) {
		$loginedid = $_SESSION['loginedid'];
		$name = $_POST["name"];
		$link = $_POST["link"];
		$pay = $_POST["pay"];
		$sql = "INSERT INTO job (name, link, companyid, pay) VALUES (:name, :link, :companyid, :pay)";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':name', $name);
		$statement->bindParam(':link', $link);
		$statement->bindParam(':companyid', $loginedid);
		$statement->bindParam(':pay', $pay);
		
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
	
		<?php //echo $temp; ?>
		<table>
			<tr>
				<td colspan="2">Info company HERE</td>
				
			</tr>
			<?php
				$loginedid = $_SESSION["loginedid"];
				$sql = "SELECT * FROM user WHERE id=:id";
				$statement = $pdo->prepare($sql);
				$statement->bindParam(':id', $loginedid);
				$statement->execute();
				$row = $statement->fetch(PDO::FETCH_ASSOC);
			?>
			<tr>
				<td>Name</td>
				<td><?php echo $row['name']; ?></td>
			</tr>
		</table>
	
		<form method="post" action="companyjob.php">
			<table>
				<tr>
					<td colspan="2">Add job HERE</td>
					
				</tr>
				<tr>
					<td>Name</td>
					<td><input type="text" value="" name="name"></td>
				</tr>
				<tr>
					<td>Link</td>
					<td><input type="text" value="" name="link"></td>
				</tr>
				<tr>
					<td>Pay</td>
					<td><input type="text" value="" name="pay"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Add" name="add"></td>
				</tr>
			</table>
		</form>
		
		
		
		<table>
				<tr>
					<td colspan="2">List jobs HERE</td>
					
				</tr>
				<tr>
					<td>Id</td>
					<td>Name</td>
					<td>Link</td>
					<td>Pay</td>
					<td>Link to related factors</td>
				</tr>
				<?php
					$sql = "SELECT id, name, link, pay FROM job WHERE companyid = :companyid";
					$statement = $pdo->prepare($sql);
					$loginedid = $_SESSION['loginedid'];
					$statement->bindParam(':companyid', $loginedid);
					$statement->execute();
					
					while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
				?>
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><a href="<?php echo $row['link']; ?>" target="_blank"><?php echo $row['link']; ?></a>"</td>
					<td><?php echo $row['pay']; ?></td>
					<td><a href="jobfactor.php?jobid=<?php echo $row['id']; ?>" target="_blank">Related factors</a></td>
				</tr>
					<?php } ?>
			</table>
	<div>
</body>
</html>
