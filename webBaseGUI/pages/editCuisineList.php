<?php
	header('Content-Type: text/html; charset=utf-8');
	define("Image_DIR", "/var/www/sources/cuisines/photos/");
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
		$title="菜肴列表编辑";
		$buttonTile=array("添加","返回","编辑","修改","修改图片","删除","取消");
	} else {
    	$title="Cuisine List Edit";
    	$buttonTile=array("ADD","GO BACK","Edit","Change","Change Image","Delete","Cancel");
	}

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	$conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['DoneEditCuisine'])) {
		$intro = $_POST['description'];
		$cuisineName=$_POST['cuisineName'];
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="SELECT description_inChinese FROM cuisinelist WHERE cuisineName_inChinese='$cuisineName'";
		} else {
			$sql="SELECT description_inEnglish FROM cuisinelist WHERE cuisineName_inEnglish='$cuisineName'";
		}
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);

		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$f = fopen(Intro_DIR.$row[description_inChinese], "w");
		} else {
			$f = fopen(Intro_DIR.$row[description_inEnglish], "w");
		}
		fwrite($f, $intro);
		fclose($f);

		header("location:editCuisineList.php");
	}

	if (isset($_GET['DoneChangeImage'])) {
		$cuisineName=$_GET['cuisineName'];
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="SELECT * FROM cuisinelist WHERE cuisineName_inChinese='$cuisineName'";
		} else {
			$sql="SELECT * FROM cuisinelist WHERE cuisineName_inEnglish='$cuisineName'";
		}
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);

		if (!empty($_FILES['imageFile'])) {
			$imageFile=$_FILES['imageFile'];
			$fileName=$imageFile['name'];

			$parts=pathinfo($fileName);
			$cuisineImage=$cuisineName.".".$parts['extension'];
			
			$upload=move_uploaded_file($imageFile['tmp_name'], Image_DIR.$cuisineImage);
			chmod(Image_DIR.$cuisineImage, 0644);

			if ($cuisineImage!=$row['cuisineImage']) {
				unlink(Image_DIR.$row['cuisineImage']);
				if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
					$sql="UPDATE cuisinelist SET cuisineImage='$cuisineImage' WHERE cuisineName_inChinese='$cuisineName'";
				} else {
					$sql="UPDATE cuisinelist SET cuisineImage='$cuisineImage' WHERE cuisineName_inEnglish='$cuisineName'";
				}
				$result=mysql_query($result);
			}
		}
		header("location:editCuisineList.php");
	}

	if (isset($_GET['Delete'])) {
		$cuisineName=$_GET['cuisineName'];
		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="SELECT * FROM cuisinelist WHERE cuisineName_inChinese='$cuisineName'";
		} else {
			$sql="SELECT * FROM cuisinelist WHERE cuisineName_inEnglish='$cuisineName'";
		}
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);

		unlink(Image_DIR.$row['cuisineImage']);
		unlink(Intro_DIR.$row['description_inChinese']);
		unlink(Intro_DIR.$row['description_inEnglish']);

		if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
			$sql="DELETE FROM cuisinelist WHERE cuisineName_inChinese='$cuisineName'";
		} else {
			$sql="DELETE FROM cuisinelist WHERE cuisineName_inEnglish='$cuisineName'";
		}
		$result=mysql_query($sql);

		header("location:editCuisineList.php");
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
				<td width="10%"></td>
				<td width="80%" align="center">
					<table width="1000px">
						<tr><td align="center"><?php echo $title; ?></td></tr>
						<?php
							$sql="SELECT * FROM cuisinelist";
							$result=mysql_query($sql);
							while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
								if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
									$f=fopen("../sources/cuisines/intros/".$row['description_inChinese'], "r");
									$description=fgets($f);
									fclose($f);

									echo "<tr><td align=\"center\"><table border=\"1\" width=\"100%\"><form name=\"". $row['cuisineName_inChinese'] ."\" action=\"editCuisineList.php?cuisineName=". $row['cuisineName_inChinese'] ."&DoneEditCuisine\" method=\"post\"><tr>
									<td width=\"200px\" align=\"center\" valign=\"top\"><img src=\"../sources/cuisines/photos/". $row['cuisineImage'] ."\" width=\"200px\"></td>";
									if (isset($_GET['editCuisine'])&&$_GET['cuisineName']==$row['cuisineName_inChinese']) {
										echo "<td width=\"700px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td><input type=\"text\" name=\"cuisineName\" value=\"". $row['cuisineName_inChinese'] ."\"  class=\"cleardefault\"><br><hr /></td></tr>
										<tr><td width=\"700px\" height=\"150px\" valign=\"top\"><textarea name=\"description\" style=\"width: 500px; height: 150px;\">". $description ."</textarea></td></tr></table></td>";
										echo "<td width=\"100px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td align=\"center\"><input type=\"submit\" name=\"Change\" value=\"".$buttonTile[3]."\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName_inChinese'] ."&ChangeImage'\" value=\"".$buttonTile[4]."\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName_inChinese'] ."&Delete'\" value=\"".$buttonTile[5]."\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php'\" value=\"".$buttonTile[6]."\"></td></tr></table></td>";
									} else {
										echo "<td width=\"700px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td>". $row['cuisineName_inChinese'] ."<br><hr /></td></tr><tr><td width=\"700px\" height=\"150px\"  valign=\"top\">". $description ."</td></tr></table></td>";
										echo "<td width=\"100px\" align=\"center\" valign=\"top\">";
										if (isset($_GET['ChangeImage'])&&$_GET['cuisineName']==$row['cuisineName_inChinese']) {
											echo "<table width=\"100%\"><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php'\" value=\"".$buttonTile[6]."\"></td></tr></table></td>";
										} else {
											echo "<table width=\"100%\"><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName_inChinese'] ."&editCuisine'\" value=\"".$buttonTile[2]."\"></td></tr><tr><td></td></tr><tr><td></td></tr></table></td>";
										}
									}
									echo "</tr></form>";
									if (isset($_GET['ChangeImage'])&&$_GET['cuisineName']==$row['cuisineName_inChinese']) {
										echo "<form name=\"". $row['cuisineName_inChinese'] ."_changeImage\" method=\"post\" action=\"editCuisineList.php?cuisineName=". $row['cuisineName_inChinese'] ."&DoneChangeImage\" enctype=\"multipart/form-data\"><tr><td></td><td><input type=\"file\" name=\"imageFile\"><input type=\"submit\" name=\"changeImage\" value=\"".$buttonTile[4]."\"></td><td><br></td></tr></form></table></td></tr>";
									} else {
										echo "<tr><td><br></td><td><br></td><td><br></td></tr></table></td></tr>";
									}
								} else {
									$f=fopen("../sources/cuisines/intros/".$row['description_inEnglish'], "r");
									$description=fgets($f);
									fclose($f);

									echo "<tr><td align=\"center\"><table border=\"1\" width=\"100%\"><form name=\"". $row['cuisineName_inEnglish'] ."\" action=\"editCuisineList.php?cuisineName=". $row['cuisineName_inEnglish'] ."&DoneEditCuisine\" method=\"post\"><tr>
									<td width=\"200px\" align=\"center\" valign=\"top\"><img src=\"../sources/cuisines/photos/". $row['cuisineImage'] ."\" width=\"200px\"></td>";
									if (isset($_GET['editCuisine'])&&$_GET['cuisineName']==$row['cuisineName_inEnglish']) {
										echo "<td width=\"700px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td><input type=\"text\" name=\"cuisineName\" value=\"". $row['cuisineName_inEnglish'] ."\"  class=\"cleardefault\"><br><hr /></td></tr>
										<tr><td width=\"700px\" height=\"150px\" valign=\"top\"><textarea name=\"description\" style=\"width: 500px; height: 150px;\">". $description ."</textarea></td></tr></table></td>";
										echo "<td width=\"100px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td align=\"center\"><input type=\"submit\" name=\"Change\" value=\"".$buttonTile[3]."\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName_inEnglish'] ."&ChangeImage'\" value=\"".$buttonTile[4]."\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName_inEnglish'] ."&Delete'\" value=\"".$buttonTile[5]."\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php'\" value=\"".$buttonTile[6]."\"></td></tr></table></td>";
									} else {
										echo "<td width=\"700px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td>". $row['cuisineName_inEnglish'] ."<br><hr /></td></tr><tr><td width=\"700px\" height=\"150px\"  valign=\"top\">". $description ."</td></tr></table></td>";
										echo "<td width=\"100px\" align=\"center\" valign=\"top\">";
										if (isset($_GET['ChangeImage'])&&$_GET['cuisineName']==$row['cuisineName_inEnglish']) {
											echo "<table width=\"100%\"><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php'\" value=\"".$buttonTile[6]."\"></td></tr></table></td>";
										} else {
											echo "<table width=\"100%\"><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName_inEnglish'] ."&editCuisine'\" value=\"".$buttonTile[2]."\"></td></tr><tr><td></td></tr><tr><td></td></tr></table></td>";
										}
									}
									echo "</tr></form>";
									if (isset($_GET['ChangeImage'])&&$_GET['cuisineName']==$row['cuisineName_inEnglish']) {
										echo "<form name=\"". $row['cuisineName_inEnglish'] ."_changeImage\" method=\"post\" action=\"editCuisineList.php?cuisineName=". $row['cuisineName_inEnglish'] ."&DoneChangeImage\" enctype=\"multipart/form-data\"><tr><td></td><td><input type=\"file\" name=\"imageFile\"><input type=\"submit\" name=\"changeImage\" value=\"".$buttonTile[4]."\"></td><td><br></td></tr></form></table></td></tr>";
									} else {
										echo "<tr><td><br></td><td><br></td><td><br></td></tr></table></td></tr>";
									}
								}
							}
							if (!isset($_GET['editCuisine'])&&!isset($_GET['ChangeImage'])) {
								echo "<tr><td align=\"center\"><button onclick=\"location.href='addCuisine.php'\">".$buttonTile[0]."</button></td></tr>";
							}
							echo "<tr><td align=\"center\"><button onclick=\"location.href='login_success.php'\">".$buttonTile[1]."</button></td></tr>";
						?>
					</table>
				</td>
				<td width="10%"></td>
			</tr>
		</table>
	</body>
</html>