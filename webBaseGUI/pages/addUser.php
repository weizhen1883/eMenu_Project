<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['userEditable'] == "N") {
        header("location:login.php");
    }

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="userDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['add'])) {
		$username=$_POST['username'];
		$password=$_POST['password'];
		$lname=$_POST['lname'];
		$fname=$_POST['fname'];
		$DOB=$_POST['birthday'];
		$IDnumber=$_POST['IDnumber'];
		$position=$_POST['position'];

		$sql="SELECT * FROM userInfo WHERE username='$username'";
		$result=mysql_query($sql);
		$countUsernames=mysql_num_rows($result);
		$sql="SELECT * FROM userInfo WHERE IDnumber='$IDnumber'";
		$result=mysql_query($sql);
		$countUsers=mysql_num_rows($result);

		if ($countUsers!=0) {
			header("location:addUser.php?userExist");
		} elseif ($countUsernames!=0) {
			header("location:addUser.php?usernameExist");
		} else {
			$sql="INSERT INTO userInfo VALUES ('$username', '$password', '$lname', '$fname', '$DOB', '$IDnumber', '$position')";
			$result=mysql_query($sql);

			header("location:editUsers.php");
		}
	}

?>

<html>
	<head>
		<title>Add User</title>
    	<style type="text/css"></style>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center"><form name="userInfoEdit" action="addUser.php?add" method="post"><table width="400px">
					<tr><td align="center">Add User: <hr /></td><td></td></tr>
					<tr><td align="center">username</td><td><?php echo "<input type=\"text\" name=\"username\" id=\"username\">";?></td></tr>
					<tr><td align="center">password</td><td><?php echo "<input type=\"password\" name=\"password\" id=\"password\">";?></td></tr>
					<tr><td align="center">Last Name</td><td><?php echo "<input type=\"text\" name=\"lname\" id=\"lname\">";?></td></tr>
					<tr><td align="center">First Name</td><td><?php echo "<input type=\"text\" name=\"fname\" id=\"fname\">";?></td></tr>
					<tr><td align="center">Date of Birth</td><td><?php
						echo "<input type=\"date\" name=\"birthday\">";
					?></td></tr>
					<tr><td align="center">ID Number</td><td><?php echo "<input type=\"text\" name=\"IDnumber\" id=\"IDnumber\">";?></td></tr>
					<tr><td align="center">Position</td><td><?php
						echo "<select name=\"position\">";
						$sqlPosition="SELECT * FROM positionPermission";
						$resultPosition=mysql_query($sqlPosition);
						while($rowPosition=mysql_fetch_array($resultPosition,MYSQL_ASSOC)){
							echo "<option value=\"". $rowPosition['position'] ."\">". $rowPosition['position'] ."</option>";
						}
					?></td></tr>
					<tr><td align="center"><?php
						if (isset($_GET['userExist'])) {
							echo "<span style=\"color:red; text-align:center;\">error: user existed</span>";
						} elseif (isset($_GET['usernameExist'])) {
							echo "<span style=\"color:red; text-align:center;\">error: username existed</span>";
						} else {
							echo "<br>";
						}
					?></td><td><br></td></tr>
					<tr><td align="center"><input type="submit" name="Add" value="Add"></td><td><input type="button" onclick="location.href='editUsers.php'" value="Go Back"></td></tr>
				</table></form></td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>