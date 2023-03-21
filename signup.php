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
                <h2>Create an account</h2>
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



            
            