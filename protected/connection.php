<?php

 $connection = new PDO('mysql:host=127.0.0.1;dbname=chatter', 'newuser', '#1v#2a#3m#4hOW');
if(!$connection) {
    die('failed to connect to the server: ' . mysqli_connect_error());
}
