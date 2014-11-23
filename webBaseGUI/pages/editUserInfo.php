<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['userEditable'] == "N" || !isset($_GET['username'])) {
        header("location:login.php");
    }

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="userDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	$username=$_GET['username'];
	$username=stripslashes($username);
	$username=mysql_real_escape_string($username);

	$sql="SELECT * FROM userInfo WHERE username='$username'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result,MYSQL_ASSOC);

	if (isset($_GET['edited'])) {
		if ($row['username']!=$_POST['username']) {
			$usernameUpdate=$_POST['username'];
			$sqlCheck="SELECT * FROM userInfo WHERE username='$usernameUpdate'";
			$resultCheck=mysql_query($sqlCheck);
			$countUsernames=mysql_num_rows($resultCheck);
			if ($countUsernames==0) {
				$sqlUpdate="UPDATE userInfo SET username='$usernameUpdate' WHERE username='$username'";
				$resultUpdate=mysql_query($sqlUpdate);
				if ($username==$_SESSION['username']) {
					$_SESSION['username']=$username;
				}
				$Error="NULL";
			} else {
				$Error="usernameExist";
			}	
		}
		if ($row['password']!=$_POST['password']) {
			$password=$_POST['password'];
			$sqlUpdate="UPDATE userInfo SET password='$password' WHERE username='$username'";
			$resultUpdate=mysql_query($sqlUpdate);
			if ($username==$_SESSION['username']) {
				$_SESSION['password']=$password;
			}
			$Error="NULL";
		}
		if ($row['lname']!=$_POST['lname']) {
			$lname=$_POST['lname'];
			$sqlUpdate="UPDATE userInfo SET lname='$lname' WHERE username='$username'";
			$resultUpdate=mysql_query($sqlUpdate);
			$Error="NULL";
		}
		if ($row['fname']!=$_POST['fname']) {
			$fname=$_POST['fname'];
			$sqlUpdate="UPDATE userInfo SET fname='$fname' WHERE username='$username'";
			$resultUpdate=mysql_query($sqlUpdate);
			$Error="NULL";
		}
		if ($row['DOB']!=$_POST['birthday']) {
			$birthday=$_POST['birthday'];
			$sqlUpdate="UPDATE userInfo SET DOB='$birthday' WHERE username='$username'";
			$resultUpdate=mysql_query($sqlUpdate);
			$Error="NULL";
		}
		if ($row['IDnumber']!=$_POST['IDnumber']) {
			$IDnumber=$_POST['IDnumber'];
			$sqlCheck="SELECT * FROM userInfo WHERE IDnumber='$IDnumber'";
			$resultCheck=mysql_query($sqlCheck);
			$countUsers=mysql_num_rows($resultCheck);
			if ($countUsers==0) {
				$sqlUpdate="UPDATE userInfo SET IDnumber='$IDnumber' WHERE username='$username'";
				$resultUpdate=mysql_query($sqlUpdate);
				$Error="NULL";
			} else {
				$Error="userExist";
			}
		}
		if ($row['position']!=$_POST['position']) {
			$position=$_POST['position'];
			$sqlUpdate="UPDATE userInfo SET position='$position' WHERE username='$username'";
			$resultUpdate=mysql_query($sqlUpdate);
			if ($username==$_SESSION['username']) {
				$sqlPosition="SELECT * FROM positionPermission WHERE position='$position'";
				$resultPosition=mysql_query($sqlPosition);
				$rowPosition=mysql_fetch_array($resultPosition,MYSQL_ASSOC);
				$_SESSION['userEditable']=$rowPosition['userEditable'];
				$_SESSION['positionEditable']=$rowPosition['positionEditable'];
				$_SESSION['menuEditable']=$rowPosition['menuEditable'];
				$_SESSION['cuisineEditable']=$rowPosition['cuisineEditable'];
				$_SESSION['orderSubmitable']=$rowPosition['orderSubmitable'];
				$_SESSION['orderChangeable']=$rowPosition['orderChangeable'];
			}
			$Error="NULL";
		}

		if ($Error=="NULL") {
			header("location:editUsers.php");
		} else {
			header("location:editUserInfo.php?username=". $username ."&". $Error);
		}
	}
?>

<html>
	<head>
		<title>User Information Edit</title>
    	<style type="text/css"></style>
        <script type="text/javascript" src="../sources/js/util-functions.js"></script>
        <script type="text/javascript" src="../sources/js/clear-default-text.js"></script>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center"><form name="userInfoEdit" action="editUserInfo.php?username=<?php echo "$username";?>&edited" method="post"><table width="400px">
					<tr><td align="center">Edit User Information: <hr /></td><td></td></tr>
					<tr><td align="center">username</td><td><?php echo "<input type=\"text\" name=\"username\" id=\"username\" value=\"". $row['username'] ."\" class=\"cleardefault\">";?></td></tr>
					<tr><td align="center">password</td><td><?php echo "<input type=\"password\" name=\"password\" id=\"password\" value=\"". $row['password'] ."\" class=\"cleardefault\">";?></td></tr>
					<tr><td align="center">Last Name</td><td><?php echo "<input type=\"text\" name=\"lname\" id=\"lname\" value=\"". $row['lname'] ."\" class=\"cleardefault\">";?></td></tr>
					<tr><td align="center">First Name</td><td><?php echo "<input type=\"text\" name=\"fname\" id=\"fname\" value=\"". $row['fname'] ."\" class=\"cleardefault\">";?></td></tr>
					<tr><td align="center">Date of Birth</td><td><?php
						echo "<input type=\"date\" name=\"birthday\" value=\"". $row['DOB'] ."\">";
					?></td></tr>
					<tr><td align="center">ID Number</td><td><?php echo "<input type=\"text\" name=\"IDnumber\" id=\"IDnumber\" value=\"". $row['IDnumber'] ."\" class=\"cleardefault\">";?></td></tr>
					<tr><td align="center">Position</td><td><?php
						echo "<select name=\"position\">";
						$sqlPosition="SELECT * FROM positionPermission";
						$resultPosition=mysql_query($sqlPosition);
						while($rowPosition=mysql_fetch_array($resultPosition,MYSQL_ASSOC)){
							echo "<option value=\"". $rowPosition['position'] ."\" ";
							if ($row['position']==$rowPosition['position']) {
								echo "selected";
							}
							echo ">". $rowPosition['position'] ."</option>";
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
					<tr><td align="center"><input type="submit" name="Submit" value="Submit"></td><td><input type="button" onclick="location.href='editUsers.php'" value="Go Back"></td></tr>
				</table></form></td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>