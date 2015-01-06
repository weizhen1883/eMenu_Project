<?php
	session_start();
	if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
		$editUsers="编辑用户";
		$editPositions="编辑职位";
		$editMenu="编辑菜单";
		$editCuisineList="编辑菜肴配方";
		$submitOrder="提交订单";
		$changeOrder="更改订单";
	} else {
		$editUsers="Edit Users";
		$editPositions="Edit Positions";
		$editMenu="Edit Menu";
		$editCuisineList="Edit Cuisines List";
		$submitOrder="Submit Order";
		$changeOrder="Change Order";
	}
	echo "<html><body><ul>";
	if ($_SESSION['userEditable'] == "Y") {
	 	echo "<li><a href=\"editUsers.php\">". $editUsers ."</a></li>";
	}
	if ($_SESSION['positionEditable'] == "Y") {
		echo "<li><a href=\"editPositions.php\">". $editPositions ."</a></li>";
	}
	if ($_SESSION['menuEditable'] == "Y") {
		echo "<li><a href=\"editMenu.php\">". $editMenu ."</a></li>";
	}
	if ($_SESSION['cuisineEditable'] == "Y") {
		echo "<li><a href=\"editCuisineList.php\">". $editCuisineList ."</a></li>";
	}
	if ($_SESSION['orderSubmitable'] == "Y") {
		echo "<li><a href=\"\">". $submitOrder ."</a></li>";
	}
	if ($_SESSION['orderChangeable'] == "Y") {
		echo "<li><a href=\"\">". $changeOrder ."</a></li>";
	}
	echo "</ul></body></html>";
?>