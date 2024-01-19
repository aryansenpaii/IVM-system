<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_role'])) {
    header("Location: index.php"); // Redirect to the login page
    exit();
}


// Dynamically load content based on user role
$userRole = $_SESSION['user_role'];
?>

<span style="font-family: verdana, geneva, sans-serif;">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>Dashboard | By Code Info</title>
        <!-- <link rel="stylesheet" href="styles.css" /> -->
        <!-- Font Awesome Cdn Link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="dashboard.php" class="logo">
                            <img src="https://www.shutterstock.com/image-vector/shopping-bag-logo-260nw-786121486.jpg" alt="">
                            <span class="nav-item">DashBoard</span>
                        </a></li>
                    <li><a href="dashboard.php">
                            <i class="fas fa-home"></i>
                            <span class="nav-item">Home</span>
                        </a></li>
                    <li><a href="profile.php">
                            <i class="fas fa-user"></i>
                            <span class="nav-item">Profile</span>
                        </a></li>

                    <?php if ($userRole === 'admin'): ?>
                        <li><a href="addProduct.php">
                        <i class="fas fa-plus-square"></i>
                                <span class="nav-item">Add Product</span>
                            </a></li>
                        <li><a href="manage.php">
                        <i class="fas fa-tasks"></i>
                                <span class="nav-item">Manage</span>
                            </a></li>
                        <li><a href="discounts.php">
                        <i class="fas fa-user-tag"></i>
                                <span class="nav-item">Discounts</span>
                            </a></li>

                    <?php elseif ($userRole === 'sales'): ?>

                        <li><a href="scanBill.php">
                        <i class="fas fa-barcode"></i>
                                <span class="nav-item">Scan & Bill</span>
                            </a></li>
                        <li><a href="billHistory.php">
                        <i class="fas fa-history"></i>
                                <span class="nav-item">Billing History</span>
                            </a></li>
                    <?php else: ?>
                        <p>Invalid user role.</p>
                    <?php endif; ?>

                    <li><a href="logout.php" class="logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-item">Log out</span>
                        </a></li>
                </ul>
            </nav>

            <section class="main">
                <div class="main-top">
                    <h1>Add Product</h1>
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="main-skills">
                <div class="card">


    <form action="addProduct.php" method="post">
        <label for="product_id">Product ID:</label>
        <input type="text" name="product_id" id="product_id" placeholder="Product ID">

        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" placeholder="Product Name">

        <label for="category">Category:</label>
        <input type="text" name="category" id="category" placeholder="Category">

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" placeholder="Price">

        <label for="manufacturer">Manufacturer:</label>
        <input type="text" name="manufacturer" id="manufacturer" placeholder="Manufacturer">

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" placeholder="Quantity">

        <label for="expiry">Expiry:</label>
        <input type="date" name="expiry" id="expiry" placeholder="Expiry">

        <button type="submit">Add item</button>
    </form>
    <?php 
            include('db_connection.php');
           
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_id = $_POST["product_id"];
    $product_name = $_POST["product_name"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $manufacturer = $_POST["manufacturer"];
    $quantity = $_POST["quantity"];
    $expiry = $_POST["expiry"];

    // Validate and sanitize input data if needed

    
    // Insert data into the database
    $sql = "INSERT INTO products (id, product_name, category, price, manufacturer, quantity, expiry)
            VALUES ('$product_id', '$product_name', '$category', $price, '$manufacturer', $quantity , '$expiry')";

    if ($conn->query($sql) === TRUE) {
        // Display success message
        echo "Product added successfully!";
    } else {
        // Display error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>
   
        
</div>

                </div>
            </section>
        </div>
    </body>

    </html>
</span>