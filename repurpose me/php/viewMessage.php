<!--
     Name:         Michael Bradley
     Project:      Project: Final Phase
     Purpose:      Create an on-line bookstore for viewing and ordering books.
     URL:          http://unixweb.kutztown.edu/~mbrad287/index.html
     Course:       CSC 242 - Spring 2016
     Due Date:     May 2, 2016
 -->

<?php
if(isset($_SESSION['messages'])) {
  foreach($_SESSION['messages'] as $key => $messageType) {
    foreach($messageType as $message) { ?>
      <div class="message <?php echo $key; ?> text-centered">
        <p><?php echo $message ?></p>
      </div>
    <?php }
    unset($_SESSION['messages'][$key]);
  }
  ;
} ?>
