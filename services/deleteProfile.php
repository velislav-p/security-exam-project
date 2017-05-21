<?php
$referer = $_SERVER["HTTP_REFERER"];
if ($referer !== "https://188.226.141.57/views/profile.php"){
    exit("unknown request origin");
} else {
    session_start();
    require "../protected/connection.php";
    require "../protected/functions.php";

    $profileToDelete = $_POST["hostId"];
    $admin = $_SESSION["user"];

    if ($profileToDelete == $admin->host->id)
    {
        $stmt = $connection->prepare("SELECT * FROM chatter_user WHERE Id = :id");
        $stmt->bindvalue(":id", $admin->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row["Admin"] == 1){
            $stmt = $connection->prepare("DELETE FROM chatter_user WHERE Id = :hostId AND Admin = 0");
            $stmt->bindvalue(":hostId", $profileToDelete);
            $stmt->execute();
            header("Location: ../views/profile.php");
        } else {
            header("Location: ../views/genericpffttr.html");
        }
    }
}