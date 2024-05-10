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

        $description = "";
        switch ($commentType) {
            case 'pageid':
                $query = "SELECT * FROM pages WHERE pageid = :id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $description = " commented on page '" . $results['title'] . "'";
                break;
            case 'forumid':
                $query = "SELECT * FROM forums WHERE forumid = :forumid";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":forumid", $id);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $description = " commented on forum '" . $results['title'] . "'";
                break;
            case 'wallid':
                $query = "SELECT * FROM accounts WHERE userid = :userid";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":userid", $id);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $description = " posted a message on the profile of '" . $results['username'] . "'";
                break;
            case 'replyid':
                $query = "SELECT * FROM comments WHERE commentid = :commentid";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":commentid", $id);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $description = " replied to comment '" . $results['content'] . "'";
                break;
            default:
                $description = " did something";
                break;
            }
        $query = "INSERT INTO activities (userid, description, " . $commentType . ") VALUES (:userid, :description, :id)";
        $stmt = $pdo->prepare($query); 

        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: " . $_SESSION['lastPage']);

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
} else {
    echo "There was a problem";
    die();
}