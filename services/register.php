<?php

// connection to the server
require 'connection.php';

//Check if session is set
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
    $usernamePreEncode = $_POST['username'];
    $email = $_POST['email'];
    $passwordPreHash = $_POST['password'];

    // Sanitize password
    if (filter_var($passwordPreHash, FILTER_SANITIZE_STRING) === false) {
      echo("password is not valid");
      header("../views/register.html");
    }

    // Sanitize username
    if (filter_var($usernamePreEncode, FILTER_SANITIZE_STRING) === false) {
      echo("password is not valid");
      header("../views/register.html");
    }

    // Remove all illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    // Validate e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      // Email is valid ??
    } else {
        echo("Email address is not valid");
        header("../views/register.html");
    }

    // Encode username
    $username = base64_encode($usernamePreEncode);
    // Hash password
    $password = md5($passwordPreHash);

    // Prepare and execute sql statement
    $stmt = $connection -> prepare("INSERT INTO chatter_user(username, password, email) VALUES(:username, :password, :email)");
    $stmt -> bindValue(":username",$username);
    $stmt -> bindValue(":password",$password);
    $stmt -> bindValue(":email",$email);
    $stmt -> execute();

    session_start();

    $_SESSION["username"] = $username;

    header("Location: ../views/profile.php");
}

header("profile.php");

?>
