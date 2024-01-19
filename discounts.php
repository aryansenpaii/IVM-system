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
        <style>
            .discount-form {
                display: none;
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <?php
        include('discountFunc.php');
        ?>

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
                    <h1>Discounts</h1>
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="main-skills">
                    <div class="card">
                        <form action="discounts.php" method="post" id="occasionalDiscountForm" class="discount-form">
                            <label for="occasionName">Occasion Name:</label>
                            <input type="text" name="occasionName" required>

                            <label for="occasionalDiscount">Discount Percentage:</label>
                            <input type="number" name="occasionalDiscount" min="1" max="100" required>

                            <label for="occasionalCategory">Select Category:</label>
                            <select name="occasionalCategory" required>
                                <?php
                                foreach ($categories as $category) {
                                    echo "<option value='$category'>$category</option>";
                                }
                                ?>
                            </select>
                            <label for="occasionDate">Occasion Date:</label>
                            <input type="date" name="occasionDate" required>

                            <button type="submit">Apply Occasional Discount</button>
                        </form>

                        <form action="discounts.php" method="post" id="normalDiscountForm" class="discount-form">
                            <label for="normalDiscount">Normal Discount:</label>
                            <input type="number" name="normalDiscount" min="1" max="100" required>
                            <label for="normalCategory">Select Category:</label>
                            <select name="normalCategory" required>
                                <?php
                                global $categories;
                                foreach ($categories as $category) {
                                    echo "<option value='$category'>$category</option>";
                                }
                                ?>
                            </select>
                            <button type="submit">Apply Normal Discount</button>
                        </form>

                        <script>
                            function showForm(selectedFormId) {
                                // Hide all forms
                                document.querySelectorAll('.discount-form').forEach(form => form.style.display = 'none');

                                // Show the selected form
                                document.getElementById(selectedFormId).style.display = 'block';
                            }
                        </script>
                        <br>
                        <br><br><br>
                        <p>Select a discount type:</p>
                        <button type="button" onclick="showForm('occasionalDiscountForm')">Occasional Discount</button>

                        <button type="button" onclick="showForm('normalDiscountForm')">Normal Discount</button>
                        <br><br><br><br><br>
                        <?php
                        include('db_connection.php');
                        $sql = "SELECT id, discount_type, occasion_name, discount_percentage, discount_expiry,discount_category,original_price FROM discounts";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Display table header
                            echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Discount Type</th>
                    <th>Occasion Name</th>
                    <th>Discount Percentage</th>
                    <th>Discount Expiry</th> 
                    <th>Discount Category</th> 
                    <th>Original Price</th> 
                    <th>Edit</th>
                </tr>";

                            // Display data from the database
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["discount_type"] . "</td>
                    <td>" . $row["occasion_name"] . "</td>
                    <td>" . $row["discount_percentage"] . "</td>
                    <td>" . $row["discount_expiry"] . "</td>
                    <td>" . $row["discount_category"] . "</td>
                    <td>" . $row["original_price"] . "</td>

                    <td><a href='revertDiscount.php?id=" . $row["id"] . "' class='edit-btn'>Remove</a></td>
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