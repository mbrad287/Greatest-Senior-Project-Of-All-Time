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
  $bookId = $_GET['bookId'];
  if(!isset($bookId)) {
    header("Location: books.php");
    die();
  }
  require("php/mysql_connect.php");
  openConnection();
  $result = getByValueFrom("ProductID", $bookId, "Products");
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
      <div class="container text-centered">
        <?php require("php/viewMessage.php") ?>
        <?php
        if(mysqli_num_rows($result) < 1) { ?>
          <p class="lead">Book not found.</p>
        <?php } else {
          $row = mysqli_fetch_assoc($result);
          $categoryResult = getByValueFrom('CategoryID', $row['CategoryID'], 'Categories');
          if(mysqli_num_rows($categoryResult) < 1) {
            $categoryName = "Category does not exist";
          }
          else {
            $categoryRow = mysqli_fetch_assoc($categoryResult);
            $categoryName = $categoryRow['CategoryName'];
          }
          $authors = "By ".$row['Author1'];
          if(!empty($row['Author2'])) {
            if(!empty($row['Author3']))
              $authors .= ", ".$row['Author2'].", and ".$row['Author3'];
            else
            $authors .= " and ".$row['Author2'];
          }
          ?>
          <h2><?php echo $row['Title'] ?></h2>
          <h3><?php echo $authors; ?></h3>
          <h5><?php echo $categoryName ?></h5>
          <div class="row">
            <div class="span-tablet-offset-2 span-tablet-2">
              <h5>ISBN: <?php echo $row['ProductID'] ?></h5>
            </div>
            <div class="span-tablet-2">
              <h5>Price: $<?php echo number_format($row['Price'], 2); ?></h5>
            </div>
            <div class="span-tablet-2">
              <h5>Quantity: <?php echo $row['Quantity']?></h5>
            </div>
          </div>
          <div class="row">
            <div class="span-tablet-offset-2 span-tablet-6">
              <form action="cart.php" method="POST">
                  <legend>Purchase</legend>
                  <input type="hidden" name="action" value="add" />
                  <input type="text" value="0" name="quantities[<?php echo $row['ProductID'];?>]" />
                  <input type="submit" value="Submit" />
              </form>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </body>
</html>