<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_role'])) {
    header("Location: index.php"); // Redirect to the login page
    exit();
}
include("db_connection.php");
// Check if the product ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Get the product ID from the URL parameter
    $discountID = $_GET['id'];
    $discountQuery = "SELECT * FROM discounts WHERE id = $discountID";
    $discountResult = mysqli_query($conn, $discountQuery);
    $discount = mysqli_fetch_assoc($discountResult);
    $discountCategory=$discount['discount_category'];
    // Fetch product details based on the product ID
    $productQuery = "SELECT * FROM products WHERE category = '$discountCategory'";
    $productResult = mysqli_query($conn, $productQuery);
    if ($productResult) {
        // Modify the price using a mathematical formula (e.g., increase by 10%)
        $newPrice = $discount['original_price'];
        
        while ($product = mysqli_fetch_assoc($productResult)) {
            // Display the original product details
            // echo "Original Price: " . $product['price'] . "<br>";
            $product_id = $product['id'];
            // Update the product price in the database
            $updateQuery = "UPDATE products SET price = $newPrice WHERE id = '$product_id'";
            $updateResult = mysqli_query($conn, $updateQuery);
           
        }
        include("removeDiscount.php");
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        echo "Error fetching product details: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>