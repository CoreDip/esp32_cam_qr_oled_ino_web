<?php
$mysqli = new mysqli("localhost", "root", "root", "db_item");
$mysqli->query("SET NAMES 'utf8'");
//получаю данные с базы и записываю в масивы
$i=0;
$result = $mysqli->query('SELECT * FROM `items`');
	while(($row = $result->fetch_assoc()) !== null){
	$i++;
	$item[$i]=$row['name'];
	$prices[$i]=$row['price'];
}

if (isset($_GET['id'])){
	$id=$_GET['id'];
	if($_GET['type'] == "itemname"){
		echo($item[$id]);
	}
	if($_GET['type'] == "price"){
		echo($prices[$id]);
	}
}



?>