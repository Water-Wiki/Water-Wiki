<?php
// Get username from username from userid
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

if (empty($results)) {
    echo "There was a problem getting the user id.";
    die();
} else {
    foreach ($results as $row) {
        $userid = $row["userid"];
    }
}
?>