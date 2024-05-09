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
<body>
    <!-- Top bar navigation -->
    <div class="navbar">
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
        
    </div>
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