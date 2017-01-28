<!--
     Name:         Michael Bradley
     Project:      Project: Final Phase
     Purpose:      Create an on-line bookstore for viewing and ordering books.
     URL:          http://unixweb.kutztown.edu/~mbrad287/index.html
     Course:       CSC 242 - Spring 2016
     Due Date:     May 2, 2016
 -->

<?php

function storeMessage($message, $type) {
  if($type != "success" && $type != "info" && $type != "warning" && $type != "danger")
    $type="info";
  if(!isset($_SESSION['messages']))
    $_SESSION['messages'] = array();
  if(!isset($_SESSION['messages'][$type]))
    $_SESSION['messages'][$type] = array();
  $_SESSION['messages'][$type][] = $message;
}

?>
