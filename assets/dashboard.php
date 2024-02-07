<?php 
session_start();
ob_start();
include "connect.php";
if(!isset($_SESSION['activeuser']))
{
  header('location:login.php?error=login or register');
  ob_end();
}
$filename = basename($_SERVER["SCRIPT_FILENAME"], ".php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport' />
    <title><?php echo $filename; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

<body class="cbody">  
  <!-- navbar start -->
<?php  include "nav.php"; ?>
    <!-- navbar end -->

    <div class="container-fluid">
        <div class="row flex-nowrap mt-2">
            <!-- start sidebar -->
            <?php include "sidebar.php"; ?>
                <!-- end sidebar -->
          
            <div class="col mt-5">
                <!-- start main content  -->
                <div class="vh-auto h-100 mt-4">
                    <h5 class="">Dashboard </h5>
                
                </div>
            </div>
            <!-- end main content -->
        </div>
    </div>
    <!-- start footer -->
   <?php include "footer.php"; ?>
    <!-- end footer -->
   
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
