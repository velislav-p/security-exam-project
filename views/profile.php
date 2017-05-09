<?php
  session_start();
  // error_reporting(0);

  if(!empty($_SESSION['username']))  {

    $username = base64_decode($_SESSION['username']);

  }else{
    session_destroy();

    // header("Location: ../index.html");
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to your profile!</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <!-- StyleSheet -->
    <link rel="stylesheet" href="../style/style.css">
  </head>
  <body>

  <div>
      <img src="profile" alt="$username" height="200" width="200" class="profilePicture">
  </div>

    <div class="wdw-profile-form form-group">
      <h4>Welcome to Chatter <?php echo $username ?></h4>
      <a type="button" class="btn btn-warning" name="button">Start a new room</a>
      <a type="button" class="btn btn-warning" name="button">Change your profile</a>
      <a type="button" href="../services/logout.php" class="btn btn-danger" name="button">Logout</a>
    </div>
    <div class="form-group">
        <form class="input-form" action="../services/ChangeProfilePicture.php" method="post" enctype="multipart/form-data">
            <input type="file" name="FileToUpload" id="FileToUpload" class="btn btn-warning">
            <input type="submit" value="Upload Image" name="submit" class="btn btn-warning">
        </form>
    </div>

  </body>
</html>
