<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <p>This is a <?php echo "nice"; ?> paragraph!</p>

    <?php
    /*
    This is a big comment
    Like this
    Or that
    */

    // Print Hello World When true 
    if (true){
        echo "Hello World!";
        // New Line
        echo "<br>";
    }

    $name = "First Last";
    echo $name;

    // Arrays
    $names = ["Jack", "Time", "Tom"];

    // Empty Array
    $emptyArray = [];

    // Variable is waiting for type
    $empty;
    $null = null;
    ?>

    <!-- Built in Variable -->
    <?php
    echo $_SERVER["DOCUMENT_ROOT"];
    echo "<br>";
    echo $_SERVER["PHP_SELF"];
    echo "<br>";
    echo $_SERVER["SERVER_NAME"];
    echo "<br>";
    echo $_SERVER["REQUEST_METHOD"];
    echo "<br>";
    ?>

    <!-- GET method (If you want to show the user what is submitted) -->
    <?php
    // echo $_GET["name"];
    // echo $_GET["eyeColor"];
    ?>

    <!-- POST method (If you want to hide the information submitted from the user) -->
    <?php
    // echo $_REQUEST["name"];
    ?>

    <!-- FILE method -->
    <?php
    // echo $_FILES["name"];
    ?>

    <!-- COOKIE and SESSION method -->
    <?php
    // $_SESSION["username"] = "Kledman";
    // echo $_SESSION["username"];
    ?>

    <!-- ENVIRONMENT method -->
    <?php
    // $_ENV["name"];
    ?>

    <!-- Concatenate -->
    <?php
    echo "<br>";
    $a = "Hello";
    $b = "World";
    $c = $a . " " . $b;
    echo $c;
    ?>

    <!-- Arithmetic -->
    <?php
    echo "<br>";
    echo 2 + 3;
    echo "<br>";
    echo 3 - 2;
    echo "<br>";
    echo 1 * 2;
    echo "<br>";
    echo 2 / 2;
    echo "<br>";
    echo 5 % 4;
    echo "<br>";
    echo 6 ** 2; // to the power of
    ?>

    <!-- Compare Operators -->
    <?php
    echo "<br>";
    $a = 3;
    $b = "3";

    if ($a == $b){ // if the value are the same
        echo "this statement is true!"; // does print
    }

    if ($a === $b){ // if the value AND type are the same
        echo "this statement is true!"; // does not print
    }

    if ($a != $b){ // if the value are not the same
        echo "this statement is not true!"; // does not print
    }

    if ($a == $b and $b == $a){ // and operator
        echo "this statement is not true!"; // does not print
    }

    if ($a == $b && $b == $a){ // another and operator
        echo "this statement is not true!"; // does not print
    }

    if ($a == $b or $b == $a){ // or operator
        echo "this statement is not true!"; // does not print
    }

    if ($a == $b || $b == $a){ // another or operator
        echo "this statement is not true!"; // does not print
    }

    // increment operators
    echo ++$a; // add then echo
    echo $a++; // echo then add

    // decrement operators
    echo --$a; // subtract then echo
    echo $a--; // echo then subtract
    ?>

    <!-- Conditions and Control structure -->
    <?php
    echo "<br>";
    $a = 3;
    $b = "3";

    switch ($a) {
        case 1: // is $a == 1?
            echo "The first case is correct!";
            $a++;
        case 2:
            echo "The second case is correct!";
            break; // tells the code we're done
        case 3:
            echo "The third case is correct!"; // will still check if case 1 satisfies
            $a++;
        case 4:
            echo "The fourth case is correct!"; // will still check if case 1 satisfies
        default: // no condition is satisfied
            echo "None of the conditions were true!";
    }

    $result = match ($b) { // if data is the same and are the following
        1, 3, 5 => "Variable b is equal to 1, 3, or 5",
        4 => "Variable b is equal to four!",
        default => "None were a match"
    };

    echo $result; // if no conditions are met, an error will occur
    ?>

    <!-- Arrays -->
    <?php
    echo "<br>";
    $fruits = ["Apple", "Banana", "Cherry"]; // starts at index 0
    $fruits2 = ["Jackfruit", "Durian"];

    echo $fruits[1];

    // Insert value to array
    $fruits[] = "Orange";

    echo "<br>" . $fruits[3];

    // Replace a value
    $fruits[1] = "Pineapple";

    echo "<br>" . $fruits[1];

    // set element to null
    unset($fruits[1]);

    // deleting the element from start index to end index (shifting all elements after end index back)
    array_splice($fruits, 0, 1);

    echo "<br>" . $fruits[1];

    // Add mango to the end
    array_push($fruits, "Mango");
    echo "<br>";
    print_r($fruits); // prints everything in dictionary

    // Insert in between the data
    array_splice($fruits, 2, 0, "Kiwi");
    echo "<br>";
    print_r($fruits); // prints everything in dictionary

    // Insert another array in between the data
    array_splice($fruits, 2, 0, $fruits2);
    echo "<br>";
    print_r($fruits); // prints everything in dictionary
    ?>

    <!-- Nested Array -->
    <?php
    $fruits = [
        ["Apple", "Tomato"], 
        "Banana", 
        "Cherry"
    ]; // starts at index 0

    // Printing nested array
    echo "<br>";
    echo $fruits[0][1];
    ?>

    <!-- Dictionary -->
    <?php
    // Associative array
    $tasks = [
        "laundry" => "Zack",
        "trash" => "Bob",
        "dishes" => "Andy",
        "vacuum" => "Derrick"
    ];

    echo "<br>" . $tasks["trash"]; // echos who does the task
    print_r($tasks); // prints everything in dictionary
    echo "<br>" . count($tasks); // return array size
    sort($tasks); // sorted by alphabet, then number
    print_r($tasks); // prints everything in dictionary
    $tasks["dusting"] = "Catherine";
    print_r($tasks); // prints everything in dictionary
    ?>

    <!-- Nested Dictionary -->
    <?php
    $fruits = [
        "fruits" => ["apple", "potato", "cherry"],
        "meat" => ["Cow", "Pork"]
    ];

    // Printing nested dictionary
    echo "<br>";
    echo $fruits["fruits"][1];
    ?>

    <!-- Built-in Functions -->
    <?php
        $string = "Hello World!";

        echo "<br>" . strlen($string); // print the length of string
        echo "<br>" . strpos($string, "o"); // print the position of the first letter detected
        echo "<br>" . str_replace("World!", "Daniel", $string); // replace string
        echo "<br>" . strtolower($string); // convert string to lowercase
        echo "<br>" . strtoupper($string); // convert string to uppercase
        echo "<br>" . substr($string, 2, 5); // print string from start index to end (all if not specified)
        print_r(explode(" ", $string)); // place string into array (print readable)

        $number = -5.5;

        echo "<br>" . abs($number); // absolute number
        echo "<br>" . round($number); // absolute number
        echo "<br>" . pow(2, 3); // power of
        echo "<br>" . sqrt(16); // square root
        echo "<br>" . rand(1, 100); // return a random number
        
        $array = ["apple", "banana", "cherry"];
        $array2 = ["apple", "pumpkin"];

        echo "<br>" . is_array($array) . "<br>"; // 1 is true, 0 is false
        array_push($array, "kiwi"); // add kiwi to array
        print_r($array);
        echo "<br>";
        array_pop($array); // remove the last index
        print_r($array);
        echo "<br>";
        print_r(array_reverse($array)); // reverses the array
        echo "<br>";
        print_r(array_merge($array, $array2)); // add second array to the end of first array
        echo "<br>";

        // date
        echo "<br>" . date("Y-m-d H:i:s"); // print date based on format
        echo "<br>" . time(); // print seconds since January something (check online for more info)
        echo "<br>" . strtotime("2023-04-11 12:00:00"); // convert string to time
    ?>

    <!-- User Definited Functions -->
    <?php
        function SayMessage(string $message = "No message provided") {
            global $globalVariable;
            $globalVariable = true;
            echo "<br>" . $message;
            return "<br>" . "Message printed";
        }

        echo SayMessage("Hello World");
        echo SayMessage();
        echo "<br>" . $globalVariable;
    ?>

    <!-- Static Variable -->
    <?php
        function myFunction() {
            static $staticVariable = 0;
            $staticVariable++;
            return $staticVariable;
        }

        echo "<br>" . myFunction();
        echo "<br>" . myFunction();
        echo "<br>" . myFunction();
    ?>

    <!-- Constant Variable -->
    <?php
        define("PI", 3.14);
        // define("PI", 5.64); // this will cause an error message because PI is already defined
        echo "<br>" . PI;
    ?>

    <!-- Loops -->
    <?php
        // for loop
        for ($i = 0; $i <= 10; $i++) {
            echo "This is iteration number " . $i . "<br>";
        }

        // while loop
        $i = 1;
        while ($i < 10) {
            echo "This is iteration number " . $i . "<br>";
            $i++;
        }

        // do while loop (does at least one iteration)
        $i = 1;
        do {
            echo "This is iteration number " . $i . "<br>";
            $i++;
        }  while ($i < 10);

        // for each loop on array
        $fruits = ["Apple", "Banana", "Cherry"];

        foreach ($fruits as $fruit){
            echo "This is a " . $fruit . "<br>";
        }

        // for each loop on dictionaries
        $fruits = [
            "Apple" => "red", 
            "Banana" => "yellow", 
            "Cherry" => "red"
        ];

        foreach ($fruits as $fruit => $color){
            echo "<br> The " . $fruit . " is " . " $color";
        }
    ?>
</body>
</html>