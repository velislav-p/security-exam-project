<?php
$referer = $_SERVER["HTTP_REFERER"];
if ($referer !== "https://188.226.141.57/views/profile.php"){
    exit("unknown request origin");
} else {
    session_start();
    require "../protected/connection.php";
    require "../protected/functions.php";

    if (!empty($_POST['description'])) {
        $desc = $_POST['description'];
        $user = $_SESSION['user'];

        $desc = htmlentities($desc);

        $user->description = $desc;
        $UserId = $user->id;

        echo $desc;
        echo $UserId;

        $stmt = $connection->prepare("UPDATE chatter_user SET ProfileDescription=:desc WHERE Id=:id");
        $stmt->bindValue(":desc", $desc);
        $stmt->bindValue(":id", $UserId);
        $stmt->execute();

        header("Location: ../views/profile.php");
    } else {
        header("Location: ../views/profile.php");
    }
}