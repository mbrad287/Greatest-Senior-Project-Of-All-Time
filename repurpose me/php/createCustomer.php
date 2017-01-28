<!--
     Name:         Michael Bradley
     Project:      Project: Final Phase
     Purpose:      Create an on-line bookstore for viewing and ordering books.
     URL:          http://unixweb.kutztown.edu/~mbrad287/index.html
     Course:       CSC 242 - Spring 2016
     Due Date:     May 2, 2016
 -->

<?php
  require('storeMessage.php');
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $address = $_POST['address'];
  $address2 = $_POST['address2'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip = $_POST['zip'];
  $phone = $_POST['phone'];

  $valid = isset($fname) && isset($lname) && isset($email) && isset($password) && isset($address) && isset($city) && isset($state) && isset($zip);

  if(!$valid) {
    storeMessage('Invalid');
    header('Location: ../signup.php');
    die();
  }

  require('mysql_connect.php');
  openConnection();
  
  $emailCheck = getByValueFrom('Email', $email, 'Customers');
  if(mysqli_num_rows($emailCheck) > 0) {
    closeConnection();
    storeMessage('Account already created');
    header("Location: ../signup.php?email=".urlencode($email));
	die();
  }
  
  $query = "INSERT INTO `Customers` (`FirstName`, `LastName`, `Email`, `Passwd`,".
  "`Address1`, `Address2`, `City`, `State`, `ZipCode`, `PhoneNumber`) VALUES ('".
  mysqli_escape_string($connection, $fname)."', '".
  mysqli_escape_string($connection, $lname)."', '".
  mysqli_escape_string($connection, $email)."', '".
  mysqli_escape_string($connection, $password)."', '".
  mysqli_escape_string($connection, $address)."', '".
  mysqli_escape_string($connection, $address2)."', '".
  mysqli_escape_string($connection, $city)."', '".
  mysqli_escape_string($connection, $state)."', '".
  mysqli_escape_string($connection, $zip)."', '".
  mysqli_escape_string($connection, $phone)."');";
  if(runQuery($query)) {
    storeMessage('Your account has been created!', 'success');
    header('Location: ../books.php');
  }
  else {
    storeMessage('There was a problem creating your account: '.getError());
    header('Location: ../signup.php');
  }
  closeConnection();
?>
