<!DOCTYPE html>
    <html>
        <head>
            <meta charset="TF-8">
            <meta name="viewport" content="width=device-width, initial scale=1.0">
            <title>Sign up</title>
            <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        </head>

        <body>
        <div class = "container">
            <div class = "content">
                <h2>Sign up for an account</h2>
                <?php
                        if (isset($_GET["error"])){
                            if($_GET["error"] == "emptyfields"){
                                echo "<p class='errormsg'>Fields cannot be empty. Please try again.</p>";
                            }
                            if($_GET["error"] == "passwordmismatch"){
                                echo "<p class='errormsg'>Passwords did not match. Please try again.</p>";
                            }
                            if($_GET["error"] == "duplicateuser"){
                                echo "<p class='errormsg'>Username already exists. Please enter a different username.</p>";
                            }
                            if($_GET["error"] == "duplicateemail"){
                                echo "<p class='errormsg'>Email already exists. Please enter a different email.</p>";
                            }
                            if($_GET["error"] == "duplicateboth"){
                                echo "<p class='errormsg'>Both username and email already exist.<br>Please enter a different username and email.</p>";
                            }
                            if($_GET["error"] == "passwordlength"){
                                echo "<p class='errormsg'>Your password must be between 3 and 20 characters.</p>";
                            }
                            if($_GET["error"] == "alphanumericonly"){
                                echo "<p class='errormsg'>Your username must only contain letters or numbers.</p>";
                            }
                            if($_GET["error"] == "lettersonly"){
                                echo "<p class='errormsg'>Your first and last name must only contain letters.</p>";
                            }
                            if($_GET["error"] == "emailvalidation"){
                                echo "<p class='errormsg'>Please enter a valid email.</p>";
                            }
                        }
                    ?>
                    <form action="procedures/register.php" method="post">
                        <input type="text" name="username" placeholder="Enter Username">
                        <input type="password" name="password" placeholder="Enter Password">
                        <input type="password" name="cpassword" placeholder="Confirm Password">
                        <input type="text" name="firstName" placeholder="Enter First Name">
                        <input type="text" name="lastName" placeholder="Enter Last Name">
                        <input type="text" name="email" placeholder="Enter Email">

                        <button type="submit" name="submit" class="button">Register New User</button>
                    </form>
                <p>Already a user? <a href="index.php">Click here to log in!</p>
            </div>
        </div>


    </body>



            
            