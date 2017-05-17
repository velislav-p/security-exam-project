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
             $email = $_POST["user"];
         } else {

             header("Location: index.html");
         }

     } else{
         // Sanitize user
         if (filter_var($username, FILTER_SANITIZE_STRING) === false) {

             header("Location: index.html");
         }

     }

     // Sanitize password
     if (filter_var($passwordPreHash, FILTER_SANITIZE_STRING) === false) {

         header("Location: index.html");
     }
     //Hashing the Password
     $password = md5($passwordPreHash);

     // Prepare and execute SQL statement
     $stmt = $connection->prepare("SELECT * FROM chatter_user WHERE (Username = :user OR Email = :user) AND Password = :password");
     $stmt->bindvalue(":email", $email);
     $stmt->bindvalue(":user", $username);
     $stmt->bindvalue(":password", $password);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
     $count = $stmt->rowCount();
     if ($count == 0) {

         echo 'Failed';

     } else {

       $newUser = new stdClass();

       $newUser->username = $row["Username"];
       $newUser->email = $row["Email"];
       $newUser->id = $row["Id"];
       $newUser->profilePicture = $row["ProfilePicture"];
       $newUser->description = $row["ProfileDescription"];

       $_SESSION["user"] = $newUser;

       header("Location: ../views/profile.php");

     }

 } else{

     header("Location: ../index.html " );

 }

 ?>
