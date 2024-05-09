<?php

// Database connection details - Replace with your actual credentials
$servername = "192.168.45.156";
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
} 
else if (isset($_POST['name']) && isset($_POST['password'])) {

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
      $errorMsg = "Invalid username or password";
    }
  } else {
    $errorMsg = "Invalid username or password";
  }
} else {
  // Neither sign-up nor sign-in data submitted
  $errorMsg = "Invalid request";
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authentication Response</title>
</head>
<body>
  <?php
  // Display success or error message based on processing outcome
  if (isset($successMsg)) {
    echo "<p style='color: green;'>$successMsg</p>";
  } else if (isset($errorMsg)) {
    echo "<p style='color: red;'>$errorMsg</p>";
  }
  ?>

  <a href="registration.html">Sign Up</a>
  <a href="login.html">Log In</a>
</body>
</html>
