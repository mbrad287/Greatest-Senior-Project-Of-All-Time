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
    storeMessage('You are already logged in.');
    header('Location: index.php');
    die();
  }
?>

    <!--
   Error checking:
   - Required field are filled out
   - Email contains @ and .
   - Zip and phone number are numbers

   -->
<html>
  <head>
    <title>Project</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/project.css" />
	<script language="JavaScript" type="text/javascript" src="Project.js"></script>
    <script type="text/javascript">

	function validateForm() { 
	 var first = document.forms["register"]["fname"].value;
	 if(first == null || first == "") {
          alert("Please enter a first name that is not a number ");
	      return false;
     }
	 
     var last = document.forms["register"]["lname"].value;
     if(last == "" || last == NULL ) {
		 alert("Please enter a last name that is not a number ");
	     return false;
     } 

	 var email = document.forms["register"]["email"].value;
     if (email.indexOf("@") == -1 || email.indexOf(".") == -1)  {
         alert('"email must contain a "@" and a "."');
         return false;
     } 
	
	 var password = document.forms["register"]["password"].value;
	 if (password == null || password == "") {
         alert("Please enter a password");	
		 return false;
	 } 
	 
	 var address = document.forms["register"]["address"].value;
	 if (address == null || address == "") {
         alert("Please enter an address");
		 return false;
	 } 
	 
	 var addresses = document.forms["register"]["addresses"].value;
	 
	 var city = document.forms["register"]["city"].value;
	 if (city == null || city == "") {
         alert("Please enter a city");
		 return false;
	 } 
	 
	 var state = document.forms["register"]["state"].value;
	 if (state == null || state == "") {
         alert("Please enter a state");
		 return false;
	 } 
	 
	 var zip = document.forms["register"]["zip"].value;
	 if (isNaN(zip)) {
         alert("Please enter a zipcode");
		 return false;
	 } 
	 
	 var phone = document.forms["register"]["phone"].value;
	 if (isNaN(phone)) {
         alert("Please enter a zipcode");
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
        <h2>Sign Up</h2>
        <form name="register" onsubmit="return validateForm()" action="php/createCustomer.php" method="POST"> 
		  <label class="required">First Name: 
		  <input name="fname" type="text" placeholder="Michael" >
          </label>
          <br>
		  <label class="required">Last Name: 
		  <input name="lname" type="text"  placeholder="Bradley" >
          </label>
          <br>
		  <label class="required">Email:
            <input name="email" type="text" placeholder="@example.com" >
          </label>
          <br>         
		  <label class="required">Password: 
		  <input name="password" type="password" placeholder="Enter Password" >
          </label>
          <br>          
		  <label class="required">Address: 
		  <input name="address" type="text" >
          </label>
          <br>          
		  <label>Second Address: (not required) 
		  <input name="address2" type="text" >
          </label>
          <br>          
		  <label class="required">City: 
		  <input name="city" type="text" >
          </label>
          <br>          
		  <label class="required">State: 
		  <input name="state" type="text" >
          </label>
          <br>          
		  <label class="required">Zip Code: 
		  <input name="zip" type="text"  >
          </label>
          <br>          
		  <label>Phone Number: (not required)
		  <input name="phone" type="text" >
          </label>
          <br>          
		  <div class="button-menu">
            <label class="button-left">
              <input type="reset" id="reset" onclick="return resetcheck()" value="Clear" >
            </label>
            <label class="button-right">
              <input type="submit"  id="submit" value="Submit" />
            </label>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
