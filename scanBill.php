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
            <title>Generate Bill | By GEU Mart</title>
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
                        </a>
                        </li>
                        <li><a href="dashboard.php">
                            <i class="fas fa-home"></i>
                            <span class="nav-item">Home</span>
                        </a>
                        </li>
                        <li><a href="profile.php">
                            <i class="fas fa-user"></i>
                            <span class="nav-item">Profile</span>
                        </a>
                        </li>

                        <?php if ($userRole === 'admin'):
                        ?>
                        <li><a href="addProduct.php">
                            <i class="fas fa-plus-square"></i>
                                <span class="nav-item">Add Product</span>
                        </a>
                        </li>
                        <li><a href="manage.php">
                            <i class="fas fa-tasks"></i>
                                <span class="nav-item">Manage</span>
                        </a>
                        </li>
                        <li><a href="discounts.php">
                            <i class="fas fa-user-tag"></i>
                                <span class="nav-item">Discounts</span>
                        </a>
                        </li>

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
                
                <?php 
                    include("db_connection.php");
                    include("auth.php");
                    
                    // Assume you have a table named 'employee_login' with a column 'name'
                    $sql = "SELECT name FROM employee_login WHERE username='$username'"; 
                    $result = mysqli_query($conn, $sql);
   
                    // Check if the query was successful
                    if (isset($row['name'])) {
                        $userName = $row['name'];
                    } else {
                        $userName = "Guest";
                    }
                ?>
                <section class="main">
                    <div class="main-top">
                        <h1>Biling</h1>
                        <i class="fas fa-user-cog"></i>
                        <?php echo $userName; ?>
                    </div>

                    
                    <form class="form-horizontal00 billingForm" action="#" method="POST" name="billingForm" id="dd" autocomplete="off" onkeydown="return event.key != 'Enter';">
				        <input type="hidden" id="invoice_id" name="invoice_id" value="<?php echo $invoice_id;?>" />
				
				        <table>
					        <thead>
						        <th>Barcode</th>
						        <th>Name</th>
						        <th>MRP</th>
						        <th>Quantity</th>
						        <th>Available Quantity</th>
						        <th>Sale Price</th>
					        </thead>
					        <tbody>
					            <tr id="1">
						            <td>
							            <input type="text" id="bar_code_1" class="form-control" onchange="get_detail(this.value,1)" name="bar_code[]" />
						            </td>
					                <td>
						                <select name="name[]" id="name_1" class="form-control" onchange="get_detail_name(this.value,1)">
							                <option value="">Choose Product</option>
							                <?php $sqlP = $conn->query("SELECT * FROM product WHERE status = 1 ORDER BY name ASC");
							                    while($rowP = $sqlP->fetch_array()){?>
							                    <option value="<?php echo $rowP['name']?>"><?php echo $rowP['name'];?></option>
							                    <?php }
                                            ?>
						                </select>
					                </td>
					                <td>
						                <input type="text" class="form-control" readonly id="mrp_1" name="mrp[]" />
					                </td>
					                <td>	
						                <input type="number" class="form-control" onkeyup="calculate_price(this.value,1)" step="0.001" id="quantity_1" name="quantity[]" />
					                </td>
					                <td>
						                <input type="text" readonly class="form-control" id="av_quantity_1" name="av_quantity[]" />
					                </td>
					                <td>
						                <input type="number" class="form-control" onkeyup="get_quantity(this.value,1)" step="0.01" id="sale_price_1" name="sale_price[]" />
						                <input type="hidden" class="form-control" id="sale_price_org_1" name="sale_price_org[]" />
					                </td>
				                </tr>
				            </tbody>
				            <tfoot id="foot" style="margin-top:20px;">
					            <tr>
						            <td class="text-right"><b>Paid By : </b></td>
						            <td > 
							            <select name="payment_method" class="form-control" id="payment_method">
								            <option value='cash'>Cash</option>
								            <option value='card'>Card</option>
								            <option value='paytm'>Paytm</option>
								            <option value='phone_pay'>Phone Pay</option>
								            <option value='google_pay'>Google Pay</option>
								            <option value='upi'>UPI</option>
								            <option value='udhar'>UDHAR</option>
								            <option value='other'>Other</option>
							            </select>
						            </td>
						            <td   colspan="3" class='text-right'><b>Total : </b></td>
						            <td><input type="number" class="form-control" readonly name="total" value="0" id="getTotal" /></td>
					            </tr>
				            </tfoot>
				        </table>
                        <div class="text-right">
                            <button type="submit" name="add_user" class="btn btn-primary" id="validateButton2">Submit</button>
                        </div>
                    </form>

                    <?php 
                        include('db_connection.php');
           
                        // Check if the form has been submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Retrieve form data
                            $product_id = $_POST["product_id"];
                            $product_name = $_POST["product_name"];
                            $rate = $_POST["rate"];
                            $quantity = $_POST["quantity"];
                            $price = $_POST["price"];
                            // Validate and sanitize input data if needed
    
                             // Insert data into the database
                            $sql = "INSERT INTO bill (product_id, product_name, rate,quantity,price)
                            VALUES ('$product_id', '$product_name', '$rate',  '$quantity' , '$price')";

                            if ($conn->query($sql) === TRUE) {
                                // Display success message
                                echo "Product billed successfully!";
                            } else {
                                // Display error message
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }

                            // Close database connection
                            $conn->close();
                        }
                    ?>
                </section>
            </div>
        </body>
    </html>
</span>

