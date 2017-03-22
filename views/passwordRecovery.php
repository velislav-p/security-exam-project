<?php
$key = $_GET["key"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password recovery</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <!-- StyleSheet -->
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<div id="wdw-password-recovery" class="form-group">
    <form method="post" class="input-form" action="../services/passwordRecovery.php">
        <input type="text" class="form-control" name="username">
        <input type="text" class="form-control" name="password">
        <input type="hidden" name="key" value="<?php echo $key ?>">
        <input type="submit" class="btn btn-warning" value="Recover password">
    </form>
</div>
</body>
</html>
