<?php


/* GET Title cunction */
function getTitle(){
	global $pageTitle;
	if(isset($pageTitle)){
		echo $pageTitle;
	}
}


/* Get Members Count */
function getCount($selectedField, $table){
	global $conn;
	$sql = "SELECT $selectedField FROM $table";
	$result = $conn->query($sql);
	$row = mysqli_num_rows($result);
	return $row;
}

/* Get Members Count */
function getPenddingCount($selectedField, $table, $condition){
	global $conn;
	$sql = "SELECT $selectedField FROM $table WHERE $condition = 0 ";
	$result = $conn->query($sql);
	$row = mysqli_num_rows($result);
	return $row;
}

/* Get Latest Numbers */

?>