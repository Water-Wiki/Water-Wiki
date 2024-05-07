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
    FROM page
    WHERE title = \"" . $title . "\";";

    $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
    $stmt->execute();
    // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative

    $pdo = null; // Not required, but helps free up resources asap
    $stmt = null;
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
                <a href="Home.html">Home</a>
                <a href="#news">News</a>
                <a href="#news">News</a>
                <div class="dropdown">
                    <button class="dropbtn">Dropdown
                        <i class="fa fa-caret-down"></i>
                    </button>
                    
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
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
                        $description = htmlspecialchars($row["description"]);
                        $created_at = htmlspecialchars($row["created_at"]);
                        $image = $row["image"];

                        echo $title . ": " . $description . " " . $created_at;
                        echo "<img src=" . $image . " alt=\"Image\">";
                    }
                }
            ?>

        </body>
    </head>
</html>

