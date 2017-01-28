<!--
     Name:         Michael Bradley
     Project:      Project: Final Phase
     Purpose:      Create an on-line bookstore for viewing and ordering books.
     URL:          http://unixweb.kutztown.edu/~mbrad287/index.html
     Course:       CSC 242 - Spring 2016
     Due Date:     May 2, 2016
 -->
 
<?php
function calcSubTotal() {
  $subTotal = 0;
  $cart = setupTheCart();
  foreach($cart as $item) {
    $subTotal += $item['total'];
  }
  $subtotal = number_format($subTotal, 2);
  return $subTotal;
}

function calcShipping($shippingMethod, $subTotal) {
  $shipping = 0;
  switch($shippingMethod) {
    case 'E':
      $shipping = 5;
	case 'S':
    default:
      if($subTotal < 25)
        $shipping += 4.5;
      if($subTotal >= 25 && $subTotal < 50)
        $shipping += 7;
      if($subTotal > 50)
        $shipping += 10.25;
	
  }
  $shipping = number_format($shipping, 2);
  return $shipping;
}

function setupTheCart() {
  if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
  }
  return $_SESSION['cart'];
}

?>
