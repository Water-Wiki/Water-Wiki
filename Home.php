<?php
session_start();
$dsn = "mysql:host=localhost;port=3307;dbname=main_database";
$dbusername = "root";
$dbpassword = "password";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Terminate the script if connection fails
}

if ($_SESSION['logged_in']) {
    $username= $_SESSION['username'];
}

$sql = "SELECT * FROM ACCOUNTS WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
$userid = $user_data['userid']
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <!-- <link rel="stylesheet" href="styles/mainNavigation.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<style>
    body {
        background-image: url('https://wallpapercave.com/wp/wp8335591.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
    }

    .logout-btn {
        padding: 14px 16px;
        margin-right: 20px; /* Adjust the margin as needed */
        background-color: #f44336;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .logout-btn:hover {
        background-color: #da190b;
    }

    .profile-btn {
        padding: 14px 16px;
        margin-left: 20px; /* Adjust the margin as needed */
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .profile-btn:hover {
        background-color: #45a049;
    }
</style>

</head>
    <body>
        <!-- Top bar navigation -->
        <div class="navbar">
            <div>
                <a href="Home.php">Home</a>
                <div class="dropdown">
                    <button class="dropbtn">Databases
                        <i class="fa fa-caret-down"></i>
                    </button>
                    
                    <div class="dropdown-content">
                        <a href="plantList.php">Plants</a>
                        <a href="fertilizerList.php">Fertilizers</a>
                        <a href="toolList.php">Tools</a>
                        <a href="shopList.php">Shops</a>
                    </div>
                </div>
                <button onclick="location.href='profile.php?userid=<?php echo $userid; ?>';" class="profile-btn"><i class="fas fa-user"></i> Profile</button>
            </div>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div id="mainContainer">
            <h1>The Water Wiki</h1>
            <hr>
            <p>Welcome to Water Wiki, a wiki about plant care.</p>
            <hr>
            <div class="imageContainer">
                <!-- <img src="img_snow_wide.jpg" alt="Snow" style="width:100%;">
                <div class="bottom-left">Bottom Left</div> -->

                <div class="square" onclick="location.href='plantList.php';">
                    <img src="https://vectorified.com/images/plant-icon-21.png" alt="Image">
                    <p>Plants</p>
                </div>

                <div class="square" onclick="location.href='fertilizerList.php';">
                    <img src="https://static.vecteezy.com/system/resources/previews/000/568/870/original/fertilizer-icon-vector.jpg" alt="Image">
                    <p>Fertilizer</p>
                </div>

                <div class="square" onclick="location.href='toolList.php';">
                    <img src="https://static.vecteezy.com/system/resources/previews/000/571/249/original/tool-icon-vector.jpg" alt="Image">
                    <p>Tools</p>
                </div>

                <div class="square" onclick="location.href='shopList.php';">
                    <img src="https://static.vecteezy.com/system/resources/previews/000/349/187/original/vector-shop-icon.jpg" alt="Image">
                    <p>Shops</p>
                </div>
            </div>
        </div>
    </body>
</html>