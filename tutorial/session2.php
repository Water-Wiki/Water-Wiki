<?php
session_start();

// unset($_SESSION["username"]); // remove data from this particular variable during session
session_unset(); // deletes all the session data
session_destroy(); // unsets the session ID on the server, but not the session id cookie
// if destroy is on its own, the effect will not take place until the user goes to the next page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    echo $_SESSION["username"];
    ?>

</body>

</html>