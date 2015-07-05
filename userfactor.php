<?php
	session_start();
	
	require_once("db_config.php");
	
	if (isset($_POST["add"])) {
		$loginedid = $_SESSION['loginedid'];
		$factorid = $_POST["factorid"];
		$point = $_POST["point"];
		$atdatetime = $_POST["atdatetime"];
		$sql = "INSERT INTO userfactor (userid, factorid, point, atdatetime) VALUES (:userid, :factorid, :point, :atdatetime)";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':userid', $loginedid);
		$statement->bindParam(':factorid', $factorid);
		$statement->bindParam(':point', $point);
		if ((! isset($atdatetime)) || ($atdatetime == '')) {
			$atdatetime = "" . date('y-m-d');// . " 00:00:00";
		}
		//$atdatetime = "'" . $atdatetime . "'";
		//$temp = '=====' . $atdatetime . '=========';
		
		//$statement->bindValue(':atdatetime', $atdatetime, PDO::PARAM_STR);
		$statement->bindParam(':atdatetime', $atdatetime);
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
				<td colspan="2">Info user HERE</td>
				
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
	
		<form method="post" action="userfactor.php">
			<table>
				<tr>
					<td colspan="2">Add factor HERE</td>
					
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
					<td>Point</td>
					<td><input type="text" value="" name="point"></td>
				</tr>
				<tr>
					<td><!-- At datetime --></td>
					<td><input type="hidden" value="" name="atdatetime"></td>
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
				<td>Factor</td>
				<td>Point</td>
				<td>At datetime</td>
			</tr>
			<?php
				$sql = "SELECT userfactor.id AS userfactorid, name, point, atdatetime, factorid FROM userfactor INNER JOIN factor ON userfactor.factorid = factor.id WHERE userid = :userid ORDER BY factorid ASC, point ASC";
				$statement = $pdo->prepare($sql);
				$loginedid = $_SESSION['loginedid'];
				$statement->bindParam(':userid', $loginedid);
				$statement->execute();
				
				while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			?>
			<tr>
				<td><?php echo $row['userfactorid']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['point']; ?></td>
				<td><?php echo $row['atdatetime']; ?></td>
			</tr>
			<tr>
				<td>+++++++++</td>
				<td colspan="3">
					<table>
						<tr>
							<td colspan="2">List needed courses HERE</td>
							
						</tr>
						<tr>
							<td>Id</td>
							<td>Name link</td>
							<td>Factor</td>
							<td>Goal point</td>
						</tr>
						<?php
							$sql_inner = "SELECT id, name, link, goalpoint FROM course WHERE course.factorid = :factorid AND goalpoint > :point ORDER BY goalpoint ASC";
							$statement_inner = $pdo->prepare($sql_inner);
							$statement_inner->bindParam(':factorid', $row['factorid']);
							$statement_inner->bindParam(':point', $row['point']);
							$statement_inner->execute();
							
							while ($row_inner = $statement_inner->fetch(PDO::FETCH_ASSOC)) {
						?>
						<tr>
							<td><?php echo $row_inner['id']; ?></td>
							<td><a href="<?php echo $row_inner['link']; ?>" target="_blank"><?php echo $row_inner['name']; ?></a></td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row_inner['goalpoint']; ?></td>
						</tr>
							<?php } ?>
					</table>
				</td>
				
			</tr>
				<?php } ?>
		</table>
			
		<table>
			<tr>
				<td colspan="2">List passed jobs HERE</td>
				
			</tr>
			<tr>
				<td>Id</td>
				<td>Name</td>
				<td>Link</td>
				<td>Pay</td>
			</tr>
			<?php
				$sql = "SELECT * FROM job";
				$statement = $pdo->prepare($sql);
				$statement->execute();
				
				while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
					$sql_inner_job_factors = "SELECT * FROM jobfactor WHERE jobfactor.jobid = :jobid";
					$statement_inner_job_factors = $pdo->prepare($sql_inner_job_factors);
					$statement_inner_job_factors->bindParam(':jobid', $row['id']);
					$statement_inner_job_factors->execute();
					
					$job_passed = true;
					
					while ($job_passed && ($row_inner_job_factor = $statement_inner_job_factors->fetch(PDO::FETCH_ASSOC))) {
						$sql_inner_job_factor_passed = "SELECT * FROM userfactor WHERE userfactor.userid = :userid AND userfactor.factorid = :factorid AND point >= :minimumpoint";
						$statement_inner_job_factor_passed = $pdo->prepare($sql_inner_job_factor_passed);
						$loginedid = $_SESSION['loginedid'];
						$statement_inner_job_factor_passed->bindParam(':userid', $loginedid);
						$statement_inner_job_factor_passed->bindParam(':factorid', $row_inner_job_factor['factorid']);
						$statement_inner_job_factor_passed->bindParam(':minimumpoint', $row_inner_job_factor['minimumpoint']);
						$statement_inner_job_factor_passed->execute();
						
						if (! $statement_inner_job_factor_passed->fetch(PDO::FETCH_ASSOC)) {
							$job_passed = false;
						}
					}
					
					if ($job_passed) {
			?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><a href="<?php echo $row['link']; ?>"><?php echo $row['link']; ?></a></td>
				<td><?php echo $row['pay']; ?></td>
			</tr>
			<?php
					}
				}
			?>
		</table>
	<div>
</body>
</html>
