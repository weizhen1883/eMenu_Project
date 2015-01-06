<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['menuEditable'] == "N") {
        if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			header("location:login.php?CN");
		} else {
        	header("location:login.php?EN");
    	}
    }

    if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
		$title="菜单编辑";
		$subTitle="种类";
		$specialList="特别推荐";
		$buttonTile=array("添加","编辑","修改","删除","取消","修改价格","返回");
	} else {
    	$title="Menu Edit";
    	$subTitle="Cuisine Types";
    	$specialList="Special List";
    	$buttonTile=array("ADD","Edit","Change","Delete","Cancel","Change Price","GO BACK");
	}

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	$conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['DoneAddCuisineType'])) {
		$addTypeID=$_POST['addTypeID'];
		$addTypeName_inEnglish=$_POST['addTypeName_inEnglish'];
		$addTypeName_inChinese=$_POST['addTypeName_inChinese'];
		if ($addTypeID!=NULL&&($addTypeName_inEnglish!=NULL||$addTypeName_inChinese!=NULL)) {
			if ($addTypeName_inEnglish!=NULL&&$addTypeName_inChinese!=NULL) {
				if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
					$addTableName=$addTypeName_inChinese."TB";
				} else {
					$addTableName=$addTypeName_inEnglish."TB";
				}
				$addTableName=str_replace(' ', '', $addTableName);
				$sql="INSERT INTO cuisineType VALUES ($addTypeID, '$addTypeName_inEnglish', '$addTypeName_inChinese', '$addTableName')";
				$result=mysql_query($sql);
				$sql="CREATE TABLE IF NOT EXISTS $addTableName LIKE cuisineTypeSampleTB";
				$result=mysql_query($sql);
			} elseif ($addTypeName_inEnglish==NULL&&$addTypeName_inChinese!=NULL) {
				$addTableName=$addTypeName_inChinese."TB";
				$addTableName=str_replace(' ', '', $addTableName);
				$sql="INSERT INTO cuisineType VALUES ($addTypeID, '$addTypeName_inEnglish', '$addTypeName_inChinese', '$addTableName')";
				$result=mysql_query($sql);
				$sql="CREATE TABLE IF NOT EXISTS $addTableName LIKE cuisineTypeSampleTB";
				$result=mysql_query($sql);
			} elseif ($addTypeName_inEnglish!=NULL&&$addTypeName_inChinese==NULL) {
				$addTableName=$addTypeName_inEnglish."TB";
				$addTableName=str_replace(' ', '', $addTableName);
				$sql="INSERT INTO cuisineType VALUES ($addTypeID, '$addTypeName_inEnglish', '$addTypeName_inChinese', '$addTableName')";
				$result=mysql_query($sql);
				$sql="CREATE TABLE IF NOT EXISTS $addTableName LIKE cuisineTypeSampleTB";
				$result=mysql_query($sql);
			}
		}
	
		header("location:editMenu.php?cuisineType=".$_GET['cuisineType']);
	}

	if (isset($_GET['cuisineTypeChanged'])) {
		$cuisineType=$_GET['editCuisineType'];
		$editedTypeID=$_POST['typeID'];
		$editedTypeName_inEnglish=$_POST['typeName_inEnglish'];
		$editedTypeName_inChinese=$_POST['typeName_inChinese'];
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="SELECT * FROM cuisineType WHERE typeName_inChinese='$cuisineType'";
		} else {
			$sql="SELECT * FROM cuisineType WHERE typeName_inEnglish='$cuisineType'";
		}
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		if ($editedTypeID!=$row['typeID']&&$editedTypeName_inChinese==$row['typeName_inChinese']&&$editedTypeName_inEnglish==$row['typeName_inEnglish']) {
			if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
				$sql="UPDATE cuisineType SET typeID=$editedTypeID WHERE typeName_inChinese='$cuisineType'";
			} else {
				$sql="UPDATE cuisineType SET typeID=$editedTypeID WHERE typeName_inEnglish='$cuisineType'";
			}
			$result=mysql_query($sql);
		} elseif ($editedTypeName_inChinese!=$row['typeName_inChinese'] || $editedTypeName_inEnglish!=$row['typeName_inEnglish']) {
			$editedTableName_inEnglish=$editedTypeName_inEnglish."TB";
			$editedTableName_inEnglish=str_replace(' ', '', $editedTableName_inEnglish);
			$editedTableName_inChinese=$editedTypeName_inChinese."TB";
			$editedTableName_inChinese=str_replace(' ', '', $editedTableName_inChinese);
			if ($editedTableName_inEnglish!=$row['tableName']&&$editedTableName_inChinese!=$row['tableName']) {
				if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
					$sql="UPDATE cuisineType SET typeID=$editedTypeID, typeName_inEnglish='$editedTypeName_inEnglish', typeName_inChinese='$editedTypeName_inChinese', tableName='$editedTableName_inChinese' WHERE typeName_inChinese='$cuisineType'";
					$result=mysql_query($sql);
					$sql="RENAME TABLE ". $row['tableName'] ." TO $editedTableName_inChinese";
					$result=mysql_query($sql);
				} else {
					$sql="UPDATE cuisineType SET typeID=$editedTypeID, typeName_inEnglish='$editedTypeName_inEnglish', typeName_inChinese='$editedTypeName_inChinese', tableName='$editedTableName_inEnglish' WHERE typeName_inEnglish='$cuisineType'";
					$result=mysql_query($sql);
					$sql="RENAME TABLE ". $row['tableName'] ." TO $editedTableName_inEnglish";
					$result=mysql_query($sql);
				}
			} else {
				if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
					$sql="UPDATE cuisineType SET typeID=$editedTypeID, typeName_inEnglish='$editedTypeName', typeName_inChinese='$editedTypeName_inChinese' WHERE typeName_inChinese='$cuisineType'";
				} else {
					$sql="UPDATE cuisineType SET typeID=$editedTypeID, typeName_inEnglish='$editedTypeName', typeName_inChinese='$editedTypeName_inChinese' WHERE typeName_inEnglish='$cuisineType'";
				}
				$result=mysql_query($sql);
			}
		}

		header("location:editMenu.php?cuisineType=".$_GET['cuisineType']);
	}

	if (isset($_GET['deleteCuisineType'])) {
		$deleteType=$_GET['deleteCuisineType'];
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="SELECT * FROM cuisineType WHERE typeName_inChinese='$deleteType'";
		} else {
			$sql="SELECT * FROM cuisineType WHERE typeName_inEnglish='$deleteType'";
		}
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$count=mysql_num_rows($result);
		if ($count>0) {
			$tableName=$row['tableName'];
			$sql="DROP TABLE $tableName";
			$result=mysql_query($sql);
			if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
				$sql="DELETE FROM cuisineType WHERE typeName_inChinese='$deleteType'";
			} else {
				$sql="DELETE FROM cuisineType WHERE typeName_inEnglish='$deleteType'";
			}
			$result=mysql_query($sql);
		}

		header("location:editMenu.php?cuisineType=".$_GET['cuisineType']);
	}

	if (isset($_GET['deleteCuisine'])) {
		$cuisineType=$_GET['cuisineType'];
		$cuisineName=$_GET['cuisineName'];
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="SELECT * FROM cuisineType WHERE typeName_inChinese='$cuisineType'";
		} else {
			$sql="SELECT * FROM cuisineType WHERE typeName_inEnglish='$cuisineType'";
		}
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$tableName=$row['tableName'];
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="DELETE FROM $tableName WHERE cuisineName_inChinese='$cuisineName'";
		} else {
			$sql="DELETE FROM $tableName WHERE cuisineName_inEnglish='$cuisineName'";
		}
		$result=mysql_query($sql);

		header("location:editMenu.php?cuisineType=".$cuisineType);
	}

	if (isset($_GET['changePrice'])) {
		$cuisineType=$_GET['cuisineType'];
		$cuisineName=$_GET['cuisineName'];
		$price=floatval($_POST['cuisinePrice']);
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="SELECT * FROM cuisineType WHERE typeName_inChinese='$cuisineType'";
		} else {
			$sql="SELECT * FROM cuisineType WHERE typeName_inEnglish='$cuisineType'";
		}
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$tableName=$row['tableName'];
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="UPDATE $tableName SET cuisinePrice=$price WHERE cuisineName_inChinese='$cuisineName'";
		} else {
			$sql="UPDATE $tableName SET cuisinePrice=$price WHERE cuisineName_inEnglish='$cuisineName'";
		}
		$result=mysql_query($sql);

		header("location:editMenu.php?cuisineType=".$cuisineType);
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
			<tr><td width="5%"></td><td width="90%" align="center"><?php echo $title; ?><br><hr /></td><td width="5%"></td></tr>
			<tr>
				<td width="5%"></td>
				<td width="90%" align="center">
					<table width="1000px">
						<tr align="center"><td width="250px"><?php echo $subTitle; ?></td><td width="10px"></td><td width="740px"><?php if(isset($_GET['cuisineType'])&&$_GET['cuisineType']!=NULL){echo $_GET['cuisineType'];}else{echo $specialList;}?></td></tr>
						<tr align="left" valign="top">
							<td width="250px"><form name="cuisineType" action="editMenu.php?cuisineType=<?php echo $_GET['cuisineType']."&"; if(isset($_GET['addCuisineType'])){echo "DoneAddCuisineType";}elseif(isset($_GET['cuisineTypeEdit'])){echo "editCuisineType=". $_GET['editCuisineType'] ."&cuisineTypeChanged";}?>" method="post">
								<table width="100%">
									<tr><td><table border="1" width="100%"><?php
										echo "<tr><td width=\"35px\"></td><td width=\"115px\"><a href=\"editMenu.php\">".$specialList."</a></td><td width=\"50px\" align=\"center\"></td><td width=\"50px\" align=\"center\"></td></tr>";
										if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
											$sql="SELECT * FROM cuisineType ORDER BY typeID ASC, typeName_inChinese DESC";
											$result=mysql_query($sql);
											while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
												if (isset($_GET['addCuisineType'])) {
													echo "<tr><td width=\"35px\">". $row['typeID'] ."</td><td width=\"115px\">". $row['typeName_inChinese'] ."</td><td width=\"50px\" align=\"center\"></td><td width=\"50px\" align=\"center\"></td></tr>";
												} else if (isset($_GET['cuisineTypeEdit'])&&$_GET['editCuisineType']==$row['typeName_inChinese']) {
													echo "<tr><td width=\"35px\"><input type=\"number\" name=\"typeID\" value=\"". $row['typeID'] ."\" min=\"1\" style=\"width: 35px;\" class=\"cleardefault\"></td><td width=\"115px\"><input type=\"text\" name=\"typeName_inChinese\" value=\"". $row['typeName_inChinese'] ."\" style=\"width: 100px;\" class=\"cleardefault\"></td><td width=\"50px\" align=\"center\"><input type=\"submit\" name=\"Change\" value=\"".$buttonTile[2]."\"></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&deleteCuisineType=". $row['typeName_inChinese'] ."'\" value=\"".$buttonTile[3]."\"></td></tr>
													<tr><td></td><td><input type=\"text\" name=\"typeName_inEnglish\" value=\"". $row['typeName_inEnglish'] ."\" style=\"width: 100px;\" class=\"cleardefault\"></td><td></td><td></td></tr>";
												} else {
													echo "<tr><td width=\"35px\">". $row['typeID'] ."</td><td width=\"115px\"><a href=\"editMenu.php?cuisineType=". $row['typeName_inChinese'] ."\">". $row['typeName_inChinese'] ."</a></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&editCuisineType=". $row['typeName_inChinese'] ."&cuisineTypeEdit'\" value=\"".$buttonTile[1]."\"></td><td width=\"50px\" align=\"center\"></td></tr>";
												}
											}
											if (isset($_GET['addCuisineType'])) {
												echo "<tr><td width=\"35px\"><input type=\"number\" name=\"addTypeID\" min=\"1\" style=\"width: 35px;\"></td><td width=\"115px\">CN:<input type=\"text\" name=\"addTypeName_inChinese\" style=\"width: 100px;\"></td><td width=\"50px\" align=\"center\"><input type=\"submit\" name=\"Add\" value=\"".$buttonTile[0]."\"></td><td width=\"50px\" align=\"center\"></td></tr>
												<tr><td></td><td>EN:<input type=\"text\" name=\"addTypeName_inEnglish\"style=\"width: 100px;\"></td><td></td><td></td></tr>";
											}
										} else {
											$sql="SELECT * FROM cuisineType ORDER BY typeID ASC, typeName_inEnglish DESC";
											$result=mysql_query($sql);
											while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
												if (isset($_GET['addCuisineType'])) {
													echo "<tr><td width=\"35px\">". $row['typeID'] ."</td><td width=\"115px\">". $row['typeName_inEnglish'] ."</td><td width=\"50px\" align=\"center\"></td><td width=\"50px\" align=\"center\"></td></tr>";
												} else if (isset($_GET['cuisineTypeEdit'])&&$_GET['editCuisineType']==$row['typeName_inEnglish']) {
													echo "<tr><td width=\"35px\"><input type=\"number\" name=\"typeID\" value=\"". $row['typeID'] ."\" min=\"1\" style=\"width: 35px;\" class=\"cleardefault\"></td><td width=\"115px\"><input type=\"text\" name=\"typeName_inEnglish\" value=\"". $row['typeName_inEnglish'] ."\" style=\"width: 100px;\" class=\"cleardefault\"></td><td width=\"50px\" align=\"center\"><input type=\"submit\" name=\"Change\" value=\"".$buttonTile[2]."\"></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&deleteCuisineType=". $row['typeName_inEnglish'] ."'\" value=\"".$buttonTile[3]."\"></td></tr>
													<tr><td></td><td><input type=\"text\" name=\"typeName_inChinese\" value=\"". $row['typeName_inChinese'] ."\" style=\"width: 100px;\" class=\"cleardefault\"></td><td></td><td></td></tr>";
												} else {
													echo "<tr><td width=\"35px\">". $row['typeID'] ."</td><td width=\"115px\"><a href=\"editMenu.php?cuisineType=". $row['typeName_inEnglish'] ."\">". $row['typeName_inEnglish'] ."</a></td><td width=\"50px\" align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&editCuisineType=". $row['typeName_inEnglish'] ."&cuisineTypeEdit'\" value=\"".$buttonTile[1]."\"></td><td width=\"50px\" align=\"center\"></td></tr>";
												}
											}
											if (isset($_GET['addCuisineType'])) {
												echo "<tr><td width=\"35px\"><input type=\"number\" name=\"addTypeID\" min=\"1\" style=\"width: 35px;\"></td><td width=\"115px\">EN:<input type=\"text\" name=\"addTypeName_inEnglish\" style=\"width: 100px;\"></td><td width=\"50px\" align=\"center\"><input type=\"submit\" name=\"Add\" value=\"".$buttonTile[0]."\"></td><td width=\"50px\" align=\"center\"></td></tr>
												<tr><td></td><td>CN:<input type=\"text\" name=\"addTypeName_inChinese\" style=\"width: 100px;\"></td><td></td><td></td></tr>";
											}
										}
									?></table></td></tr>
									<?php
										if (!isset($_GET['addCuisineType']) && !isset($_GET['cuisineTypeEdit'])) {
											echo "<tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&addCuisineType'\" value=\"".$buttonTile[0]."\"></td></tr>";
										} else {
											echo "<tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."'\" value=\"".$buttonTile[4]."\"></td></tr>";
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
											if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
												$sql="SELECT * FROM cuisineType WHERE typeName_inChinese='$cuisineType'";
												$result=mysql_query($sql);
												$row=mysql_fetch_array($result,MYSQL_ASSOC);
												$menuTable=$row['tableName'];
												$sql="SELECT * FROM $menuTable";
												$result=mysql_query($sql);
												while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
													$cuisineName=$row['cuisineName_inChinese'];
													$sqlCuisine="SELECT * FROM cuisinelist WHERE cuisineName_inChinese='$cuisineName'";
													$resultCuisine=mysql_query($sqlCuisine);
													$rowCuisine=mysql_fetch_array($resultCuisine,MYSQL_ASSOC);
													$cuisineImage=$rowCuisine['cuisineImage'];
													$imagePath="../sources/cuisines/photos/".$cuisineImage;
													$f=fopen("../sources/cuisines/intros/".$rowCuisine['description_inChinese'], "r");
													$description=fgets($f);
													fclose($f);
													echo "<tr><td><table width=\"100%\">";
													echo "<tr><td width=\"200px\"><img src=\"". $imagePath ."\" width=\"200px\"></td>
													<td width=\"440px\" valign=\"top\"><table width=\"100%\"><tr><td>". $rowCuisine['cuisineName_inChinese'] ."<br><hr /></td></tr><tr><td>". $description ."</td></tr></table></td>
													<td width=\"100px\" valign=\"top\"><table width=\"100%\">
													<form name=\"changeCuisinePrice\" method=\"post\" action=\"editMenu.php?cuisineType=". $_GET['cuisineType'] ."&cuisineName=". $rowCuisine['cuisineName_inChinese'] ."&changePrice\"><tr><td><input type=\"text\" name=\"cuisinePrice\" value=\"". $row['cuisinePrice'] ."\" align=\"right\" style=\"width: 50px; text-align: right;\" class=\"cleardefault\"></td></tr><tr><td align=\"center\"><input type=\"submit\" name=\"changePrice\" value=\"".$buttonTile[5]."\"></td></tr></form>
													<tr><td align=\"center\"><button onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&cuisineName=". $rowCuisine['cuisineName_inChinese'] ."&deleteCuisine'\">".$buttonTile[3]."</button></td></tr></table></td></tr>";
													echo "</table></td></tr>";
												}
												echo "</table></td></tr><tr><td align=\"center\"><button onclick=\"location.href='addCuisineToMenu.php?cuisineType=". $cuisineType ."'\">".$buttonTile[0]."</button></td></tr>";
											} else {
												$sql="SELECT * FROM cuisineType WHERE typeName_inEnglish='$cuisineType'";
												$result=mysql_query($sql);
												$row=mysql_fetch_array($result,MYSQL_ASSOC);
												$menuTable=$row['tableName'];
												$sql="SELECT * FROM $menuTable";
												$result=mysql_query($sql);
												while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
													$cuisineName=$row['cuisineName_inEnglish'];
													$sqlCuisine="SELECT * FROM cuisinelist WHERE cuisineName_inEnglish='$cuisineName'";
													$resultCuisine=mysql_query($sqlCuisine);
													$rowCuisine=mysql_fetch_array($resultCuisine,MYSQL_ASSOC);
													$cuisineImage=$rowCuisine['cuisineImage'];
													$imagePath="../sources/cuisines/photos/".$cuisineImage;
													$f=fopen("../sources/cuisines/intros/".$rowCuisine['description_inEnglish'], "r");
													$description=fgets($f);
													fclose($f);
													echo "<tr><td><table width=\"100%\">";
													echo "<tr><td width=\"200px\"><img src=\"". $imagePath ."\" width=\"200px\"></td>
													<td width=\"440px\" valign=\"top\"><table width=\"100%\"><tr><td>". $rowCuisine['cuisineName_inEnglish'] ."<br><hr /></td></tr><tr><td>". $description ."</td></tr></table></td>
													<td width=\"100px\" valign=\"top\"><table width=\"100%\">
													<form name=\"changeCuisinePrice\" method=\"post\" action=\"editMenu.php?cuisineType=". $_GET['cuisineType'] ."&cuisineName=". $rowCuisine['cuisineName_inEnglish'] ."&changePrice\"><tr><td><input type=\"text\" name=\"cuisinePrice\" value=\"". $row['cuisinePrice'] ."\" align=\"right\" style=\"width: 50px; text-align: right;\" class=\"cleardefault\"></td></tr><tr><td align=\"center\"><input type=\"submit\" name=\"changePrice\" value=\"".$buttonTile[5]."\"></td></tr></form>
													<tr><td align=\"center\"><button onclick=\"location.href='editMenu.php?cuisineType=". $_GET['cuisineType'] ."&cuisineName=". $rowCuisine['cuisineName_inEnglish'] ."&deleteCuisine'\">".$buttonTile[3]."</button></td></tr></table></td></tr>";
													echo "</table></td></tr>";
												}
												echo "</table></td></tr><tr><td align=\"center\"><button onclick=\"location.href='addCuisineToMenu.php?cuisineType=". $cuisineType ."'\">".$buttonTile[0]."</button></td></tr>";
											}
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
			<tr><td width="5%"></td><td width="90%" align="center"><button onclick="location.href='login_success.php'"><?php echo $buttonTile[6]; ?></button></td><td width="5%"></td></tr>
		</table>
	</body>
</html>