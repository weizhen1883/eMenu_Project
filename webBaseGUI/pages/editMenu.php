<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['menuEditable'] == "N") {
        header("location:login.php");
    }

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['DoneAddCuisineType'])) {
		$addTypeID=$_POST['addTypeID'];
		$addTypeName=$_POST['addTypeName'];
		if ($addTypeID!=NULL&&$addTypeName!=NULL) {
			$addTableName=$addTypeName."TB";
			$sql="INSERT INTO cuisineType VALUES ($addTypeID, '$addTypeName', '$addTableName')";
			$result=mysql_query($sql);
			$sql="CREATE TABLE IF NOT EXISTS $addTableName LIKE cuisineTypeSampleTB";
			$result=mysql_query($sql);
		}
	
		header("location:editMenu.php?cuisineType=".$_GET['cuisineType']);
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
			<tr><td width="5%"></td><td width="90%" align="center">Menu<br><hr /></td><td width="5%"></td></tr>
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center">
					<table width="1000px">
						<tr align="center"><td width="250px">Cuisine Types</td><td width="10px"></td><td width="740px">Cuisines</td></tr>
						<tr align="left" valign="top">
							<td width="250px"><form name="cuisineType" action="editMenu.php?cuisineType=<?php echo $_GET['cuisineType']."&"; if(isset($_GET['addCuisineType'])){echo "DoneAddCuisineType";}?>" method="post">
								<table width="100%">
									<tr><td><table border="1" width="100%"><?php
										$sql="SELECT * FROM cuisineType ORDER BY typeID ASC";
										$result=mysql_query($sql);
										while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
											if (isset($_GET['addCuisineType'])) {
												echo "<tr><td width=\"35px\">". $row['typeID'] ."</td><td width=\"115px\">". $row['typeName'] ."</td><td width=\"100px\" align=\"center\"></td></tr>";
											} else if (isset($_GET['cuisineTypeEdit'])&&$_GET['cuisineTypeID']==$row['typeID']) {
												echo "<tr><td width=\"35px\"><input type=\"number\" name=\"typeID\" value=\"". $row['typeID'] ."\" min=\"1\" style=\"width: 35px;\" class=\"cleardefault\"></td><td width=\"115px\"><input type=\"text\" name=\"typeName\" value=\"". $row['typeName'] ."\" style=\"width: 100px;\" class=\"cleardefault\"></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='changeCuisineType.php?cuisineTypeID=". $row['typeID'] ."'\" value=\"Change\"></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='deleteCuisineType.php?cuisineType=". $row['typeName'] ."'\" value=\"Delete\"></td></tr>";
											} else {
												echo "<tr><td width=\"35px\">". $row['typeID'] ."</td><td width=\"115px\"><a href=\"editMenu.php?cuisineType=". $row['typeName'] ."\">". $row['typeName'] ."</a></td><td width=\"100px\" align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&cuisineTypeID=". $row['typeID'] ."&cuisineTypeEdit'\" value=\"Edit\"></td></tr>";
											}
										}
										if (isset($_GET['addCuisineType'])) {
											echo "<tr><td width=\"35px\"><input type=\"number\" name=\"addTypeID\" min=\"1\" style=\"width: 35px;\"></td><td width=\"115px\"><input type=\"text\" name=\"addTypeName\" style=\"width: 100px;\"></td><td width=\"100px\" align=\"center\"><input type=\"submit\" name=\"Add\" value=\"Done\"></td></tr>";
										}
									?></table></td></tr>
									<?php
										if (!isset($_GET['addCuisineType']) && !isset($_GET['cuisineTypeEdit'])) {
											echo "<tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&addCuisineType'\" value=\"Add\"></td></tr>";
										} else {
											echo "<tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."'\" value=\"Cancel\"></td></tr>";
										}
									?>
								</table>
							</form></td>
							<td width="10px"></td>
							<td width="740px"><form name="cuisineOnMenu" action="addCuisineToMenu.php" method="post">
								<table width="100%">
									<tr><td><table border="1" width="100%"><?php
										if (isset($_GET['cuisineType'])) {
											$cuisineType=$_GET['cuisineType'];
											$sql="SELECT * FROM cuisineType WHERE typeName='$cuisineType'";
											$result=mysql_query($sql);
											$row=mysql_fetch_array($result,MYSQL_ASSOC);
											$menuTable=$row['tableName'];
											$sql="SELECT * FROM $menuTable";
											$result=mysql_query($sql);
											while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
												$cuisineName=$row['cuisineName'];
												$sqlCuisine="SELECT * FROM cuisinelist WHERE cuisineName='$cuisineName'";
												$resultCuisine=mysql_query($sqlCuisine);
												$rowCuisine=mysql_fetch_array($resultCuisine,MYSQL_ASSOC);
												echo "<tr><td><table width=\"100%\">";
												echo "<tr><td>". $rowCuisine['cuisineName'] ."</td><td align=\"right\"><input type=\"text\" name=\"cuisinePrice\" value=\"". $row['cuisinePrice'] ."\" align=\"right\" style=\"width: 50px; text-align: right;\" class=\"cleardefault\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" onclick=\"location.href='editPrice.php?cuisineType=". $_GET['cuisineType'] ."&cuisineName=". $rowCuisine['cuisineName'] ."'\" value=\"Change Price\"></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='deleteCuisineFromMenu.php?cuisineType=". $_GET['cuisineType'] ."&cuisineName=". $rowCuisine['cuisineName'] ."'\" value=\"Delete\"></td></tr>";
												//$imageName=$rowCuisine['cuisineImage'];
												//$sqlImage="SELECT * FROM cuisineImage WHERE imageName=$imageName";
												//$resultImage=mysql_query($sqlImage);
												//$rowImage=mysql_fetch_array($resultImage,MYSQL_ASSOC);
												echo "<tr><td width=\"300px\"></td><td></td><td></td></tr>";
												echo "</table></td></tr>";
											}
										}
									?></table></td></tr>
									<tr><td align="center"><input type="submit" name="Add" value="Add"></td></tr>
								</table>
							</form></td>
						</tr>
					</table>
				</td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>