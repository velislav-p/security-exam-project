<?php

require "../protected/connection.php";
require "../protected/functions.php";
if (isset($_GET["token"]) && !empty($_GET["token"])){
    $token= $_GET["token"];
    $token_decoded = base64_decode($token);
    $token_deciphered = explode("tokenId",$token_decoded);
    $emailRaw = $token_deciphered[1];
    $email = filter_var($emailRaw, FILTER_SANITIZE_EMAIL);

    $stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
    $stmt -> bindValue(":email",$email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $userId = $row["Id"];
    $secretKey = $row["Password"];
    $stmt = $connection -> prepare("SELECT * FROM password_recovery WHERE user_id=:userId");
    $stmt -> bindValue(":userId",$userId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $iv = $row["iv"];


    $token_decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secretKey, $token_deciphered[0], MCRYPT_MODE_CBC, $iv);
    $token_stripped = strip_tags($token_decrypted);


    if ($token_stripped != $userId){
       header("Location: ../index.html");
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
    <h1>Password recovery</h1>
        <form method='post' class='input-form' action='setNewPassword.php'>
            <input type='text' class='form-control' name='email' placeholder='email'>
            <input type='password' class='form-control' name='password' placeholder='password'>
            <input type='password' class='form-control' name='passwordConfirm' placeholder='confirm password'>
            <input type='hidden' name='token' value='$token'>
            <input type='submit' class='btn btn-warning' value='Recover password'>
        </form>
    </div>
    </body>
    </html>";
        echo $content;
    }

}else {
    header("Location: ../views/genericpffttr.html");

}
