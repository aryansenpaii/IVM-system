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
        <link rel="stylesheet" href="styles.css" />
        <!-- Font Awesome Cdn Link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="#" class="logo">
                            <img src="/logo.jpg" alt="">
                            <span class="nav-item">DashBoard</span>
                        </a></li>
                    <li><a href="#">
                            <i class="fas fa-home"></i>
                            <span class="nav-item">Home</span>
                        </a></li>
                    <li><a href="">
                            <i class="fas fa-user"></i>
                            <span class="nav-item">Profile</span>
                        </a></li>

                    <?php if ($userRole === 'admin'): ?>
                        <li><a href="">
                                <i class="fas fa-wallet"></i>
                                <span class="nav-item">Add Product</span>
                            </a></li>
                        <li><a href="">
                                <i class="fas fa-chart-bar"></i>
                                <span class="nav-item">Remove Product</span>
                            </a></li>
                        <li><a href="">
                                <i class="fas fa-tasks"></i>
                                <span class="nav-item">Discounts</span>
                            </a></li>

                    <?php elseif ($userRole === 'sales'): ?>

                        <li><a href="">
                                <i class="fas fa-wallet"></i>
                                <span class="nav-item">Scan & Bill</span>
                            </a></li>
                        <li><a href="">
                                <i class="fas fa-chart-bar"></i>
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
                    <h1>Skills</h1>
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="main-skills">
                    <div class="card">
                        <i class="fas fa-laptop-code"></i>
                        <h3>Web developemt</h3>
                        <p>Join Over 1 million Students.</p>
                        <button>Get Started</button>
                    </div>
                    <div class="card">
                        <i class="fab fa-wordpress"></i>
                        <h3>WordPress</h3>
                        <p>Join Over 3 million Students.</p>
                        <button>Get Started</button>
                    </div>
                    <div class="card">
                        <i class="fas fa-palette"></i>
                        <h3>graphic design</h3>
                        <p>Join Over 2 million Students.</p>
                        <button>Get Started</button>
                    </div>
                    <div class="card">
                        <i class="fab fa-app-store-ios"></i>
                        <h3>IOS dev</h3>
                        <p>Join Over 1 million Students.</p>
                        <button>Get Started</button>
                    </div>
                </div>
            </section>
        </div>
    </body>

    </html>
</span>