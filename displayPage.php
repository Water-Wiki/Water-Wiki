<?php
session_start();
$_SESSION['lastPage'] = $_SERVER['REQUEST_URI'];

try {
    require_once "includes/dbh.inc.php"; // this say we want to run another file with all the code in that file
    // require // same as include, but run an error
    // include // it will find the file, but if can't it will give a warning
    // include_once // does the same, but also checks if it has been included before, which will give a warning if it does

    $title = $_GET["title"];
    // The line below is usually not safe and data should be sanatized to avoid xss
    // $query = "INSERT INTO users (username, pwd, email) VALUES ($username, $pwd, $email);";

    $query = "SELECT *
    FROM pages
    WHERE title = \"" . $title . "\";";

    $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
    $stmt->execute();
    // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php
            echo "<title>$title</title>"
        ?>

        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/navigation.css">
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
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 0px;
            text-align: left;
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

    <head>
        <body>
            <!-- Top bar navigation -->
            <div class="navbar">
            <div>
                <a href="Home.html">Home</a>
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

                <div class="dropdown">
                    <button class="dropbtn">Profile
                        <i class="fa fa-caret-down"></i>
                    </button>
                
                    <div class="dropdown-content">
                        <a href="profile.html">Profile</a>
                        <a href="shopList.html">Signout</a>
                    </div>
                </div>
                <a href="messageWall.html">Message Wall</a>
                <a href="activity.html">Activity</a>
            </div>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div id="mainContainer">
            <table>
                <?php
                    echo "<td><h1>$title</h1><h2>Description</h2>";

                    if (empty($results)) {
                        echo "<p>There is no description!</p>";
                    } else {
                        foreach ($results as $row) {
                            $title = htmlspecialchars($row["title"]);
                            $content = htmlspecialchars($row["content"]);
                            $created_at = htmlspecialchars($row["created_at"]);
                            $image = $row["image"];

                            echo "<p>$content</p> <br> <p>Page was created on $created_at</p></td>";
                            echo "<td><img src=$image alt=\"Image\"></td>";
                        }
                    }
                ?>
            </table>

            <hr>
            <h1>Comments</h1>
            
            <?php
                $pageid = $_GET["pageid"];
                $commentType = "pageid";
                echo '<form action="includes/createComment.php?commentType=' . urlencode($commentType) . '&id=' . urlencode($pageid) . '" method="post">';
            ?>
                <label for="content">Post a comment</label>
                <br>
                <textarea id="Content" type="text" name="content" placeholder="Enter what you want to comment..." rows="10" cols="100"></textarea>
                <br>
                <button type="submit">Submit</button>
                <br><br>
            </form>

            <?php
            try {
                require_once "includes/dbh.inc.php"; // this say we want to run another file with all the code in that file

                $pageid = (int)$_GET["pageid"];

                $query = "SELECT c.created_at, c.content, a.username
                FROM comments c
                JOIN accounts a ON c.userid = a.userid
                WHERE c.pageid = :pageid;";

                $stmt = $pdo->prepare($query); // statement, helps sanatize data

                $stmt->bindParam(":pageid", $pageid);
                
                $stmt->execute();
                // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative

                $pdo = null; // Not required, but helps free up resources asap
                $stmt = null;
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
            }

            if (empty($results)) {
                echo "<p>Nobody has commented, be the first to reply!</p>";
            } else {
                
                foreach (array_reverse($results) as $row) {
                    $username = htmlspecialchars($row["username"]);
                    $content = htmlspecialchars($row["content"]);
                    $created_at = htmlspecialchars($row["created_at"]);

                    echo "<h3>$username:</h3><p>$content</p><p>Commented on $created_at</p><hr>";
                }
            }
            ?>
                
        </div>
        </body>
    </head>
</html>

