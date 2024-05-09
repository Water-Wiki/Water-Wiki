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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $displayName = $_POST['displayName'];
    $bio = $_POST['bio'];

    // Prepare and execute SQL query to update profile
    $sql = "UPDATE Accounts SET displayname = :displayName, aboutMe = :bio WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['displayName' => $displayName, 'bio' => $bio, 'username' => $_SESSION['username']]);

    $username = $_SESSION['username'];
    $sql = "SELECT * FROM Accounts WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $userid = $userData['userid'];
    // Redirect back to profile page after updating profile
    header("Location: profile.php?userid=$userid");
    exit;
}

// Retrieve user information
$username = $_SESSION['username'];
$sql = "SELECT * FROM Accounts WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant List</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <!-- <link rel="stylesheet" href="styles/mainNavigation.css"> -->
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

    tr:nth-child(odd) {
        background-color: rgb(200, 200, 200);
    }

   
    img {
    width: 100px;
    height: 100px;
    max-width: 100%;
    max-height: 100%;
    z-index: -1;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>

</head>
    <body>
        <!-- Top bar navigation -->
        <div class="navbar">
            <a href="Home.php">Home</a>
            <div class="dropdown">
                <button class="dropbtn">Databases
                    <i class="fa fa-caret-down"></i>
                </button>
                
                <div class="dropdown-content">
                    <a href="plantList.html">Plants</a>
                    <a href="fertilizerList.html">Fertilizers</a>
                    <a href="toolList.html">Tools</a>
                    <a href="shopList.html">Shops</a>
                </div>
            </div>
        </div>

        <body>
    <!-- Main Content -->
    <div id="mainContainer">
        <h1>Edit Profile</h1>
        <!-- Form for updating display name and bio -->
        <form action="updateProfile.php" method="post">
            <label for="displayName">Display Name:</label><br>
            <input type="text" id="displayName" name="displayName" value="<?php echo $userData['displayName']; ?>"><br>
            <label for="bio">Bio:</label><br>
            <textarea id="bio" name="bio"><?php echo $userData['aboutMe']; ?></textarea><br>
            <input type="submit" value="Update Profile">
        </form>
    </div>
</body>
</html>