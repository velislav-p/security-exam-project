
<?php
$referer = $_SERVER["HTTP_REFERER"];
if ($referer !== "https://188.226.141.57/views/profile.php"){
    exit("unknown request origin");
} else {
    session_start();
    require("connection.php");
    require("functions.php");

    $message = $_POST["message"];
    $user = $_SESSION["user"];

    $message = htmlentities($message);

    $receiverId = $user->host->id;
    $senderId = $user->id;
    $messageId = md5(getGUID());

    $stmt = $connection->prepare("INSERT INTO message(Id,receiver_id,sender_id,content) VALUES(:id,:receiver,:sender,:message)");
    $stmt->bindValue(":id", $messageId);
    $stmt->bindValue(":receiver", $receiverId);
    $stmt->bindValue(":sender", $senderId);
    $stmt->bindValue(":message", $message);
    $stmt->execute();

    echo '{"user":"' . $user->username . '","message":"' . $message . '"}';


}
