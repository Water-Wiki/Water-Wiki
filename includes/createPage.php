<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database
    $title = $_POST["title"];
    $description = $_POST["description"];
    $image = $_POST["image"];

    try {
        require_once "dbh.inc.php"; // this say we want to run another file with all the code in that file
        // require // same as include, but run an error
        // include // it will find the file, but if can't it will give a warning
        // include_once // does the same, but also checks if it has been included before, which will give a warning if it does

        // The line below is usually not safe and data should be sanatized to avoid xss
        // $query = "INSERT INTO users (username, pwd, email) VALUES ($username, $pwd, $email);";

        $query = "INSERT INTO page (title, description, image) VALUES
        (:title, :description, :image);";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image", $image);

        $stmt->execute();
        // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

        $pdo = null; // Not required, but helps free up resources asap
        $stmt = null;

        header("Location: ../Home.html");

        die();
        // exit(); // if you're just closing off the script without a connection, use this
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    header("Location: ../Home.html");
    echo "There was a problem";
}