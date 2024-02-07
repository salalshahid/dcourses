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
                    <div class="col-md-3  mb-3">

                             
                <?php
                $cid = $_GET['id'];
       $wstmt = $db->prepare("SELECT * FROM courses where id = '$cid' ");
       $wstmt->execute();
       $row = $wstmt->fetch(PDO::FETCH_ASSOC);
       
       ?>
                    <div class="card shadow hover-1">
                                    <a class="text-decoration-none" href="#">
                              
                              <img height="150" src="<?php  echo $row['photo']; ?>" class="card-img-top opacity-75" alt="...">
                              <div class="card-img-overlay p-0 h-25 w-25">
                              
                                
                              </div>
                              <div class="card-body text-center">
                                <h5 class="card-title text-muted fw-bold fs-6"><?php  echo $row['name']; ?></h5>
                                
                                <div class="ctext">
                                <span class="card-text small text-muted">Updated: <?php  echo $row['updates']; ?></span>
                                     
                                <p class="mt-2 mb-0 mt-0"><strike class="text-muted fw-bold strik small">50% Discount $<?php  echo $row['price'] * 2; ?></strike></span> 
                                </p>
                                <span class="fw-bold fs-5 mb-0">Now $<?php echo $row['price'];  ?></span>
                                </div>

                              </div>
                              </a>
                              <div class="card-footer border-0 bg-white">
                              <a class="text-muted small text-decoration-none"  
                              href="../index.php">Check other</a>
                              <div class="z-3 clearfix d-inline">
                            
                                  <a class="btn btn-sm btn-dark ccolor float-end " 
                                  href="cart.php?courseid=<?php echo $row['id']; ?>`">Add to Cart</a>
                                
                            
                                </div>
                                    </div>
                                  
                                  </div>
                    </div>

                    <div class="col-md-8 text-center mb-3">
                      


<!-- start video -->
<?php


if (isset($_GET['yid'])) {
?>
<div class="card mt-1 shadow rounded sticky-top mx-auto col-md-8">
<div class="card-body px-0 py-0" >
<div  class="ratio ratio-16x9">
<iframe  src="https://www.youtube.com/embed/<?php echo $_GET['yid'];?>?rel=0&showinfo=0&loop=1&modestbranding=0&controls=1&disablekb=1&autoplay=0" 
  sandbox="allow-forms allow-scripts allow-pointer-lock allow-same-origin allow-top-navigation" title="YouTube video" allowfullscreen></iframe>
</div>
</div>
</div>
<?php
}
?>
<!-- end video -->

           
<!-- Start Course Detail -->
<div class="card shadow mt-2 mb-3 col-lg-8 mx-auto">
    <div class="card-header bg-white py-3">
    <?php

$vstmt = $db->prepare("SELECT count(*)FROM vip where cid = '$cid' and status = 'active' ");
$vstmt->execute();
$vip = $vstmt->fetch(PDO::FETCH_NUM);

?>
    <span class="fs-4">Detail</span>
    <?php
    if ($vip[0] ?? null > 0 ) {
      ?>
  <button class="btn btn-sm btn-success">Active</button>
  
  <?php
    }
  ?>
    </div>
    <div class="card-body" >

    
   <div class="table-responsive ">
                <table class="table table-borderless table-hover">

      <!-- table header -->
                    <thead class="bg-light mb-2">
                    <th class="text-muted">#</th> 
                  <th class="text-muted">Lectures</th> 
                  <th class="text-muted">Watch</th> 
                 
                  </thead>
  <!-- start row -->
  <?php

  

$stmt = $db->prepare("SELECT * FROM lectures where cid = '$cid' and mark = '' ");
$stmt->execute();
$count = 1;
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
  $count++;
    
  if ($count >= 4 && !$vip[0] ?? null > 0 ) {
    ?>
  <tr>
  <td><span class="text-muted"><?php echo $count;?></span></td>
  <td><span class="text-muted"><?php echo $row['title'] ?? null;?></span></td>
  <td><span class="text-muted">VIP only</span></td>
  
  
  
  
  </tr>
  <?php


      }elseif ($count >= 4 && $vip[0] ?? null > 0 ) {
  ?>
<tr>
  <td><span class="text-muted"><?php echo $count;?></span></td>
  <td><span class="text-muted"><?php echo $row['title'] ?? null;?></span></td>
  <td> 
<a  class=" btn btn-outline-dark btn-sm" 
href="detail.php?yid=<?php echo $row['yid'];?>&id=<?php echo $row['cid'];?>">watch</a>

</td>
  
  
  
  
  </tr>
   <?php
      }else{
   ?>

<tr  
<?php
if (isset($_GET['yid'])) {
  if( $row['yid'] == $_GET['yid'] ) {
    echo 'class="bg-dark-subtle"';
  }}
?>
>

<td><span class="text-muted"><?php echo $count;?></span></td>
<td>
  <a class="text-decoration-none" href="detail.php?yid=<?php echo $row['yid'];?>&id=<?php echo $row['cid'];?>">
<span class="text-muted"><?php echo $row['title'] ?? null;?></span>
</a>
</td>
<td> 
<a  class=" btn btn-outline-dark btn-sm" 
href="detail.php?yid=<?php echo $row['yid'];?>&id=<?php echo $row['cid'];?>">watch</a>

</td>

</tr>

<?php
}}

?>

</table>
</div>
</div>
</div>
<!-- End Course Detail -->


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
