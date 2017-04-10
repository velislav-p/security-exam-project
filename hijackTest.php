<?php

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>hijacking Test</title>
  </head>
  <body>
    <?php

    $str = "<script> alert(document.cookie); </script> "; $newstr = filter_var($str, FILTER_SANITIZE_STRING); echo $newstr;

    $str2 = "<script> alert(document.cookie); </script>";
    echo $str2;
    ?>

  </body>
</html>
