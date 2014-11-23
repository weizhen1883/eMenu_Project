<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['positionEditable'] == "N") {
        header("location:login.php");
    }

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="userDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['add'])) {
		$position=$_POST['position'];
		$sql="SELECT * FROM positionPermission WHERE position='$position'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		if ($count==0) {
			$userEditable=$_POST['userEditable'];
			$positionEditable=$_POST['positionEditable'];
			$menuEditable=$_POST['menuEditable'];
			$cuisineEditable=$_POST['cuisineEditable'];
			$orderSubmitable=$_POST['orderSubmitable'];
			$orderChangeable=$_POST['orderChangeable'];
			$sql="INSERT INTO positionPermission VALUES ('$position', '$userEditable', '$positionEditable', '$menuEditable', '$cuisineEditable', '$orderSubmitable', '$orderChangeable');";
			$result=mysql_query($sql);
			header("location:editPositions.php");
		} else {
			header("location:addPosition.php?positionExist");
		}
	}
?>

<html>
	<head>
		<title>Position Edit</title>
    	<style type="text/css"></style>
    	<script type="text/javascript" src="../sources/js/util-functions.js"></script>
        <script type="text/javascript" src="../sources/js/clear-default-text.js"></script>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center"><table width="1024px">
					<tr align="center"><td>Position Permission</td></tr>
					<tr><td>
						<table border="1" width="1024px">
							<tr align="center"><td>position</td><td>userEditable</td><td>positionEditable</td><td>menuEditable</td><td>cuisineEditable</td><td>orderSubmitable</td><td>orderChangeable</td><td></td></tr>
							<form name="permission" action="addPosition.php?add" method="post">
							<tr align="center">
								<td><input type="text" name="position" value="position" class="cleardefault"></td>
								<td><input type="radio" name="userEditable" value="Y">YES&nbsp;<input type="radio" name="userEditable" value="N" checked>NO</td>
								<td><input type="radio" name="positionEditable" value="Y">YES&nbsp;<input type="radio" name="positionEditable" value="N" checked>NO</td>
								<td><input type="radio" name="menuEditable" value="Y">YES&nbsp;<input type="radio" name="menuEditable" value="N" checked>NO</td>
								<td><input type="radio" name="cuisineEditable" value="Y">YES&nbsp;<input type="radio" name="cuisineEditable" value="N" checked>NO</td>
								<td><input type="radio" name="orderSubmitable" value="Y">YES&nbsp;<input type="radio" name="orderSubmitable" value="N" checked>NO</td>
								<td><input type="radio" name="orderChangeable" value="Y">YES&nbsp;<input type="radio" name="orderChangeable" value="N" checked>NO</td>
								<td><input type="submit" name="Submit" value="Add"></td>
							</tr>
							</form>
						</table>
					</td></tr>
					<tr align="center"><td><?php 
						if (isset($_GET['positionExist'])) {
							echo "<span style=\"color:red; text-align:center;\">error: position existed</span>";
						} else {
							echo "<br>";
						}
					?></td></tr>
					<tr align="center"><td><button onclick="location.href='editPositions.php'">Go Back</button></td></tr>
				</table></td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>