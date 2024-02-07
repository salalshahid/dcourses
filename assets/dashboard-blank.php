<?php $filename = basename($_SERVER["SCRIPT_FILENAME"], ".php"); ?>
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
        <div class="row ">
            <!-- start sidebar -->
            <?php include "sidebar.php"; ?>
                <!-- end sidebar -->
          
            <div class="col pt-3">
                <!-- start main content  -->
                <div class="vh-auto h-100">
                    <h5 class="pt-5 mt-4">Blank</h5>

                    <span class="small text-secondary">Content will display here..</span>
                
                </div>
            </div>
            <!-- end main content -->
        </div>
    </div>
    <!-- start footer -->
   <?php include "footer.php"; ?>
    <!-- end footer -->
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
