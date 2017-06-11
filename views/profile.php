<?php
require "../protected/connection.php";
require "../protected/functions.php";
session_start();
$user = $_SESSION['user'];

// error_reporting(0);
$profileId = "";
if(!empty($_POST['visit-user-id']) && (!empty($_SESSION['user']))){

    $hostUsername = $_POST['visit-user-id'];

    $hostUsername = filter_var($hostUsername, FILTER_SANITIZE_STRING);


    $stmt = $connection->prepare("SELECT * FROM chatter_user WHERE Username = :hostUser");
    $stmt->bindvalue(":hostUser", $hostUsername);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($count == 0) {

        $sorry =  "Sorry, no friend was found";

        $user = $_SESSION['user'];

        $name = htmlentities($user->username);
        $description = htmlentities($user->description);
        $image = $user->profilePicture;
        $profileId = $user->id;

    }else {

        $host = new stdClass();

        $host->username = htmlentities($row["Username"]);
        $host->profilePicture = $row["ProfilePicture"];
        $host->description = htmlentities($row["ProfileDescription"]);
        $host->id = $row["Id"];

        $user->host = $host;

        $name = $user->host->username;
        $description = $user->host->description;
        $image = $user->host->profilePicture;

        $visitorName = htmlentities($user->username);
        $visitorDescription = htmlentities($user->description);
        $visitorImage = "<img src='../images/".$user->profilePicture."' alt='visitor' height='400' width='400' class='profilePicture'>";

        $profileId = $host->id;
    }

}else if(!empty($_SESSION['user'])){

    $user = $_SESSION['user'];
    $name = htmlentities($user->username);
    $description = htmlentities($user->description);
    $image = $user->profilePicture;
    $profileId = $user->id;

}else {
    session_destroy();
    header("Location: ../");
}

$stmt = $connection->prepare("SELECT * FROM message, chatter_user WHERE (message.receiver_id = :hostUser OR message.sender_id = :hostUser) AND chatter_user.Id = message.sender_id");
$stmt->bindValue(":hostUser", $profileId);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();
if ($count == 0) {
    $messageSorry = "This wall is still empty";
}else{
    $allMessages = $rows;
}

$formDeleteProfile = "";
if($user->admin==1){
    $idToDelete = $user->host->id;
    $formDeleteProfile = "<div class='form-group'>
        <form class='input-form' id='delete-input-formgroup' action='../services/deleteProfile.php' method='post'>
            <input type='hidden' id='hostId' name='hostId' value='$idToDelete'>
            <input type='submit' value='Delete user' name='submit' class='btn btn-danger'>
        </form>
    </div>";
}

//header('Content-type: image/jpg;');
//$p = "../images/Untitled.jpg";
//$a = file_get_contents($p);
//echo $a;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to your profile!</title>
    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
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
    <div id="user-profile-picture">
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
            <input type="file" name="image">
            <input type="submit" value="Upload Image" name="submit" class="btn btn-warning">
        </form>
    </div>
    <?php echo $formDeleteProfile ?>
</div>

<!-- Wall area -->
<div class="col" id="wdw-wall-area">
    <div id="wall">
        <?php echo $messageSorry ?>
        <?php
        foreach($allMessages as $singleMessage => $items){
            echo "<div><p class='wallMessage'>".$items["Username"]." says: </p><p class='wallMessage'>" .$items["content"]."</p></div>";
        }
        ?>

    </div>
    <div class="form-group" id="input-send-message-form">
        <form id="messageForm" class="input-form" action="../services/sendMessage.php" method="post" enctype="multipart/form-data">
            <input type="text" id="message" name="message" class="form-control" placeholder="Send a message" required>
            <input type="submit" value="Send message" name="submit" class="btn btn-warning">
        </form>
    </div>
</div>

<!-- Visiter area -->
<div class="col" id="wdw-visiter-area">
    <h5><?php echo $sorry  ?></h5>
    <div class="form-group">
        <form class="input-form" id="theGoForm" action="profile.php" method="post">
            <input type="text" name="visit-user-id" id="visit-Input-field" class="form-control" placeholder="go somewhere else">
            <input type="submit" value="GO!" id="btn-change-room" class="btn btn-warning" name="button">
        </form>
    </div>
    <h3><?php echo $visitorDescription ?></h3>
    <div id="wdw-visitor-img">
        <?php echo $visitorImage ?>
    </div>
</div>

<script type="text/javascript">
        var test="";
        var frm = $("#messageForm");
        frm.submit(function (ev) {
            var message = $("#message").val();
            $.ajax({
                "method":"POST",
                "url":"../services/sendMessage.php",
                "data": {"message":message},
                "dataType": "JSON",
                "cache":false
            }).done(function(jData){
                $("#wall").append("<div><p class='wallMessage'>"+jData.user+" says:</p><p class='wallMessage'>" +jData.message+"</p></div>");
                $("#message").val("");
            });
            ev.preventDefault();
        });
</script>
</body>
</html>
