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
  $categories = getAllFrom("Categories");
  closeConnection();

?>
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
        <div class="section-group text-centered">
          <div class="section partial">
            <h3>Search by Title</h3>
            <form action="titleSearch.php" method="GET">
              <label>
                <input type="text" name="q" />
              </label>
              <label class="button-left">
                <input type="reset" value="Clear">
              </label>
              <label class="button-right">
                <input type="submit" value="Submit">
              </label>
            </form>
          </div>
          <div class="section partial">
            <h3>Search by ISBN</h3>
            <form action="isbnSearch.php" method="GET">
              <label>
                <input type="text" name="q" />
              </label>
              <label class="button-left">
                <input type="reset" value="Clear">
              </label>
              <label class="button-right">
                <input type="submit" value="Submit">
              </label>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="span-desktop-offset-2 span-desktop-6">
            <h3 class="text-centered">Browse by Categories</h3>    
              <?php while($row = mysqli_fetch_assoc($categories)) { ?>
                  <a href="category.php?categoryId=<?php echo $row['CategoryID']; ?>">
                    <?php echo $row['CategoryName']?>
                  <br><br></a>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
