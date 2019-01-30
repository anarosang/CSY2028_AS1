<?php
require 'head.php';
//when the loging form button is pressed
  if (isset($_POST['submit'])) {
    //gets the information of the email inserted by the person
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $values = [ 'email' => $_POST['email'],];
    $stmt->execute($values);
    $user = $stmt->fetch();
    //checks if the password inserted matchs the email
    if (password_verify($_POST['password'], $user['password'])) {
      //if it matchs saves the user id (email) and goes to homepage
      $_SESSION['loggedin'] = $user['email'];
      header("Location: index.php");
    }else {
      //if it's wrong shows a erro message
      echo '<p>Sorry, your account could not be found.</p>';
    }
  }
  else {
 ?>
 <!--login form-->
<form action="login.php" method="POST">
  <label> Email: </label> <input type="text" name="email" />
  <label> Password: </label> <input type="password" name="password" />

  <input type="submit" value="Submit" name="submit" />
</form>

<?php
  }
  echo '<hr />';
//when the register form button is pressed
  if (isset($_POST['registe'])) {
    $server = 'v.je';
    $username = 'student';
    $password = 'student';
    $schema = 'as1';

    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
    [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $hash = password_hash($_POST['rPassword'], PASSWORD_DEFAULT); // to codify the passward inserted
    $results = $pdo->query('INSERT INTO users(email, username, password) VALUES("'. $_POST['rEmail'] .'","'. $_POST['rUsername'] .'","'. $hash .'")');
    header("Location: login.php");

  }else {
  ?>
  <!--Register form-->
  <form action="login.php" method="POST">
    <label> Username: </label> <input type="text" name="rUsername" />
    <label> Email: </label> <input type="text" name="rEmail" />
    <label> Password: </label> <input type="password" name="rPassword" />

    <input type="submit" value="Registe" name="registe" />
  </form>

<?php
  }
 ?>

<?php require 'foot.php'; ?>
