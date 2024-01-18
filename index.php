<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVM-GEU</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to GEU Inventory Management System</h1>
        <h2>Please choose your access level</h2>
        <form action="index.php" method="post">
            <input type="hidden" name="formSubmitted" value="1">
            <button type="submit" class="loginChoice" name="loginChoice" value="adminChoice">Administrator</button>
            <button type="submit" class="loginChoice" name="loginChoice" value="salesChoice">Salesman</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formSubmitted"])) {
            // Check which button was clicked
            $selectedOption = $_POST["loginChoice"];

            // Display a statement based on the selected option
            if ($selectedOption === "adminChoice") {
                header("Location: adminLogin.php");
                exit();
            } elseif ($selectedOption === "salesChoice") {
                header("Location: salesLogin.php");
                exit();
            }
        }
        ?>
    </div>
</body>


</html>