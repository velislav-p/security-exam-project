<?php
require 'connection.php';
//$username = $_POST["username"];
//$password = $_POST["password"];
//$passwordConfirm = $_POST["passwordConfirm"];
$key = "XzpYu+B897143eUGDO9FVAuGaNXM0TIFRCaqfbQ7gGdmdWNreW913/FD9LaN65Dri1YDpbVq1Y1SjxDKK645BYcvWmUv+Po=";
$email = "m@m.m";

$stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
$stmt -> bindValue(":email", $email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$secret_key = md5($row["ID"]);

$key_decoded = base64_decode($key);
$key_deciphered = explode("fuckyou",$key_decoded);
$iv = $key_deciphered[1];
$key_decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $key_deciphered[0], MCRYPT_MODE_CBC, $iv);


echo $key_decrypted;

//$stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
//$stmt -> bindValue(":email", $email);
//$stmt->execute();
//$row = $stmt->fetch(PDO::FETCH_ASSOC);


//header("Location: http://localhost/SecurityProject/security-exam-project/views/passwordChanged.php");
