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

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Add your CSS stylesheets here -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
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
    <?php
        require_once "includes/createTopNavigation.php";
    ?>
        
    <script>
        window.onload = function() {
        // Get the tab name from the URL if available
        var urlParams = new URLSearchParams(window.location.search);
        var tabFromUrl = urlParams.get('tab');

        if (tabFromUrl) {
            openTab(tabFromUrl);
        } else {
            // If no tab is specified in the URL, default to the first tab
            openTab('about');
        }
    };

        function openTab(tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
        }
    </script>
    <!-- Main Content -->
    <div id="mainContainer">
        <button onclick="openTab('about')">About</button>
        <button onclick="openTab('activity')">Activity</button>
        <button onclick="openTab('messageWall')">Message Wall</button>
        <div id="about" class="tabcontent">
            <!-- Include content from about.php -->
            <?php include_once("about.php"); ?>
        </div>

        <div id="activity" class="tabcontent" style="display: none;">
            <!-- Include content from activity.php -->
            <?php include_once("activity.php"); ?>
        </div>

        <div id="messageWall" class="tabcontent" style="display: none;">
            <!-- Include content from activity.php -->
            <?php include_once("messageWall.php"); ?>
        </div>
    </div>
</body>
</html>