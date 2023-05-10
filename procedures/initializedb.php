<?php

require ("dbconnect.php");

$conn = new mysqli($servername, $username, $password, $dbname);

$tables = array("favorite", "review", "item", "itemCategory", "user");
foreach ($tables as $table) {
    $sql = "DROP TABLE IF EXISTS $table;";
    if ($conn->query($sql) === false) {
        exit("Error dropping $table table: " . $conn->error);
    }
}


$userTable = "CREATE TABLE IF NOT EXISTS user (
    username VARCHAR(32) NOT NULL PRIMARY KEY,
    password VARCHAR(64) NOT NULL,
    firstName VARCHAR (64) NOT NULL,
    lastName VARCHAR(64) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE);";

if ($conn->query($userTable) === false) {
    exit("Error creating user table: " . $conn->error);
}

$itemCategoryTable = "CREATE TABLE itemCategory (
    category VARCHAR(64) NOT NULL PRIMARY KEY);";
    

if ($conn->query($itemCategoryTable) === false) {
    exit("Error creating itemCategory table: " . $conn->error);
}



$itemTable = "CREATE TABLE IF NOT EXISTS item (
    itemId INT(10) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(64) NOT NULL,
    description TEXT(255),
    category VARCHAR(64) NOT NULL,
    FOREIGN KEY (category) REFERENCES itemCategory(category),
    price DECIMAL(10,2),
    postDate DATE NOT NULL DEFAULT (CURRENT_DATE),
    postedBy VARCHAR(32) NOT NULL,
    FOREIGN KEY (postedBy) REFERENCES user(username));";

if ($conn->query($itemTable) === false) {
    exit("Error creating item table: " . $conn->error);
}



$reviewTable = "CREATE TABLE review (
    reviewId INT(10) AUTO_INCREMENT PRIMARY KEY,
    remark TEXT (255),
    score VARCHAR(10),
    reviewDate DATE NOT NULL DEFAULT (CURRENT_DATE),
    writtenBy VARCHAR(32) NOT NULL,
    FOREIGN KEY (writtenBy) REFERENCES user(username),
    forItem INT(10) NOT NULL,
    FOREIGN KEY (forItem) REFERENCES item(itemId));";

if ($conn->query($reviewTable) === false) {
    exit("Error creating review table: " . $conn->error);
}



$favoriteTable = "CREATE TABLE favorite (
    favoriteId INT(10) AUTO_INCREMENT PRIMARY KEY,
    buyer VARCHAR(32) NOT NULL,
    FOREIGN KEY (buyer) REFERENCES user(username),
    seller VARCHAR(32) NOT NULL,
    FOREIGN KEY (seller) REFERENCES user(username));";


if ($conn->query($favoriteTable) === false) {
    exit("Error creating review table: " . $conn->error);
}



$queries = array(
    "INSERT INTO user(username, password, firstName, lastName, email) VALUES
        ('john1', 'p@ssword1', 'John', 'Smith', 'john.smith@example.com'),
        ('jane2', 'p@ssword2', 'Jane', 'Doe', 'jane.doe@example.com'),
        ('matt3', 'p@ssword3', 'Matt', 'Garcia', 'jason.garcia@example.com'),
        ('lisa4', 'p@ssword4', 'Lisa', 'Kim', 'lisa.kim@example.com'),
        ('alice5', 'p@ssword5', 'Alice', 'Williams', 'alice.williams@example.com'),
        ('james6', 'p@ssword6', 'James', 'Lee', 'james.lee@example.com')",

    "INSERT INTO favorite (buyer, seller) VALUES
        ('john1', 'jane2'), ('john1', 'matt3'), ('john1', 'lisa4'),
        ('jane2', 'matt3'), ('jane2', 'lisa4'), ('jane2', 'alice5'),
        ('matt3', 'john1'), ('matt3', 'jane2'), ('lisa4', 'john1')",

    "INSERT INTO itemCategory(category) VALUES
        ('Art & Collectibles'),
        ('Baby & Kids'),
        ('Clothing & Accessories'),
        ('Electronics'),
        ('Furniture'),
        ('Home & Garden'),
        ('Pet Supplies'),
        ('Sporting Goods'),
        ('Toys'),
        ('Other')",
    
    "INSERT INTO item(title, description, category, price, postDate, postedBy) VALUES
        ('Smartphone 14 Pro', 'Newest phone with improved camera and battery life', 'Electronics', '500.00', '2023-03-03', 'john1'),
        ('Wireless headphones', 'World-class combination of noise cancelling performance and premium comfort', 'Electronics', '275.00', '2023-03-30', 'jane2'),
        ('Artisan Stand Mixer', 'Mix ingredients with ease using this powerful and stylish stand mixer', 'Home & Garden', '150.00', '2023-03-17', 'jane2'),
        ('Mountain Bike', 'Full suspension mountain bike with 29-inch wheels', 'Sporting Goods', '800.00', '2023-03-28', 'matt3'),
        ('Vintage Watch', 'Mechanical wristwatch from the 1950s', 'Clothing & Accessories', '300.00', '2023-03-28', 'matt3'),
        ('Leather Shoulder Bag', 'Womens crossbody bag with adjustable strap', 'Clothing & Accessories', '75.00', '2023-03-30', 'lisa4'),
        ('Ripped Jeans', 'Sylish, trendy baggy ripped jeans', 'Clothing & Accessories', '30.00', '2023-03-07', 'alice5'),
        ('Movie Posters', 'Large posters from 90s movies', 'Art & Collectibles', '80.00', '2023-04-07', 'james6'),
        ('Stroller', 'Easy-folding stroller with locking wheels', 'Baby & Kids', '120.00', '2023-04-07', 'james6'),
        ('Baby Crib', 'Wooden crib with rounded edges and made with non-harmful finishes', 'Baby & Kids', '215.00', '2023-04-24', 'james6')",


    "INSERT INTO review(remark, score, reviewDate, writtenBy, forItem) VALUES
        ('Great phone. The battery lasts all day!', 'Excellent', '2023-05-03', 'jane2', '1'),
        ('These headphones are fantastic! It blocks out all noise.', 'Excellent', '2023-05-02', 'john1', '2'),
        ('It is easy to use and looks great on my kitchen counters.', 'Excellent', '2023-05-01', 'john1', '3'),
        ('Amazing quality leather!', 'Excellent', '2023-04-10', 'jane2', '6'),
        ('Perfect for every day because it goes with anything.', 'Excellent', '2023-04-12', 'lisa4', '6'),
        ('Too loud and I wish the bowl was bigger.', 'Poor', '2023-03-29', 'lisa4', '3'), 
        ('Love it! I received many compliments.', 'Excellent', '2023-04-20', 'alice5', '6'),
        ('Broke after only 2 months. Avoid!', 'Poor', '2023-04-04', 'alice5', '4'),
        ('The seat is so uncomfortable and needs more cushion.', 'Poor', '2023-04-10', 'james6', '4'),
        ('The face was cracked when I received it', 'Poor', '2023-04-23', 'james6', '5')"


);

foreach ($queries as $query) {
    if ($conn->query($query) === TRUE) {
        header("Location: ../index.php?error=initsuccess");
    } else {
        echo "Error inserting into database: " . $conn->error;
    }
}
    


$conn->close();
?>



