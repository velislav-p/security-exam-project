<?php
  session_start();


  if(isset($_SESSION['username']))  {

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
    <title>Welcome to your profile!</title>
  </head>
  <body>
    <h2>HALLOOOOOOO AND WELCOME <?php print $username; ?></h2>
  </body>
</html>
