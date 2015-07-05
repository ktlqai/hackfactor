<?php
	session_start();
	
	require_once("db_config.php");
	
	if (isset($_GET['jobid'])) {
		$jobid = $_GET['jobid'];
		$_SESSION['jobid'] = $jobid;
	}
	
	$jobid = $_SESSION['jobid'];
	
	if (isset($_POST["add"])) {
		$loginedid = $_SESSION['loginedid'];
		$factorid = $_POST["factorid"];
		$minimumpoint = $_POST["minimumpoint"];
		$sql = "INSERT INTO jobfactor (jobid, factorid, minimumpoint) VALUES (:jobid, :factorid, :minimumpoint)";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':jobid', $jobid);
		$statement->bindParam(':factorid', $factorid);
		$statement->bindParam(':minimumpoint', $minimumpoint);
		
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
			<tr>
				<td colspan="2">Info job HERE</td>
				
			</tr>
			<?php
				$jobid = $_SESSION["jobid"];
				$sql = "SELECT * FROM job WHERE id=:id";
				$statement = $pdo->prepare($sql);
				$statement->bindParam(':id', $jobid);
				$statement->execute();
				$row = $statement->fetch(PDO::FETCH_ASSOC);
			?>
			<tr>
				<td>Name</td>
				<td><?php echo $row['name']; ?></td>
			</tr>
			<tr>
				<td>Link</td>
				<td><a href="<?php echo $row['link']; ?>" target="_blank"><?php echo $row['link']; ?></a></td>
			</tr>
			<tr>
				<td>Pay</td>
				<td><?php echo $row['pay']; ?></td>
			</tr>
		</table>
	
		<form method="post" action="jobfactor.php">
			<table>
				<tr>
					<td colspan="2">Add job factors HERE</td>
					
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
					<td>Minimum point</td>
					<td><input type="text" value="" name="minimumpoint"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Add" name="add"></td>
				</tr>
			</table>
		</form>
		
		
		
		<table>
				<tr>
					<td colspan="2">List job factors HERE</td>
					
				</tr>
				<tr>
					<td>Id</td>
					<td>Factor</td>
					<td>Minimum point</td>
				</tr>
					<?php
						$jobid = $_SESSION['jobid'];
						$sql = "SELECT jobfactor.id AS jobfactorid, factorid, name, minimumpoint FROM jobfactor INNER JOIN factor ON jobfactor.factorid = factor.id WHERE jobid = :jobid";
						$statement = $pdo->prepare($sql);
						$statement->bindParam(':jobid', $jobid);
						$statement->execute();
						$num_of_factors = 0;
						$passed_users = array();
						
						while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
					?>
				<tr>
					<td><?php echo $row['jobfactorid']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['minimumpoint']; ?></td>
				</tr>
					<?php
							$num_of_factors++;
					
							$sql_inner = "SELECT user.id AS userid, name FROM user INNER JOIN userfactor ON user.id = userfactor.userid AND userfactor.factorid = :factorid AND point >= :minimumpoint";
							$statement_inner = $pdo->prepare($sql_inner);
							$statement_inner->bindParam(':factorid', $row['factorid']);
							$statement_inner->bindParam(':minimumpoint', $row['minimumpoint']);
							$statement_inner->execute();
							
							while ($row_inner = $statement_inner->fetch(PDO::FETCH_ASSOC)) {
								if (! isset($passed_users[$row_inner['userid']])) {
									$passed_users[$row_inner['userid']] = 1;
								}
								else {
									$passed_users[$row_inner['userid']]++;
								}
							}
						}
					?>
				<tr>
					<td>+++++++++</td>
					<td colspan="2">
						<table>
							<tr>
								<td colspan="2">List of Passed users</td>
								
							</tr>
							<?php
								foreach ($passed_users as $k => $v) {
									if ($v == $num_of_factors) {
									
							?>
							<tr>
								<td><?php echo $k; ?></td>
								<td></td>
							</tr>
								<?php
									}
								}
						?>
						</table>
					</td>
				</tr>
			</table>
	<div>
</body>
</html>
