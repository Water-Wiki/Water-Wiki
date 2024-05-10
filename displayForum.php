<?php
session_start();
$badgeTypeName = "First Post";
require_once "includes/createBadge.php";
$_SESSION['lastPage'] = $_SERVER['REQUEST_URI'];
$forumid = $_GET["forumid"];

try {
    require_once "includes/dbh.inc.php"; // this say we want to run another file with all the code in that file
    // require // same as include, but run an error
    // include // it will find the file, but if can't it will give a warning
    // include_once // does the same, but also checks if it has been included before, which will give a warning if it does

    $title = $_GET["title"];
    // The line below is usually not safe and data should be sanatized to avoid xss
    // $query = "INSERT INTO users (username, pwd, email) VALUES ($username, $pwd, $email);";

    $query = "SELECT *
    FROM forums
    WHERE title = \"" . $title . "\";";

    $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
    $stmt->execute();
    // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php
            echo "<title>$title</title>"
        ?>

        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>

    <style>
        body {
            background-image: url('https://wallpapercave.com/wp/wp8335591.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 0px;
            text-align: left;
        }

        img {
        width: 100px;
        height: 100px;
        max-width: 100%;
        max-height: 100%;
        z-index: -1;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    #forumOverlay {
        display: none;
    }

    </style>

        <body>
        <!-- Top bar navigation -->
        <?php
        require_once "includes/createTopNavigation.php";
        ?>

        <!-- Main Content -->
        <div id="mainContainer">
        <button id="openForm">Edit Forum Post</button>
            <br>

            <div id="overlay">
                <?php
                echo '<form action="includes/updateForum.php?forumid=' . urlencode($_GET["forumid"]) . '" method="post">';
                ?>
                    <label for="title">Title</label>
                    <br>
                    <input required id="forumTitle" type="text" name="title" placeholder="Title...">
        
                    <br>
                    <br>

                    <label for="content">Description</label>
                    <br>
                    <textarea required id="forumContent" type="text" name="content" placeholder="Description..." rows="10" cols="100"></textarea>
        
                    <br>
                    <br>

                    <button type="submit">Submit</button>
                </form>
            </div>
            
            <table>
                <?php
                    echo "<td><h1>$title</h1><br>";

                    if (empty($results)) {
                        echo "<p>There is no description!</p>";
                    } else {
                        foreach ($results as $row) {
                            $title = htmlspecialchars($row["title"]);
                            $content = htmlspecialchars($row["content"]);
                            $created_at = htmlspecialchars($row["created_at"]);

                            echo "<h3>$content</h3> <br> <p>Forum was created on $created_at</p></td>";
                        }
                    }
                ?>
            </table>

            <?php
            // Get Count of LIKES under forumid
            try {
                require_once "includes/dbh.inc.php";
        
                $query = "SELECT COUNT(*) AS count
                FROM likes
                WHERE forumid = :forumid;";
        
                $stmt = $pdo->prepare($query); // statement, helps sanatize data
        
                $stmt->bindParam(":forumid", $forumid);
        
                $stmt->execute();
        
                $likeCount = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
            }

            // Get Count of DISLIKES under forumid
            try {
                require_once "includes/dbh.inc.php";
        
                $query = "SELECT COUNT(*) AS count
                FROM dislikes
                WHERE forumid = :forumid;";
        
                $stmt = $pdo->prepare($query); // statement, helps sanatize data
        
                $stmt->bindParam(":forumid", $forumid);
        
                $stmt->execute();
        
                $dislikeCount = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
            }

            if (empty($likeCount)) {
                echo "<p>There is no description!</p>";
            } else {
                foreach ($likeCount as $row) {
                    $likeCount = $row["count"];
                }
            }

            if (empty($dislikeCount)) {
                echo "<p>There is no description!</p>";
            } else {
                foreach ($dislikeCount as $row) {
                    $dislikeCount = $row["count"];
                }
            }

            echo '
                <a href="includes/createReactionFeedback.php?idType=likeid&reactionType=likes&postType=forumid&id=' . $forumid . '">
                    <button>Upvote(' . $likeCount . ')</button>
                </a>
                <a href="includes/createReactionFeedback.php?idType=dislikeid&reactionType=dislikes&postType=forumid&id=' . $forumid . '">
                    <button>Downvote(' . $dislikeCount . ')</button>
                </a>
            ';
            ?>

            <hr>
            <h1>Comments</h1>
            
            <?php
                $forumid = $_GET["forumid"];
                $commentType = "forumid";
                echo '<form action="includes/createComment.php?commentType=' . urlencode($commentType) . '&id=' . urlencode($forumid) . '" method="post">';
            ?>
                <label for="content">Post a comment</label>
                <br>
                <textarea id="Content" type="text" name="content" required placeholder="Enter what you want to comment..." rows="10" cols="100"></textarea>
                <br><br>
                <button type="submit">Submit</button>
                <br><br>
            </form>

            <?php
            try {
                require_once "includes/dbh.inc.php"; // this say we want to run another file with all the code in that file

                $forumid = (int)$_GET["forumid"];

                $query = "SELECT c.created_at, c.content, a.username, c.commentid, c.userid
                FROM comments c
                JOIN accounts a ON c.userid = a.userid
                WHERE c.forumid = :forumid;";

                $stmt = $pdo->prepare($query); // statement, helps sanatize data

                $stmt->bindParam(":forumid", $forumid);
                
                $stmt->execute();
                // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
            }

            if (empty($results)) {
                echo "<p>Nobody has commented, be the first to reply!</p>";
            } else {
                $count = 0;

                foreach (array_reverse($results) as $row) {
                    $count++;
                    $commentType = "replyid";

                    $commentid = $row["commentid"];
                    $username = htmlspecialchars($row["username"]);
                    $userid = htmlspecialchars($row["username"]);
                    $commentContent = htmlspecialchars($row["content"]);
                    $created_at = htmlspecialchars($row["created_at"]);

                    // Get Count of LIKES under commentid
                    try {
                        require_once "includes/dbh.inc.php";
                
                        $query = "SELECT COUNT(*) AS count
                        FROM likes
                        WHERE commentid = :commentid;";
                
                        $stmt = $pdo->prepare($query); // statement, helps sanatize data
                
                        $stmt->bindParam(":commentid", $commentid);
                
                        $stmt->execute();
                
                        $likeCount = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
                    } catch (PDOException $e) {
                        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
                    }

                    // Get Count of DISLIKES under commentid
                    try {
                        require_once "includes/dbh.inc.php";
                
                        $query = "SELECT COUNT(*) AS count
                        FROM dislikes
                        WHERE commentid = :commentid;";
                
                        $stmt = $pdo->prepare($query); // statement, helps sanatize data
                
                        $stmt->bindParam(":commentid", $commentid);
                
                        $stmt->execute();
                
                        $dislikeCount = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
                    } catch (PDOException $e) {
                        die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
                    }

                    if (empty($likeCount)) {
                        echo "<p>There is no description!</p>";
                    } else {
                        foreach ($likeCount as $row) {
                            $likeCount = $row["count"];
                        }
                    }

                    if (empty($dislikeCount)) {
                        echo "<p>There is no description!</p>";
                    } else {
                        foreach ($dislikeCount as $row) {
                            $dislikeCount = $row["count"];
                        }
                    }

                    echo '
                    <style>
                    #replyOverlay' . $count . ' {
                        display: none;
                    }
                    </style>

                    <h3>' . $commentContent . '</h3>
                    <p>Commented by <a href="profile.php?userid=' . $userid . '">' . $username . '</a> on ' . $created_at . '</p>

                    <div>
                    <button id="openReply' . $count . '">Reply</button>

                    <a href="includes/createReactionFeedback.php?idType=likeid&reactionType=likes&postType=commentid&id=' . $commentid . '">
                        <button>Upvote(' . $likeCount . ')</button>
                    </a>

                    <a href="includes/createReactionFeedback.php?idType=dislikeid&reactionType=dislikes&postType=commentid&id=' . $commentid . '">
                        <button>Downvote(' . $dislikeCount . ')</button>
                    </a>

                    </div>
                    
                    <div id="replyOverlay' . $count . '">
                        <form action="includes/createComment.php?commentType=' . urlencode($commentType) . '&id=' . urlencode($commentid) . '" method="post">
                            <br>
                            <label for="content">Post a reply</label>
                            <br>
                            <textarea required id="replyContent" type="text" name="content" placeholder="Enter what you want to reply with..." rows="10" cols="100"></textarea>
                
                            <br>
                            <br>
                            <button type="submit">Post Reply</button>
                        </form>
                    </div><hr>

                    <script>
                        document.getElementById("openReply' . $count . '").addEventListener(\'click\', x => {
                            if (document.getElementById("replyOverlay' . $count . '").style.display == "none") {
                                document.getElementById("replyOverlay' . $count . '").style.display = "block";
                            } else {
                                document.getElementById("replyOverlay' . $count . '").style.display = "none";
                            };
                        });
                    </script>
                    ';
                }
                $pdo = null;
                $stmt = null;
            }
            ?>
                
        </div>

    <script>
    window.onload = function() {
        <?php
        echo "document.getElementById('forumTitle').value = '$title';
        document.getElementById('forumContent').value = '$content';"
        ?>
    };
    </script>

    <script src="scripts/main.js"></script>
    </body>
</html>

