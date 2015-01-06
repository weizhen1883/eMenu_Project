<?php
	header('Content-Type: text/html; charset=utf-8');
	header('content-type: application/json; charset=utf-8');
	session_start();
    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	$conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	mysql_select_db("$db_name")or die("cannot select DB");

	$response = array();

	$sql="SELECT * FROM cuisineType ORDER BY typeID ASC";
	$result=mysql_query($sql);
	if (mysql_num_rows($result) > 0) {
		$response["cuisineTypes"] = array();
		while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
			$cuisineTypes = array();
	        $cuisineTypes["type"] = $row["typeName_inChinese"];
	        $menuTable=$row['tableName'];
	        $sql1 = "SELECT * FROM $menuTable ORDER BY cuisineName_inEnglish";
	        $result1 = mysql_query($sql1);
	        if (mysql_num_rows($result1) > 0) {
	        	$response[$cuisineTypes["type"]] = array();
		        while ($row1=mysql_fetch_array($result1,MYSQL_ASSOC)) {
		        	$cuisines = array();
		        	$cuisineName = $row1["cuisineName_inChinese"];
		        	$cuisines["name"] = $cuisineName;
		        	$cuisines["price"] = $row1["cuisinePrice"];
		        	$sql2 = "SELECT * FROM cuisinelist WHERE cuisineName_inChinese = '$cuisineName'";
		        	$result2 = mysql_query($sql2);
		        	$row2=mysql_fetch_array($result2,MYSQL_ASSOC);
		        	$cuisines["image"] = utf8_encode($row2["cuisineImage"]);
		        	$cuisines["intro"] = utf8_encode($row2["description_inChinese"]);
		        	array_push($response[$cuisineTypes["type"]], $cuisines);
		        }
		        $cuisineTypes["hasCuisine"] = 1;
		    } else {
		    	$cuisineTypes["hasCuisine"] = 0;
		    }
	        array_push($response["cuisineTypes"], $cuisineTypes);
		}
		$response["success"] = 1;
		echo json_encode($response);
	} else {
		$response["success"] = 0;

    	echo json_encode($response);
	}
?>