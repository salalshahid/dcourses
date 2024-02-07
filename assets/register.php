<?php
ini_set('display_errors', 'On');
ini_set('html_errors', 0);
error_reporting(-1);
ob_start();
include "connect.php";

if (isset($_POST['rsubmit'])) {
  
  // name post
  $uname = $_POST['name'];
// email post
$umail = $_POST['email'];
// password post
$upass = $_POST['password'];

  $stmt = $db->prepare("SELECT * FROM member Where email = '$umail'");
  $stmt->execute();
  $erow=$stmt->fetch(PDO::FETCH_ASSOC);
  if($erow['email']==$umail) {
     header('location:register.php?error=Oops.. Email already registered ');
     ob_end();
  }else{

try{

$upass = password_hash($upass, PASSWORD_DEFAULT);
$photo = 'img/user.png';

  $stmt = $db->prepare("INSERT INTO member(photo,name,email,password)
  VALUES(:uphoto,:uname, :umail, :upass)");
  $stmt->bindparam(":uphoto", $photo );
  $stmt->bindparam(":uname", $uname);
  $stmt->bindparam(":umail", $umail);
  $stmt->bindparam(":upass",$upass );

  if ($stmt->execute()) {
    header('location: register.php?done=congratulation! you are registered successfully.');
ob_clean();
  }

return $stmt;
}
catch(PDOException $e)
{
echo $e->getMessage();
}

}

} 
// end psubmut

 ?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport' />
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <title>Register</title>
  </head>
  <body class="d-flex flex-column vh-100 ccolor">
    <div class="container py-5">
      <div class="row  align-items-center justify-content-center ">
        <div class="card col-auto  col-lg-4  shadow">
          <div class="card-header text-center border-0 bg-white pt-3">
            <h1 class="fs-2 py-3">Sign up</h1>
          </div>
          <div class="card-body">
            <div class="justify-content-center align-item-center p-3">
              <form action="register.php" method="post" class="needs-validation" novalidate> <?php
					 if(isset($_GET['error']))
					 {
						 $error = $_GET['error'];

						 echo '
									<div class="form-control m-2 d-block alert alert-danger alert-dismissible fade show" role="alert">
										<strong>Oops!</strong> '.$error.'
	 
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>';
					 }elseif(isset($_GET['done']))
						{
							$done = $_GET['done'];

						echo '
									<div class="form-control m-2 d-block alert alert-success alert-dismissible fade show" role="alert">
										<strong>Congratulation!</strong> '.$done.'
	
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>';

						}
						 ?> 
				<input autocomplete="off" minlength="3" maxlength="50" class="form-control m-2 " type="text" name="name" value="" placeholder="Your Name*" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Name*" required>
                <input autocomplete="off" minlength="6" maxlength="50" class="form-control m-2 " type="email" name="email" value="" placeholder="Your Email*" required required data-bs-toggle="tooltip" data-bs-placement="top" title="Your email*" required>
                <input autocomplete="off" minlength="6" maxlength="100" class="form-control m-2 mt-2" type="password" name="password" value="" placeholder="Your Password*" required required data-bs-toggle="tooltip" data-bs-placement="top" title="Your Password*" required>
                <button id="button1" class="form-control btn btn-dark m-2 ms-2" 
                type="submit" name="rsubmit" value="">Create New Account</button>
              
			 </form>
              <div class=" mb-4 border-bottom py-2 mt-2 ms-2"></div>
              <div class="justify-content-center align-item-center text-center">
                <label class="pb-0 small mt-2 text-secondary ">Already have an account ? <a class=" btn btn-sm btn-outline-dark text-decoration-none small" href="login.php">Log in</a>
                </label>
              </div>
            </div>
          </div>
          <!-- end card body -->
        </div>
        <!-- end card -->
      </div>
    </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Optional JavaScript; choose one of the two! -->
    <script type="text/javascript">
      (() => {
        'use strict';
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach((form) => {
          form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      })();
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })

      function enableBtn() {
        document.getElementById("button1").disabled = false;
      }
    </script>
    <script src="js/popper.min.js"></script>
</html>