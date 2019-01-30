<?php
  session_start();
  //close the session started when login
  unset($_SESSION['loggedin']);
  //go back to homepage
  header("Location: index.php");
?>
