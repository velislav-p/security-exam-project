<?php

$correctUsername = "asd";
$correctPassword = "123";

$username = $_POST["username"];
$password = $_POST["password"];
$key = $_POST["key"];

echo $username.$password.$key;