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
            <div class = "container-login">
                <div class = "content">
                    <h1> Welcome</h1>
                    <?php
                        if (isset($_GET["error"])){
                            if($_GET["error"] == "none"){
                                echo "<p class='errormsg'>New user was registered successfully! </p>";
                            }
                            if($_GET["error"] == "emptyfields"){
                                echo "<p class='errormsg'>Fields cannot be empty. Please try again. </p>";
                            }
                            if($_GET["error"] == "usernotfound"){
                                echo "<p class='errormsg'>Username was not found. Please try again. </p>";
                            }
                            if($_GET["error"] == "passwordwrong"){
                                echo "<p class='errormsg'>Password did not match our records. Please try again.</p>";
                            }
                            if($_GET["error"] == "invalidsession"){
                                echo "<p class='errormsg'>You did not have access to that page because you are not logged in.</p>";
                            }
                            if($_GET["error"] == "loggedout"){
                                echo "<p class='errormsg'>You have successfully logged out.</p>";
                            }
                            if($_GET["error"] == "initsuccess"){
                                echo "<p class='errormsg'>The database has been initialized successfully!</p>";
                            }
                        }
                    ?>
                    <form action="procedures/login.php" method="post">
                        <input type="text" name="username" placeholder="Enter Username">
                        <input type="password" name="password" placeholder="Enter Password">
                        <button type="submit" class="button">Log in</button>
                    </form>
                    <p>New user? <a href="signup.php">Click here to sign up!</p> 
                    <br>
                    <form action="procedures/initializedb.php">
                    <button type="submit" class="button-2">Initialize Database</button>
                    </form>
                </div>
            </div>
        </body>