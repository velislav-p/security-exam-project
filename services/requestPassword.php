<?php

require ("connection.php");

$emailRaw = $_POST["email"];
$email = filter_var($emailRaw, FILTER_SANITIZE_EMAIL);
// Finding the user based on the email provided
$stmt = $connection -> prepare("SELECT * FROM chatter_user WHERE email = :email");
$stmt -> bindValue(":email", $email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


// creating the token
$secretKey = $row["Password"];
$stringToEncrypt = $row["Id"];
$stringSeparator = "tokenId";
$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
// ON DUPLICATE KEY UPDATE iv=:IV
$stmt = $connection -> prepare("INSERT INTO password_recovery(user_id,iv) VALUES (:ID,:IV) ON DUPLICATE KEY UPDATE iv=:IV");
$stmt -> bindValue(":ID", $row["Id"]);
$stmt -> bindValue(":IV", $iv);
$stmt->execute();

$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secretKey, $stringToEncrypt, MCRYPT_MODE_CBC, $iv);
$encoded_string_base64 = urlencode(base64_encode($encrypted_string.$stringSeparator.$email));

$link = "http://188.226.141.57/Group03/services/passwordRecovery.php?token=".$encoded_string_base64;
echo $link;

$to      = $email;
$subject = "testing password recovery";
$message = 'Please follow the link to continue with password recovery.'."\r\n" .
    $link;
$headers = 'From: pwrecovery@Group03.localdomain' . "\r\n" .
    'Reply-To: me@v-peychev.dk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

?>
