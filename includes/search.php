<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database

    try {
        require_once "includes/dbh.inc.php"; // this say we want to run another file with all the code in that file
        // require // same as include, but run an error
        // include // it will find the file, but if can't it will give a warning
        // include_once // does the same, but also checks if it has been included before, which will give a warning if it does

        // The line below is usually not safe and data should be sanatized to avoid xss
        // $query = "INSERT INTO users (username, pwd, email) VALUES ($username, $pwd, $email);";

        $query = "SELECT *
        FROM page;";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->bindParam(":title", $title);

        $stmt->execute();
        // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative

        $pdo = null; // Not required, but helps free up resources asap
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    echo "There was a problem";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
        echo "<title> . $title . </title>"
    ?>

</head>

<body>

    <h3>Search results:</h3>

    <?php
        if (empty($results)) {
            echo "<p>There were no results!</p>";
        } else {
            foreach ($results as $row) {
                $title = htmlspecialchars($row["title"]);
                $description = htmlspecialchars($row["description"]);
                $created_at = htmlspecialchars($row["created_at"]);

                echo "<div>";
                echo $title . ": " . $description . " " . $created_at . "<br>";
                echo "</div>";
            }
        }
    ?>

</body>

</html>