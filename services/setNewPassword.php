<?php
require 'connection.php';
if(isset($_POST["token"]) && !empty($_POST["token"])){
    $token= $_POST["token"];

    $token_decoded = base64_decode($token);
    $token_deciphered = explode("tokenId",$token_decoded);
    $emailRaw = $token_deciphered[1];
    $email = filter_var($emailRaw, FILTER_SANITIZE_EMAIL);
    $stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
    $stmt -> bindValue(":email",$email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
//if there is a row found do this, else do smth else

    $userId = $row["Id"];
    $secretKey = $row["Password"];
    $stmt = $connection -> prepare("SELECT * FROM password_recovery WHERE user_id=:userId");
    $stmt -> bindValue(":userId",$userId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $iv = $row["iv"];


    $token_decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secretKey, $token_deciphered[0], MCRYPT_MODE_CBC, $iv);

    if (isset($_POST["email"], $_POST["password"],$_POST["passwordConfirm"]) && $token_decrypted == $userId) {
        $emailRaw = $_POST["email"];
        $passwordRaw = $_POST["password"];
        $passwordConfirmRaw = $_POST["passwordConfirm"];

        $email = filter_var($emailRaw, FILTER_SANITIZE_STRING);
        $password = filter_var($passwordRaw, FILTER_SANITIZE_STRING);
        $passwordConfirm = filter_var($passwordConfirmRaw, FILTER_SANITIZE_STRING);

        if ($password != $passwordConfirm) {
            echo "Passwords do not match";
        }
        else {
            $stmt = $connection->prepare("UPDATE chatter_user SET Password=:password WHERE ID=:user_id");
            $stmt->bindValue(":password", md5($password));
            $stmt->bindValue(":user_id", $userId);
            $stmt->execute();
            header("Location: ../views/passwordChanged.html");
        }
    } else if ($token_decrypted != $userId) {
        echo "invalid token";
    } else {
        echo "Please fill out all the fields";
    }
}
else {
    //header("Location: ../index.html");
}
