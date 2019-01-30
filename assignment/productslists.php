<?php
	require 'head.php';

	$server = 'v.je';
  $username = 'student';
  $password = 'student';
  $schema = 'as1';

  $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
      [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	echo '<ul class="products">';
//this if list all the products of a category defined by the user
  if(isset($_GET['category'])){
		$results = $pdo->query('SELECT * FROM products WHERE category ="' . $_GET['category'] . '" ORDER BY insertdate DESC');
    foreach($results as $row){
			echo '<li>';
			echo '<h3><a href="https://v.je/assignment/product.php?name=' . $row['name'] .'">' . $row['name'] . '</a></h3>';
      echo '<p>' . $row['description'] . '</p>';
      echo '<div class="price">' . $row['price'] . '</div>';
      echo '</li>';
    }
		echo '</ul>';
  }
//this if list all products whit names similar to what was inserted in the search box
	else if(isset($_GET['search'])) {
		$results = $pdo->query('SELECT * FROM products WHERE name like "%' . $_GET['search'] . '%" ORDER BY insertdate DESC');
    foreach($results as $row){
			echo '<li>';
			echo '<h3><a href="https://v.je/assignment/product.php?name=' . $row['name'] .'">' . $row['name'] . '</a></h3>';
      echo '<p>' . $row['description'] . '</p>';
      echo '<div class="price">' . $row['price'] . '</div>';
      echo '</li>';
    }
		echo '</ul>';
  }


	require 'foot.php';
?>
