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

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
} else {
    $userid = 2;
}

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
        <!-- Main Content -->
        
            
        
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
          <script src="scripts/main.js"></script>
    </body>
</html>