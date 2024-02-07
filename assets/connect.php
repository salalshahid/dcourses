<?php
  //localhost
  $host_name  = "localhost";
  // db name
  $database_name = "dcourses";
  // database user
  $database_user = "root";
  // database password
  $database_password = "";
  
  try{
    $db = new PDO("mysql:host=$host_name;dbname=$database_name", "$database_user", "$database_password");
    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connect Successfully. Host info: " .
  $db->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));
  } catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
  }
  
  // Close connection
  
  ?>