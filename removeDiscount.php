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
    echo $productId;

    // Fetch product data based on the provided ID
    $sql = "DELETE FROM discounts WHERE id = '$productId'";
    mysqli_query($conn, $sql);
    header("Location: {$_SERVER['HTTP_REFERER']}");
    
} else {
    echo "Discount ID not provided.";
    exit;
}

// Check if the form has been submitted for updating
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
//     $removeDiscountQuery = "DELETE FROM discounts WHERE id = $productId";

//     if ($conn->query($removeDiscountQuery) === TRUE) {
//         echo "Discount removed SuccessFully";
//         // Redirect to the product list page after updating
//         header("Location: {$_SERVER['HTTP_REFERER']}");
//         exit;
//     } else {
//         echo "Error Deleting Discount: " . $conn->error;
//     }
// }

// Close database connection
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

