<?php
require 'connection.php';
$token= $_POST["token"];

$token_decoded = base64_decode($token);
$token_deciphered = explode("tokenId",$token_decoded);
$email = $token_deciphered[1];

$stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
$stmt -> bindValue(":email",$email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//if there is a row found do this, else do smth else

$userId = $row["ID"];
$secretKey = $row["Password"];
$stmt = $connection -> prepare("SELECT * FROM password_recovery WHERE user_id=$userId");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$iv = base64_decode($row["iv"]);


$token_decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secretKey, $token_deciphered[0], MCRYPT_MODE_CBC, $iv);

if (isset($_POST["username"], $_POST["password"],$_POST["passwordConfirm"]) && $token_decrypted == md5($row["ID"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordConfirm"];
    if ($password != $passwordConfirm) {
        echo "Passwords do not match";
    }
    if ($token_decrypted != md5($row["ID"])) {
        echo "invalid token";
    } else {
        $stmt = $connection->prepare("UPDATE chatter_user SET Password=:password WHERE ID=:user_id");
        $stmt->bindValue(":password", md5($password));
        $stmt->bindValue(":user_id", $userId);
        $stmt->execute();
        header("Location: ../views/passwordChanged.html");
    }
} else {

}