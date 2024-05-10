<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database
    $title = $_POST["title"];
    $content = $_POST["content"];
    $forumid = $_GET["forumid"];

    // Query for the id under the categoryName
    try {
        require_once "dbh.inc.php";

        $query = "UPDATE forums
        SET title = :title, content = :content
        WHERE forumid = :forumid;";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":forumid", $forumid);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        $website = "Location: displayForum.php?title=" . $title ."&forumid=" . $forumid;
        header("Location: ../displayForum.php?title=" . $title ."&forumid=" . $forumid);
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    header("Location: ../Home.html");
    echo "There was a problem";
}