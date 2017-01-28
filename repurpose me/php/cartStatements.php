<!--
     Name:         Michael Bradley
     Project:      Project: Final Phase
     Purpose:      Create an on-line bookstore for viewing and ordering books.
     URL:          http://unixweb.kutztown.edu/~mbrad287/index.html
     Course:       CSC 242 - Spring 2016
     Due Date:     May 2, 2016
 -->

<?php
function addToCart($itemKey, $quantity) {
  global $items;
  $cart = setupCart();
  if(isset($cart[$itemKey])) {
    $currentItem = $cart[$itemKey];
    $quantity += $currentItem['quantity'];
    updateItemInCart($itemKey, $quantity);
  }
  else {
    $price = $items[$itemKey]['price'];
    $total = $items[$itemKey]['price'] * $quantity;
    $newItem = array(
      'name' => $items[$itemKey]['name'],
      'quantity' => $quantity,
      'total' => $total,
      'price' => $price
    );
    $cart[$itemKey] = $newItem;
    $_SESSION['cart'] = $cart;
  }
}

function updateItemInCart($itemKey, $quantity) {
  global $items;
  $cart = setupCart();
  if(isset($cart[$itemKey])) {
    if($quantity <= 0) {
      removeFromCart($itemKey);
      return;
    }
    else {
      $cart[$itemKey]['quantity'] = $quantity;
      $total = $cart[$itemKey]['quantity'] * $cart[$itemKey]['price'];
      $cart[$itemKey]['total'] = $total;
      $_SESSION['cart'] = $cart;
    }
  }

}

function removeFromCart($itemKey) {
  $cart = setupCart();
  unset($cart[$itemKey]);
  $_SESSION['cart'] = $cart;

}

function calcTheSubTotal() {
  $subTotal = 0;
  $cart = setupCart();
  foreach($cart as $item) {
    $subTotal += $item['total'];
  }
  return $subTotal;
}

function setupCart() {
  if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
  }
  return $_SESSION['cart'];
}
?>
