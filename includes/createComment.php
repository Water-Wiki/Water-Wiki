<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // we're not using htmlspecialchars() because we're not outputting any data with echo, we're just inserting data to database
    $userid = null;
    $content = $_POST["content"];
    $commentType = $_GET["commentType"];
    $id = $_GET["id"];
    echo $_SESSION['username'];
    $username = $_SESSION['username'];

    // Query for the id under username
    try {
        require_once "dbh.inc.php";

        $query = "SELECT userid FROM accounts WHERE username = :username;";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":username", $username);

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
            $userid = $row["userid"];
        }
    }

    // Insert with userid
    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO comments (content, userid," . $commentType . ") VALUES
        (:content, :userid, :id);";

        $stmt = $pdo->prepare($query); // statement, helps sanatize data

        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: .." . $_SESSION['lastPage']);

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    echo "There was a problem";
    die();
}