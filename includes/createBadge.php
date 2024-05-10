<?php
$username = $_SESSION['username'];
$badgeTypeid = null;

require_once "getUserid.php";

function hasBadge($userid, $badgeTypeid) {
    try {
        require "dbh.inc.php";
    
        $query = "SELECT *
        FROM accounts a
        JOIN badges b ON a.userid = b.userid
        WHERE b.badgeTypeid = :badgeTypeid AND a.userid = :userid;";
    
        $stmt = $pdo->prepare($query);
    
        $stmt->bindParam(":badgeTypeid", $badgeTypeid);
        $stmt->bindParam(":userid", $userid);
    
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }

    if (empty($results)) {
        return false;
    } else {
        return true;
    }
}

function getBadgeid($badgeTypeName) {
    try {
        require "dbh.inc.php";
    
        $query = "SELECT badgeTypeid 
        FROM badgetypes
        WHERE badgeTypeName = :badgeTypeName;";
    
        $stmt = $pdo->prepare($query);
    
        $stmt->bindParam(":badgeTypeName", $badgeTypeName);
    
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
    
    if (empty($results)) {
        echo "There was a problem getting the badge id or badge name is wrong.";
        die();
    } else {
        foreach ($results as $row) {
            $badgeTypeid = $row["badgeTypeid"];
        }
    }

    return $badgeTypeid;
}

function createBadge($userid, $badgeTypeid) {
    try {
        require "dbh.inc.php";
    
        $query = "INSERT INTO badges (userid, badgeTypeid) 
        VALUES (:userid, :badgeTypeid);";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":userid", $userid);
        $stmt->bindParam(":badgeTypeid", $badgeTypeid);
    
        $stmt->execute();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
    }
}

if (!hasBadge($userid, getBadgeid($badgeTypeName))) {
    createBadge($userid, getBadgeid($badgeTypeName));
    echo "<script>alert(\"You've been awarded the [" . $badgeTypeName . "] badge!\")</script>";
}

return;