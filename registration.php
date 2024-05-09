<?php
    session_start();
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE)  {
       header("Location: home.html");
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        <link rel="stylesheet" href="styles/mystyles.css">
        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
        <script src="validation.js" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </head>
    <body>
        
        <div class="wrapper">
            <form action="process.php" id="register" method="post"> 
                <h1>Register</h1>
                <div class="input-box">
                    <input type="email" placeholder="" id="email" name ="email">
                    <span class="floating-label">Email</span>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="" id="username" name ="username">
                    <span class="floating-label">Username</span>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="" id="displayname" name ="displayname">
                    <span class="floating-label">Display Name</span>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="" id="password" name="password">
                    <span class="floating-label">Password (minimum 8 characters, 1 letter, & 1 number)</span>
                    <span id='message'></span>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="" id="cpassword" name="cpassword">
                    <span class="floating-label">Confirm Password</span>
                    <span id='message2'></span>
                    <script>
                        $('#password, #cpassword').on('keyup', function () {
                            if ($('#password').val() == $('#cpassword').val()) {
                                $('#message').html('Passwords Match ✓').css('color', 'green');
                                $('#message2').html('Passwords Match ✓').css('color', 'green');
                            } else {
                                $('#message').html('Passwords Do Not Match ✕').css('color', 'red');
                                $('#message2').html('Passwords Do Not Match ✕').css('color', 'red');
                            }
                        });
                    </script>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="register-link">
                    <p>Already have an account? <a href="Login.php">Login</a></p>
                </div>
            </form>
        </div>
    </body>
</html>