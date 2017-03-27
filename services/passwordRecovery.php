<?php

$correctUsername = "asd";
$correctPassword = "123";

$username = $_POST["username"];
$password = $_POST["password"];
$passwordConfirm = $_POST["passwordConfirm"];
$key = $_POST["key"];

// prepare statement for checking if username and key match the database


header("Location: http://localhost/SecurityProject/security-exam-project/views/passwordChanged.php");
