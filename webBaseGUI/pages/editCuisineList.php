<?php
	define("Image_DIR", "/var/www/sources/cuisines/photos/");
	define("Intro_DIR", "/var/www/sources/cuisines/intros/");
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['cuisineEditable'] == "N") {
        header("location:login.php");
    }

    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	if (isset($_GET['DoneEditCuisine'])) {
		$intro = $_POST['description'];
		$cuisineName=$_POST['cuisineName'];

		$sql="SELECT * FROM cuisinelist WHERE cuisineName='$cuisineName'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);

		$f = fopen(Intro_DIR.$row['description'], "w");
		fwrite($f, $intro);
		fclose($f);

		header("location:editCuisineList.php");
	}

	if (isset($_GET['DoneChangeImage'])) {
		$cuisineName=$_GET['cuisineName'];
		$sql="SELECT * FROM cuisinelist WHERE cuisineName='$cuisineName'";
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
				$sql="UPDATE cuisinelist SET cuisineImage='$cuisineImage' WHERE cuisineName='$cuisineName'";
				$result=mysql_query($result);
			}
		}
		header("location:editCuisineList.php");
	}

	if (isset($_GET['Delete'])) {
		$cuisineName=$_GET['cuisineName'];
		$sql="SELECT * FROM cuisinelist WHERE cuisineName='$cuisineName'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);

		unlink(Image_DIR.$row['cuisineImage']);
		unlink(Intro_DIR.$row['description']);

		$sql="DELETE FROM cuisinelist WHERE cuisineName='$cuisineName'";
		$result=mysql_query($sql);

		header("location:editCuisineList.php");
	}
?>
<html>
	<head>
		<title>Cuisine List Edit</title>
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
						<tr><td align="center">Cuisine List</td></tr>
						<?php
							$sql="SELECT * FROM cuisinelist";
							$result=mysql_query($sql);
							while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
								$f=fopen("../sources/cuisines/intros/".$row['description'], "r");
								$description=fgets($f);
								fclose($f);

								echo "<tr><td align=\"center\"><table border=\"1\" width=\"100%\"><form name=\"". $row['cuisineName'] ."\" action=\"editCuisineList.php?cuisineName=". $row['cuisineName'] ."&DoneEditCuisine\" method=\"post\"><tr>
								<td width=\"200px\" align=\"center\" valign=\"top\"><img src=\"../sources/cuisines/photos/". $row['cuisineImage'] ."\" width=\"200px\"></td>";
								if (isset($_GET['editCuisine'])&&$_GET['cuisineName']==$row['cuisineName']) {
									echo "<td width=\"700px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td><input type=\"text\" name=\"cuisineName\" value=\"". $row['cuisineName'] ."\"  class=\"cleardefault\"><br><hr /></td></tr>
									<tr><td width=\"700px\" height=\"150px\" valign=\"top\"><textarea name=\"description\" style=\"width: 500px; height: 150px;\">". $description ."</textarea></td></tr></table></td>";
									echo "<td width=\"100px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td align=\"center\"><input type=\"submit\" name=\"Change\" value=\"Change\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName'] ."&ChangeImage'\" value=\"Change Image\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName'] ."&Delete'\" value=\"Delete\"></td></tr><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php'\" value=\"Cancel\"></td></tr></table></td>";
								} else {
									echo "<td width=\"700px\" align=\"center\" valign=\"top\"><table width=\"100%\"><tr><td>". $row['cuisineName'] ."<br><hr /></td></tr><tr><td width=\"700px\" height=\"150px\"  valign=\"top\">". $description ."</td></tr></table></td>";
									echo "<td width=\"100px\" align=\"center\" valign=\"top\">";
									if (isset($_GET['ChangeImage'])&&$_GET['cuisineName']==$row['cuisineName']) {
										echo "<table width=\"100%\"><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php'\" value=\"Cancel\"></td></tr></table></td>";
									} else {
										echo "<table width=\"100%\"><tr><td align=\"center\"><input type=\"button\" onclick=\"location.href='editCuisineList.php?cuisineName=". $row['cuisineName'] ."&editCuisine'\" value=\"Edit\"></td></tr><tr><td></td></tr><tr><td></td></tr></table></td>";
									}
								}
								echo "</tr></form>";
								if (isset($_GET['ChangeImage'])&&$_GET['cuisineName']==$row['cuisineName']) {
									echo "<form name=\"". $row['cuisineName'] ."_changeImage\" method=\"post\" action=\"editCuisineList.php?cuisineName=". $row['cuisineName'] ."&DoneChangeImage\" enctype=\"multipart/form-data\"><tr><td></td><td><input type=\"file\" name=\"imageFile\"><input type=\"submit\" name=\"changeImage\" value=\"Change Image\"></td><td><br></td></tr></form></table></td></tr>";
								} else {
									echo "<tr><td><br></td><td><br></td><td><br></td></tr></table></td></tr>";
								}
							}
							if (!isset($_GET['editCuisine'])&&!isset($_GET['ChangeImage'])) {
								echo "<tr><td align=\"center\"><button onclick=\"location.href='addCuisine.php'\">Add</button></td></tr>";
							}
							echo "<tr><td align=\"center\"><button onclick=\"location.href='login_success.php'\">Go Back</button></td></tr>";
						?>
					</table>
				</td>
				<td width="10%"></td>
			</tr>
		</table>
	</body>
</html>