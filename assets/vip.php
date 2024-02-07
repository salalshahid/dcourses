<?php 
session_start();
ob_start();
include "connect.php";
$filename = basename($_SERVER["SCRIPT_FILENAME"], ".php");
$stmt = $db->query("SHOW TABLES");
$stmt->execute();
$tables = $stmt->fetchAll(PDO::FETCH_NUM);
foreach($tables as $table){
  if ($table[0] == $filename) {
    $ctable = $filename;
  }}
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
          <div class="row flex-nowrap mt-2">
              <!-- start sidebar -->
              <?php include "sidebar.php"; ?>
                  <!-- end sidebar -->
            
                <div class="col mt-5">
                  <!-- start main content  -->
                    <div class="vh-auto h-100 mt-4">
                      <h4 class="pt-4 mt-3"><?php echo $filename; ?></h4>
                      <?php  include "include/code.php"; ?>
                  </div>       
                  
              </div>
            <!-- end main content -->
        </div>
   
        <!-- start footer -->
        <?php include "footer.php"; ?>
        <!-- end footer -->
  
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
