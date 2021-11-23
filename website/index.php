<!DOCTYPE HTML>
<html>
	<head>
		<title>Esp32 QR ItemShop</title>
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		</head>
	<body>	
		<?php
		if(!isset($_GET['page'])) $_GET['page'] = 1;
		$page=$_GET['page'];
		$mysqli = new mysqli("localhost", "root", "root", "db_item");
		$mysqli->query("SET NAMES 'utf8'");
		//создаю таблицю якщо не існує
		$mysqli->query("CREATE TABLE IF NOT EXISTS items (`id` INT(5) NOT NULL AUTO_INCREMENT, `name` VARCHAR(50), `price` INT(5), PRIMARY KEY(`id`), INDEX(`name`));");
		//создаю таблицю якщо не існує

		//записую в базу якщо передано товар
		if(isset($_GET['name']) && isset($_GET['price']) ){
			if(isset($_GET['addpage'])){$mysqli->query("INSERT INTO items  VALUES (NULL,'".$_GET['name']."', '".$_GET['price']."');" );}
		}

		//якщо потрібно змінити запис
		if( isset($_GET['name']) && isset($_GET['0']) ){
			if(isset($_GET['redactpage'])){$mysqli->query("UPDATE items SET name = '".$_GET['name']."', price = '".$_GET['0']."' WHERE id = '".$page."'");}
		}

		//якщо потрібно видалити запис
		if(isset($_GET['delete'])){
			$mysqli->query("DELETE from items where id='".$page."';");
			$page=1;
			//переінкремент
			$mysqli->query("SET @i :=0");
			$mysqli->query("UPDATE `items` SET  `id` = (@i := @i + 1)");
			$mysqli->query("ALTER TABLE `items` AUTO_INCREMENT = 1");
			//переінкремент
		}
		//якщо потрібно видалити запис

		//отримую дані с бази и записую в масиви
		$i=0;
		$result = $mysqli->query('SELECT * FROM `items`');
			while(($row = $result->fetch_assoc()) !== null){
				$i++;
				$item[$i]=$row['name'];
				$prices[$i]=$row['price'];
		}
		//отримую дані с бази и записую в масиви
		$pages=$result->num_rows;

		$body = "<br><br>
		
		<form style='display: inline;'>
		  <button class='navbut' formaction='index.php' name='page' value='" . ($page - 1) . "'" . ($page-1 ?: "disabled" ) . ">      &lt      </button>
		</form>

		<form style='display: inline;'>
		  <button class='navbut' formaction='index.php' name='page' value='" . (($page == $pages) ?: $page + 1) . "'" . (($page != $pages) ?: "disabled") . ">      &gt      </button>
		</form><br><br>
		
		<form style='display: inline;' name='editor' action='index.php' method='get'>
		<table class='t1' border='1' cellspacing='0' cellpadding='5'>
		<tr><th > ID: </th><th ><input name='name' type='text' width='40' value='".$page."'></th></tr>
		<tr><th > Назва: </th><th ><input name='name' type='text' width='40' value='".$item[$page]."'></th></tr>
		<tr><th > Ціна: </th><th ><input name='0' type='text' width='40' value='".$prices[$page]."'></th></tr>";
		$body .= "";
	

		$body .= "<th colspan='2'><input type='hidden' name='page' value='" . $page ."'>
		<input class='buttons' name='redactpage' type='submit' width='40' value='Редагувати поточний'></input>
		</form>
		<form style='display: inline;'>
		<input type='hidden' name='page' value='" . $page . "'>
		<button class='buttons' formaction='index.php' type='submit' name='delete'>Видалити поточний</button>
		</form></th></table>";

		$sender = "<h1>Додати товар:</h1>
		<form name='sender' action='index.php' method='get' >
		<table border='1' cellspacing='0' cellpadding='5'>
		<tr>
			<th >ID:</th>
			<th ><input name='name' type='text' width='40' value=". ($pages+1) ." readonly></th>
		</tr>
		<tr>
			<th >Назва:</th>
			<th ><input name='name' type='text' width='40'></th>
		</tr>
		<tr>
			<th>Ціна</th>
			<th><input name='price' type='text' width='40'></th>
		</tr>
		</table><br>
		<input type='hidden' name='page' value='" . ($pages+1) ."'>
		<br>
		<input class='buttons2' name='addpage' type='submit' width='40' value='Додати'>
		</form>";

		?>
			<center>
				<div id="output"></div>
				<div><?php echo($body); ?></div>
				<div><?php echo($sender); ?></div>
			<center>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
				<script type="text/javascript" src="lib/jquery.qrcode.min.js"></script>
				<script>
					jQuery(function(){
						jQuery('#output').qrcode('<?=$page?>');
					})
		</script>
	</body>
</html>
