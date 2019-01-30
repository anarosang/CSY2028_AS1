<!doctype html>
<html>
	<head>
		<title>Ed's Electronics</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="electronics.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>
		<header>
			<h1>Ed's Electronics</h1>

<!--menu list-->
			<ul>
				<li><a href="https://v.je/assignment/index.php">Home</a></li>
				<li>Products
					<?php
						$server = 'v.je';
						$username = 'student';
						$password = 'student';
						$schema = 'as1';

						$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
								[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
						echo '<ul>';

						//gets all categories in the database and show it as sub-menu of products
							$results = $pdo->query('SELECT * FROM categories');
							foreach($results as $row){
								echo '<li><a href="https://v.je/assignment/productslists.php?category=' . $row['name'] .'">' . $row['name'] . '</a></li>';
							}

						echo '</ul>';
						echo '</li>';
					?>
				<li><a href="https://v.je/assignment/admin.php" id="adminArea" style="visibility:hidden;">Admin area</a></li> <!--hidden menu option for admin-->

			</ul>

			<address>
				<p>We are open 9-5, 7 days a week. Call us on
					<strong>01604 11111</strong>
				</p>
				<br>
				<div class="sessionlog">
					<?php
					session_start();
					//checks if the person is loggedin and
					if (isset($_SESSION['loggedin'])) {
						// if is, saves that user name and its type and shows a Welcome message and logout option
						$results = $pdo->query('SELECT username,type FROM users WHERE email = "' . $_SESSION['loggedin'] .'"');
						foreach($results as $row){
							$username = $row['username'];
							$usertype = $row['type'];
						}
						echo '<i>Welcome ' . $username . '!</i> ';
						echo '<a href="logout.php">Logout</a>';
					//if the user is and admin, changes the admin option on the menu to visible
					if ($usertype == 'admin') {
							echo '<script language="javascript">';
				      echo 'document.getElementById("adminArea").style.visibility = "visible";';
				      echo '</script>';
						}
					}
					else {//if the person isn't loggedin show a link to login
						echo '<a href="login.php">Login</a>';
					}
					?>
				</div>
			</address>

		</header>
		<section></section>
		<main>
			<!--search product form-->
			<div class="search-container">
				<form action="" method="post">
			    <input type="text" name="searchText" placeholder="Products search.."/>
			    <button type="submit" name="search"><i class="fa fa-search"></i></button>
			  </form>
			</div>
		<?php
		//if search form button is pressed and the input is not blank
		  if (isset($_POST['search'])) {
		    if($_POST['searchText'] != ""){
		      header("Location: productslists.php?search=" . $_POST['searchText'] ); //go to productslists
		    }
		  }
		?>
