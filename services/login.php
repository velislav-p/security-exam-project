<?php
session_start();

    //Connection to the Database
require 'connection.php';

    //Checking the Session
 if (isset ($_POST['username']) && isset ($_POST['password'])){

    $usernamePreEncode = $_POST['username'];
    //$email = $_POST['email'];
    $passwordPreHash = $_POST['password'];

    //Encoding the Username.
    $username = base64_encode($usernamePreEncode);
    //Hashing the Password
    $password = md5($passwordPreHash);

     // Sanitize password
     if (filter_var($passwordPreHash, FILTER_SANITIZE_STRING) === false) {
         echo("password is not valid");
         header("Location: index.html");
     }

     // Sanitize username
     if (filter_var($usernamePreEncode, FILTER_SANITIZE_STRING) === false) {
         echo("password is not valid");
         header("Location: index.html");
     }







     // Prepare and execute SQL statement
    $stmt = $connection->prepare("SELECT * FROM chatter_User WHERE  password = :password && email = :username|| username = :username ");
     //$stmt ->bindvalue(":email" , $email);
    $stmt ->bindvalue(":username" , $username);
    $stmt ->bindvalue (":password" , $password);
    $stmt->execute();
    $count = $stmt->rowCount();
    if($count == '0'){

        echo  'Failed';

    } else {

         header("Location: ../views/profile.php");

     }


 }

 ?>
