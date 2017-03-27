<?php
  session_start();


  if(isset($_SESSION['username'] && $_SESSION['password'])  ){

    $username = base64_decode($_SESSION['username']);

  }else{
    session_destroy();

    header("index.html");
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to your profile <?php print $username; ?></title>
  </head>
  <body>

  </body>
</html>
