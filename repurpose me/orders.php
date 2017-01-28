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
  if(isset($_SESSION['userID'])) {
    require('php/mysql_connect.php');
    openConnection();
    $orders = getByValueFrom('CustomerID',$_SESSION['userID'],'Orders');
    closeConnection();
  }
  else {
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
        <div class="row">
          <h3>Orders</h3>
          <?php if(mysqli_num_rows($orders) < 1) { ?>
            <p class="text-centered">Place an order.</p>
          <?php } else { ?>
            <table class="order-list-table">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>S&amp;H</th>
                  <th>Tax</th>
                  <th>Total</th>
                  <th>Date</th>
				</tr>
              </thead>
              <tbody>
			  <?php while($row = mysqli_fetch_assoc($orders)) {
				  date_default_timezone_set('America/New_York');
                  $time = strtotime($row['OrderDate']);
                  $orderDate = date("m/d/y g:i A", $time);
			  ?>
                  <tr>
                    <td>
                      <a href="order.php?orderId=<?php echo $row['OrderID']; ?>">
                        Order #<?php echo $row['OrderID']?>
                      </a>
                    </td>
                    <td>
                      $<?php echo number_format($row['ShippingCost'], 2);?>
                    </td>
                    <td>
                      $<?php echo number_format($row['Tax'], 2);?>
                    </td>
                    <td>
                      $<?php echo number_format($row['Total'], 2);?>
                    </td>
                    <td>
                      <?php echo $orderDate; ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
      </div>
    </div>
  </body>
</html>