<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- go to same website -->
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post"> 
        <input required type="number" name="num1" placeholder="Enter first number...">

        <select name="operator">
            <option value="add">+</option>
            <option value="subtract">-</option>
            <option value="multiply">x</option>
            <option value="divide">/</option>
        </select>

        <input required type="number" name="num2" placeholder="Enter second number...">

        <button>Calculate</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = filter_input(INPUT_POST, "num1", FILTER_SANITIZE_NUMBER_FLOAT);
        $num2 = filter_input(INPUT_POST, "num2", FILTER_SANITIZE_NUMBER_FLOAT);
        $operator = htmlspecialchars($_POST["operator"]);

        // Error handlers
        $errors = false;

        if (empty($num1) || empty($num2) || empty($operator)) {
            echo "<p>Fill in all fields!</p>";
            $errors = true;
        }

        if (!is_numeric($num1) || !is_numeric($num2)) {
            echo "<p>Only write number!</p>";
            $errors = true;
        }

        // Calculate the numbers if no errors
        if (!$errors) {
            $value = 0;
            switch($operator) {
                case "add":
                    $value = $num1 + $num2;
                    break;
                case "subtract":
                    $value = $num1 - $num2;
                    break;
                case "multiply":
                    $value = $num1 * $num2;
                    break;
                case "divide":
                    $value = $num1 / $num2;
                    break;
                default:
                    echo "<p>Something went wrong!</p>";
            }
        }

        echo "<p>Result = " . $value . "</p>";
    }
    ?>

</body>

</html>