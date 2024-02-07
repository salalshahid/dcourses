<?php
include ('connect.php');
  $filename = basename($_SERVER["SCRIPT_FILENAME"], ".php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport' />
    <title><?php echo $filename; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

<body class="bg-light">  
  <!-- navbar start -->
      <?php  include "nav.php"; ?>
    <!-- navbar end -->

        <div class="container-fluid">
            <div class="container">
                <div class=" row py-5 align-items-center justify-content-center" style="min-height: 100vh">
                    <div class="col-6 text-center mb-3">
                        <span class="fs-1">blank</span>
                    </div>

                    <div class="col-6 text-center mb-3">
                        <span class="fs-1">blank</span>
                    </div>

                </div>
            </div>
        </div>
    
    <!-- start footer -->
    <?php include "footer.php"; ?>
     <!-- end footer -->        
  
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
