<?php

require 'services/connection.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
    $usernamePreEncode = $_POST['username'];
    $email = $_POST['email'];
    $passwordPreHash = $_POST['password'];

    $username = base64_encode($usernamePreEncode);
    $password = password_hash($passwordPreHash, PASSWORD_DEFAULT);

    $stmt = $connection -> prepare("INSERT INTO chatter_user(username, password, email) VALUES(:username, :password, :email)");
    $stmt -> bindValue(":username",$username);
    $stmt -> bindValue(":password",$password);
    $stmt -> bindValue(":email",$email);
    $stmt -> execute();

    session_start();

    $_SESSION["username"] = $username;
}

header("profile.php");

?>
