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

	if (isset($_GET['position'])) {
		$position=$_GET['position'];
		if (isset($_GET['delete'])) {
			$sqlDelete="DELETE FROM positionPermission WHERE position='$position'";
			$resultDelete=mysql_query($sqlDelete);
		} else {
			$positionUpdate=$_POST['position'];
			$userEditableUpdate=$_POST['userEditable'];
			$positionEditableUpdate=$_POST['positionEditable'];
			$menuEditableUpdate=$_POST['menuEditable'];
			$cuisineEditableUpdate=$_POST['cuisineEditable'];
			$orderSubmitableUpdate=$_POST['orderSubmitable'];
			$orderChangeableUpdate=$_POST['orderChangeable'];
			$sqlUpdate="UPDATE positionPermission SET position='$positionUpdate', userEditable='$userEditableUpdate', positionEditable='$positionEditableUpdate', menuEditable='$menuEditableUpdate', cuisineEditable='$cuisineEditableUpdate', orderSubmitable='$orderSubmitableUpdate', orderChangeable='$orderChangeableUpdate' WHERE position='$position'";
			$resultUpdate=mysql_query($sqlUpdate);
		}
		header("location:editPositions.php");
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
					<tr><td><table border="1" width="1024px"><?php
						echo "<tr align=\"center\"><td>position</td><td>userEditable</td><td>positionEditable</td><td>menuEditable</td><td>cuisineEditable</td><td>orderSubmitable</td><td>orderChangeable</td><td></td><td></td></tr>";
						$sql="SELECT * FROM positionPermission ORDER BY position ASC";
						$result=mysql_query($sql);
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							echo "<form name=\"permission_". $row['position'] ."\" action=\"editPositions.php?position=". $row['position'] ."\" method=\"post\"><tr align=\"center\"><td><input type=\"text\" name=\"position\" value=\"". $row['position'] ."\" class=\"cleardefault\"></td><td><input type=\"radio\" name=\"userEditable\" value=\"Y\"";
							if ($row['userEditable']=="Y") {
							 	echo "checked";
							} 
							echo ">YES&nbsp;<input type=\"radio\" name=\"userEditable\" value=\"N\"";
							if ($row['userEditable']=="N") {
								echo "checked";
							}
							echo ">NO</td><td><input type=\"radio\" name=\"positionEditable\" value=\"Y\"";
							if ($row['positionEditable']=="Y") {
							 	echo "checked";
							} 
							echo ">YES&nbsp;<input type=\"radio\" name=\"positionEditable\" value=\"N\"";
							if ($row['positionEditable']=="N") {
								echo "checked";
							}
							echo ">NO</td><td><input type=\"radio\" name=\"menuEditable\" value=\"Y\"";
							if ($row['menuEditable']=="Y") {
							 	echo "checked";
							} 
							echo ">YES&nbsp;<input type=\"radio\" name=\"menuEditable\" value=\"N\"";
							if ($row['menuEditable']=="N") {
								echo "checked";
							}
							echo ">NO</td><td><input type=\"radio\" name=\"cuisineEditable\" value=\"Y\"";
							if ($row['cuisineEditable']=="Y") {
							 	echo "checked";
							} 
							echo ">YES&nbsp;<input type=\"radio\" name=\"cuisineEditable\" value=\"N\"";
							if ($row['cuisineEditable']=="N") {
								echo "checked";
							}
							echo ">NO</td><td><input type=\"radio\" name=\"orderSubmitable\" value=\"Y\"";
							if ($row['orderSubmitable']=="Y") {
							 	echo "checked";
							} 
							echo ">YES&nbsp;<input type=\"radio\" name=\"orderSubmitable\" value=\"N\"";
							if ($row['orderSubmitable']=="N") {
								echo "checked";
							}
							echo ">NO</td><td><input type=\"radio\" name=\"orderChangeable\" value=\"Y\"";
							if ($row['orderChangeable']=="Y") {
							 	echo "checked";
							} 
							echo ">YES&nbsp;<input type=\"radio\" name=\"orderChangeable\" value=\"N\"";
							if ($row['orderChangeable']=="N") {
								echo "checked";
							}
							echo ">NO</td><td><input type=\"submit\" name=\"Submit\" value=\"Edit\"></td><td><input type=\"button\" onclick=\"location.href='editPositions.php?position=". $row['position'] ."&delete'\" value=\"Delete\"></td></tr></form>";
						}
					?></table></td></tr>
					<tr><td><br></td></tr>
					<tr><td align="center"><table width="1024px">
						<tr align="center"><td><button onclick="location.href='addPosition.php'">Add Position</button></td><td><button onclick="location.href='login_success.php'">GO BACK</button></td></tr>
					</table></td></tr>
				</table></td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>