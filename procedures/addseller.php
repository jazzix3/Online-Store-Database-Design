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
    $seller = $_POST["seller"];

    if ($username == $postedBy || $username == $seller) {
        $query_string = http_build_query(array('postedBy' => $postedBy, 'error' => 'sameuser'));
        header("Location: ../seller.php?" . $query_string);
    }

    $stmt = $conn->prepare("SELECT * FROM favorite WHERE buyer = ? AND (seller = ? OR seller = ?)");
    $stmt->bind_param("sss", $username, $postedBy, $seller);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $query_string = http_build_query(array('postedBy' => $postedBy, 'error' => 'duplicate'));
        header("Location: ../seller.php?" . $query_string);
        exit();
    }

    else {    
        $stmt = $conn->prepare("INSERT INTO favorite (buyer, seller) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $postedBy);

        if ($stmt->execute()) {
            $query_string = http_build_query(array('postedBy' => $postedBy, 'error' => 'none'));
            header("Location: ../seller.php?" . $query_string);
            exit();   
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    }
}

?>
