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
		$title="用户信息";
		$tableTitle=array("用户名","姓","名", "昵称", "生日", "身份证号码", "职位");
		$buttonTile=array("修改","删除","添加用户","返回");
	} else {
    	$title="User Information";
    	$tableTitle=array("USERNAME","LAST NAME","FIRST NAME", "NICK NAME", "BIRTHDAY", "ID NUMBER", "POSITION");
    	$buttonTile=array("Edit","Delete","ADD USER","GO BACK");
	}
    
    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="userDB";

	$conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	mysql_select_db("$db_name")or die("cannot select DB");
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Users Edit</title>
    	<style type="text/css"></style>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center"><table width="1024px">
					<tr align="center"><td><?php echo $title; ?></td></tr>
					<tr><td><table border="1" width="1024px"><?php
						echo "<tr align=\"center\"><td>".$tableTitle[0]."</td><td>".$tableTitle[1]."</td><td>".$tableTitle[2]."</td><td>".$tableTitle[3]."</td><td>".$tableTitle[4]."</td><td>".$tableTitle[5]."</td><td>".$tableTitle[6]."</td><td></td><td></td></tr>";
						$sql="SELECT * FROM userInfo ORDER BY position ASC, lname ASC, fname ASC";
						$result=mysql_query($sql);
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							echo "<tr align=\"center\"><td>". $row['username'] ."</td><td>". $row['lname'] ."</td><td>". $row['fname'] ."</td><td>". $row['nickname'] ."</td><td>". $row['DOB'] ."</td><td>". $row['IDnumber'] ."</td><td>";
							if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
								$position=$row['position'];
								$tmpsql="SELECT * FROM positionPermission WHERE position_inEnglish='$position'";
								$tmpresult=mysql_query($tmpsql);
								$tmprow=mysql_fetch_array($tmpresult,MYSQL_ASSOC);
							 	echo $tmprow['position_inChinese']; 
							} else {
								echo $row['position']; 
							} 
							echo "</td><td><button onclick=\"location.href='editUserInfo.php?username=". $row['username'] ."'\">".$buttonTile[0]."</button></td><td><button onclick=\"location.href='deleteUser.php?username=". $row['username'] ."'\">".$buttonTile[1]."</button></td></tr>";
						}
					?></table></td></tr>
					<tr><td><br></td></tr>
					<tr><td align="center"><table width="1024px">
						<tr align="center"><td><button onclick="location.href='addUser.php'"><?php echo $buttonTile[2]; ?></button></td><td><button onclick="location.href='login_success.php'"><?php echo $buttonTile[3]; ?></button></td></tr>
					</table></td></tr>
				</table></td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>