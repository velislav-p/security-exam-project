<?php

    function login_check($mysqli) {
      // Check if all session variables are set
      if (isset($_SESSION['user_id'],
      $_SESSION['username'],
      $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password
        FROM members
        WHERE id = ? LIMIT 1")) {
          // Bind "$user_id" to parameter.
          $stmt->bind_param('i', $user_id);
          $stmt->execute();   // Execute the prepared query.
          $stmt->store_result();

          if ($stmt->num_rows == 1) {
            // If the user exists get variables from result.
            $stmt->bind_result($password);
            $stmt->fetch();
            $login_check = hash('sha512', $password . $user_browser);

            if (hash_equals($login_check, $login_string) ){
            // Logged In!!!!
            return true;
            } else {
              // Not logged in
              return false;
            }
          } else {
            // Not logged in
            return false;
          }
        } else {
          // Not logged in
          return false;
        }
      } else {
        // Not logged in
        return false;
      }
    }
