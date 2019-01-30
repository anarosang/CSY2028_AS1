<?php
require 'head.php';

	$server = 'v.je';
  $username = 'student';
  $password = 'student';
  $schema = 'as1';

  $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
      [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//this get the name of a product and show it's information
  if(isset($_GET['name'])){
		$results = $pdo->query('SELECT * FROM products WHERE name ="' . $_GET['name'] . '"');
    foreach($results as $row){
      $productid = $row['idproduct'];
      echo '<h3>' . $row['name'] . '</h3>';
			echo '<img src="'.$row['image'].'" width="400" height=auto>';
      echo '<div class="price">' . $row['price'] . '</div>';
      echo '<h4>Product details</h4>';
      echo '<p>' . nl2br($row['description']) . '</p>';
    }
  }

  echo '<hr />';
  echo '<h4>Product reviews</h4>';
  echo '<ul class="reviews">';
//this lists all the reviews of that product
  $stmt = $pdo->query('SELECT * FROM reviews WHERE idproduct = "' . $productid .'" ORDER BY reviewdate DESC');
  foreach($stmt as $row){
    echo '<li>';
    echo '<p>' . nl2br($row['reviewtext']) . '</p>';
    echo '<div class="details">';
    echo '<strong>' . $row['username'] . '</strong>';
    echo '  <i>' . $row['reviewdate'] .'</i>' ;
    echo '</div>';
    echo '</li>';
  }

	//share buttons of facebook, twitter and google+
	echo '<a
	href="http://www.facebook.com/sharer.php?u=https://v.je/assignment/product.php?name='.$_GET['name'].'"
	target="_blank"
	class="fa fa-facebook"
	title="Click to share">
 </a>';
  echo '</ul>';

//to save the current page url and id
    $actual_product = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_product_id = $productid;

		//if the person is loggedin saves the username and the type of account
      if (isset($_SESSION['loggedin'])) {
        $results = $pdo->query('SELECT username, type FROM users WHERE email = "' . $_SESSION['loggedin'] .'"');
        foreach($results as $row){
          $user = $row['username'];
					$type = $row['type'];
        }
				//if the person is a regular the form to add a review appears
				if ($type == "regular") {
					?>
			      <form action="product.php" method="POST">
			        <textarea id="reviewtext" name="reviewtext" style="width:100%;"></textarea>

			        <input type="submit" value="Add review" name="addReview" />
			        <?php
			        echo '<input type="hidden" name="product_url" value="' . $actual_product .'"/>';
			        echo '<input type="hidden" name="product_id" value="' . $actual_product_id . '"/>'; ?>
			      </form>
					<?php
				}
				//if, to add the review to the database
        if (isset($_POST['addReview'])) {
          $reviewquery = $pdo->query('INSERT INTO reviews(idproduct, reviewtext, username, reviewdate) VALUES("'. $_POST['product_id'] .'","'. $_POST['reviewtext'] .'","'. $user .'","' . date('Y-m-d') .'")');

					//if the insert was successful it refresh the current product page
          if($pdo){
            header("Location:" . $_POST['product_url']);
          }
        }
    }
		//to block the review textarea if the person isn't loggedin
    else {
      echo '<script language="javascript">';
      echo 'document.getElementById("reviewtext").disabled = true';
      echo '</script>';
      echo '<p>You can not write reviews without being loggedin!</p>';

    }

    echo require 'foot.php';
    ?>
