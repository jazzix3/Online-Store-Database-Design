<?php

// Check if user accessed page via sign-up button
if (isset($_POST["submit"])) {

    require ("dbconnect.php");
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];

    
    // Validate input--- if any case fails return user to index, include error message 
    // in header (for debugging), and terminate script.

    // Fields must not be empty
    if (empty($username) || empty($password) || empty($cpassword) || empty($firstName) || empty($lastName) || empty($email)) {
        header("Location:../signup.php?error=emptyfields");
        exit();
    }

    // Password and confirmed password must match
    elseif ($password != $cpassword){
        header("Location:../signup.php?error=passwordmismatch");
        exit();
    }

    // Username and email must not be duplicates
    else{
        $stmt = $conn->prepare("SELECT username, email FROM user WHERE username=? OR email=?");
        if ($conn->query($stmt2) !== TRUE) {
            header("Location:../signup.php?error=sqlerror1");         
            } 
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $duplicates = mysqli_num_rows($result);
        
        if ($duplicates > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['username'] == $username) {
                    header("Location:../signup.php?error=duplicateuser");
                    exit();
                }
                elseif ($row['email'] == $email) {
                    header("Location:../signup.php?error=duplicateemail");
                    exit();
                }
            }
        }
        
        // All inputs are valid--- insert user information into database and redirect user to signin page
        else{
            $stmt2 = $conn->prepare("INSERT INTO user (username, password, firstName, lastName, email) VALUES (?, ?, ?, ?, ?)");

            if ($conn->query($stmt2) !== TRUE) {
                header("Location:../signup.php?error=sqlerror2");         
                } 
            
            $stmt2->bind_param("sssss", $username, $password, $firstName, $lastName, $email);
            $stmt2->execute();

            header("Location: ../index.php?error=none");
            exit();           
           
                        
            }
        }

        $stmt->close();
        $stmt2->close();
        $conn->close();
    }

    
else{
    header("Location: ../signup.php");
}