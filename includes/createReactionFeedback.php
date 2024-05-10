<?php
session_start();

$username = $_SESSION['username'];
$reactionType = $_GET["reactionType"]; // likes/dislikes
$postType = $_GET["postType"]; // forumid/commentid
$idType = $_GET["idType"]; // likeid/dislikeid
$id = $_GET["id"]; // id of forums/comments


// Get user id
require_once "getUserid.php";

// Check for the one you selected if exist under userid and targeted forum/comment
try {
    require_once "dbh.inc.php";

    $query = "SELECT $idType
    FROM $reactionType
    WHERE userid = :userid AND $postType = :id;";

    $stmt = $pdo->prepare($query); // statement, helps sanatize data

    $stmt->bindParam(":userid", $userid);
    $stmt->bindParam(":id", $id);

    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
}

// if the one you select has been voted, remove vote
if (!empty($results)) {
    foreach ($results as $row) {
        $reactionid = $row[$idType];
    }

    try {
        require_once "dbh.inc.php";
    
        $query = "DELETE FROM $reactionType
        WHERE $idType = :reactionid;"; // likeid/dislikeid = id;
    
        $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
        $stmt->bindParam(":reactionid", $reactionid);
    
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative

        $pdo = null;
        $stmt = null;

        header("Location: " . $_SESSION['lastPage']);
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
}

// Check for likes if exist under userid and targeted forum/comment
try {
    require_once "dbh.inc.php";

    $query = "SELECT likeid
    FROM likes
    WHERE userid = :userid AND $postType = :id;";

    $stmt = $pdo->prepare($query); // statement, helps sanatize data

    $stmt->bindParam(":userid", $userid);
    $stmt->bindParam(":id", $id);

    $stmt->execute();

    $likeResults = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
}

// Check for dislikes if exist under userid and targeted forum/comment
try {
    require_once "dbh.inc.php";

    $query = "SELECT dislikeid
    FROM dislikes
    WHERE userid = :userid AND $postType = :id;";

    $stmt = $pdo->prepare($query); // statement, helps sanatize data

    $stmt->bindParam(":userid", $userid);
    $stmt->bindParam(":id", $id);

    $stmt->execute();

    $dislikeResults = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
}

// if no result, add like/dislike
if (empty($likeResults) && empty($dislikeResults)) {
    try {
        require_once "dbh.inc.php";
    
        $query = "INSERT INTO $reactionType (userid, $postType) 
        VALUES (:userid, :id);";
    
        $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":id", $id);
    
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
        $query = "SELECT * FROM $reactionType WHERE (userid = :userid AND commentid = :commentid)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":commentid", $id);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $reactionid = $results[$idType];
        $query = "SELECT * FROM comments WHERE commentid = :commentid";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":commentid", $id);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $description = "";
        if ($idType == "likeid") {
            $description = " liked comment '" . $results['content'] . "'";
        } else {
            $description = " disliked comment '" . $results['content'] . "'";
        }
        $query = "INSERT INTO activities (userid, description, $idType) VALUES (:userid, :description, :id)";
        $stmt = $pdo->prepare($query); 

        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":id", $reactionid);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: " . $_SESSION['lastPage']);
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
}

echo "test1";
// if like is not empty, delete and insert to dislike
if (!empty($likeResults)) {
    foreach ($likeResults as $row) {
        $likeid = $row['likeid'];
    }

    try {
        require_once "dbh.inc.php";
    
        $query = "DELETE FROM likes
        WHERE likeid = :likeid;"; // likeid/dislikeid = id;
    
        $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
        $stmt->bindParam(":likeid", $likeid);
    
        $stmt->execute();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }

    try {
        require_once "dbh.inc.php";
    
        $query = "INSERT INTO dislikes (userid, $postType) 
        VALUES (:userid, :id);";
    
        $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":id", $id);
    
        $stmt->execute();
        $query = "SELECT * FROM dislikes WHERE (userid = :userid AND commentid = :commentid)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":commentid", $id);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $dislikeid = $results['dislikeid'];
        $query = "SELECT * FROM comments WHERE commentid = :commentid";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":commentid", $id);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $description = "";
        $description = " disliked comment '" . $results['content'] . "'";
        $query = "INSERT INTO activities (userid, description, dislikeid) VALUES (:userid, :description, :dislikeid)";
        $stmt = $pdo->prepare($query); 

        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":dislikeid", $dislikeid);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: " . $_SESSION['lastPage']);
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
}
echo "test2";
// if dislike is not empty, delete and insert to like
if (!empty($dislikeResults)) {
    foreach ($dislikeResults as $row) {
        $dislikeid = $row['dislikeid'];
    }

    try {
        require_once "dbh.inc.php";
    
        $query = "DELETE FROM dislikes
        WHERE dislikeid = :dislikeid;"; // likeid/dislikeid = id;
    
        $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
        $stmt->bindParam(":dislikeid", $dislikeid);
    
        $stmt->execute();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }

    try {
        require_once "dbh.inc.php";
    
        $query = "INSERT INTO likes (userid, $postType) 
        VALUES (:userid, :id);";
    
        $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":id", $id);
    
        $stmt->execute();
        $query = "SELECT * FROM likes WHERE (userid = :userid AND commentid = :commentid)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":commentid", $id);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $likeid = $results['likeid'];
        $query = "SELECT * FROM comments WHERE commentid = :commentid";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":commentid", $id);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $description = "";
        $description = " liked comment '" . $results['content'] . "'";
        $query = "INSERT INTO activities (userid, description, likeid) VALUES (:userid, :description, :likeid)";
        $stmt = $pdo->prepare($query); 

        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":likeid", $likeid);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: " . $_SESSION['lastPage']);
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }

}

?>