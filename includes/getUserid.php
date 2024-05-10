<?php
session_start();

// Check if reaction has already been given
try {
    require_once "dbh.inc.php";

    $query = "SELECT userid 
    FROM accounts
    WHERE username = :username;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $_SESSION['username']);

    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
}

?>