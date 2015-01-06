<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');
    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
						<tr align="center"><td width="150px">Cuisine Types</td><td width="10px"></td><td width="840px"><?php if(isset($_GET['cuisineType'])&&$_GET['cuisineType']!=NULL){echo $_GET['cuisineType'];}else{echo "Special List";}?></td></tr>
						<tr align="left" valign="top">
							<td width="150px">
								<table width="100%">
									<tr><td><table border="1" width="100%"><?php
										echo "<tr><td><a href=\"customersMenu.php\">Special List</a></td></tr>";
										$sql="SELECT * FROM cuisineType ORDER BY typeID ASC";
										$result=mysql_query($sql);
										while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
											echo "<tr><td><a href=\"customersMenu.php?cuisineType=". $row['typeName'] ."\">". $row['typeName'] ."</a></td></tr>";
										}
									?></table></td></tr>
								</table>
							</td>
							<td width="10px"></td>
							<td width="840px">
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
												<td width=\"640px\" valign=\"top\"><table width=\"100%\">
												<tr><td><form name=\"Orders\" method=\"post\" action=\"customersMenu.php?Ordered&cuisineType=". $cuisineType ."&cuisineName=". $rowCuisine['cuisineName'] ."\"><table width=\"100%\" align=\"right\"><tr><td>". $rowCuisine['cuisineName'] ."</td><td width=\"50px\" align=\"right\">". $row['cuisinePrice'] ."</td><td width=\"30px\"><input type=\"submit\" name=\"order\" value=\"Order\"></td></tr></table></form><br><hr /></td></tr>
												<tr><td>". $description ."</td></tr></table></td>
												</table></td></tr>";
											}
										}
										echo "</table></td></tr>";
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