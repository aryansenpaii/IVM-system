
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM employee_login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $resultArray = mysqli_fetch_assoc($result);
    $access_type = $resultArray['access_type'];

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['user_role'] = $access_type; // or 'salesman'
        header("Location: dashboard.php");
                exit();
    } else {
        // Authentication failed
        echo "Invalid username or password.";
    }
}
?>