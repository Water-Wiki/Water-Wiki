<?php
// Step 1: Connect to the database
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
//$username = $_SESSION['username']; // Assuming the user ID is 1, replace it with the actual user ID

// Prepare the SQL query
//$sql = "SELECT userid FROM Accounts WHERE username = :username";

// Prepare and execute the statement
//$stmt = $pdo->prepare($sql);
//$stmt->execute(['username' => $username]);

// Fetch the user data
//$userdata = $stmt->fetch(PDO::FETCH_ASSOC);
//$userid = $userdata['userid'];

$sql = "SELECT *FROM ACTIVITIES JOIN ACCOUNTS ON ACTIVITIES.userid = ACCOUNTS.userid;";
$stmt = $pdo->prepare($sql);
$stmt->execute();

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
                <button onclick="location.href='profile.php';" class="profile-btn"><i class="fas fa-user"></i> Profile</button>
            </div>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div id="mainContainer">
        <?php if ($activity_data) : ?>
            <div>
                <h2>Activity</h2>
                <ul>
                    <?php foreach ($activity_data as $activity) : ?>
                        <li><a href="profile.php?userid=<?php echo $activity['userid']; ?>"><?php echo $activity['username']; ?></a><?php echo $activity['description']; ?> - <?php echo $activity['created_at']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else : ?>
            <p>Activity not found.</p>
        <?php endif; ?>
          <script src="scripts/main.js"></script>
        </div>
    </body>
</head>
</html>