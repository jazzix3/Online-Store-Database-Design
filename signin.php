<?php

require 'dbconnect.php';
$username = $_POST["username"];
$password = $_POST["password"];

// Validate input--- if any case fails, return user to index, include error message 
// in header  (for debugging), and terminate script.

// username and password must not be empty
if(empty($username) || empty($password)) {
    header("Location: ../index.php?error=emptyfields");
    die();
}

else{
    $stmt = $conn->prepare("SELECT username, password FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $numusers = mysqli_num_rows($result);

    // username must exist in database
    if ($numusers = 0){
        header("Location:../index.php?error=usernotfound");
        die();
    }

    else {
        $row = $result->fetch_assoc();
        
    // password must match db password
        if($row["password"] === $password) {
            session_start();
            $_SESSION["username"] = $row["username"];
            header("Location: ../index.php?login=success");
            die();
        }
        else {
            header("Location: ../index.php?error=wrongpassword");
            die();
        }

    }

}