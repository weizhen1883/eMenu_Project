<?php
	session_start();
	echo "<html><body><ul>";
	if ($_SESSION['userEditable'] == "Y") {
	 	echo "<li><a href=\"editUsers.php\">Edit Users</a></li>";
	}
	if ($_SESSION['positionEditable'] == "Y") {
		echo "<li><a href=\"editPositions.php\">Edit Positions</a></li>";
	}
	if ($_SESSION['menuEditable'] == "Y") {
		echo "<li><a href=\"editMenu.php\">Edit Menu</a></li>";
	}
	if ($_SESSION['cuisineEditable'] == "Y") {
		echo "<li><a href=\"editCuisineList.php\">Edit Cuisines List</a></li>";
	}
	if ($_SESSION['orderSubmitable'] == "Y") {
		echo "<li><a href=\"\">Submit Order</a></li>";
	}
	if ($_SESSION['orderChangeable'] == "Y") {
		echo "<li><a href=\"\">Change Order</a></li>";
	}
	echo "</ul></body></html>";
?>