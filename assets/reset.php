<?php
ini_set('display_errors', 'On');
ini_set('html_errors', 0);
error_reporting(-1);
ob_start();

include "connect.php";

if (isset($_POST['submit2'])) {

$p1 = $_POST['p1'];
$p2 = $_POST['p2'];
$umail = $_POST['prc'];
if ($p1 == $p2) {
	$p1 = password_hash($p1, PASSWORD_DEFAULT);
	$code = md5(uniqid(rand()));
	$stmt = $db->query("UPDATE member SET password = '$p1', reset = '$code'  where email = '$umail' ");
if ($stmt->execute()) {
	header('location:?done=Password reset successfully');
  ob_end();
}else{
	header('location:?error=Something went wrong. Try again');
  ob_end();
}

}
}

if (isset($_POST['submit'])) {

	$umail = $_POST['email'];
  $stmt = $db->query("SELECT email FROM member WHERE email= '$umail'");
  $row=$stmt->fetch(PDO::FETCH_ASSOC);

  if($row['email']==$umail) {
    $code = md5(uniqid(rand()));
      $stmt = $db->query("UPDATE member SET reset = '$code' where email = '$umail' ");
if ($stmt->execute()) {

$message = '
Hi!
Recieved request for reset of password.

link below for password reset.

'.$_SERVER["SERVER_NAME"].'/assets/reset.php?code='.$code.'&email='.$umail.'


Regards,
'.$_SERVER["SERVER_NAME"].'
';
if(mail($umail,"Reset Password", $message)){

	header('location:?done=Check email password reset link sent.');
  ob_end();
}
}
}else{
	header('location:?error=not done - something went wrong');
  ob_end();
}

}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="css/style.css"  rel="stylesheet"  type="text/css">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <title>Reset</title>



  </head>
  <body class="d-flex flex-column vh-100 ccolor">

<div class="container py-5">



<div class="row  align-items-center justify-content-center ">
      <div class="card  shadow col-auto col-lg-4">

<div class="card-header text-center border-0 bg-white pt-3">



    <h3 class="fw-bold text-center py-4">Reset Password</h3>
</div>

      <div class="card-body">




<div class="text-center align-item-center">

<?php

if(isset($_GET['code']) && isset($_GET['email']))
{
 $prc = $_GET['code'];
	$email = $_GET['email'];


?>

<form oninput="result.value=!!p2.value&&(p1.value==p2.value)?'Password Matched!':'Password not same!'"   action="reset.php" method="post" class="needs-validation" novalidate>
<output  name="result"></output>

		<input class="form-control m-2 " type="hidden" name="prc" value="<?php echo $email; ?>">
<lable class="float-start ms-2 text-muted small pb-0 form-text" >New Password</lable>
		<input autocomplete="off" minlength="6"  maxlength="100" class="form-control m-2 "
		type="password" name="p1" placeholder="Type New Password" data-bs-toggle="tooltip" data-bs-placement="top" title="New Password*" required>
<lable class="float-start ms-2 text-muted small pb-0" >Retype New Password</lable>
		<input autocomplete="off" minlength="6"  maxlength="100"
		class="form-control m-2 " type="password" name="p2" placeholder="Retype New Password" data-bs-toggle="tooltip" data-bs-placement="top" title="Retype New Password*"  required>

		<button  class="form-control btn btn-success m-2 ms-2" 
    type="submit" name="submit2"   >Reset Password</button>

  </form>


<?php

}else{
 ?>


  <form  action="reset.php" method="post" class="needs-validation" novalidate>

	<div class="col-auto">
		<?php
		if(isset($_GET['error']))
		{
			$error = $_GET['error'];

			echo '<div class="form-control m-2 d-block alert alert-danger alert-dismissible fade show" role="alert">
		<strong>Oops!</strong> '.$error.'
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
		}elseif(isset($_GET['done']))
		 {
			 $error = $_GET['done'];

		 echo '<div class="form-control m-2 d-block alert alert-success alert-dismissible fade show" role="alert">
		<strong>Congratulation!</strong> '.$error.'
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';

		 }
			?>
	</div>
			<input autocomplete="off" minlength="6"  maxlength="50" class="form-control m-2 " type="email" name="email" value="" placeholder="Your email*" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Password*" required>




		  <button  class="form-control btn btn-dark m-2 ms-2 mt-2" type="submit" name="submit" value="" >Reset Password</button>

    </form>


    <div class=" mb-4 border-bottom py-2 mt-2 ms-2"></div>
  <div class="justify-content-center align-item-center text-center">
    <label class="pb-0 small mt-2 text-secondary ">Sign in with password   <a class=" btn btn-sm btn-outline-dark text-decoration-none small" href="login.php">Log in</a> </label>

  </div>

<?php
}
 ?>

      </div>

      <!-- end card body -->
  </div>
  <!-- end card -->
</div>
</div>
</div>



<script src="js/bootstrap.bundle.min.js"></script>


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
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
		})
		function enableBtn(){
		document.getElementById("button1").disabled = false;
		}

		</script>
		<script src="js/popper.min.js" ></script>

  </body>
</html>
