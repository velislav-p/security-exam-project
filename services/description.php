<?php
session_start();
require 'connection.php';

if (!empty($_POST['description']))
{
  $desc = $_POST['description'];
  $user = $_SESSION['user'];

  $user->description = $desc;
  $UserId = $user->id;

  echo $desc;
  echo $UserId;

  $stmt = $connection -> prepare("UPDATE chatter_user SET ProfileDescription=:desc WHERE Id=:id");
  $stmt -> bindValue(":desc",$desc);
  $stmt -> bindValue(":id",$UserId);
  $stmt->execute();

  header("Location: ../views/profile.php");
}else{
  echo "sorry bob";
}
