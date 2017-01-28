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
  if(isset($_SESSION['loggedIn'])) {
    storeMessage('You are already logged in', 'warning');
    header('Location: index.php');
    die();
  }
  if(isset($_GET['email']))
    $email = $_GET['email'];
  else
    $email = "";
?>

    <!--
   Error checking:
   - Email contains @ and .
   -->
   
<html>
  <head>
    <title>Project</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/project.css" />
	<script type="text/javascript">
	function validateForm() {
	 var email = document.forms["logIn"]["email"].value;
     if (email.indexOf("@") == -1 || email.indexOf(".") == -1)  {
         alert('"email must contain a "@" and a "."');
         return false;
     }
	 var password = document.forms["logIn"]["password"].value;
	 if (password == null || password == "") {
         alert("Please enter a password");
         return false;
     }
	 
	}
	
	function resetcheck()
{	
	if (confirm('Do you want to clear all the fields?'))
		{document.getElementById("reset").type="reset"; }
	else
		{document.getElementById("reset").type="button"; }
}
	</script>
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
        <h3>Login</h3>
        <form name="logIn" onsubmit="return validateForm()" action="php/loginCustomer.php" method="POST">
		  <label class="required">Email:
            <input name="email" type="text" placeholder="@example.com" value="<?php echo $email; ?>" >
          </label>
          <br>
		  <label class="required">Password:
            <input name="password" type="password" >
          </label>
          <br>
		  <div class="button-menu">
            <label class="button-left">
              <input type="reset" id="reset" onclick="return resetcheck()" value="Clear" >
            </label>
            <label class="button-right">
              <input type="submit" id="submit" value="Submit">
            </label>
          </div>
        </form>
      </div>
    </div>
    </div>
  </body>
</html>
