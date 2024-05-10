<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database
    $title = $_POST["title"];
    $content = $_POST["content"];

    // Query for the id under username
    require_once "getUserid.php";

    // Insert with userid
    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO forums (title, content, userid) VALUES
        (:title, :content, :userid);";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":userid", $userid);

        $stmt->execute();

        $query = "SELECT forumid
        FROM forums
        ORDER BY forumid DESC
        LIMIT 1;";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative

        if (empty($results)) {
            echo "There was a problem.";
            die();
        } else {
            foreach ($results as $row) {
                $forumid = $row["forumid"];
            }
        }

        $pdo = null;
        $stmt = null;

        header("Location: ../displayForum.php?title=" . $title .'&forumid=' . $forumid);

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    echo "There was a problem";
    die();
}