<?php 
  include('assets/connect.php');
  $filename = basename($_SERVER["SCRIPT_FILENAME"], ".php");
 
  ?>

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

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dCourses</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
  </head>
  <body class="">
   
<!-- Navbar Star -->
<!-- bg-body-tertiary  -->
<nav class="navbar navbar-dark ccolor border-bottom shadow" >
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><h2 class="">dCourses</h2></a>



    <div class="btn-group ">
 
<a href="assets/dashboard.php" class="me-1"> <button class="btn btn-lg btn-light">Dashboard</button></a>
 
    <button class="navbar-toggler border shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    </div>
    <div class="offcanvas offcanvas-end bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title text-light" id="offcanvasNavbarLabel">dCourses</h5>
        <button type="button" class="btn-close border text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
         
        </ul>
       
      </div>
    </div>
  </div>
</nav>

<!-- Navbar end -->

<!-- Header Start -->
<header class="ccolor"> 
<div class="container">
<div class=" row py-5 align-items-center justify-content-center" style="min-height: 100vh">


<div class="col-6 text-center text-light mb-3">
<div class="d-block"><h1 class="display-1 fw-bolder">All Courses at 50% discount
  </h1></div>

  <p class="py-3">"Welcome to our online learning community! Whether you're here to expand your skills, pursue your passions, or explore new interests, we're thrilled to have you with us. Dive into our diverse range of courses and embark on a journey of discovery and growth. Let's learn, explore, and achieve together!"





    </p>
    <div class="mt-4">
      <a href="assets/register.php">
    <button  class="btn btn-lg btn-light    p-3 ps-5 pe-5"  >Get Started</button></a>
</div>
</div>




</div>
</div>
</header>
<!-- Header End -->
<!-- Feature Section Star -->


<section>
  <div class="container bg-white">
    <div class="row align-items-center justify-content-center  gap-4" style="min-height: 75vh">
      <div class="col-md-3 g-col-2 p-5 text-center rounded-3 border shadow">

       <h3 class="fs-5">Best Courses</h3>
       <span class="lead">Discover our top-rated courses curated just for you. Dive into engaging content led by industry experts.</span>
      </div>

      <div class="col-md-3 g-col-2 p-5 text-center rounded-3 border shadow">
     
       <h3 class="fs-5">All Completed with Projects</h3>
       <span class="lead">Celebrate your achievements with our completed projects. Explore real-world applications and showcase your skills</span>
      </div>

      <div class="col-md-3 g-col-2 p-5 text-center rounded-3 border shadow">
 
       <h3 class="fs-5">Latest and brand new</h3>
       <span class="lead">Discover fresh opportunities for learning with our newest additions. Dive into cutting-edge content and expand your horizons</span>
      </div>
     

    </div>
  </div>
</section>


<!-- Feature Section End -->


<!-- card section start -->
<section class="py-5 bg-light">
                <div class="container py-5 mt-5 mb-2 py-3">
                <h1 class="text-center ">Our Courses</h1>
             


                </div>
                <div class="container py-5 mb-2">
                <div class="row row-cols-auto row-cols-2 
                row-cols-sm-2 row-cols-md-4 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5  g-3">

             
                <?php
       $wstmt = $db->prepare("SELECT * FROM courses ORDER BY id DESC limit 0,30 ");
       $wstmt->execute();
       while($row = $wstmt->fetch(PDO::FETCH_ASSOC))
       
      {
       ?>



                              
                            <div class="col">
                            
                                    <div class="card shadow hover-1">
                                    <a class="text-decoration-none" href="#">
                              
                              <img height="150" src="assets/<?php  echo $row['photo']; ?>" class="card-img-top opacity-75" alt="...">
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
                              href="assets/detail.php?id=<?php echo $row['id'];?>">Detail</a>
                              <div class="z-3 clearfix d-inline">
                            
                                  <a class="btn btn-sm btn-dark ccolor float-end " 
                                  href="assets/cart.php?courseid=<?php echo $row['id'];?>">Add to Cart</a>
                                
                            
                                </div>
                                    </div>
                                  
                                  </div>
                        
                            </div>

               <?php
          }
               ?>
                
                </div>
                </div>

</section>
<!-- card section end -->

<!-- design section Start -->
<section class=" "> 
  <div class="container">
  <div class=" row py-5 align-items-center" 
  style="min-height: 75vh">
  
    <div class="col-md-6">
  
      <img class="img-thumbnail border-0" src="assets/img/a.jpg" alt="">
    </div>

  <div class="col-md-6  mb-3">
  <div class="d-block"><h1 class="">Why Chose Us</h1></div>
  
    <p class="py-3">Experience excellence. Our commitment to your success sets us apart from the rest. Here's why.
      
      </p>

<!-- list-group-flush -->
      <div class="list-group ">
     
        <a href="#" class="list-group-item list-group-item-action">Quality Content</a>
        <a href="#" class="list-group-item list-group-item-action">Engaging Learning Experience</a>
        <a href="#" class="list-group-item list-group-item-action">Supportive Community</a>
      
      </div>

      <div class="mt-4">
      <button  class="btn btn-dark ccolor  btn btn-lg p-3 ps-5 pe-5"  >Get Started</button>
  </div>
  </div>
 
  
  
  
  </div>
  </div>
</section>
  <!-- design section end End -->


  <!-- app section Start -->
<section class="py-5"> 
  <div class="container">
  <div class=" row py-5 align-items-center" style="min-height: 75vh">
  


  <div class="col-md-6  mb-3">
  <div class="d-block"><h1 class="">Salient Features</h1></div>
  
    <p class="py-3">Explore the standout features that make our platform unique. From personalized learning paths to interactive assessments, discover what sets us apart.
      
      </p>

<div class="btn-group d-block py-3">

 
   <h3 class="fs-4  fw-bold">Instant Notification</h3>

</div>
<span class="text-secondary py-3">Never miss a beat with instant notifications. Get real-time alerts about important course updates, deadlines, and community announcements, ensuring you're always in the loop.</span>
      
<div class="btn-group d-block py-3">

 
  <h3 class="fs-4  fw-bold">User Friendly</h3>

</div>
<span class="text-secondary py-3">Simplify your experience with our user-friendly design. Navigate effortlessly and focus on what matters most: learning.</span>
      

<div class="btn-group d-block py-3">


   <h3 class="fs-4  fw-bold">Secure and Reliable</h3>

</div>
<span class="text-secondary py-3">Trust in our platform's rock-solid security measures and dependable infrastructure. Your data's safety is our top priority.</span>
      

  </div>
 
  <div class="col-md-6 text-center">
  
  <img class="img-thumbnail border-0 " src="assets/img/d.jpg" alt="">
  </div>
  
  
  </div>
  </div>
</section>
  <!-- app section End -->
  
  

<!-- download Start -->
<div class="ccolor py-5"> 
  <div class="container">
  <div class=" row py-5 align-items-center" style="min-height: 75vh">
  
    <div class="col-md-6">
    <img class="img-thumbnail border-0" src="assets/img/b.jpg" alt="">
     
    </div>
  <div class="col-md-6 float-end text-light mb-3">
  <div class="d-block mt-5"><h1 class="">Learn at your own pace</h1></div>
  
    <p class="py-3">Discover the freedom to learn at your own pace, unlocking your full potential on your terms
      
      </p>
      <div class="mt-4">
      <button  class=" btn btn-lg btn-light  border-0 p-3 ps-5 pe-5"  >Enroll now</button>
  </div>
  </div>
  
  
  
  
  </div>
  </div>
  </div>
  <!-- download End -->




  <!-- FAQs section Start -->
  <section class="py-5"> 
    <div class="container">
    <div class=" row py-5 align-items-center" style="min-height: 75vh">
    
  
  
    <div class="col-md-6  mb-3">
    <div class="d-block"><h1 class="">Interested in Learning Together</h1></div>
    
      <p class="py-3">Discover the power of collaborative learning! Join our community and experience the joy of learning together, every step of the way
        
        </p>
  
  <div class="btn-group d-block py-3">
  
    
     <h3 class="fs-4 py-2 dlink  fw-bold">Diverse Perspectives</h3>
  
  </div>
  <span class="text-secondary py-3">Collaborative learning fosters a diverse exchange of ideas, allowing learners to gain insights from varied perspectives</span>
        
  <div class=" d-block py-3">
  
   
    <h3 class="fs-4 py-2 dlink  fw-bold">Active Engagment</h3>
  
  </div>
  <span class="text-secondary py-3">Working collaboratively motivates learners to actively engage with course material, leading to a more profound comprehension of the subject matter.</span>
        
  
  <div class="btn-group d-block py-3">
  
   
     <h3 class="fs-4  py-2 dlink  fw-bold">Peer Support and Feedback</h3>
  
  </div>
  <span class="text-secondary py-3">In a collaborative learning setting, peers can provide valuable feedback, offer support, and help clarify concepts, promoting a sense of camaraderie and shared achievement</span>
        
  
    </div>
   
    <div class="col-md-6 text-center">
    
      <img class="img-thumbnail border-0" 
      src="assets/img/c.jpg" alt="">
    </div>
    
    
    </div>
    </div>
  </section>
    <!-- FAQs section End -->


    <!-- Contact us Start -->
    <section class="py-5 bg-dark text-light mb-0 bgc">
      <div class="container ">
        <div class="row justify-content-center">
        <div class="col-6 text-center ">
        <div class="d-block mt-5"><h1 class="mb-3">Explore Us</h1></div>

        <span class="lead ">Take your knowledge to the next level. Uncover advanced insights and techniques in our curated 'Need to Know Further' collection.</span>

        <div class="mt-4">
          <button  class="btn btn-lg btn-dark ccolor border-0 p-3 ps-5 pe-5"  >Need to know further</button>
      </div>
      </div>
    </div>
      </div>




    

    </section>
    <!-- Contact us end -->

<!-- footer Start -->
<footer class="bg-black">
  <div class="container text-center text-light py-3">
<span class="lead">2020 Copyrights & Protected</span>
  </div>
</footer>
<!-- footer end -->




    <script src="assets/js/bootstrap.bundle.min.js" ></script>
  </body>
</html>

