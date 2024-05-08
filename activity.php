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
$username = $_SESSION['username']; // Assuming the user ID is 1, replace it with the actual user ID

// Prepare the SQL query
$sql = "SELECT userid FROM Accounts WHERE username = :username";

// Prepare and execute the statement
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);

// Fetch the user data
$userdata = $stmt->fetch(PDO::FETCH_ASSOC);
$userid = $userdata['userid'];

$sql = "SELECT description, created_at FROM activities WHERE userid = :userid ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['userid' => $userid]);

$activity_data = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
        <!-- Top bar navigation -->
        <div class="navbar">
            <a href="Home.html">Home</a>
            <div class="dropdown">
                <button class="dropbtn">Databases
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div id="mainContainer">
            
        <div id="overlay" class="closed">
            <form action="includes/createPage.php?categoryType=plant" method="post"> 
                <label for="title">Title</label>
                <br>
                <input required id="Title" type="text" name="title" placeholder="Title...">
    
                <br>
                <br>

                <label for="description">Description</label>
                <br>
                <textarea id="Description" type="text" name="description" placeholder="Description..." rows="10" cols="100"></textarea>
    
                <br>
                <br>

                <label for="favoritepet">Image Link</label>
                <br>
                <input required id="Image" type="text" name="image" placeholder="Image URL...">
    
                <br>
                <br>
                <button type="submit">Submit</button>
            </form>
        </div>
        <?php if ($activity_data) : ?>
            <div>
                <h2>Activity</h2>
                <ul>
                    <?php foreach ($activity_data as $activity) : ?>
                        <li><?php echo $activity['description']; ?> - <?php echo $activity['created_at']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else : ?>
            <p>Activity not found.</p>
        <?php endif; ?>
          </div>
          <script src="scripts/main.js"></script>
    </body>
</html>