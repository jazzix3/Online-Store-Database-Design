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

    $stmt = $conn->prepare("SELECT * FROM item WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
  
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
