<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database
    $title = $_POST["title"];
    $content = $_POST["content"];
    $image = $_POST["image"];
    $categoryName = $_GET["categoryName"];
    $categoryid = NULL;

    echo "Query1";
    echo $categoryName;

    // Query for the id under the categoryName
    try {
        require_once "dbh.inc.php";

        $query = "SELECT categoryid FROM pageCategories WHERE categoryName = :categoryName;";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":categoryName", $categoryName);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }

    if (empty($results)) {
        echo "There was a problem.";
        die();
    } else {
        foreach ($results as $row) {
            $categoryid = $row["categoryid"];
        }
    }

    echo "Query2";
    echo $categoryid;

    // Insert with categoryid
    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO pages (title, content, image, categoryid) VALUES
        (:title, :content, :image, :categoryid);";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":categoryid", $categoryid);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: ../displayPage.php?title=" . $title);

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    header("Location: ../Home.html");
    echo "There was a problem";
}