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
			$addTableName=str_replace(' ', '', $addTableName);
			$sql="INSERT INTO cuisineType VALUES ($addTypeID, '$addTypeName', '$addTableName')";
			$result=mysql_query($sql);
			$sql="CREATE TABLE IF NOT EXISTS $addTableName LIKE cuisineTypeSampleTB";
			$result=mysql_query($sql);
		}
	
		header("location:editMenu.php?cuisineType=".$_GET['cuisineType']);
	}

	if (isset($_GET['cuisineTypeChanged'])) {
		$cuisineType=$_GET['editCuisineType'];
		$editedTypeID=$_POST['typeID'];
		$editedTypeName=$_POST['typeName'];
		$sql="SELECT * FROM cuisineType WHERE typeName='$cuisineType'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		if ($editedTypeID!=$row['typeID']&&$editedTypeName==$row['typeName']) {
			$sql="UPDATE cuisineType SET typeID=$editedTypeID WHERE typeName='$cuisineType'";
			$result=mysql_query($sql);
		} elseif ($editedTypeID==$row['typeID']&&$editedTypeName!=$row['typeName']) {
			$editedTableName=$editedTypeName."TB";
			$editedTableName=str_replace(' ', '', $editedTableName);
			$sql="UPDATE cuisineType SET typeName='$editedTypeName', tableName='$editedTableName' WHERE typeName='$cuisineType'";
			$result=mysql_query($sql);
			$sql="RENAME TABLE ". $row['tableName'] ." TO $editedTableName";
			$result=mysql_query($sql);
		} elseif ($editedTypeID!=$row['typeID']&&$editedTypeName!=$row['typeName']) {
			$editedTableName=$editedTypeName."TB";
			$editedTableName=str_replace(' ', '', $editedTableName);
			$sql="UPDATE cuisineType SET typeID=$editedTypeID, typeName='$editedTypeName', tableName='$editedTableName' WHERE typeName='$cuisineType'";
			$result=mysql_query($sql);
			$sql="RENAME TABLE ". $row['tableName'] ." TO $editedTableName";
			$result=mysql_query($sql);
		}

		header("location:editMenu.php?cuisineType=".$_GET['cuisineType']);
	}

	if (isset($_GET['deleteCuisineType'])) {
		$deleteType=$_GET['deleteCuisineType'];
		$sql="SELECT * FROM cuisineType WHERE typeName='$deleteType'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$count=mysql_num_rows($result);
		if ($count==1) {
			$tableName=$row['tableName'];
			$sql="DROP TABLE $tableName";
			$result=mysql_query($sql);
			$sql="DELETE FROM cuisineType WHERE typeName='$deleteType'";
			$result=mysql_query($sql);
		}

		header("location:editMenu.php?cuisineType=".$_GET['cuisineType']);
	}

	if (isset($_GET['deleteCuisine'])) {
		$cuisineType=$_GET['cuisineType'];
		$cuisineName=$_GET['cuisineName'];
		$sql="SELECT * FROM cuisineType WHERE typeName='$cuisineType'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$tableName=$row['tableName'];
		$sql="DELETE FROM $tableName WHERE cuisineName='$cuisineName'";
		$result=mysql_query($sql);

		header("location:editMenu.php?cuisineType=".$cuisineType);
	}

	if (isset($_GET['changePrice'])) {
		$cuisineType=$_GET['cuisineType'];
		$cuisineName=$_GET['cuisineName'];
		$price=floatval($_POST['cuisinePrice']);
		$sql="SELECT * FROM cuisineType WHERE typeName='$cuisineType'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$tableName=$row['tableName'];
		$sql="UPDATE $tableName SET cuisinePrice=$price WHERE cuisineName='$cuisineName'";
		$result=mysql_query($sql);

		header("location:editMenu.php?cuisineType=".$cuisineType);
	}
?>
<html>
	<head>
		<title>Menu Edit</title>
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
						<tr align="center"><td width="250px">Cuisine Types</td><td width="10px"></td><td width="740px"><?php if(isset($_GET['cuisineType'])&&$_GET['cuisineType']!=NULL){echo $_GET['cuisineType'];}else{echo "Special List";}?></td></tr>
						<tr align="left" valign="top">
							<td width="250px"><form name="cuisineType" action="editMenu.php?cuisineType=<?php echo $_GET['cuisineType']."&"; if(isset($_GET['addCuisineType'])){echo "DoneAddCuisineType";}elseif(isset($_GET['cuisineTypeEdit'])){echo "editCuisineType=". $_GET['editCuisineType'] ."&cuisineTypeChanged";}?>" method="post">
								<table width="100%">
									<tr><td><table border="1" width="100%"><?php
										echo "<tr><td width=\"35px\"></td><td width=\"115px\"><a href=\"editMenu.php\">Special List</a></td><td width=\"50px\" align=\"center\"></td><td width=\"50px\" align=\"center\"></td></tr>";
										$sql="SELECT * FROM cuisineType ORDER BY typeID ASC";
										$result=mysql_query($sql);
										while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
											if (isset($_GET['addCuisineType'])) {
												echo "<tr><td width=\"35px\">". $row['typeID'] ."</td><td width=\"115px\">". $row['typeName'] ."</td><td width=\"50px\" align=\"center\"></td><td width=\"50px\" align=\"center\"></td></tr>";
											} else if (isset($_GET['cuisineTypeEdit'])&&$_GET['editCuisineType']==$row['typeName']) {
												echo "<tr><td width=\"35px\"><input type=\"number\" name=\"typeID\" value=\"". $row['typeID'] ."\" min=\"1\" style=\"width: 35px;\" class=\"cleardefault\"></td><td width=\"115px\"><input type=\"text\" name=\"typeName\" value=\"". $row['typeName'] ."\" style=\"width: 100px;\" class=\"cleardefault\"></td><td width=\"50px\" align=\"center\"><input type=\"submit\" name=\"Change\" value=\"Change\"></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&deleteCuisineType=". $row['typeName'] ."'\" value=\"Delete\"></td></tr>";
											} else {
												echo "<tr><td width=\"35px\">". $row['typeID'] ."</td><td width=\"115px\"><a href=\"editMenu.php?cuisineType=". $row['typeName'] ."\">". $row['typeName'] ."</a></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&editCuisineType=". $row['typeName'] ."&cuisineTypeEdit'\" value=\"Edit\"></td><td width=\"50px\" align=\"center\"></td></tr>";
											}
										}
										if (isset($_GET['addCuisineType'])) {
											echo "<tr><td width=\"35px\"><input type=\"number\" name=\"addTypeID\" min=\"1\" style=\"width: 35px;\"></td><td width=\"115px\"><input type=\"text\" name=\"addTypeName\" style=\"width: 100px;\"></td><td width=\"50px\" align=\"center\"><input type=\"submit\" name=\"Add\" value=\"Add\"></td><td width=\"50px\" align=\"center\"></td></tr>";
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
							<td width="740px">
								<table width="100%">
									<tr><td><table border="1" width="100%"><?php
										if (isset($_GET['cuisineType'])&&$_GET['cuisineType']!=NULL) {
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
												$cuisineImage=$rowCuisine['cuisineImage'];
												$imagePath="../sources/cuisines/photos/".$cuisineImage;
												$f=fopen("../sources/cuisines/intros/".$rowCuisine['description'], "r");
												$description=fgets($f);
												fclose($f);
												echo "<tr><td><table width=\"100%\">";
												echo "<tr><td width=\"200px\"><img src=\"". $imagePath ."\" width=\"200px\"></td>
												<td width=\"440px\" valign=\"top\"><table width=\"100%\"><tr><td>". $rowCuisine['cuisineName'] ."<br><hr /></td></tr><tr><td>". $description ."</td></tr></table></td>
												<td width=\"100px\" valign=\"top\"><table width=\"100%\">
												<form name=\"changeCuisinePrice\" method=\"post\" action=\"editMenu.php?cuisineType=". $_GET['cuisineType'] ."&cuisineName=". $rowCuisine['cuisineName'] ."&changePrice\"><tr><td><input type=\"text\" name=\"cuisinePrice\" value=\"". $row['cuisinePrice'] ."\" align=\"right\" style=\"width: 50px; text-align: right;\" class=\"cleardefault\"></td></tr><tr><td align=\"center\"><input type=\"submit\" name=\"changePrice\" value=\"Change Price\"></td></tr></form>
												<tr><td align=\"center\"><button onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&cuisineName=". $rowCuisine['cuisineName'] ."&deleteCuisine'\">Delete</button></td></tr></table></td></tr>";
												echo "</table></td></tr>";
											}
											echo "</table></td></tr><tr><td align=\"center\"><button onclick=\"location.href='addCuisineToMenu.php?cuisineType=". $cuisineType ."'\">Add</button></td></tr>";
										} else {
											echo "</table></td></tr>";
										}
									?>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td width="5%"></td>
			</tr>
			<tr><td width="5%"></td><td width="90%" align="center"><button onclick="location.href='login_success.php'">Go Back</button></td><td width="5%"></td></tr>
		</table>
	</body>
</html>