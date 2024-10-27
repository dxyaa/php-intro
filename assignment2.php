<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "products_db";


$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed - " . $conn->connect_error);
}



$sql = "SELECT product_name, product_details, date_released FROM products ORDER BY date_released DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News!!</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 60%; margin: auto; padding: 20px; }
        .product-item { margin-bottom: 20px; padding: 10px; border-bottom: 1px solid #ddd; }
        .product-name { font-size: 24px; color: #333; }
        .product-date { font-size: 14px; color: #666; }
        .product-details { font-size: 18px; color: #555; }
        .form-container { margin-top: 30px; padding: 10px; border: 1px solid #ddd; }
        .form-container input, .form-container textarea { width: 100%; margin: 5px 0; padding: 10px; }
        .form-container button { padding: 10px 20px; background-color: #28a745; color: #fff; border: none; cursor: pointer; }
        .form-container button:hover { background-color: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Latest Products! </h1>
        
        <?php
    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='product-item'>";
                echo "<div class='product-name'>" . $row["product_name"] . "</div>";
                echo "<div class='product-date'>Released on: " . $row["date_released"] . "</div>";
                echo "<div class='product-details'>" . $row["product_details"] . "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>

    
        <div class="form-container" >
            <h2>Add New News Article</h2>
            <form method="POST" action="assignment2.php">
                <input type="text" name="product_name" placeholder="Product Name" required>
                <textarea name="product_details" rows="4" placeholder="Product Details" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["product_name"]) && isset($_POST["product_details"])) {
        $product_name = $_POST["product_name"];
        $product_details = $_POST["product_details"];
        $date_released = date("Y-m-d");

        
        $sql = "INSERT INTO products (product_name, product_details, date_released) VALUES ('$product_name', '$product_details', '$date_released')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>Product added successfully!</p>";
            
        
            header("assignement2.php" . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Please fill out all required fields.</p>";
    }
}


?>
  

    </div>
</body>
</html>

<?php

$conn->close();
?>