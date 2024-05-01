<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        require_once "dbh.inc.php"; // this say we want to run another file with all the code in that file
        // require // same as include, but run an error
        // include // it will find the file, but if can't it will give a warning
        // include_once // does the same, but also checks if it has been included before, which will give a warning if it does

        // The line below is usually not safe and data should be sanatized to avoid xss
        // $query = "INSERT INTO users (username, pwd, email) VALUES ($username, $pwd, $email);";

        $query = "UPDATE users 
        SET username = :username, pwd = :pwd, email = :email
        WHERE id = 3;";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $pwd);
        $stmt->bindParam(":email", $email);

        $stmt->execute();
        // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

        $pdo = null; // Not required, but helps free up resources asap
        $stmt = null;

        header("Location: ../login.php");

        die();
        // exit(); // if you're just closing off the script without a connection, use this
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    header("Location: ../login.php");
    echo "There was a problem";
}