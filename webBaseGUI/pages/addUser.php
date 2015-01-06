<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['userEditable'] == "N") {
        if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			header("location:login.php?CN");
		} else {
        	header("location:login.php?EN");
    	}
    }

    if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
		$title="添加用户: ";
		$tableTitle=array("用户名","密码","姓","名", "昵称", "出生日期", "身份证号码", "职位");
		$buttonTile=array("添加","返回");
	} else {
    	$title="Add User:";
    	$tableTitle=array("USERNAME","PASSWORD","LAST NAME","FIRST NAME", "NICK NAME", "DATE OF BIRTH", "ID NUMBER", "POSITION");
    	$buttonTile=array("ADD","GO BACK");
	}

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="userDB";

	$conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['add'])) {
		$username=$_POST['username'];
		$password=$_POST['password'];
		$lname=$_POST['lname'];
		$fname=$_POST['fname'];
		$nickname=$_POST['nickname'];
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
			$sql="INSERT INTO userInfo VALUES ('$username', '$password', '$lname', '$fname', '$nickname', '$DOB', '$IDnumber', '$position')";
			$result=mysql_query($sql);

			header("location:editUsers.php");
		}
	}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Add User</title>
    	<style type="text/css"></style>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center"><form name="userInfoEdit" action="addUser.php?add" method="post"><table width="400px">
					<tr><td align="center"><?php echo $title; ?><hr /></td><td></td></tr>
					<tr><td align="center"><?php echo $tableTitle[0]; ?></td><td><?php echo "<input type=\"text\" name=\"username\" id=\"username\">";?></td></tr>
					<tr><td align="center"><?php echo $tableTitle[1]; ?></td><td><?php echo "<input type=\"password\" name=\"password\" id=\"password\">";?></td></tr>
					<tr><td align="center"><?php echo $tableTitle[2]; ?></td><td><?php echo "<input type=\"text\" name=\"lname\" id=\"lname\">";?></td></tr>
					<tr><td align="center"><?php echo $tableTitle[3]; ?></td><td><?php echo "<input type=\"text\" name=\"fname\" id=\"fname\">";?></td></tr>
					<tr><td align="center"><?php echo $tableTitle[4]; ?></td><td><?php echo "<input type=\"text\" name=\"nickname\" id=\"nickname\">";?></td></tr>
					<tr><td align="center"><?php echo $tableTitle[5]; ?></td><td><?php
						echo "<input type=\"date\" name=\"birthday\">";
					?></td></tr>
					<tr><td align="center"><?php echo $tableTitle[6]; ?></td><td><?php echo "<input type=\"text\" name=\"IDnumber\" id=\"IDnumber\">";?></td></tr>
					<tr><td align="center"><?php echo $tableTitle[7]; ?></td><td><?php
						echo "<select name=\"position\">";
						$sqlPosition="SELECT * FROM positionPermission";
						$resultPosition=mysql_query($sqlPosition);
						while($rowPosition=mysql_fetch_array($resultPosition,MYSQL_ASSOC)){
							if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
								echo "<option value=\"". $rowPosition['position_inEnglish'] ."\">". $rowPosition['position_inChinese'] ."</option>";
							} else {
								echo "<option value=\"". $rowPosition['position_inEnglish'] ."\">". $rowPosition['position_inEnglish'] ."</option>";
							}
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
					<tr><td align="center"><input type="submit" name="Add" value="<?php echo $buttonTile[0]; ?>"></td><td><input type="button" onclick="location.href='editUsers.php'" value="<?php echo $buttonTile[1]; ?>"></td></tr>
				</table></form></td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>