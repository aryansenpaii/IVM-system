<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_role'])) {
    header("Location: index.php"); // Redirect to the login page
    exit();
}
include ("db_connection.php");
// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product data based on the provided ID
    $sql = "SELECT * FROM products WHERE id = '$productId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $productData = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Product ID not provided.";
    exit;
}

// Check if the form has been submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated form data
    $updatedProductName = $_POST["product_name"];
    $updatedCategory = $_POST["category"];
    $updatedPrice = $_POST["price"];
    $updatedManufacturer = $_POST["manufacturer"];
    $updatedQuantity = $_POST["quantity"];
    $updatedExpiry = $_POST["expiry"];

    // Update product data in the database
    $updateSql = "UPDATE products
                  SET product_name = '$updatedProductName',
                      category = '$updatedCategory',
                      price = $updatedPrice,
                      manufacturer = '$updatedManufacturer',
                      quantity = $updatedQuantity,
                      expiry = '$updatedExpiry'
                  WHERE id = '$productId'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Product updated successfully!";
        // Redirect to the product list page after updating
        header("Location: manage.php");
        exit;
    } else {
        echo "Error updating product: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form action="" method="post">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" value="<?php echo $productData['product_name']; ?>" required>

        <label for="category">Category:</label>
        <input type="text" name="category" value="<?php echo $productData['category']; ?>" required>

        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo $productData['price']; ?>" required>

        <label for="manufacturer">Manufacturer:</label>
        <input type="text" name="manufacturer" value="<?php echo $productData['manufacturer']; ?>" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $productData['quantity']; ?>" required>

        <label for="expiry">Expiry:</label>
        <input type="date" name="expiry" value="<?php echo $productData['expiry']; ?>" required>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>


