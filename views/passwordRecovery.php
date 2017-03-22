<?php
$key = $_GET["key"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password recovery</title>
</head>
<body>

<div id="wdw-password-recovery">
    <form method="post" action="../services/passwordRecovery.php">
        <input type="text" name="username">
        <input type="text" name="password">
        <input type="hidden" name="key" value="<?php echo $key ?>">
        <input type="submit" value="Recover password">
    </form>
</div>
</body>
</html>