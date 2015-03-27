<?php
	header('content-type: application/json; charset=utf-8');
	define("Intro_DIR", "/var/www/sources/cuisines/intros/");
	session_start();
    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB_v2";

	if (isset($_GET['systemLanguage'])) {
		$systemLanguage = $_GET['systemLanguage'];
	}

	$conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	mysql_select_db("$db_name")or die("cannot select DB");

	$response = array();
	//set the special list
	$response["cuisineTypes"] = array();

	$special_list_type = array();
	$special_list_type["typeID"] = "000";
	if ($systemLanguage == "Chinese") {
		$special_list_type["type"] = "每日推荐";
	} elseif ($systemLanguage == "English") {
		$special_list_type["type"] = "Special List";
	} else {
		$special_list_type["type"] = "每日推荐";
	}
	//get the special cuisine result
	$specila_list_result=mysql_query("SELECT * FROM cuisineList WHERE dailySpecial=1");
	if (mysql_num_rows($specila_list_result) > 0) {
		$response[$special_list_type["typeID"]] = array();
		while ($row=mysql_fetch_array($specila_list_result,MYSQL_ASSOC)) {
			$special_cuisines=array();
			$special_cuisines["cuisineID"] = $row['cuisineID'];
			if ($systemLanguage == "Chinese") {
				$special_cuisines["name"] = $row['cuisineName_ch'];
				$cuisineIntroFile = $row['description_ch'];
			} elseif ($systemLanguage == "English") {
				$special_cuisines["name"] = $row['cuisineName_en'];
				$cuisineIntroFile = $row['description_en'];
			} else {
				$special_cuisines["name"] = $row['cuisineName_ch'];
				$cuisineIntroFile = $row['description_ch'];
			}

			$f=fopen(Intro_DIR.$cuisineIntroFile, "r");
	        $special_cuisines["intro"] = fgets($f);
	        fclose($f);

			$special_cuisines["image"] = $row['cuisineImage'];
			$special_cuisines["price"] = $row['specialPrice'];

			array_push($response[$special_list_type["typeID"]], $special_cuisines);
		}
		$special_list_type["hasCuisine"] = 1;
	} else {
		$special_list_type["hasCuisine"] = 0;
	}
	array_push($response["cuisineTypes"], $special_list_type);

	//get the cuisine type
	$cuisine_type_result=mysql_query("SELECT * FROM cuisineType ORDER BY sortOrder ASC");
	if (mysql_num_rows($cuisine_type_result) > 0) {
		while ($row=mysql_fetch_array($cuisine_type_result,MYSQL_ASSOC)) {
			$cuisineType = array();
			$cuisineType["typeID"] = $row['typeID'];
			$typeID = $row['typeID'];
			if ($systemLanguage == "Chinese") {
				$cuisineType["type"] = $row['typeName_ch'];
			} elseif ($systemLanguage == "English") {
				$cuisineType["type"] = $row['typeName_en'];
			} else {
				$cuisineType["type"] = $row['typeName_ch'];
			}
	        
	        $cuisine_list_in_type_result = mysql_query("SELECT * FROM cuisineList WHERE typeID=$typeID AND dailySpecial!=1");
	        if (mysql_num_rows($cuisine_list_in_type_result) > 0) {
	        	$response[$cuisineType["typeID"]] = array();
		        while ($row1=mysql_fetch_array($cuisine_list_in_type_result,MYSQL_ASSOC)) {
		        	$cuisines = array();
		        	$cuisines["cuisineID"] = $row1['cuisineID'];
		        	if ($systemLanguage == "Chinese") {
		        		$cuisines["name"] = $row1['cuisineName_ch'];
		        		$cuisineIntroFile = $row1['description_ch'];
		        	} elseif ($systemLanguage == "English") {
		        		$cuisines["name"] = $row1['cuisineName_en'];
		        		$cuisineIntroFile = $row1['description_en'];
		        	} else {
						$cuisines["name"] = $row1['cuisineName_ch'];
		        		$cuisineIntroFile = $row1['description_ch'];
		        	}

		        	$f=fopen(Intro_DIR.$cuisineIntroFile, "r");
			        $cuisines["intro"] = fgets($f);
			        fclose($f);

			        $cuisines["image"] = $row1['cuisineImage'];
			        $cuisines["price"] = $row1['retailPrice'];

		        	array_push($response[$cuisineType["typeID"]], $cuisines);
		        }
		        $cuisineType["hasCuisine"] = 1;
		    } else {
		    	$cuisineType["hasCuisine"] = 0;
		    }
	        array_push($response["cuisineTypes"], $cuisineType);
		}
		$response["success"] = 1;
	} else {
		$response["success"] = 0;
	}

	echo json_encode($response);
?>