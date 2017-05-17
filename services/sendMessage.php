<?php
session_start();
require("connection.php");
require("functions.php");

$message = $_POST["message"];
$user = $_SESSION["user"];

$receiverId = $user->host->id;
$senderId = $user->id;
$messageId = md5(getGUID());

//check for message length
echo $receiverId."`````";
echo $message."``````";
echo $senderId."``````";
echo $messageId."``````";



$stmt = $connection->prepare("INSERT INTO message(Id,receiver_id,sender_id,content) VALUES(:id,:receiver,:sender,:message)");
$stmt->bindValue(":id",$messageId);
$stmt->bindValue(":receiver",$receiverId);
$stmt->bindValue(":sender",$senderId);
$stmt->bindValue(":message",$message);
$stmt->execute();

//header("Location: ../views/profile.php");

