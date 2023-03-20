<?php
session_start();
?>

<!DOCTYPE html>
    <html>
    <head>    
        <meta charset="TF-8">
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <title>Sign in</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    </head>

    <body>
        <div class = "container">
            <div class = "content">
                <h1> Welcome</h1>
                    <form action="signin.php" method="post">
                    <input type="text" name="username" placeholder="Enter Username">
                    <input type="text" name="password" placeholder="Enter Password">
                    <button type="submit" class="button">Sign in</button>
                    </form>
                <p>New user? <a href="signup.php">Click here to sign up!</p> 
            </div>
        </div>
    </body>