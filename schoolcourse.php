<?php
	session_start();
	
	require_once("db_config.php");
	
	if (isset($_POST["add"])) {
		$loginedid = $_SESSION['loginedid'];
		$factorid = $_POST["factorid"];
		$name = $_POST["name"];
		$link = $_POST["link"];
		$goalpoint = $_POST["goalpoint"];
		$sql = "INSERT INTO course (name, link, schoolid, factorid, goalpoint) VALUES (:name, :link, :schoolid, :factorid, :goalpoint)";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':name', $name);
		$statement->bindParam(':link', $link);
		$statement->bindParam(':schoolid', $loginedid);
		$statement->bindParam(':factorid', $factorid);
		$statement->bindParam(':goalpoint', $goalpoint);
		
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
				<td colspan="2">Info school HERE</td>
				
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
	
		<form method="post" action="schoolcourse.php">
			<table>
				<tr>
					<td colspan="2">Add course HERE</td>
					
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
					<?php
						$sql = "SELECT * FROM factor";
						$statement = $pdo->prepare($sql);
						$statement->execute();
					?>
					<td>Factor</td>
					<td>
						<select name="factorid">
							<option value="select-factor">-- Select Factor --</option>
						<?php
							while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
						?>
							<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
						<?php
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Goal point</td>
					<td><input type="text" value="" name="goalpoint"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Add" name="add"></td>
				</tr>
			</table>
		</form>
		
		
		
		<table>
			<tr>
				<td colspan="2">List courses HERE</td>
				
			</tr>
			<tr>
				<td>Id</td>
				<td>Name</td>
				<td>Link</td>
				<td>Factor</td>
				<td>Goal point</td>
			</tr>
			<?php
				$sql = "SELECT course.id AS courseid, course.name AS coursename, link, factor.name AS factorname, goalpoint, factorid FROM course INNER JOIN factor ON course.factorid = factor.id WHERE schoolid = :schoolid";
				$statement = $pdo->prepare($sql);
				$loginedid = $_SESSION['loginedid'];
				$statement->bindParam(':schoolid', $loginedid);
				$statement->execute();
				
				while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			?>
			<tr>
				<td><?php echo $row['courseid']; ?></td>
				<td><?php echo $row['coursename']; ?></td>
				<td><a href="<?php echo $row['link']; ?>" target="_blank"><?php echo $row['link']; ?></a>"</td>
				<td><?php echo $row['factorname']; ?></td>
				<td><?php echo $row['goalpoint']; ?></td>
			</tr>
			<tr>
				<td>+++++++++</td>
				<td colspan="4">
					<table>
						<tr>
							<td colspan="2">List needing users HERE</td>
							
						</tr>
						<tr>
							<td>Id</td>
							<td>Name</td>
							<td>Factor</td>
							<td>Current point</td>
						</tr>
						<?php
							$sql_inner = "SELECT user.id AS userid, name, point FROM user INNER JOIN userfactor ON user.id = userfactor.userid WHERE factorid = :factorid AND point < :goalpoint";
							$statement_inner = $pdo->prepare($sql_inner);
							$statement_inner->bindParam(':factorid', $row['factorid']);
							$statement_inner->bindParam(':goalpoint', $row['goalpoint']);
							$statement_inner->execute();
							
							while ($row_inner = $statement_inner->fetch(PDO::FETCH_ASSOC)) {
						?>
						<tr>
							<td><?php echo $row_inner['userid']; ?></td>
							<td><?php echo $row_inner['name']; ?></td>
							<td><?php echo $row['factorname']; ?></td>
							<td><?php echo $row_inner['point']; ?></td>
						</tr>
							<?php } ?>
					</table>
				</td>
			</tr>
				<?php } ?>
		</table>
		
	<div>
</body>
</html>
