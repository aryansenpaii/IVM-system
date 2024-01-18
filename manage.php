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
        <style>
            table {
                border-collapse: collapse;
                width: 80%;
                margin: 20px auto;
            }

            th,
            td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
            }

            .edit-btn {
                background-color: #4caf50;
                color: white;
                padding: 6px 12px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border-radius: 4px;
                cursor: pointer;
            }
        
        </style>
    </head>

    <body>




        <div class="container">
            <nav>
                <ul>
                    <li><a href="dashboard.php" class="logo">
                            <img src="/logo.jpg" alt="">
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
                    <h1>Manage</h1>
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="main-skills">
                    <div class="card">



                        <?php
                        include('db_connection.php');
                        $sql = "SELECT id, product_name, category, price, manufacturer, quantity, expiry FROM products";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Display table header
                            echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Manufacturer</th>
                    <th>Quantity</th>
                    <th>Expiry</th>
                    <th>Edit</th>
                </tr>";

                            // Display data from the database
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["product_name"] . "</td>
                    <td>" . $row["category"] . "</td>
                    <td>" . $row["price"] . "</td>
                    <td>" . $row["manufacturer"] . "</td>
                    <td>" . $row["quantity"] . "</td>
                    <td>" . $row["expiry"] . "</td>
                    <td><a href='editProduct.php?id=" . $row["id"] . "' class='edit-btn'>Edit</a></td>
                </tr>";
                            }

                            echo "</table>";
                        } else {
                            echo "No products found.";
                        }

                        // Close database connection
                        $conn->close();
                        ?>


                    </div>

                </div>
            </section>
        </div>
    </body>

    </html>
</span>