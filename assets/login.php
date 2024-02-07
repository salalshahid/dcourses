<?php
session_start();
ini_set('display_errors', 'On');
ini_set('html_errors', 0);
error_reporting(-1);
ob_start();
include "connect.php";
  if (isset($_POST['lsubmit'])) {
  $umail = $_POST['email'];
  $upass = $_POST['password'];
    try
    {
      // all columns 
      $stmt = $db->prepare("SELECT * FROM member Where email = '$umail'");
      $stmt->execute();
      $lrow=$stmt->fetch(PDO::FETCH_ASSOC);
      // exit email
      $estmt = $db->prepare("SELECT * FROM member Where email = '$umail'");
      $estmt->execute();
      $lcount = $estmt->fetchColumn();
    if ($lcount > 0) {
        if (password_verify($upass, $lrow['password'])) {
          $_SESSION['activeuser'] = $lrow['id'];
          $_SESSION['username'] = $lrow['name'];
            header('location:dashboard.php');
             ob_end();
        }
        else
        {
          header('location:login.php?error=Oops! wrong email or password.');
          ob_end();
        }
      }else{
        header('location:login.php?error=Oops! email is not registered.');
            ob_end();
      }
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }



  } // end up lsubmit


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
    <title>Login</title>
  </head>
  <body class="d-flex flex-column vh-100 ccolor ">
    <div class="container py-5 overflow-auto">
      <div class="row align-items-center justify-content-center ">
        <div class="card col-auto  col-lg-4 shadow">
          <div class="card-header text-center border-0 bg-white pt-3">
            <div class="py-2"></div>
            <h1 class="fs-2">Sign in</h1>
          </div>
          <div class="card-body">
            <div class="justify-content-center align-item-center p-3">
              <form action="login.php" method="post" class="needs-validation" novalidate> <?php
          if(isset($_GET['error']))
          {
            $error = $_GET['error'];

            echo '
									<div class="form-control m-2 d-block alert alert-danger alert-dismissible fade show" role="alert">
										<strong>Oops!</strong> '.$error.'
          
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>';
          }
            ?> 
                <input autocomplete="off" minlength="3" maxlength="50" class="form-control m-2 " type="email" name="email" placeholder="Your Email*" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Email*" required>
                <input autocomplete="off" minlength="6" maxlength="100" class="form-control m-2 mb-0 " type="password" name="password" placeholder="Your Password*" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Password*" required>
                <label class="small text-secondary ms-2 mb-2">Forgot Account? <a class="text-decoration-none" href="reset.php">Reset Password</a>
                </label>
                <button class="form-control btn btn-dark m-2 ms-2" type="submit" name="lsubmit">Log in</button>
                <div class=" mb-4 border-bottom py-2 mt-2 ms-2"></div>
                <div class="justify-content-center align-item-center text-center">
                  <label class="pb-0 small mt-2 text-secondary ms-2">Don't have an account? <a class=" btn btn-sm btn-outline-dark text-decoration-none small" href="register.php">Create New Account</a>
                  </label>
                </div>
              </form>
            </div>
          </div>
          <!-- end card body -->
        </div>
        <!-- end card -->
      </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Optional JavaScript; choose one of the two! -->
    <script type="text/javascript">
      (function() {
        'use strict'
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
      })()
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })

      function enableBtn() {
        document.getElementById("button1").disabled = false;
      }
    </script>
    <script src="js/popper.min.js"></script>
  </body>
</html>