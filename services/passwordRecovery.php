<?php
require 'connection.php';

$token= $_GET["token"];
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

if ($token_decrypted != md5($row["ID"])){
    header("Location: http://www.google.com");
} else {
    $content = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Password recovery</title>
    
        <!-- Latest compiled and minified CSS -->
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
        <!-- Bootstrap -->
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css'>
        <!-- StyleSheet -->
        <link rel='stylesheet' href='../style/style.css'>
    </head>
    <body>
    
    <div id='wdw-password-recovery' class='form-group'>
        <form method='post' class='input-form' action='../services/setNewPassword.php'>
            <input type='text' class='form-control' name='username' placeholder='username'>
            <input type='text' class='form-control' name='password' placeholder='password'>
            <input type='text' class='form-control' name='passwordConfirm' placeholder='confirm passowrd'>
            <input type='hidden' name='token' value='$token'>
            <input type='submit' class='btn btn-warning' value='Recover password'>
        </form>
    </div>
    </body>
    </html>";
    echo $content;
}

//$stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
//$stmt -> bindValue(":email", $email);
//$stmt->execute();
//$row = $stmt->fetch(PDO::FETCH_ASSOC);


//header("Location: http://localhost/SecurityProject/security-exam-project/views/passwordChanged.php");
