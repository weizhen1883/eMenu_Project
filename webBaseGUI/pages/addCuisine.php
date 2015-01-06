<?php
	header('Content-Type: text/html; charset=utf-8');
	define("Upload_DIR", "/var/www/sources/cuisines/photos/");
	define("Intro_DIR", "/var/www/sources/cuisines/intros/");
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['cuisineEditable'] == "N") {
        if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			header("location:login.php?CN");
		} else {
        	header("location:login.php?EN");
    	}
    }

    if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
		$title="添加菜肴";
		$name="菜品名称";
		$suggestPrice="建议零售价";
		$recipeTableTitle=array("原料名称","用量","成本","毛利");
		$buttonTile=array("添加","返回","编辑","修改","修改图片","删除","取消");
	} else {
    	$title="Add Cuisine";
    	$name="Cuisine Name";
    	$suggestPrice="Suggest Price For Sale";
    	$recipeTableTitle=array("NAME","DOSAGE","COST","GROSS PROFIT");
    	$buttonTile=array("ADD","GO BACK","Edit","Change","Change Image","Delete","Cancel");
	}

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	$conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['upload'])) {
		if (!empty($_FILES['imageFile'])) {
			$imageFile=$_FILES['imageFile'];
			$cuisineName=$_POST['cuisineName'];
			$fileName=$imageFile['name'];

			$parts=pathinfo($fileName);
			$cuisineImage=$cuisineName.".".$parts['extension'];
			
			$upload=move_uploaded_file($imageFile['tmp_name'], Upload_DIR.$cuisineImage);
			chmod(Upload_DIR.$cuisineImage, 0644);

			$imagePath="../sources/cuisines/photos/".$cuisineImage;
		}
	}

	if (isset($_GET['Done'])) {
		$cuisineName=$_GET['cuisineName'];
		$cuisineImage=$_GET['cuisineImage'];
		$imagePath="../sources/cuisines/photos/".$cuisineImage;
		$cuisineIntro=$cuisineName.".txt";
		$intro = $_POST['description'];

		$f = fopen(Intro_DIR.$cuisineIntro, "w");
		fwrite($f, $intro);
		fclose($f);

		chmod(Intro_DIR.$cuisineIntro, 0644);

		$sql="SELECT * FROM cuisinelist WHERE cuisineName='$cuisineName'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		if ($count==0) {
			$sql="INSERT INTO cuisinelist (cuisineName, cuisineImage, description) VALUES ('$cuisineName', '$cuisineImage', '$cuisineIntro')";
			$result=mysql_query($sql);
		}

		header("location:editCuisineList.php");
	}

	if (isset($_GET['Cancel'])) {
		header("location:editCuisineList.php");
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Add Cuisine</title>
    	<style type="text/css"></style>
    	<script type="text/javascript" src="../sources/js/util-functions.js"></script>
        <script type="text/javascript" src="../sources/js/clear-default-text.js"></script>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td width="10%"></td>
				<td width="80%" align="center" valign="top">
					<table border="1" width="600px">
						<form name="imageUpload" method="post" action="addCuisine.php?upload" enctype="multipart/form-data">
						<tr><td align="center">Add Cuisine</td></tr>
						<tr><td align="center"><table width="500px"><tr><td align="center">Cuisine Name</td><td align="center"><input type="text" name="cuisineName" value="<?php echo $cuisineName; ?>"></td></tr></table></td></tr>
						<tr><td align="center"><table width="500px"><tr><td align="center">Image:<input type="file" name="imageFile"></td><td align="center"><input type="submit" name="Upload" value="Upload"></td></tr></table></td></tr>
						</form>
						<tr><td align="center" width="600px" height="400px"><img src="<?php echo $imagePath; ?>" width="600px"></td></tr>
						<form name="intro" method="post" action="addCuisine.php?Done&cuisineName=<?php echo $cuisineName; ?>&cuisineImage=<?php echo $cuisineImage; ?>">
						<tr><td align="center"><textarea name="description" style="width: 600px; height: 200px;"></textarea></td></tr>
						<tr><td></td></tr>
						<tr><td align="center"><table width="500px"><tr><td align="center"><input type="submit" name="Done" value="Done"></td><td align="center"><input type="button" onclick="location.href='addCuisine.php?Cancel&cuisineImage=<?php echo $cuisineImage; ?>'" value="Cancel"></td></tr></table></td></tr>
						</form>
					</table>
				</td>
				<td width="10%"></td>
			</tr>
		</table>
	</body>
</html>