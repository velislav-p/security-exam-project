<?php

require ("connection.php");
include("../variables.php");

$email = $_GET["email"];

$stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
$stmt -> bindValue(":email", $email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$secretKey = md5($row["ID"]);
$stringToEncrypt = $row["Password"];
$stringSeparator = "userID";
$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secretKey, $stringToEncrypt, MCRYPT_MODE_CBC, $iv);
$encoded_string_base64 = base64_encode($encrypted_string.$stringSeparator.$iv);

$link = "../views/emailSent.php?user=".$encoded_string_base64;

echo $link;
$to      = $email;
$subject = "testing password recovery";
$message = 'Please follow the link to continue with password recovery.'."\r\n" .
    $link;
$headers = 'From: me@v-peychev.dk' . "\r\n" .
    'Reply-To: me@v-peychev.dk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

header("Location: ../views/emailSent.php");
?>
