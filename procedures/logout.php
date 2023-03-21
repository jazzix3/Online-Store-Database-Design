<?php

session_start();

// Remove all session variables and destroy the session
session_unset();
session_destroy();

// Redirect user to index.php to log in
header("Location: ../index.php?error=loggedout");
exit();

?>