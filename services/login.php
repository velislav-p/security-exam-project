<?php
  session_start();

    //Connection to the Database
require "connection.php";

    //Checking the Session

 if (!empty($_POST["user"]) && !empty($_POST["password"])) {

     $username = $_POST["user"];
     $passwordPreHash = $_POST["password"];
     $user = "";
     if (strpos($username, "@") == true) {
         // Remove all illegal characters from email
         $user = filter_var($username, FILTER_SANITIZE_EMAIL);
         // Validate e-mail
         if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
             // Email is valid ??
         } else {

             header("Location: index.html");
         }

     } else{
         // Sanitize user
         if (filter_var($username, FILTER_SANITIZE_STRING) === false) {
             echo("user is not valid");
             header("Location: index.html");
         } else{
             //Code continues

         }
     }

     // Sanitize password
     if (filter_var($passwordPreHash, FILTER_SANITIZE_STRING) === false) {
         echo("password is not valid");
         header("Location: index.html");
     }
     //Hashing the Password
     $password = md5($passwordPreHash);

     // Prepare and execute SQL statement
     $stmt = $connection->prepare("SELECT * FROM chatter_user WHERE (username = :user OR email =:user) AND password = :password ");
     $stmt->bindvalue(":email", $user);
     $stmt->bindvalue(":user", $user);
     $stmt->bindvalue(":password", $password);
     $stmt->execute();
     $count = $stmt->rowCount();
     if ($count == 0) {

         echo 'Failed';

     } else {

         $_SESSION["username"] = $user;
         header("Location: ../views/profile.php");
     }

 } else{

     echo "There was an error.";

 }

 ?>
