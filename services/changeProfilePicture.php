
<?php
$referer = $_SERVER["HTTP_REFERER"];
if ($referer !== "https://188.226.141.57/views/profile.php"){
    exit("unknown request origin");
} else {
    require "../protected/connection.php";
    require "../protected/functions.php";
    session_start();
    $filename=basename($_FILES["image"]["name"]);

    //file sanitization
    $sanitizedFilename = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $filename);

    $user = $_SESSION["user"];
    $userId = $user->id;
    $userName = $user->username;
    $userEmail = $user->email;


    $user->profilePicture = $sanitizedFilename;
    $_SESSION["user"] = $user;

    $target="../images/$sanitizedFilename";
    $moved = move_uploaded_file($_FILES["image"]["tmp_name"],$target);

    if( $moved ) {
        $stmt = $connection -> prepare("UPDATE chatter_user SET ProfilePicture=:pic WHERE Id=:id");
        $stmt -> bindValue(":pic",$sanitizedFilename);
        $stmt -> bindValue(":id",$userId);
        $stmt->execute();
        header("Location: ../views/profile.php");
    } else {
        echo "File NOT uploaded. Please try with a smaller file";
    }

}

