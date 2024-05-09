<?php
// Step 1: Connect to the database
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

// Step 2: Retrieve user information
// You need to specify the user ID or username for which you want to display the profile
if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
    $username = $_SESSION['username'];
}
// Prepare the SQL query
$sql = "SELECT * FROM Accounts WHERE userid = :userid";

// Prepare and execute the statement
$stmt = $pdo->prepare($sql);
$stmt->execute(['userid' => $userid]);
// Fetch the user data
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$sql = "SELECT * FROM Accounts WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$userData2 = $stmt->fetch(PDO::FETCH_ASSOC);
$allowEdit = ($userid == $userData2['userid']);
// Step 3: Display the profile information
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
       
        <!-- Main Content -->
        <?php if ($userData) : ?>
            <div>
                <h1 style="display: inline;"><?php echo $userData['displayName']; ?></h1>
                <span class="username">(@<?php echo $userData['username']; ?>)</span>
            </div>
            <p>About: <?php echo $userData['aboutMe']; ?></p>
            <p>Joined <?php echo $userData['create_at']; ?></p>
            <?php if ($allowEdit) : ?>
            <a href="updateProfile.php" class="edit-profile-button">Edit Profile</a>
            <?php endif; ?>
        <?php else : ?>
            <p>User not found.</p>
        <?php endif; ?>
          <script src="scripts/main.js"></script>
    </body>
</html>