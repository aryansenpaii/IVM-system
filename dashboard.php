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
        <title>Dashboard | GEU Mart</title>
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
                            <img src="https://thumbs.dreamstime.com/b/mart-logo-letter-m-concept-213107037.jpg" alt="">
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
                    <h1>GEU Mart</h1>
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="main-skills">
                    <div class="card">
                        
                        <i class="fas fa-laptop-code"></i>
                        <h1 id="welcomeText">Welcome to GEU Shopping Mart</h1>
                    
                        
                    </div>
                </div>
            </section>
        </div>
    </body>

    </html>
</span>