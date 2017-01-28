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
  $orderId = $_GET['orderId'];
  if(!isset($orderId)) {
    header("Location: orders.php");
    die();
  }
  if(!isset($_SESSION['loggedIn'])) {
    storeMessage('You must be logged in to view.');
    header('Location: login.php');
    die();
  }
  require('php/mysql_connect.php');
  openConnection();
  $result = getByValueFrom('OrderID', $orderId, 'Orders');
  $orderDetails = getByValueFrom('OrderID', $orderId, 'OrderDetails');
  closeConnection();

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
        <?php if(mysqli_num_rows($result) < 1) { ?>
          <p>Order not found</p>
        <?php } else {
          $row = mysqli_fetch_assoc($result);
          $customerResult = getByValueFrom('CustomerID', $row['CustomerID'], 'Customers');
          if(mysqli_num_rows($customerResult) < 1) {
            $customerName = "Customer not found";
          }
          else {
            $customerRow = mysqli_fetch_assoc($customerResult);
            $customerName = $customerRow['FirstName']." ".$customerRow['LastName'];
          }
          date_default_timezone_set('America/New_York');
		  $time = strtotime($row['OrderDate']);
          $orderDate = date("m/d/y g:i A", $time);
        ?>
          <p>
            <a href="orders.php">Orders</a> /
            <a href="order.php?orderId=<?php echo $row['OrderID'] ?>">Order #<?php echo $row['OrderID'] ?></a>

            <h3>Order: #<?php echo $row['OrderID'] ?><h3>
            <h4>Customer: <?php echo $customerName ?></h4>
            <h4>Date: <?php echo $orderDate ?></h4>
            <h4>Total: $<?php echo number_format($row['Total'],2); ?></h4>
            <h3>Order Details</h3>
          <table class="cart-list-table">
            <thead>
              <tr>
                <th>#</th>
                <th>ISBN</th>
                <th>Desciption</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>S&amp;H:</th>
                <td>$<?php echo number_format($row['ShippingCost'], 2); ?></td>
              </tr>
              <tr>
                <th>Tax:</th>
                <td>$<?php echo number_format($row['Tax'], 2); ?></td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>$<?php echo number_format($row['Total'], 2); ?></td>
              </tr>
            </tfoot>
            <tbody>
              <?php
                $count = 0;
                while($orderRow = mysqli_fetch_assoc($orderDetails)) {
                $count++;
                $productResult = getByValueFrom('ProductID', $orderRow['ProductID'], 'Products');
                $product = mysqli_fetch_assoc($productResult);
              ?>
                <tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo $orderRow['ProductID']; ?></td>
                  <td><?php echo $product['Title']; ?></td>
                  <td><?php echo $orderRow['Quantity']; ?></td>
                  <td>$<?php echo number_format($product['Price'], 2); ?></td>
                  <td>$<?php echo number_format($orderRow['LineTotal'], 2); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php }?>
      </div>
    </div>
  </body>
</html>
