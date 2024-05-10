<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database
    $title = $_POST["title"];
    $content = $_POST["content"];
    $image = $_POST["image"];
    $pageid = $_GET["pageid"];

    // Query for the id under the categoryName
    try {
        require_once "dbh.inc.php";

        $query = "UPDATE pages
        SET title = :title, content = :content, image = :image
        WHERE pageid = :pageid;";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":pageid", $pageid);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        $website = "Location: displayPage.php?title=" . $title ."&pageid=" . $pageid;
        header("Location: ../displayPage.php?title=" . $title ."&pageid=" . $pageid);
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    header("Location: ../Home.php");
    echo "There was a problem";
}