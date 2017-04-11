<?php

require 'connection.php';

 if (isset ($_POST['username']) && isset ($_POST['password'])){

     $_POST ['username'] = $username;
    // $_POST ['email'] = $email;
     $_POST ['password'] = $password;

     $stmt = $connection->prepare("SELECT * FROM chatter_User WHERE  password = :password && email = :username|| username = :username ");
     //$stmt ->bindvalue(":email" , $email);
     $stmt ->bindvalue(":username , $username");
     $stmt ->bindvalue (":password" , $password);
     $stmt->execute();

 } else {

     echo 'hi!';

 }

