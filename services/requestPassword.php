<?php

require 'connection.php';

$email = $_GET["email"];


$stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
$stmt -> bindValue(":email", $email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$secret_key = md5($row["ID"]);
$string = $row["Username"];

$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_CBC, $iv);
$encrypted_string_base64 = base64_encode($encrypted_string."fuckyou".$iv);


$link = "../views/emailSent.php?user=".$encrypted_string_base64;

echo $encrypted_string_base64;
$to      = $email;
$subject = "testing password recovery";
$message = 'Please follow the link to continue with password recovery.'."\r\n" .
    $link;
$headers = 'From: me@v-peychev.dk' . "\r\n" .
    'Reply-To: me@v-peychev.dk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

//header("Location: ../views/emailSent.php");
?>
