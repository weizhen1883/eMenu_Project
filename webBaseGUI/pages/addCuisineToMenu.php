<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['menuEditable'] == "N" || !isset($_GET['cuisineType'])) {
        header("location:login.php");
    }
    header('Content-Type: text/html; charset=utf-8');

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['Done'])&&!empty($_POST['cuisines'])) {
		$cuisineType=$_GET['cuisineType'];
		$sql="SELECT * FROM cuisineType WHERE typeName='$cuisineType'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$menuTable=$row['tableName'];
		foreach($_POST['cuisines'] as $cuisine){
			$cuisinePrice=floatval($_POST['cuisinePrice'][$cuisine]);
			$sql="INSERT INTO $menuTable (cuisineName, cuisinePrice) VALUES ('$cuisine', $cuisinePrice)";
			$result=mysql_query($sql);
		}
		header("location:editMenu.php?cuisineType=".$cuisineType);
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Add Cuisine To Menu</title>
    	<style type="text/css"></style>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="10%"></td>
				<td width="80%" align="center">
					<table width="800px">
						<tr><td align="center"><?php echo $_GET['cuisineType']; ?></td></tr>
						<tr><td align="center"><form method="post" action="addCuisineToMenu.php?cuisineType=<?php echo $_GET['cuisineType']; ?>&Done"><table border="1" width="100%">
						<?php
							$cuisineType=$_GET['cuisineType'];
							$sql="SELECT * FROM cuisineType WHERE typeName='$cuisineType'";
							$result=mysql_query($sql);
							$row=mysql_fetch_array($result,MYSQL_ASSOC);
							$menuTable=$row['tableName'];
							$sql="SELECT * FROM $menuTable";
							$result=mysql_query($sql);
							while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
								$menuList[]=$row['cuisineName'];	
							}
							$sql="SELECT * FROM cuisinelist";
							$result=mysql_query($sql);
							while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
								if (!in_array($row['cuisineName'], $menuList)) {
									$priceName=$row['cuisineName']."Price";
									echo "<tr><td width=\"50px\" align=\"center\"><input type=\"checkbox\" name=\"cuisines[]\" value=\"". $row['cuisineName'] ."\"></td><td width=\"650px\" align=\"center\">". $row['cuisineName'] ."</td><td width=\"100px\" align=\"center\"><input type=\"text\" name=\"cuisinePrice[". $row['cuisineName'] ."]\" align=\"right\" style=\"width: 50px; text-align: right;\"></td></tr>";
								}
							}
							echo "<tr><td><br></td><td><br></td><td><br></td></tr>";
							echo "<tr><td></td><td align=\"center\"><input type=\"submit\" value=\"Add\"></td><td></td></tr>";
						?>
						</table></form></td></tr>
						<tr><td align="center"><button onclick="location.href='editMenu.php?cuisineType=<?php echo $_GET['cuisineType']; ?>'">Go Back</button></td></tr>
					</table>
				</td>
				<td width="10%"></td>
			</tr>
		</table>
	</body>
</html>