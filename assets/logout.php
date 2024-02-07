<?php
session_start();
if(isset($_GET['logout']) && $_GET['logout']=="true")
{
session_destroy();
unset($_SESSION['activeuser']);
header('location:../index.php');
}

 ?>
