<?php
    session_start();
    if (isset($_SESSION['login_error'])) {
        $error = $_SESSION['login_error'];
        echo "<script>alert('$error');</script>";
        unset($_SESSION['login_error']);
    }
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
        header("Location: Home.php");
        exit; 
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="styles/mystyles.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        
        <div class="wrapper">
            <form action="authentication.php" method="post"> 
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" placeholder="" name ="username" required>
                    <i class='bx bxs-user'></i>
                    <span class="floating-label">Username</span>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="" name="password" required>
                    <i class='bx bxs-lock-alt'></i>
                    <span class="floating-label">Password</span>
                </div>


                <button type="submit" class="btn">Login</button>

                <div class="register-link">
                    <p>Don't have an account? <a href="Registration.php">Register</a></p>
                </div>
                <div class="register-link">
                    <p><a href="Home.html">Home</a></p>
                </div>
            </form>
        </div>
    </body>
</html>