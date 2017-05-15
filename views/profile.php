<?php
  require '../services/connection.php';
  session_start();
  $user = $_SESSION['user'];
  // error_reporting(0);
  if(!empty($_POST['visit-user-id']) && (!empty($_SESSION['user']))){

    $hostUsername = $_POST['visit-user-id'];

    $stmt = $connection->prepare("SELECT * FROM chatter_user WHERE Username = :hostUser");
    $stmt->bindvalue(":hostUser", $hostUsername);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($count == 0) {

      $sorry =  "sorry, no friend was found";

      $user = $_SESSION['user'];
      $name = $user->username;
      $description = $user->description;
      $image = $user->profilePicture;

    }else {

      $host = new stdClass();

      $host->username = $row["Username"];
      $host->profilePicture = $row["ProfilePicture"];
      $host->description = $row["ProfileDescription"];
      $host->id = $row["Id"];

      $user->host = $host;

      $name = $user->host->username;
      $description = $user->host->description;
      $image = $user->host->profilePicture;

      $visitorName = $user->username;
      $visitorDescription = $user->description;
      $visitorImage = $user->profilePicture;
    }

  }else if(!empty($_SESSION['user'])){

    $user = $_SESSION['user'];
    $name = $user->username;
    $description = $user->description;
    $image = $user->profilePicture;

  }else {

    //session_destroy();

    //header("Location: ../index.html");

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
        <img src="../images/<?php echo $image ?>" alt="userImg" height="400" width="400" class="profilePicture">
    </div>

      <div class="wdw-profile-form form-group">
        <h4>Welcome to Chatter <?php echo $name ?></h4>
        <h3><?php echo $description ?></h3>
        <form class="input-form" id="description-input-form" action="../services/description.php" method="post">
          <input type="text" class="form-control" name="description" placeholder="Add a new description">
          <button type="submit" id="description-btn" class="btn btn-warning" name="button">Add description</button>
        </form>
        <a type="button" id="logout-btn" href="../services/logout.php" class="btn btn-danger" name="button">Logout</a>
      </div>
      <div class="form-group">
          <form class="input-form" id="file-input-formgroup" action="../services/changeProfilePicture.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image" value="">
            <input type="submit" value="Upload Image" name="submit" class="btn btn-warning">
          </form>
      </div>

  </div>
  <!-- Wall area -->
  <div class="col" id="wdw-wall-area">
    <div id="wall">

    </div>
    <div class="form-group" id="input-send-message-form">
        <form class="input-form" action="../services/sendMessage.php" method="post" enctype="multipart/form-data">
            <input type="text" id="message" name="message" class="form-control" placeholder="Send a message">
            <input type="submit" value="Write test" name="submit" class="btn btn-warning">
        </form>
    </div>
  </div>
  <!-- Visiter area -->
  <div class="col" id="wdw-visiter-area">
    <h5><?php echo $sorry  ?></h5>
    <div class="form-group">
      <form class="input-form" action="profile.php" method="post">
        <input type="text" name="visit-user-id" id="visit-Input-field" class="form-control" placeholder="go somewhere else">
        <input type="submit" value="GO!" id="btn-change-room" class="btn btn-warning" name="button">
      </form>
    </div>
    <div id="wdw-visitor-img">
        <img src="../images/<?php echo $userimage ?>" alt="visitor" height="400" width="400" class="profilePicture">
    </div>
  </div>

  </body>
</html>
