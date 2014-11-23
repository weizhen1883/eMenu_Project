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
?>

<html>
	<head>
		<title>Users Edit</title>
    	<style type="text/css"></style>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center"><table width="1024px">
					<tr align="center"><td>User Information</td></tr>
					<tr><td><table border="1" width="1024px"><?php
						echo "<tr align=\"center\"><td>username</td><td>last name</td><td>first name</td><td>birthday</td><td>ID number</td><td>position</td><td></td><td></td></tr>";
						$sql="SELECT * FROM userInfo ORDER BY position ASC, lname ASC, fname ASC";
						$result=mysql_query($sql);
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							echo "<tr align=\"center\"><td>". $row['username'] ."</td><td>". $row['lname'] ."</td><td>". $row['fname'] ."</td><td>". $row['DOB'] ."</td><td>". $row['IDnumber'] ."</td><td>". $row['position'] ."</td><td><button onclick=\"location.href='editUserInfo.php?username=". $row['username'] ."'\">Edit</button></td><td><button onclick=\"location.href='deleteUser.php?username=". $row['username'] ."'\">Delete</button></td></tr>";
						}
					?></table></td></tr>
					<tr><td><br></td></tr>
					<tr><td align="center"><table width="1024px">
						<tr align="center"><td><button onclick="location.href='addUser.php'">ADD USER</button></td><td><button onclick="location.href='login_success.php'">GO BACK</button></td></tr>
					</table></td></tr>
				</table></td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>