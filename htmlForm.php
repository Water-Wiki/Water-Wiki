<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <main>
        <!-- <?php // echo $_SERVER["PHP_SELF"]; ?> included after action -->

        <!-- go to file website -->
        <form action="includes/formhandler.php" method="post"> 
            <label for="firstname">Firstname?</label>


            <input required id="firstname" type="text" name="firstname" placeholder="Firstname...">

            <label for="lastname">Lastname?</label>
            <input id="lastname" type="text" name="lastname" placeholder="Lastname...">

            <label for="favoritepet">Favorite Pet?</label>
            <select id="favoritepet" name="favoritepet">
                <option value="none">None</option>
                <option value="cat">Cat</option>
                <option value="dog">Dog</option>
                <option value="bird">Bird</option>
            </select>

            <button type="submit">Submit</button>
            <!-- <button type="submit" name="submit">Submit</button> if we're checking for type "submit", but this method is bad -->
        </form>
    </main>

</body>

</html>