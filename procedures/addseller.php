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

    $postedBy = $_POST["postedBy"];

    if ($username == $postedBy) {
        $query_string = http_build_query(array('postedBy' => $postedBy, 'error' => 'sameuser'));
        header("Location: ../seller.php?" . $query_string);
    }

    /*
    else {
        $remark = $_POST["remark"];
        $score = $_POST["score"];
        $itemId = $_POST["itemId"];
    
        $stmt = $conn->prepare("INSERT INTO review (remark, score, writtenBy, forItem ) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $remark, $score, $username, $itemId);

        if ($stmt->execute()) {
            $query_string = http_build_query(array('itemId' => $itemId, 'error' => 'none'));
            header("Location: ../reviews.php?" . $query_string);
            exit();   
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    }*/
}

?>
