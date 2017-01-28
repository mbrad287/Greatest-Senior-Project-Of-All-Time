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
  require("php/mysql_connect.php");
  openConnection();
  $products = getlikeValueFrom("ProductID", $_GET['q'], "Products");
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
        <p><a href="books.php">Books</a> /
          <a href="titleSearch.php?q=<?php echo $_GET['q']; ?>">ISBN Search</a>
        </p>
        <form action="titleSearch.php" method="GET">
          <label>Results
            <input type="text" name="q" value="<?php echo $_GET['q']; ?>" />
          </label>
          <label class="button-right">
            <input type="reset" value="Reset">
            <input type="submit" value="Submit">
          </label>
        </form>
        <?php if(isset($_SESSION['loggedIn'])) { ?>
          <form action="cart.php" method="GET">
            <input type="hidden" name="action" value="add" />
            <table class="book-list-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Quantity</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <td></td>
                  <td>
                    <label>
                      <input type="reset" value="Clear" />
                    </label>
                    <label>
                      <input type="submit" value="Order" />
                    </label>
                  </td>
                  <td></td>
                </tr>
              </tfoot>
              <tbody>
                <?php while($row = mysqli_fetch_assoc($products)) { ?>
                  <tr>
                    <td>
                      <a href="book.php?bookId=<?php echo $row["ProductID"]; ?>">
                        <?php echo $row["Title"]; ?>
                      </a>
                    </td>
                    <td>
                      <input size="3" type="text" value="0" name="quantities[<?php echo $row['ProductID'];?>]" /> /
                      <?php echo $row["Quantity"]; ?>
                    </td>
                    <td>
                      $<?php echo number_format($row['Price'], 2); ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </form>
        <?php } else { ?>
          <table class="book-list-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($products)) { ?>
                <tr>
                  <td>
                    <a href="book.php?bookId=<?php echo $row["ProductID"]; ?>">
                      <?php echo $row["Title"]; ?>
                    </a>
                  </td>
                  <td>
                    <?php echo $row["Quantity"]; ?>
                  </td>
                  <td>
                    $<?php echo number_format($row['Price'], 2); ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } ?>
      </div>
    </div>
  </body>
</html>
