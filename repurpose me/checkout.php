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
  require('php/storeMessage.php');
  require('php/cartStatements.php');
  require('php/checkoutStatements.php');
  if(!isset($_SESSION['loggedIn'])) {
    storeMessage('You must be logged in to view.');
    header('Location: login.php');
    die();
  }
?>

<html>
  <head>
    <title>Project</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/project.css" />
    <script type="text/javascript" src="javascript/Project.js"></script>
  </head>
  <body>
		<ul>
        <li><a href="index.php">Home</a></li>
		<li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
		<li><a href="books.php">Books</a></li>
		<li><a href="cart.php">Cart</a></li>
		<li><a href="orders.php">Orders</a></li>
		<li><a href="contact.php">Contact Us</a></li>
		<li><a href="php/logoutCustomer.php">Logout</a></li>
		</ul> 
    <div id="content">
      <div class="container">
        <?php require("php/viewMessage.php") ?>
        <h3 class="text-centered">Checkout</h3>
        <br>
        <?php if(empty($_SESSION['cart'])) { ?>
          <p>Your Cart is empty</p>
        <?php } else { ?>
          <table class="cart-list-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($_SESSION['cart'] as $key => $item) { ?>
                <tr>
                  <td>
                    <a href="book.php?bookId=<?php echo $key; ?>">
                      <?php echo $item['name']; ?>
                    </a>
                  </td>
                  <td>
                    <?php echo $item['quantity'] ?>
                  </td>
                  <td>
                    $<?php echo number_format($item['price'], 2); ?>
                  </td>
                  <td>
                    $<?php echo number_format($item['total'], 2); ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <?php
            if(isset($_GET['shippingMethod']) && ($_GET['shippingMethod'] == 'E' || $_GET['shippingMethod'] == 'S')) {
              $shippingMethod = $_GET['shippingMethod'];
            }
            else {
              $shippingMethod = 'S';
            }
            $subTotal = calcSubTotal();
            $shipping = calcShipping($shippingMethod, $subTotal);
            $tax = $subTotal * 0.06;
            $total = $subTotal + $tax + $shipping;
            ?>
            <tfoot>
              <tr>
                <td></td>
                <td></td>
                <th style="text-align: right;">Sub-Total:</th>
                <td>$<?php echo number_format($subTotal, 2);?></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <th style="text-align: right;">Tax:</th>
                <td>$<?php echo number_format($tax, 2);?></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <th style="text-align: right;">Shipping:</th>
                <td>$<?php echo number_format($shipping, 2);?></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <th style="text-align: right;">Total:</th>
                <td>$<?php echo number_format($total, 2);?></td>
              </tr>
            </tfoot>
          </table>
          <div class="row">
              <form method="GET">
                  Shipping Method:
                    <p>
					<label>
                      Standard: <input type="radio" name="shippingMethod" value="S" <?php if($shippingMethod == 'S') { echo'checked'; } ?> />
                    </label>
                    <label>
                      Expedited: <input type="radio" name="shippingMethod" value="E" <?php if($shippingMethod == 'E') { echo'checked'; } ?> />
                    </label>
                    <input type="submit" value="Update">
					</p>
              </form>
              <form action="php/createOrder.php" method="POST">
                  <input type="hidden" name="shippingMethod" value="<?php echo $shippingMethod; ?>" />   
                    <label>
					  <input type="button" value="Back to Cart" onClick="history.go(-1);">
					</label>
					<label>
                      <input type="submit" value="Place Order">
                    </label>
              </form>
          </div>
        <?php }?>
      </div>
    </div>
  </body>
</html>
