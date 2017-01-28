<!--
     Name:         Michael Bradley
     Project:      Project: Final Phase
     Purpose:      Create an on-line bookstore for viewing and ordering books.
     URL:          http://unixweb.kutztown.edu/~mbrad287/index.html
     Course:       CSC 242 - Spring 2016
     Due Date:     May 2, 2016
 -->

<?php

  $connection = NULL;
  function openConnection() {
    global $connection;
    $connection = mysqli_connect('localhost', 'mbrad287', 'Fra6Uchu', 'bookstore_mbrad287');
    if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
    }
  }

    function runQuery($query) {
    global $connection;
    $result = mysqli_query($connection, $query);
    return $result;
  }

  function getAllFrom($table) {
    global $connection;
    $query = "SELECT * FROM `$table`;";
    $result = mysqli_query($connection, $query);
    return $result;
  }

  function getByValueFrom($col, $value, $table) {
    global $connection;
    $query = "SELECT * FROM `$table` WHERE `$col` = '".mysqli_real_escape_string($connection, $value)."';";
    $result = mysqli_query($connection, $query);
    return $result;
  }

  function getLikeValueFrom($col, $value, $table) {
    global $connection;
    $query = "SELECT * FROM `$table` WHERE `$col` LIKE '%".mysqli_real_escape_string($connection, $value)."%';";
    $result = mysqli_query($connection, $query);
    return $result;
  }

 

  function getError() {
    global $connection;
    return mysqli_error($connection);
  }

  function closeConnection() {
    @mysqli_close($connection);
  }
?>
