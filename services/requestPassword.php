<?php

require 'connection.php';


$email = $_POST["email"];
$key = "secretkey";
$link = 'example';

$stmt = $db -> prepare("SELECT * FROM user WHERE username = :username");
$stmt -> bindValue(":username",$username);
$stmt->execute();
$rows = $stmt->fetch(PDO::FETCH_ASSOC);


//prepare statement to check the database for email address and create secret key that identifies the account;
//if yes, send this email, else send an email saying the email is not associated to an account.

$to      = $email;
$subject = "testing password recovery";
$message = 'Please follow the link to continue with password recovery.'."\r\n" .
    $link;
$headers = 'From: me@v-peychev.dk' . "\r\n" .
    'Reply-To: me@v-peychev.dk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

header("Location: http://v-peychev.dk/SecuritySemesterProject/views/emailSent.html");
?>
