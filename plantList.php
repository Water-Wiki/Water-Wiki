<?php
try {
    require_once "includes/dbh.inc.php";

    $query = "SELECT p.*
    FROM pages p
    JOIN pageCategories pc ON p.pageCategoryid = pc.pageCategoryid
    WHERE pc.pageCategoryName = \"plant\";";

    $stmt = $pdo->prepare($query); // statement, helps sanatize data
    
    $stmt->execute();
    // $stmt->execute([$username, $pwd, $email]); // this can also be used, top may provide more readablility

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch associative

    $pdo = null; // Not required, but helps free up resources asap
    $stmt = null;
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage()); // terminate the entire script and output an error message
}
?>

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

    .navbar {
        display: flex;
        justify-content: space-between;
    }

    .logout-btn {
        padding: 14px 16px;
        margin-right: 20px; /* Adjust the margin as needed */
        background-color: #f44336;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .logout-btn:hover {
        background-color: #da190b;
    }

    .profile-btn {
        padding: 14px 16px;
        margin-left: 20px; /* Adjust the margin as needed */
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .profile-btn:hover {
        background-color: #45a049;
    }
}
</style>

</head>
    <body>
        <!-- Top bar navigation -->
        <?php
        require_once "includes/createTopNavigation.php";
        ?>

        <!-- Main Content -->
        <div id="mainContainer">
            <h1>Plant List</h1>

            <button id="openForm">Create Page</button>
            <br><br>

            <div id="overlay">
                <form action="includes/createPage.php?pageCategoryName=plant" method="post"> 
                    <label for="title">Title</label>
                    <br>
                    <input required id="Title" type="text" name="title" placeholder="Title...">
        
                    <br>
                    <br>

                    <label for="content">Description</label>
                    <br>
                    <textarea id="Content" type="text" name="content" placeholder="Description..." rows="10" cols="100"></textarea>
        
                    <br>
                    <br>

                    <label for="image">Image Link</label>
                    <br>
                    <input required id="Image" type="text" name="image" placeholder="Image URL...">
        
                    <br>
                    <br>
                    <button type="submit">Submit</button>
                </form>
            </div>

            <table>
                <tr>
                <th>Plants</th>
                <th>Difficulty</th>
                <th>Life Span</th>
                <th>Image</th>
                </tr>

                <?php
                    if (empty($results)) {
                        echo "<p>There were no results!</p>";
                    } else {
                        foreach ($results as $row) {
                            $pageid = $row['pageid'];
                            $title = htmlspecialchars($row["title"]);
                            $description = htmlspecialchars($row["content"]);
                            $created_at = htmlspecialchars($row["created_at"]);
                            $image = $row["image"];

                            echo '<tr>
                                <td><a href="displayPage.php?title=' . $title .'&pageid=' . $pageid . '">' . $title . '</a></td>
                                <td>Impossible</td>
                                <td>1 - 2 Days</td>
                                <td><img src="' . $image . '" alt="Image"></td>
                            </tr>';
                        }
                    }
                ?>

            </table>

        </div>
        <script src="scripts/main.js"></script>
    </body>
</html>