<?php

// Return information sent and method
var_dump($_SERVER["REQUEST_METHOD"]);

// if (isset($_POST["submit"])) {
//    echo "test1";
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST["firstname"]); // convert into html to avoid XSS
    $lastname = htmlspecialchars($_POST["lastname"]); // convert into html to avoid XSS
    $pets = htmlspecialchars($_POST["favoritepet"]); // convert into html to avoid XSS

    if (empty($firstname)) {
        exit(); // stop the script outside of if statement
        // header("Location: ../htmlForm.php"); // sends you to indicated file
    }

    // htmlentities() sanitize everything

    echo "<br>These are data the user entered";
    echo "<br>";
    echo $firstname;
    echo "<br>";
    echo $lastname;
    echo "<br>";
    echo $pets;
} else {
    // header("Location: ../htmlForm.php"); // sends you to indicated file
}