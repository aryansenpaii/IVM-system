<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVM-GEU</title>
</head>

<body>



    <div class=container>
        <h1>Welcome SalesPerson</h1>
        <h3>Please enter your details</h3>
        <form action="salesLogin.php" method="post">
            <input type="text" name="username" id="username" placeholder="Enter your username">
            <input type="password" name="password" id="password" placeholder="Enter your password">
            <button type="submit" class="loginButton">Log In</button>
        </form>

        <?php
        include('db_connection.php');
        include('auth.php');
        $_SESSION['user_role'] = 'sales'; // or 'salesman'
        ?>

<a href="index.php">Back</a>

    </div>


</body>

</html>