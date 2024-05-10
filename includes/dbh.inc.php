<?php

$dsn = "mysql:host=localhost;port=3306;dbname=main_database";
$dbusername = "root";
$dbpassword = "";

try {
    // my sql connection (VERY BAD)
    // my sqli (sql improve, is ok, good for mysql databases)
    // pdo (php data object, very flexible with other databases)
    
    // we could just call this line, but in case of errors, we should use try-catch
    $pdo = new PDO($dsn, $dbusername, $dbpassword); // instantiate the database connection object
    // throws an exception on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // allow us to change some attribute such as changing how it handle errors
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}