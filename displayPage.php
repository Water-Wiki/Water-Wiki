<?php
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
                </div>
                <form action="logout.php" method="post">
                    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>

            <!-- Main Content -->
            <?php
                echo "<h1>$title</h1>";
                echo "<h2>Description<h2>";

                if (empty($results)) {
                    echo "<p>There were no results!</p>";
                } else {
                    foreach ($results as $row) {
                        $title = htmlspecialchars($row["title"]);
                        $content = htmlspecialchars($row["content"]);
                        $created_at = htmlspecialchars($row["created_at"]);
                        $image = $row["image"];

                        echo $title . ": " . $content . " " . $created_at;
                        echo "<img src=" . $image . " alt=\"Image\">";
                    }
                }
            ?>

            <div id="mainContainer">
            <h1>Comments</h1>

            <form action="includes/createPage.php?categoryType=plant" method="post"> 
                    <label for="comment">Post a comment</label>
                    <br>
                    <textarea id="Comment" type="text" name="comment" placeholder="Enter what you want to comment..." rows="10" cols="100"></textarea>
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
                echo "<p>Nobdoy has commented, be the first to reply!</p>";
            } else {
                foreach ($results as $row) {
                    $username = htmlspecialchars($row["username"]);
                    $content = htmlspecialchars($row["content"]);
                    $created_at = htmlspecialchars($row["created_at"]);

                    echo $username . ": " . $content . " " . $created_at;
                }
            }
            ?>

            
            </div>

            <div>
                
            </div>
        </body>
    </head>
</html>

