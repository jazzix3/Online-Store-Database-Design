<?php 
session_start();

// If user is not logged in, redirect to index.php to log in
if (!isset($_SESSION["username"])){
    header("Location: index.php?error=invalidsession");
    exit();
}

if (isset($_POST["submit"])) {
    require ("dbconnect.php");
    
    $category = $_POST["category"];

    $search = mysqli_real_escape_string($conn, $category);
    $sql = "SELECT * FROM item WHERE category LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);

    $queryResult = mysqli_num_rows($result);

    if(queryResult > 0){
        
    }
    else {
        while($row = mysqli_fetch_assoc($result)) {
            echo $queryResult. "results found!";
        }
        echo "No results found for '". $category. "'";
    }






}

else{
    header("Location: ../home.php");
    exit();
}


