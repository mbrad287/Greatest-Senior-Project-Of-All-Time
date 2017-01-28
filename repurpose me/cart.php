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
  if(!isset($_SESSION['loggedIn'])) {
    storeMessage('You must be logged in to view.');
    header('Location: login.php');
    die();
  }
  if(isset($_POST['action'])) {
    $action = $_POST['action'];
  }
  else if(isset($_GET['action'])) {
    $action = $_GET['action'];
  }
  else {
    $action = "view";
  }

  switch($action) {
    case 'add':
      $quantities = setupQuantities();
      $items = setupItems();
      foreach($quantities as $key => $quantity) {
        if(isset($_SESSION['cart'][$key]))
          $currentQuantity = $_SESSION['cart'][$key]['quantity'] + $quantity;
        else
          $currentQuantity = $quantity;
        if($quantity > 0 && $items[$key]['quantity'] >= $currentQuantity) {
          addToCart($key, $quantity);
        }
        else if($quantity > 0) {
          $quantityError = "Apologies. We do not currently carry '".$items[$key]['name']."' ";
          storeMessage($quantityError);
          updateItemInCart($key, $items[$key]['quantity']);
        }
      }
      header('Location: cart.php');
      die();
    break;
    case 'update':
      $quantities = setupQuantities();
      $items = setupItems();
      foreach($quantities as $key => $quantity) {
        if(isset($_SESSION['cart'][$key])) {
          if($items[$key]['quantity'] >= $quantity) {
            updateItemInCart($key, $quantity);
          }
          else {
            $quantityError = "Apologies. We do not currently carry '".$items[$key]['name']."' ";
            storeMessage($quantityError);
            updateItemInCart($key, $items[$key]['quantity']);
          }
        }
      }
      header('Location: cart.php');
      die();
    break;
  }
  function setupQuantities() {
    if(isset($_POST['quantities'])) {
      $quantities = $_POST['quantities'];
    }
    else if(isset($_GET['quantities'])) {
      $quantities = $_GET['quantities'];
    }
    else {
      storeMessage('Problem adding items to cart.');
      header('Location: cart.php');
      die();
    }
    return $quantities;
  }

  function setupItems() {
    require("php/mysql_connect.php");
    openConnection();
    $result = getAllFrom("Products");
    $items = array();
    while($row = mysqli_fetch_assoc($result)) {
      $item = array(
        'price' => $row['Price'],
        'quantity' => $row['Quantity'],
        'name' => $row['Title']
      );
      $items[$row['ProductID']] = $item;
    }
    closeConnection();
    return $items;
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

        <h3 class="text-centered">Cart</h3>
        <br>
        <?php if(empty($_SESSION['cart'])) { ?>
          <p class="text-centered">Your Cart is empty</p>
        <?php } else { ?>
          <form action="cart.php" method="GET">
            <input type="hidden" name="action" value="update" />
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
                      <input size="6" type="text" value="<?php echo $item['quantity'] ?>" name="quantities[<?php echo $key;?>]" />
                    </td>
                    <td>
                      $<?php echo number_format($item['price'], 2); ?>
                    </td>
                    <td style="text-align: right;">
                      $<?php echo number_format($item['total'], 2); ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td>
                    <label>
                      <input type="submit" value="Update">
                    </label>
                  </td>
                  <th style="text-align: right">Total:</th>
                  <td>$<?php echo number_format(calcTheSubTotal(), 2);?></td>
                </tr>
              </tfoot>
            </table>
          </form>
          <br />
          <div>
              <form action="checkout.php">
                    <label>
                      <input type="submit" value="Checkout">
                    </label>
              </form>
          </div>
        <?php }?>
      </div>
    </div>
  </body>
</html>
