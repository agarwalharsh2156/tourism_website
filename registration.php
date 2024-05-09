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


// Check if form is submitted for sign-up or sign-in
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {


  // Sign-up processing
  $username = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm-password']);


  // Validate passwords match
  if ($password !== $confirmPassword) {
    $errorMsg = "Passwords do not match";
  }else {

    // Hash the password for secure storage
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //Verifying redundancy in email
    $sql = "SELECT email FROM clients";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);
      if ($email == $row['email']){
        $errorMsg="Email already exists";
      }
      else{
        //Insert user data into database
        $sql = "INSERT INTO clients (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
        if (mysqli_query($conn, $sql)) {
        $successMsg = "Registration successful! Please log in.";
        }else {
         $errorMsg = "Unable to Register";
        }
      }
    }
  }
} //else {
//     // Neither sign-up nor sign-in data submitted
//     $errorMsg = "Invalid request";
//   }

  mysqli_close($conn);
?>



<html>
    <head>
        <meta charset="utf-8">
        <title>Register Kravi lejo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="authetication-style.css">
    </head>
    <body>
        <div class="container"> 
            <form class="form" action="registration.php" method="post">
                <div class="form-title">
                    <b>Sign In</b>
                </div>
                <br>

                <input type="text"  name="name" required placeholder="Username">
        
                <br>
        
                <input type="email"  name="email" required placeholder="email">
        
                <br>
        
                <input type="password"  name="password" required placeholder="Password">
                
                <br>

                <input type="password" name="confirm-password" required placeholder="Confirm Password">

                <br>
                           
                <button type="submit" value="Submit" style="size: 110px;">Sign In</button>

                <?php
                    // Display success or error message based on processing outcome
                    if (isset($successMsg)) {
                      echo "<p>$successMsg</p>";
                    } else if (isset($errorMsg)) {
                      echo "<p>$errorMsg</p>";
                    }
                ?>
                    
                <br>

                <div class="redirect">
                    <p>Already have an account / Want to <a href="login.php">Login</a></p>
                </div>
            </form>
        </div>
        
    </body>
</html>
