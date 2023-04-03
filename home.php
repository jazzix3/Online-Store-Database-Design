<?php 
session_start();

// If user is not logged in, redirect to index.php to log in
if (!isset($_SESSION["username"])){
    header("Location: index.php?error=invalidsession");
    exit();
}

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
            <div class = "container-main">
            <div class="navbar">
                <a class="active" href="#home">Search</a>
                <a href="insert.php">Insert</a>
                <form action="procedures/logout.php" method="post">
                        <button type="submit" class="button-3">Log out</button>                
                    </form>
            </div>
                <div class = "content">
                    <?php
                        $firstName = $_SESSION["firstName"];
                        echo "<p><h2>Hello, " . $firstName . "!</h2> This is the homepage.<br>You successfully logged in.</p>"; 
                    ?>        
                    </form>
                </div>
            </div>
        </body>

        
       
