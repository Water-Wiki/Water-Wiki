<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant List</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <!-- <link rel="stylesheet" href="styles/mainNavigation.css"> -->
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
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    tr:nth-child(odd) {
        background-color: rgb(200, 200, 200);
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
</style>

    <body>
        <h1>Message Wall</h1>
        <?php
                $userid = $_GET["userid"];
                $commentType = "wallid";
                echo '<form action="includes/createComment.php?commentType=' . urlencode($commentType) . '&id=' . urlencode($userid) . '" method="post">';
            ?>
            <label for="content">Enter your message here:</label>
            <br>
            <textarea id="Content" type="text" name="content" required placeholder="Enter message..." rows="10" cols="100"></textarea>
            <br><br>
            <button type="submit">Submit</button>
</form>
                <br><br>

                <?php
                //$currentUrl = $_SERVER['REQUEST_URI'];
                $currentUrl = '../profile.php?userid=' . $userid . '&tab=messageWall';
                $_SESSION['lastPage'] = $currentUrl;
           try {
            require_once "includes/dbh.inc.php"; // this say we want to run another file with all the code in that file

            $userid = (int)$_GET["userid"];

            $query = "SELECT c.created_at, c.content, a.username, c.commentid, c.userid
            FROM comments c
            JOIN accounts a ON c.userid = a.userid
            WHERE c.wallid = :userid;";

            $stmt = $pdo->prepare($query); // statement, helps sanatize data

            $stmt->bindParam(":userid", $userid);
            
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
                $userid = htmlspecialchars($row['userid']);
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
                <button class="small" id="openReply' . $count . '">Reply</button>
                <a href="includes/createReactionFeedback.php?idType=likeid&reactionType=likes&postType=commentid&id=' . $commentid . '">
                    <button class="small">Upvote(' . $likeCount . ')</button>
                </a>

                <a href="includes/createReactionFeedback.php?idType=dislikeid&reactionType=dislikes&postType=commentid&id=' . $commentid . '">
                    <button class="small">Downvote(' . $dislikeCount . ')</button>
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
                        <button class="small" type="submit">Post Reply</button>
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
            <div class="chat-page">
                <div class="msg-inbox">
                    <div class="chats">
                        <div class="msg-page">
                        </div>
                    </div>
                </div>
            </div>
            <script src="scripts/main.js"></script>
    </body>
</html>