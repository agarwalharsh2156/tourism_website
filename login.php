<?php 
// Database connection details - Replace with your actual credentials
$servername = "192.168.43.123";
$username = "Harsh";
$password ="9322136615";
$dbname = "db";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);


// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['name']) && isset($_POST['password'])) {

    // Sign-in processing
    $username = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
  
    // Check if username exists
    $sql = "SELECT * FROM clients WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
  
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
  
      // Verify password using password_verify function
      if (password_verify($password, $row['password'])) {
  
        // Login successful - Start a session and redirect
        session_start();
        $_SESSION['name'] = $username;
        header('Location: index.html');
      } else {
        $errorMsg = "Password khabar nathi??";
      }
    } else {
      $errorMsg = "Daal ma kai kadu chhe!!";
    }
  }else {
    // Neither sign-up nor sign-in data submitted
    $errorMsg = "Invalid request";
  }

  mysqli_close($conn);
?>


<html>
    <head>
        <meta charset="utf-8">
        <title>Kudo andar</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="authetication-style.css">
    </head>
    <body>
        <div class="container"> 
            <form class="form" action="login.php" method="post">
                <div class="form-title">
                    <strong>Log In</strong>
                </div>

                <br/>

                <input type="text"  name="name" placeholder="Username" required>
        
                <br/>

                <input type="password"  name="password" placeholder="Password" required>
                
                <br/>

                <button type="submit" value="Submit">Log In</button>
                
                <br/>

                <?php echo "<p>".$errorMsg."</p>" ?>

                <div class="redirect">
                    <p>Don't have an account? <a href="registration.php">Register</a></p>
                </div>
            </form>
        </div>
       
    </body>
</html>

