<?php
$email = $_POST["email"];
$key = "secretkey";
$link = "http://v-peychev.dk/SecuritySemesterProject/views/passwordRecovery.php?key=".$key;


$to      = $email;
$subject = "testing password recovery";
$message = 'Please follow the link to continue with password recovery.'."\r\n" .
           $link;
$headers = 'From: me@v-peychev.dk' . "\r\n" .
    'Reply-To: me@v-peychev.dk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>