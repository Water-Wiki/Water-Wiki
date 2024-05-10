<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forums</title>
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

</head>
    <body>
        <!-- Top bar navigation -->
        <?php
        require_once "includes/createTopNavigation.php";
        ?>

        <!-- Main Content -->
        <?php
        try {
            require_once "includes/dbh.inc.php";

            $query = "SELECT *
            FROM forums f
            JOIN accounts a ON f.userid = a.userid;";

            $stmt = $pdo->prepare($query); // statement, helps sanatize data
            
            $stmt->execute();
            // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
        }
        ?>    

        <!-- Display option to create post -->
        <div id="mainContainer">
        <h1>Post a Forum</h1>

        <form action="includes/createForum.php" method="post"> 
            <label for="title">Title</label>
                <br>
                <input required id="title" type="text" name="title" placeholder="Title of the post...">
    
                <br>
                <br>

                <label for="content">Description</label>
                <br>
                <textarea required id="content" type="text" name="content" placeholder="Describe more context about the post..." rows="10" cols="100"></textarea>
                <br>
                <br>
                <button type="submit">Post</button>
        </form>
    </div>

    <!-- Display all forums -->
    <div id="mainContainer">
    <h1>Forums</h1>

            <?php
            // Get all forums
            try {
                require_once "includes/dbh.inc.php"; // this say we want to run another file with all the code in that file

                $query = "SELECT f.created_at, f.content, a.username, f.forumid, f.title, f.userid
                FROM forums f
                JOIN accounts a ON f.userid = a.userid;";

                $stmt = $pdo->prepare($query); // statement, helps sanatize data
                
                $stmt->execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative

                $pdo = null;
                $stmt = null;
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
            }

            if (empty($results)) {
                echo "<h2>Nobody has posted, be the first to post!</h2>";
            } else {
                foreach (array_reverse($results) as $row) {
                    $title = $row["title"];
                    $forumid = $row["forumid"];
                    $username = htmlspecialchars($row["username"]);
                    $userid = htmlspecialchars($row["userid"]);
                    $commentContent = htmlspecialchars($row["content"]);
                    $created_at = htmlspecialchars($row["created_at"]);
                    $content = $row["content"];

                    echo '
                    <a href="displayForum.php?title=' . $title .'&forumid=' . $forumid . '"><h2>' . $title . '</h2></a>
                    <p>Posted by <a href="profile.php?userid=' . $userid . '">' . $username . '</a> on ' . $created_at . '</p><hr>
                    ';
                }
            }
            ?>
            </div>
    </body>
</html>