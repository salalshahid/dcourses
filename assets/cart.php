<?php
session_start();
// start session
ob_start();
include ('connect.php');
  $filename = basename($_SERVER["SCRIPT_FILENAME"], ".php");



  if(!isset($_SESSION['activeuser']))
  {
    header('location:login.php?error=login or register');
    ob_end_clean();
  }else{
    $mid = $_SESSION['activeuser'];
  }
  $filename = basename($_SERVER["SCRIPT_FILENAME"], ".php");
// end session
?>


<!-- Start Delete -->
<?php
if (isset($_GET['delete'])) {
  $d = $_GET['delete'];
  $stmt = $db->query("DELETE FROM vip where id = '$d' ");
  $stmt->execute();
  header("location: cart.php?s=Cart item deleted");
    ob_end();
  }
?>
<!-- end delete -->

<!-- start Add product into cart -->
<?php
  
  if (isset($_GET['courseid'])) {
    $courseid = $_GET['courseid'];
    $cstmt = $db->prepare("SELECT * FROM courses where id = '$courseid' ");
  $cstmt->execute();
  $crow = $cstmt->fetch(PDO::FETCH_ASSOC);
    $nm = $crow['name'];
    $price = $crow['price'];
    $photo = $crow['photo'];
    $sts = 'pending';
  
    $chkstmt = $db->prepare("SELECT * FROM vip where mid = '$mid' and cid = '$courseid '  ");
  $chkstmt->execute();
  $vvrow = $chkstmt->fetch(PDO::FETCH_ASSOC);
  if (empty($vvrow)) {
      $nstmt = $db->prepare("INSERT INTO vip(photo,mid,cid,course,price,status)
      VALUES(:pt,:md, :cid,:nm, :pr,:sts)");
       $nstmt->bindparam(":pt", $photo );
       $nstmt->bindparam(":md", $mid );
       $nstmt->bindparam(":cid", $courseid );
     
      $nstmt->bindparam(":nm", $nm );
      $nstmt->bindparam(":pr", $price );
    $nstmt->bindparam(":sts", $sts );
    if ($nstmt->execute()) {
      header('location: cart.php?s=Successfully added. You can add more products in the Cart. ');
    ob_end_clean();
    }

  }else{
    header('location: cart.php?s=Product already in record. ');
    ob_end_clean();
  }
    
  }
 
  
  
   ?>
<!-- end add product into cart -->

 <!-- start confirm Order -->
 <?php
if (isset($_POST['corder'])) {
  
  $tcourse = $_POST['tcount'];
  $status = 'in process';
  // start loop update 

  for ($i=0; $i <= $tcourse; $i++) { 
    $cid = $_POST['cid'.$i];
    $stockstmt = $db->prepare("UPDATE vip SET status = '$status' where cid = '$cid' ");
    if ($stockstmt->execute()) {
      header('location: cart.php?s=You order has been submitted successfully - We will contact you soon.&id=');
     }
  }
 // end loop update 

  header('location: cart.php?s=Submited');
ob_end_clean();
}
?>

<!-- end confirm order -->



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
                    <div class="col-md-8 text-center mb-3">
                    <?php
        if(isset($_GET['s']))
        {
        $s = $_GET['s'];
        ?>
        
      <div class="form-control d-block alert alert-success alert-dismissible fade show mt-5" role="alert">
        <strong></strong> <?php echo $s; 
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     
      </div>

                  
        <?php
          }
        ?>             

                                                <div class="card shadow m-auto">
                            <div class="card-header bg-white py-3">
                            Cart Courses List 
                            
                            </div>
                            <div class="card-body">

                            <form action="cart.php" method="post">
          
                        <div class="table-responsive ">
                                        <table class="table table-borderless table-hover">

                            <!-- table header -->
                                            <thead class=" text-muted bg-light mb-2">
                                            <th></th> 
                                            <th>#</th> 
                                        <th>Photo</th>  
                                        <th>name</th> 
                                        <th>price</th> 
                                        
                                        </thead>
                        <!-- start row -->
                        <?php
                      
                        $count = 0;
                        $tprice = 0;
                        $stmt = $db->prepare("SELECT * FROM vip where mid = '$mid' and status = 'pending' ");
                        $stmt->execute();
                        $stmt = $db->prepare("SELECT * FROM vip where mid = '$mid' and status = 'pending' ");
                        $stmt->execute();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                        $count++;
                        $tprice = $tprice + ($row['price']);
                        ?>
                        <tr>
                        <input type="hidden" name="cid<?php echo $count; ?>" value="<?php echo $row['cid']; ?>" />
                        <?php
                        if ($row['status'] == 'pending') {
                        ?>
                        <td><span class="text-muted small"> <a class="text-decoration-none" href="cart.php?delete=<?php echo $row['id'];?>">X</a>  </span></td>
                        <?php
                        }else{
                        ?>
                        <td></td>
                        <?php 
                        }
                        ?>
                        <td><span class="small text-muted"><?php echo $count;?></span></td>
                        <td><img class="lazyload" height="50" width="50" src="<?php echo $row['photo'];?>" alt=""></td>
                        <td><span class="small text-muted"><?php echo $row['course'];?></span></td>
                        <td><span class="small text-muted"><?php echo $row['price'];?></span></td>

                        </tr>


                        <?php
                        }
                        ?>
                        <tr class="fw-bold text-muted border-top">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="1">Total</td>
                        <td scop="col" ><?php echo $tprice; ?></td>

                        </tr>
                        <tr class=" text-muted">
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td colspan="1">Discount</td>
                        <td scop="col" ><?php $d = 0; echo $d ;// round($tprice / 100 * $count * 15); echo $d; ?></td>

                        </tr>
                        <tr class=" text-muted">
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td colspan="1">Delivery Charges</td>
                        <td scop="col" >0</td>

                        </tr>
                        <tr class="fw-bold border-top">
                        <td></td>
                        <td></td>
                        <td> </td>
                        <td colspan="1">Grand Total</td>
                        <td scop="col" ><?php $fbill = $tprice - $d; echo $fbill ; ?></td>

                        </tr>
                        </table>
                        </div>
                        </div>
                        </div>
                       
                    </div>

                    <div class="col-md-3  mb-3">
                    <?php
                       $uid =  $_SESSION['activeuser'];
       $wstmt = $db->prepare("SELECT * FROM member where id = '$uid' ");
       $wstmt->execute();
       $urow = $wstmt->fetch(PDO::FETCH_ASSOC);
       
       
       ?>

<div class="card p-3 shadow pb-3">
    <div class="card-header bg-white py-3">
    User Detail
    
    </div>
    <div class="card-body ps-1">
   
    <input type="hidden" value="<?php  echo $oid ; ?>" name="oid">    
        <input type="hidden" value="<?php  echo $tprice ; ?>" name="tbill">    
        <input type="hidden" value="<?php  echo $count ; ?>" name="tcount"> 
        <input type="hidden" value="<?php  echo $d ; ?>" name="discount">   
        <input type="hidden" value="<?php  echo $fbill ; ?>" name="fbill">
    <label class=" text-secondary small mb-0 fw-bold ">Your Name*</label>   
      <span class="d-block text-muted"> 
        <?php echo $urow['name']; ?></span>


    <label class=" text-secondary small mb-0 d-block">Your email* </label> 
    <span class="d-block text-muted"> 
  <?php echo $urow['email']; ?>  
</span>


               <button type="submit" class="form-control  btn btn-sm btn-dark ccolor py-2 mt-2"  name="corder">Confirm Order</button>

    
</form>
</div>
</div>
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
