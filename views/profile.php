<?php
  session_start();
  error_reporting(0);

  if(!empty($_SESSION['user']))  {

    $username = $_SESSION['user'];

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

  <!-- Current user profile -->
  <div class="col" id="wdw-current-user-area">
    <div>
        <img src="profile" alt="$username" height="200" width="200" class="profilePicture">
    </div>

      <div class="wdw-profile-form form-group">
        <h4>Welcome to Chatter <?php echo $username ?></h4>
        <a type="button" id="description-btn" class="btn btn-warning" name="button">Add a description</a>
        <a type="button" id="logout-btn" href="../services/logout.php" class="btn btn-danger" name="button">Logout</a>
      </div>
      <div class="form-group">
          <form class="input-form" id="file-input-formgroup" action="../services/changeProfilePicture.php" method="post" enctype="multipart/form-data">
            <input type="file" name="img" value="">
            <input type="submit" value="Upload Image" name="submit" class="btn btn-warning">
          </form>
      </div>

  </div>
  <!-- Wall area -->
  <div class="col" id="wdw-wall-area">
    <div id="wall">

    </div>
    <div class="form-group" id="input-send-message-form">
        <form class="input-form" action="sendtext.php" method="post" enctype="multipart/form-data">
            <input type="text" id="messageSubmit" class="form-control" placeholder="Send a message">
            <input type="submit" value="Write test" name="submit" class="btn btn-warning">
        </form>
    </div>
  </div>
  <!-- Visiter area -->
  <div class="col" id="wdw-visiter-area">
    <div class="form-group">
      <input type="text" id="messageSubmit" class="form-control" placeholder="go somewhere else">
      <button type="button" id="btn-change-room" class="btn btn-warning" name="button">GO!</button>
    </div>
    <div id="wdw-visitor-img">
        <img src="profile" alt="visitor" height="200" width="200" class="profilePicture">
    </div>
  </div>

  </body>
</html>
