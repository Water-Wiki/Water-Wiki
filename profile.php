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

    <!-- Main Content -->
    <div id="mainContainer">
        <button onclick="openTab('about')">About</button>
        <button onclick="openTab('activity')">Activity</button>
        <div id="about" class="tabcontent">
            <!-- Include content from about.php -->
            <?php include_once("about.php"); ?>
        </div>

        <div id="activity" class="tabcontent" style="display: none;">
            <!-- Include content from activity.php -->
            <?php include_once("activity.php"); ?>
        </div>
    </div>

    <script>
        function openTab(tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
        }
    </script>
</body>
</html>