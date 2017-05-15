<?php
require 'connection.php';
session_start();
$filename=basename($_FILES["image"]["name"]);
$user = $_SESSION["user"];
$userId = $user->id;
$userName = $user->username;
$userEmail = $user->email;


$user->profilePicture = $filename;
$_SESSION["user"] = $user;

$target="../images/$filename";
$moved = move_uploaded_file($_FILES["image"]["tmp_name"],$target);

if( $moved ) {
    $stmt = $connection -> prepare("UPDATE chatter_user SET ProfilePicture=:pic WHERE Id=:id");
    $stmt -> bindValue(":pic",$filename);
    $stmt -> bindValue(":id",$userId);
    $stmt->execute();
    header("Location: ../views/profile.php");
} else {
    echo "File NOT uploaded. Please try with a smaller file";
}




