<?php
session_start();

// If user is not logged in, redirect to index.php to log in
if (!isset($_SESSION["username"])){
    header("Location: index.php?error=invalidsession");
    exit();
}

require("dbconnect.php");

$username = $_SESSION["username"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemId = $_POST["itemId"];

    // User cannot give more than 3 reviews per day
    $sql = "SELECT COUNT(*) FROM review WHERE writtenBy = '$username' AND DATE(reviewDate) = DATE(NOW());";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_fetch_array($result)[0];
    if ($count >= 3) {
        $query_string = http_build_query(array('itemId' => $itemId, 'error' => 'reachedlimit'));
        header("Location: ../reviews.php?" . $query_string);
        exit();
    }

    // User cannot review own item posted
    $sql = "SELECT postedBy FROM item WHERE itemId = $itemId";
    $result = mysqli_query($conn, $sql);
    $postedBy = mysqli_fetch_array($result)[0];
    if ($username == $postedBy) {
        $query_string = http_build_query(array('itemId' => $itemId, 'error' => 'sameuser'));
        header("Location: ../reviews.php?" . $query_string);
        exit();
    }
    

    /* Not sure why this will not work with prepared statements. Error occurs when trying to insert
    
    // User cannot review own item posted
    $stmt = $conn->prepare("SELECT postedBy FROM item WHERE itemId = ?");
    $stmt->bind_param("s", $itemId);
    $stmt->execute();
    $stmt->bind_result($postedBy);
    $stmt->fetch();

    if ($username == $postedBy) {
         $query_string = http_build_query(array('itemId' => $itemId, 'error' => 'sameuser'));
         header("Location: ../reviews.php?" . $query_string);
         exit();
     }
    */

    else {
        $remark = $_POST["remark"];
        $score = $_POST["score"];
        

        $stmt2 = $conn->prepare("INSERT INTO review (remark, score, writtenBy, forItem ) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("ssss", $remark, $score, $username, $itemId);

        if ($stmt2->execute()) {
            $query_string = http_build_query(array('itemId' => $itemId, 'error' => 'none'));
            header("Location: ../reviews.php?" . $query_string);
            exit();   
        } 
        
        else {
            echo "Error inserting data: " . $conn->error;
        }
    }
    
}
else{
    header("Location: ../home.php");
    exit();
}

?>