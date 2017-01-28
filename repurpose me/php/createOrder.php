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
  require('checkoutStatements.php');
  if(!isset($_SESSION['loggedIn'])) {
    storeMessage('You must be logged in to view.');
    header('Location: ../login.php');
    die();
  }
  if(empty($_SESSION['cart'])) {
    storeMessage('Cannot place order with an empty cart.');
    header('Location: ../books.php');
    die();
  }
  require('mysql_connect.php');
  openConnection();
  $productsResult = getAllFrom("Products");
  $items = array();
  while($row = mysqli_fetch_assoc($productsResult)) {
    $item = array(
      'price' => $row['Price'],
      'quantity' => $row['Quantity'],
      'name' => $row['Title']
    );
    $items[$row['ProductID']] = $item;
  }
  $badCount = 0;
  $needToUpdate = 'action=update';
  foreach($_SESSION['cart'] as $key => $item) {
    if($item['quantity'] > $items[$key]['quantity']) {
      $badCount++;
      $needToUpdate .= "&quantities[$key]=".$item['quantity'];
    }
  }
  if($badCount > 0) {
    storeMessage('Please check your cart.');
    header('Location: ../cart.php?'.$needToUpdate);
    die();
  }
  if(isset($_POST['shippingMethod']) && ($_POST['shippingMethod'] == 'E' || $_POST['shippingMethod'] == 'S')) {
    $shippingMethod = $_POST['shippingMethod'];
  }
  else {
    $shippingMethod = 'S';
  }
  $subTotal = calcSubTotal();
  $shipping = calcShipping($shippingMethod, $subTotal);
  $tax = $subTotal * 0.06;
  $total = $subTotal + $tax + $shipping;
  $insertOrderQuery = 'INSERT INTO `Orders` (`ShippingCost`,`CustomerID`, `Tax`, `Total`, `OrderDate`) VALUES (\''.
    mysqli_escape_string($connection, $shipping).'\', \''.
    mysqli_escape_string($connection, $_SESSION['userID']).'\', \''.
    mysqli_escape_string($connection, $tax).'\', \''.
    mysqli_escape_string($connection, $total).'\', now());';
  if(!runQuery($insertOrderQuery)){
    storeMessage('There was a problem creating your order: '.getError());
    header('Location: ../index.php');
    die();
  }
  $orderID = mysqli_insert_id($connection);

  foreach($_SESSION['cart'] as $key => $item) {
    $insertOrderDetailQuery = 'INSERT INTO `OrderDetails` (`OrderID`, `ProductID`, `Quantity`, `LineTotal`) VALUES (\''.
      mysqli_escape_string($connection, $orderID).'\', \''.
      mysqli_escape_string($connection, $key).'\', \''.
      mysqli_escape_string($connection, $item['quantity']).'\', \''.
      mysqli_escape_string($connection, $item['total']).'\');';
    if(!runQuery($insertOrderDetailQuery)) {
      storeMessage('There was a problem creating your order: '.getError());
      header('Location: ../index.php');
      die();
    }
    $newQuantity = $items[$key]['quantity'] - $item['quantity'];
    $updateBookQuery = "UPDATE `Products` SET `Quantity`='$newQuantity' WHERE `ProductID`='$key';";
    if(!runQuery($updateBookQuery)) {
      storeMessage('There was a problem creating your order: '.getError());
      header('Location: ../index.php');
      die();
    }
  }
  closeConnection();
  $_SESSION['cart'] = array();
  header('Location: ../order.php?orderId='.$orderID);
?>
