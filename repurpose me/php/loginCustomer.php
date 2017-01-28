<!--
     Name:         Michael Bradley
     Project:      Project: Final Phase
     Purpose:      Create an on-line bookstore for viewing and ordering books.
     URL:          http://unixweb.kutztown.edu/~mbrad287/index.html
     Course:       CSC 242 - Spring 2016
     Due Date:     May 2, 2016
 -->
 
<?php
  session_start();
  require('storeMessage.php');
  require('mysql_connect.php');
  $email = $_POST['email'];
  $password = $_POST['password'];

  $valid = isset($email) && isset($password);
  if(!$valid) {
    closeConnection();
    storeMessage('Invalid Login');
    header('Location: ../login.php');
    die();
  }
  openConnection();
  $emailCheck = getByValueFrom('Email', $email, 'Customers');
  if(mysqli_num_rows($emailCheck) < 1) {
    closeConnection();
    storeMessage('Invalid Email');
    header("Location: ../login.php?email=".urlencode($email));
    die();
  }
  $query = "SELECT * FROM `Customers` WHERE `Email` = '".
  mysqli_escape_string($connection, $email)."' AND `Passwd` ='".
  mysqli_escape_string($connection, $password)."';";

  $result = runQuery($query);
  if(mysqli_num_rows($result) < 1) {
    closeConnection();
    storeMessage('Invalid Email/Password');
    header('Location: ../login.php?email='.urlencode($email));
    die();
  }
  $user = mysqli_fetch_assoc($result);
  $_SESSION['loggedIn'] = true;
  $_SESSION['userID'] = $user['CustomerID'];
  $_SESSION['cart'] = array();
  closeConnection();
  storeMessage('You have successfully logged in');
  header('Location: ../books.php');
?>
