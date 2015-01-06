<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['positionEditable'] == "N") {
        if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			header("location:login.php?CN");
		} else {
        	header("location:login.php?EN");
    	}
    }

    if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
		$title="职位权限";
		$tableTitle=array("职位名称(EN)","职位名称(CN)","编辑用户权限","编辑职位权限", "编辑菜单权限", "编辑菜肴配方权限", "提交订单权限", "更改订单权限");
		$buttonTile=array("修改","删除","添加","返回","取消");
		$premissionChoices=array("有","无");
	} else {
    	$title="Position Permission";
    	$tableTitle=array("POSITION(EN)", "POSITION(CN)", "userEditable","positionEditable", "menuEditable", "cuisineEditable", "orderSubmitable", "orderChangeable");
    	$buttonTile=array("Edit","Delete","ADD","GO BACK","Cancel");
    	$premissionChoices=array("YES","NO");
	}

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="userDB";

	$conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['position'])) {
		$position=$_GET['position'];
		if (isset($_GET['delete'])) {
			$sqlDelete="DELETE FROM positionPermission WHERE position_inEnglish='$position'";
			$resultDelete=mysql_query($sqlDelete);
			header("location:editPositions.php");
		} else {
			if ($position!=$_POST['position_inEnglish']) {
				$positionUpdate_inEnglish=$_POST['position_inEnglish'];
				$positionUpdate_inChinese=$_POST['position_inChinese'];
				$sql="SELECT * FROM positionPermission WHERE position_inEnglish='$positionUpdate_inEnglish' OR position_inChinese='$positionUpdate_inChinese'";
				$result=mysql_query($sql);
				$count=mysql_num_rows($result);
				if ($count==0) {
					$userEditableUpdate=$_POST['userEditable'];
					$positionEditableUpdate=$_POST['positionEditable'];
					$menuEditableUpdate=$_POST['menuEditable'];
					$cuisineEditableUpdate=$_POST['cuisineEditable'];
					$orderSubmitableUpdate=$_POST['orderSubmitable'];
					$orderChangeableUpdate=$_POST['orderChangeable'];
					$sqlUpdate="UPDATE positionPermission SET position_inEnglish='$positionUpdate_inEnglish', position_inChinese='$positionUpdate_inChinese', userEditable='$userEditableUpdate', positionEditable='$positionEditableUpdate', menuEditable='$menuEditableUpdate', cuisineEditable='$cuisineEditableUpdate', orderSubmitable='$orderSubmitableUpdate', orderChangeable='$orderChangeableUpdate' WHERE position_inEnglish='$position'";
					$resultUpdate=mysql_query($sqlUpdate);
					header("location:editPositions.php");
				} else {
					header("location:editPositions.php?positionExist");
				}
			} else {
				$userEditableUpdate=$_POST['userEditable'];
				$positionEditableUpdate=$_POST['positionEditable'];
				$menuEditableUpdate=$_POST['menuEditable'];
				$cuisineEditableUpdate=$_POST['cuisineEditable'];
				$orderSubmitableUpdate=$_POST['orderSubmitable'];
				$orderChangeableUpdate=$_POST['orderChangeable'];
				$sqlUpdate="UPDATE positionPermission SET userEditable='$userEditableUpdate', positionEditable='$positionEditableUpdate', menuEditable='$menuEditableUpdate', cuisineEditable='$cuisineEditableUpdate', orderSubmitable='$orderSubmitableUpdate', orderChangeable='$orderChangeableUpdate' WHERE position_inEnglish='$position'";
				$resultUpdate=mysql_query($sqlUpdate);
				header("location:editPositions.php");
			}
		}
	}

	if (isset($_GET['add'])) {
		$position_inEnglish=$_POST['position_inEnglish'];
		$sql="SELECT * FROM positionPermission WHERE position_inEnglish='$position_inEnglish'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		if ($count==0) {
			$position_inChinese=$_POST['position_inChinese'];
			$userEditable=$_POST['userEditable'];
			$positionEditable=$_POST['positionEditable'];
			$menuEditable=$_POST['menuEditable'];
			$cuisineEditable=$_POST['cuisineEditable'];
			$orderSubmitable=$_POST['orderSubmitable'];
			$orderChangeable=$_POST['orderChangeable'];
			$sql="INSERT INTO positionPermission VALUES ('$position_inEnglish', '$position_inChinese', '$userEditable', '$positionEditable', '$menuEditable', '$cuisineEditable', '$orderSubmitable', '$orderChangeable')";
			$result=mysql_query($sql);
			header("location:editPositions.php");
		} else {
			header("location:editPositions.php?addPosition&positionExist");
		}
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title><?php echo $title; ?></title>
    	<style type="text/css"></style>
    	<script type="text/javascript" src="../sources/js/util-functions.js"></script>
        <script type="text/javascript" src="../sources/js/clear-default-text.js"></script>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center"><table width="1024px">
					<tr align="center"><td><?php echo $title; ?></td></tr>
					<tr><td><table border="1" width="1024px"><?php
						echo "<tr align=\"center\"><td>". $tableTitle[0] ."</td><td>". $tableTitle[1] ."</td><td>". $tableTitle[2] ."</td><td>". $tableTitle[3] ."</td><td>". $tableTitle[4] ."</td><td>". $tableTitle[5] ."</td><td>". $tableTitle[6] ."</td><td>". $tableTitle[7] ."</td><td></td><td></td></tr>";
						$sql="SELECT * FROM positionPermission ORDER BY position_inEnglish ASC";
						$result=mysql_query($sql);
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							echo "<form name=\"permission_". $row['position_inEnglish'] ."\" action=\"editPositions.php?position=". $row['position_inEnglish'] ."\" method=\"post\"><tr align=\"center\"><td><input type=\"text\" name=\"position_inEnglish\" value=\"". $row['position_inEnglish'] ."\" class=\"cleardefault\"></td><td><input type=\"text\" name=\"position_inChinese\" value=\"". $row['position_inChinese'] ."\" class=\"cleardefault\"></td><td><input type=\"radio\" name=\"userEditable\" value=\"Y\"";
							if ($row['userEditable']=="Y") {
							 	echo "checked";
							} 
							echo ">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"userEditable\" value=\"N\"";
							if ($row['userEditable']=="N") {
								echo "checked";
							}
							echo ">".$premissionChoices[1]."</td><td><input type=\"radio\" name=\"positionEditable\" value=\"Y\"";
							if ($row['positionEditable']=="Y") {
							 	echo "checked";
							} 
							echo ">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"positionEditable\" value=\"N\"";
							if ($row['positionEditable']=="N") {
								echo "checked";
							}
							echo ">".$premissionChoices[1]."</td><td><input type=\"radio\" name=\"menuEditable\" value=\"Y\"";
							if ($row['menuEditable']=="Y") {
							 	echo "checked";
							} 
							echo ">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"menuEditable\" value=\"N\"";
							if ($row['menuEditable']=="N") {
								echo "checked";
							}
							echo ">".$premissionChoices[1]."</td><td><input type=\"radio\" name=\"cuisineEditable\" value=\"Y\"";
							if ($row['cuisineEditable']=="Y") {
							 	echo "checked";
							} 
							echo ">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"cuisineEditable\" value=\"N\"";
							if ($row['cuisineEditable']=="N") {
								echo "checked";
							}
							echo ">".$premissionChoices[1]."</td><td><input type=\"radio\" name=\"orderSubmitable\" value=\"Y\"";
							if ($row['orderSubmitable']=="Y") {
							 	echo "checked";
							} 
							echo ">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"orderSubmitable\" value=\"N\"";
							if ($row['orderSubmitable']=="N") {
								echo "checked";
							}
							echo ">".$premissionChoices[1]."</td><td><input type=\"radio\" name=\"orderChangeable\" value=\"Y\"";
							if ($row['orderChangeable']=="Y") {
							 	echo "checked";
							} 
							echo ">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"orderChangeable\" value=\"N\"";
							if ($row['orderChangeable']=="N") {
								echo "checked";
							}
							echo ">".$premissionChoices[1]."</td>";

							if (!isset($_GET['addPosition'])) {
								echo "<td><input type=\"submit\" name=\"Submit\" value=\"". $buttonTile[0] ."\"></td><td><input type=\"button\" onclick=\"location.href='editPositions.php?position=". $row['position_inEnglish'] ."&delete'\" value=\"". $buttonTile[1] ."\"></td>";
							} else {
								echo "<td></td><td></td>";
							}
							echo "</tr></form>";
						}

						if (isset($_GET['addPosition'])) {
							echo "<form name=\"permission\" action=\"editPositions.php?add\" method=\"post\">
							<tr align=\"center\">
								<td><input type=\"text\" name=\"position_inEnglish\"></td>
								<td><input type=\"text\" name=\"position_inChinese\"></td>
								<td><input type=\"radio\" name=\"userEditable\" value=\"Y\">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"userEditable\" value=\"N\" checked>".$premissionChoices[1]."</td>
								<td><input type=\"radio\" name=\"positionEditable\" value=\"Y\">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"positionEditable\" value=\"N\" checked>".$premissionChoices[1]."</td>
								<td><input type=\"radio\" name=\"menuEditable\" value=\"Y\">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"menuEditable\" value=\"N\" checked>".$premissionChoices[1]."</td>
								<td><input type=\"radio\" name=\"cuisineEditable\" value=\"Y\">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"cuisineEditable\" value=\"N\" checked>".$premissionChoices[1]."</td>
								<td><input type=\"radio\" name=\"orderSubmitable\" value=\"Y\">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"orderSubmitable\" value=\"N\" checked>".$premissionChoices[1]."</td>
								<td><input type=\"radio\" name=\"orderChangeable\" value=\"Y\">".$premissionChoices[0]."&nbsp;<input type=\"radio\" name=\"orderChangeable\" value=\"N\" checked>".$premissionChoices[1]."</td>
								<td><input type=\"submit\" name=\"Submit\" value=\"".$buttonTile[2]."\"></td><td><input type=\"button\" onclick=\"location.href='editPositions.php'\" value=\"". $buttonTile[4] ."\">
							</tr>
							</form>";
						}
					?></table></td></tr>
					<tr align="center"><td><?php 
						if (isset($_GET['positionExist'])) {
							echo "<span style=\"color:red; text-align:center;\">error: position existed</span>";
						} else {
							echo "<br>";
						}
					?></td></tr>
					<tr><td align="center"><table width="1024px">
						<tr align="center"><td><?php if(!isset($_GET['addPosition'])) echo "<button onclick=\"location.href='editPositions.php?addPosition'\">".$buttonTile[2]."</button>"; ?></td><td><button onclick="location.href='login_success.php'"><?php echo $buttonTile[3]; ?></button></td></tr>
					</table></td></tr>
				</table></td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>