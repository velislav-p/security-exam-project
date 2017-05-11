<?php
session_start();
require 'connection.php';
$user = $_POST["user"];
$pic = $_POST["image"];

$filename=basename($_FILES["image"]["name"]);
$target="images/$filename";
move_uploaded_file($_FILES["image"]["tmp_name"],$target);

$stmt = $connection -> prepare("UPDATE chatter_user SET ProfilePicture=:pic WHERE Id=:id");
$stmt -> bindValue(":pic",$pic);
$stmt -> bindValue(":id",$user);
$stmt->execute();