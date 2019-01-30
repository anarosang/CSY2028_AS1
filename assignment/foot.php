</main>

<aside>
  <?php
  $server = 'v.je';
  $username = 'student';
  $password = 'student';
  $schema = 'as1';

  $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
  [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $results = $pdo->query('SELECT * FROM featured_product WHERE date=(SELECT MAX(date) FROM featured_product)');//select the most recent product in the featured_product table
    //and shows it
    foreach($results as $row){
      echo '<h1><a href="https://v.je/assignment/product.php?name=' . $row['name'] .'">Featured Product</a></h1>';
      echo '<p><strong>' . $row['name'] . '</strong></p>';
      echo '<p>' . nl2br($row['description']) . '</p>';
    }
  ?>
</aside>

<footer>
  Ana Rosa Gaspar &copy; Ed's Electronics 2018
</footer>

</body>

</html>
