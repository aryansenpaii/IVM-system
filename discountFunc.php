
<?php
include('db_connection.php');

$categoriesQuery = "SELECT DISTINCT category FROM products";
$categoriesResult = mysqli_query($conn, $categoriesQuery);

if (!$categoriesResult) {
    die("Error fetching categories: " . mysqli_error($conn));
}

$categories = [];
while ($row = mysqli_fetch_assoc($categoriesResult)) {
    $categories[] = $row['category'];
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which form was submitted
    if (isset($_POST['occasionName']) && isset($_POST['occasionalDiscount']) && isset($_POST['occasionalCategory'])) {
        // Occasional Discount form submitted
        $discountExpiry=$_POST['occasionDate'];
        $occasionalCategory = $_POST['occasionalCategory'];
        applyOccasionalDiscount($_POST['occasionName'], $_POST['occasionalDiscount'], $occasionalCategory,$discountExpiry);
    } elseif (isset($_POST['normalDiscount'])) {
        // Normal Discount form submitted
        $normalCategory = $_POST['normalCategory'];
        applyNormalDiscount($_POST['normalDiscount'], $normalCategory);
    } else {
        echo "Invalid form submission.";
    }
}

function applyOccasionalDiscount($occasionName, $occasionalDiscount, $occasionalCategory,$discountExpiry)
{
    // Apply Occasional Discount logic here
    // You can use $occasionName and $occasionalDiscount to perform specific actions
    // Update database, log, etc.
    global $conn; // Make sure to use the correct variable name for your database connection

    // Fetch products with the 'occasional' category
    $productsQuery = "SELECT * FROM products WHERE category = '$occasionalCategory'";
    $productsResult = mysqli_query($conn, $productsQuery);


    if ($productsResult) {
        while ($row = mysqli_fetch_assoc($productsResult)) {
            // Calculate discounted price for each product
            $id = $row['id'];
            $originalPrice = $row['price'];
            $discountedPrice = calculateDiscountedPrice($originalPrice, $occasionalDiscount);

            // Update the product in the database with the discounted price
            $updateQuery = "UPDATE products SET price = $discountedPrice WHERE id='$id'";
           

            mysqli_query($conn, $updateQuery);  

        }
        $discountTableQuery="INSERT INTO discounts (discount_type, occasion_name, discount_percentage, discount_expiry,discount_category,original_price)
        VALUES ('Occasional', '$occasionName', $occasionalDiscount, '$discountExpiry','$occasionalCategory' ,$originalPrice)";
        mysqli_query($conn, $discountTableQuery);
        echo "Occasional Discount applied successfully!";
    } else {
        echo "Error fetching products: " . mysqli_error($conn);
    }
}

function calculateDiscountedPrice($originalPrice, $totalDiscount)
{
    // Calculate and return the discounted price
    $discountedPrice = $originalPrice - ($originalPrice * $totalDiscount / 100);
    return $discountedPrice;
}





function applyNormalDiscount($normalDiscount, $normalCategory)
{
    global $conn;
    // Apply Normal Discount logic here
    // You can use $normalDiscount to perform specific actions
    // Update database, log, etc.
    $productsQuery = "SELECT * FROM products WHERE category = '$normalCategory'";
    $productsResult = mysqli_query($conn, $productsQuery);

    if ($productsResult) {
        while ($row = mysqli_fetch_assoc($productsResult)) {
            // Calculate discounted price for each product
            $originalPrice = $row['price'];
            $discountedPrice = calculateDiscountedPrice($originalPrice, $normalDiscount);

            // Update the product in the database with the discounted price
            $id = $row['id']; // Adjust this based on your actual column name
            $updateQuery = "UPDATE products SET price = $discountedPrice WHERE id = '$id'";
            mysqli_query($conn, $updateQuery);
        }

        echo "Normal Discount applied successfully!";
    } else {
        echo "Error fetching products: " . mysqli_error($conn);
    }
}
?>