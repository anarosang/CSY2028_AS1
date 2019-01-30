<?php require 'head.php';
//checks if the person is loggedin and saved the type of account
if (isset($_SESSION['loggedin'])) {
	$results = $pdo->query('SELECT username,type FROM users WHERE email = "' . $_SESSION['loggedin'] .'"');
	foreach($results as $row){
		$usertype = $row['type'];
	}
	//if it is an admin, it shows the forms and tables
	if ($usertype == 'admin') {
?>
<!--Product table-->
	<h2>Products</h2>
		    <table class="table-products">
		    <tr>
					<th>ID</th>
		      <th>Name</th>
		      <th>Description</th>
		      <th>Price</th>
					<th>Category</th>
		    </tr>
				<?php
					$server = 'v.je';
					$username = 'student';
					$password = 'student';
					$schema = 'as1';

					$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
					[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


						$results = $pdo->query('SELECT * FROM products');
						foreach($results as $row){
							echo '<tr>';
								echo '<td>' . $row['idproduct'] . '</td>';
								echo '<td>' . $row['name'] . '</td>';
								echo '<td>' . $row['description'] . '</td>';
								echo '<td>' . $row['price'] . '</td>';
								echo '<td>' . $row['category'] . '</td>';
							echo '</tr>';
						}
				?>
		  </table>
		</br>
		<!--Edit product form-->
		<h3>Edit</h3>
			<form action="admin.php" method="POST">
				<label> Product: </label>
				<select name="eproductID"><!--dropdow box with products names-->
					<option value=""></option>
					<?php
						$results = $pdo->query('SELECT * FROM products');
						foreach($results as $row){
							echo '<option value="' . $row['idproduct'] . '">' . $row['name'] . '</option>';
						}
					?>
				</select>

				<label>Select what you want to change:</label>
				<select name="field" > <!--dropdow box to choose the field-->
					<option value="name">Name</option>
					<option value="description">Description</option>
					<option value="price">Price</option>
					<option value="image">Image</option>
				</select>
				<input type="text" name="fieldInput"/><!--input for choose the field new text-->

				<label>Change category:</label><select name="categoriesChange"> <!--dropdow box to choose the new category-->
					<option value=""></option>
					<?php
						$results = $pdo->query('SELECT * FROM categories');
						foreach($results as $row){
							echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
						}
					?>
				</select>

				<input type="submit" value="Edit" name="productEdit" />
			</form>

		</br>

		<!--Add product form-->
		<h3>Add</h3>
			<form action="admin.php" method="POST">
				<label> Name: </label> <input type="text" name="productName" />

				<label> Image (url): </label> <input type="url" name="imageToUpload">

				<label> Description: </label> <textarea name="productDescription"></textarea>

				<label> Price: </label> <input type="number" name="productPrice" step=".01" />

				<label> Category: </label><select name="productCategories">
					<option value=""></option>
					<?php
						$results = $pdo->query('SELECT * FROM categories');
						foreach($results as $row){
							echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
						}
					?>
				</select>

			  <input type="submit" value="Add" name="productSubmit" />
			</form>

		</br>

		<!--Remove product form-->
		<h3>Remove</h3>
		<form action="admin.php" method="post">
			<label> Product: </label>
			<select name="removeProductID">
				<option value=""></option>
				<?php
					$results = $pdo->query('SELECT * FROM products');
					foreach($results as $row){
						echo '<option value="' . $row['idproduct'] . '">' . $row['name'] . '</option>';
					}
				?>
			</select>
			<input type="submit" value="Remove" name="productRemove"/>
		</form>

			<hr />
			<!--Categories table-->
			<h2>Categories</h2>
			<table class="table-products">
			<tr>
				<th>ID</th>
				<th>Name</th>
			</tr>
			<?php
					$results = $pdo->query('SELECT * FROM categories');
					foreach($results as $row){
						echo '<tr>';
							echo '<td>' . $row['idcategories'] . '</td>';
							echo '<td>' . $row['name'] . '</td>';
						echo '</tr>';
					}
			?>
		</table>
	</br>

	<!--Edit category form-->
	<h3>Edit</h3>
	<form action="admin.php" method="post">
		<label> Which category do you want to edit: </label><select name="categoriesChange">
			<option value=""></option>
			<?php
				$results = $pdo->query('SELECT * FROM categories');
				foreach($results as $row){
					echo '<option value="' . $row['idcategories'] . '">' . $row['name'] . '</option>';
				}
			?>

			<label>New name: </label> <input type="text" name="newCategory"/>

			<input type="submit" value="Edit" name="categoryEdit"/>
		</select>
	</form>

</br>

<!--Add category form-->
	<h3>Add</h3>
			<form action="admin.php" method="POST">
				<label> Name: </label> <input type="text" name="categoryName"/>

				<input type="submit" value="Add" name="categorySubmit" />
			</form>

</br>

<!--Remove category form-->
	<h3>Remove</h3>
	<form action="admin.php" method="post">
		<label> Which category do you want to remove: </label><select name="removeCategoryid">
			<!--<option value=""></option>-->
			<?php
				$results = $pdo->query('SELECT * FROM categories');
				foreach($results as $row){
					echo '<option value="' . $row['idcategories'] . '">' . $row['name'] . '</option>';
				}
			?>
			<input type="submit" value="Remove" name="categoryRemove"/>
	</form>

			<?php
			//Add product submit button action
			if (isset($_POST['productSubmit']) && isset($_POST['productName']) && isset($_POST['productDescription']) && isset($_POST['productPrice']) && isset($_POST['productCategories'])) {
				$productDate = date("Y-m-d");
				$results = $pdo->prepare('INSERT INTO products(name, description, price, category, insertdate, image) VALUES(:productName, :productDescription, :productPrice, :productCategories, "' . $productDate . '", :imageToUpload)');

				unset($_POST['productSubmit']);
				$results->execute($_POST);

				if($pdo){
					echo '<script>console.log("The category has been successfully inserted!")</script>';
					echo "<meta http-equiv='refresh' content='0'>";
				}
			}

			//Add category submit button action
			if(isset($_POST['categorySubmit']) && isset($_POST['categoryName'])){
				$results = $pdo->prepare('INSERT INTO categories(name) VALUES(:categoryName)');

				unset($_POST['categorySubmit']);
				$results->execute($_POST);

				if ($pdo) {
					echo '<script>console.log("The category has been successfully inserted!")</script>';
					echo "<meta http-equiv='refresh' content='0'>";
				}
			}

			//Edit product submit button action
			if (isset($_POST['productEdit']) && $_POST['eproductID'] != "") {
				if($_POST['fieldInput'] == "" && $_POST['categoriesChange'] != ""){
					$results = $pdo->query('UPDATE products SET category ="'. $_POST['categoriesChange'] .'" WHERE idproduct ="' . $_POST['eproductID'] .'"');
				}elseif ($_POST['fieldInput'] != "" && $_POST['categoriesChange'] != "") {
					$results = $pdo->query('UPDATE products SET ' . $_POST['field'] . '="' . $_POST['fieldInput'] .'", category ="'. $_POST['categoriesChange'] .'" WHERE idproduct ="' . $_POST['eproductID'] .'"');
				}elseif ($_POST['fieldInput'] != "" && $_POST['categoriesChange'] == "") {
					$results = $pdo->query('UPDATE products SET ' . $_POST['field'] . '="' . $_POST['fieldInput'] .'" WHERE idproduct ="' . $_POST['eproductID'] .'"');
				}

				if ($pdo) {
					//echo '<script>console.log("The product has been successfully updated!")</script>';
					echo "<meta http-equiv='refresh' content='0'>";
				}
			}

			//Remove product submit button action
			if (isset($_POST['removeProductID']) && isset($_POST['productRemove'])) {
				$results = $pdo->query('DELETE FROM products WHERE idproduct="'. $_POST['removeProductID'] .'" LIMIT 1');

				if ($pdo) {
					echo "<meta http-equiv='refresh' content='0'>";
				}
			}

			//Edit category submit button action
			if (isset($_POST['categoryEdit']) && $_POST['categoriesChange'] != "" && isset($_POST['newCategory'])) {
				$results = $pdo->query('UPDATE categories SET name="' . $_POST['newCategory'] .'" WHERE idcategories ="' . $_POST['categoriesChange'] .'"');

				if ($pdo) {
					echo "<meta http-equiv='refresh' content='0'>";
				}
			}

			//Remove category submit button action
			if (isset($_POST['categoryRemove'])) {
				$results = $pdo->query('DELETE FROM categories WHERE idcategories="'. $_POST['removeCategoryid'] .'" LIMIT 1');

				if ($pdo) {
					echo "<meta http-equiv='refresh' content='0'>";
				}
			}?>

		</main>

<!--admin footer-->
		<aside>
			<!--add featured product form-->
		  <form action="admin.php" method="post">
				<label>Select featured product</label>
		    <select name="featuredItem">
		      <option value=""></option>
		      <?php
		        $results = $pdo->query('SELECT * FROM products');
		        foreach($results as $row){
		          echo '<option value="' . $row['idproduct'] . '">' . $row['name'] . '</option>';
		        }
		      ?>
		    </select>

		    <input type="submit" value="Submit" name="submitFeatured" />
		  </form>

		  <?php //current featured product information
		    $results = $pdo->query('SELECT * FROM featured_product WHERE date=(SELECT MAX(date) FROM featured_product)');

		    foreach($results as $row){
		      echo '<h1><a href="https://v.je/assignment/product.php?name=' . $row['name'] .'">Featured Product</a></h1>';
		      echo '<p><strong>' . $row['name'] . '</strong></p>';
		      echo '<p>' . nl2br($row['description']) . '</p>';
		    }
		  ?>
		</aside>

		<footer>
		  &copy; Ed's Electronics 2018
		</footer>

		</body>

		</html>

		<?php
		//unset current featured product
		  if (isset($_POST['submitFeatured'])) {
		    $results = $pdo->query('SELECT * FROM products WHERE idproduct='. $_POST['featuredItem'].'');
		    foreach($results as $row){
		      $itemName = $row['name'];
		      $itemDescription = $row['description'];
		    }
		    $itemDate = date("Y-m-d");//current date
				//insert featured product form inputs
		    $insert = $pdo->query('INSERT INTO featured_product(name,description,date) VALUES("'. $itemName .'","'. $itemDescription .'","'. $itemDate .'")');

		    if ($pdo) {
		      echo "<meta http-equiv='refresh' content='0'>"; //refresh the page
		    }
		  }
		}else { //if the person isn't an admin, shows erro message
			echo "<p>This page couldn't be found!";
			require 'foot.php';
		}
	}else {//if the person isn't loggedin, shows erro message
		echo "<p>This page couldn't be found!";
		require 'foot.php';
	}
		?>
