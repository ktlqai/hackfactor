<!DOCTYPE html>
<html>
<head>
	<title>PHP Starter Application</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	
	<div class="wrapper">
		<?php require_once('header.php'); ?>
	
		<form method="post" action="login.php">
			<table>
				<tr>
					<td colspan="2">Log in HERE</td>
					
				</tr>
				<tr>
					<td>E-mail</td>
					<td><input type="text" value="" name="email"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" value="" name="password"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Log in" name="login"></td>
				</tr>
			</table>
		</form>
	<div>
</body>
</html>
