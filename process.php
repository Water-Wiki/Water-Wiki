<html>
    <head>
        <title>Processing</title>
    </head>
    <body>
        <?php
            if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["displayname"]))   {
                $conn = mysqli_connect("localhost", "root", "", "maindatabase");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];
                $displayname = $_POST["displayname"];
                $sql="SELECT * FROM account WHERE username='$username'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                if($count>0) {
                    echo "<script>alert('Registration unsuccessful. That userid is already taken.');window.location.href='Registration.php';</script>";
                }
                $sql="SELECT * FROM account WHERE email ='$email'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                if($count>0) {
                    echo "<script>alert('Registration unsuccessful. That email is already taken.');window.location.href='Registration.php';</script>";
                }
                $sql = "INSERT INTO account (username, password, email, displayname) VALUES ('$username', '$password', '$email', '$displayname')";
                $results = mysqli_query($conn, $sql);
                if ($results) {
                    mkdir("images/" . $username . "/", 0777);
                    mkdir("images/" . $username . "/deposits" . "/", 0777);
                    echo "<script>alert('Registration Successful');window.location.href='Login.php';</script>";
                }
                else {
                    echo mysqli_error($conn);
                }
                mysqli_close($conn);
            }
            else if ($_SESSION['logged_in'] == TRUE) header("Location: user.php");
            else header("Location: Login.php");
        ?>
    </body>
</html>