<?php

// database connection details
$servername = "192.168.43.123";
$username = "Harsh";
$password ="9322136615";
$dbname = "db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
$info;
$info_result;
$image;
$img_result;

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    // Write a command to return the image associated to the search name
    $sql1 = "SELECT img FROM content_tab2 WHERE name ='$search'";
    $img_result = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($img_result) > 0) {
        $image = mysqli_fetch_assoc($img_result);
    }

    // Write a command to return the content information associated to the search name
    $sql2 = "SELECT * FROM content_tab2 WHERE name='$search'";
    $info_result = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($info_result) > 0) {
        $info = mysqli_fetch_assoc($info_result);
    }

}
?>


<!DOCTYPE html>
<html>
<head>
<title>Ghoomo Gujarat</title>
<link rel="stylesheet" href="search.css">
</head>

<body>
    <header>
        <div class="logo">
          <img src="Images/gujarat-tourism-logo.png" alt="Website Logo">
        </div>
        <div class="site-name">
          <h1>Gujarat Tourism</h1>
        </div>
        <div class="search-bar">
          <form action="search.php" method="get">
            <input type="text" name="search" placeholder="Search">
            <input type="submit">
          </form>
        </div>
      
        <nav>
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="registration.php">SignIn</a></li>
            <li><a href="login.php">LogIn</a></li>
          </ul>
        </nav>
      
      </header>

      <section class="content">

        <div id="content-img">
          <img src="<?php echo $image['img'] ?>">
        </div>

        <div id="content">
          
          <div >
            <?php echo "<p>".$info['name']."</p>" ?>
          </div>

          <div>
            <?php echo "<p>".$info['description']."</p>" ?>
          </div>

        </div>

      </section>

      <footer>
        <div>Contact: +91-000xxx000</div>
        <div>Email: govofguj@guj.com</div>
        <div>Instagram: gov_of_gujtour</div>
      </footer>
</body>