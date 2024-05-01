<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clickable Square with Background Image</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
</head>

<style>
    body {
        background-image: url('https://wallpapercave.com/wp/wp8335591.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }
</style>

</head>
    <body>
        <!-- Navigation bar -->
        <!-- <div class="topnav"> -->
            <!-- <div class="dropdown">
                <button class="dropbtn">Dropdown</button>
                
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div> -->

            <!-- <a href="#contact">Contact</a>
            <a href="#about">About</a> -->
        <!-- </div> -->

        <div class="navbar">
  <a href="#home">Home</a>
  <a href="#news">News</a>
  <div class="dropdown">
    <button class="dropbtn">Dropdown
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Link 1</a>
      <a href="#">Link 2</a>
      <a href="#">Link 3</a>
    </div>
  </div>
</div>

        <!-- <ul>
            <li><a class="active" href="#home">Home</a></li>
            <li><a href="#news">News</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#about">About</a></li>
        </ul> -->

        <!-- <script src="scripts\dropDownButton.js"></script> -->

        <!-- Main Content -->
        <div class="square" onclick="location.href='plantList.php';">
            <img src="images\Plant_List_Image.png" alt="Image">
            <p>Your Text Here</p>
        </div>

    </body>

</html>