<?php require 'head.php' ?>
			<h1>Welcome to Ed's Electronics</h1>

			<p>We stock a large variety of electrical goods including phones, tvs, computers and games. Everything comes with at least a one year guarantee and free next day delivery.</p>

			<hr />
		</br>

			<?php
				$server = 'v.je';
				$username = 'student';
				$password = 'student';
				$schema = 'as1';

				$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
						[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
				echo '<ul class="products">';

				$results = $pdo->query('SELECT * FROM products ORDER BY insertdate DESC'); // to list all products from the most recent to the older

				foreach($results as $row){
					echo '<li>';
					echo '<h3><a href="https://v.je/assignment/product.php?name=' . $row['name'] .'">' . $row['name'] . '</a></h3>';
					echo '<p>' . $row['description'] . '</p>';
					echo '<div class="price">' . $row['price'] . '</div>';
					echo '</li>';
				}

				echo '</ul>';

			require 'foot.php'; ?>
