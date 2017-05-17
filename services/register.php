<?php
// connection to the server
$referer = $_SERVER["HTTP_REFERER"];
if ($referer !== "https://188.226.141.57/views/register.html"){
    exit("unknown request origin");
} else {
    require 'connection.php';


//Check if session is set
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $passwordPreHash = $_POST['password'];

        // Sanitize password
        if (filter_var($passwordPreHash, FILTER_SANITIZE_STRING) === false) {
            echo("password is not valid");
            header("../views/register.html");
        }

        // Sanitize username
        if (filter_var($username, FILTER_SANITIZE_STRING) === false) {
            echo("password is not valid");
            header("../views/register.html");
        }

        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        // Validate e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            // Email is valid ??
        } else {
            echo("Email address is not valid");
            header("../views/register.html");
        }

        function getGUID()
        {
            if (function_exists('com_create_guid')) {
                return com_create_guid();
            } else {
                mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
                $charid = strtoupper(md5(uniqid(rand(), true)));
                $hyphen = chr(45);// "-"
                $uuid = chr(123)// "{"
                    . substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12)
                    . chr(125);// "}"
                return $uuid;
            }
        }

        $id = getGUID();


        // Encode ID
        $encodedId = md5($id);

        // Hash password
        $password = md5($passwordPreHash);

        $emailStatement = $connection->prepare("SELECT * FROM chatter_user WHERE Email = :email OR Username = :username");
        $emailStatement->bindValue(':email', $email);
        $emailStatement->bindValue(':username', $username);
        $emailStatement->execute();
        $row = $emailStatement->fetch(PDO::FETCH_ASSOC);
        $count = $emailStatement->rowCount();
        if ($count == 0) {
            $stmt = $connection->prepare("INSERT INTO chatter_user (ID, Username, Password, Email) VALUES (:id, :username, :password, :email)");
            $stmt->bindValue(':id', $encodedId);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            session_start();

            $newUser = new stdClass();

            $newUser->username = $username;
            $newUser->id = $encodedId;

            $_SESSION["user"] = $newUser;

            header("Location: ../views/profile.php");
        } else {
            $_SESSION["invalid"] = "Sorry, the user already exists";
            header("Location: ../views/register.html");
        }


    } else {
        header("Location: ../views/genericpffttr.html");
    }
}
?>
