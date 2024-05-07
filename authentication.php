<?php
session_start();
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are provided
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Authenticate the user (replace this with your authentication logic)
        $username = $_POST['username'];
        $password = $_POST['password'];
        $conn = mysqli_connect("localhost", "root", "", "maindatabase");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM account WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User found, verify password
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify password
            if ($password == $hashed_password) {
                // Password is correct, set session variables and redirect to user page
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                echo "success";
                header("Location: home.html");
                exit();
            } else {
                // Password is incorrect, redirect back to login page with error message
                $_SESSION['login_error'] = "Incorrect password";
                header("Location: login.php");
                exit();
            }
        } else {
            // User not found, redirect back to login page with error message
            $_SESSION['login_error'] = "User not found";
            header("Location: login.php");
            exit();
        }
    } else {
        // Redirect user back to login page if username or password is not provided
        header("Location: login.php");
        exit();
    }
} else {
    // Redirect user back to login page if form is not submitted
    header("Location: login.php");
    exit();
}
$conn->close();
?>