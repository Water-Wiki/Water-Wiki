<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database
    $title = $_POST["title"];
    $content = $_POST["content"];
    $image = $_POST["image"];
    $pageCategoryName = $_GET["pageCategoryName"];
    $pageCategoryid = NULL;

    // Query for the id under the categoryName
    try {
        require_once "dbh.inc.php";

        $query = "SELECT pageCategoryid FROM pageCategories WHERE pageCategoryName = :pageCategoryName;";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":pageCategoryName", $pageCategoryName);

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
            $pageCategoryid = $row["pageCategoryid"];
        }
    }

    echo "Query2";
    echo $pageCategoryid;

    // Insert with pageCategoryid
    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO pages (title, content, image, pageCategoryid) VALUES
        (:title, :content, :image, :pageCategoryid);";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":pageCategoryid", $pageCategoryid);

        $stmt->execute();

        $query = "SELECT pageid
        FROM pages
        ORDER BY pageid DESC
        LIMIT 1;";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative

        $pdo = null;
        $stmt = null;

        if (empty($results)) {
            echo "There was a problem.";
            die();
        } else {
            foreach ($results as $row) {
                $pageid = $row["pageid"];
            }
        }

        header("Location: ../displayPage.php?title=" . $title .'&pageid=' . $pageid);

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    header("Location: ../Home.html");
    echo "There was a problem";
}