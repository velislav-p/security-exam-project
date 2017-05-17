<?php

 $connection = new PDO('mysql:host=127.0.0.1;dbname=chatter', 'newuser', '#1v#2a#3m#4hOW');
    // $connection = mysqli_connect('127.0.0.1', 'root', '#1h#2m#3a#4vIT');
if(!$connection) {
    die('failed to connect to the server: ' . mysqli_connect_error());
}

echo "hey there!";