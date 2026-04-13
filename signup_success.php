<?php
session_start();
if (!isset($_SESSION['signup_success'])) {
    header('Location: signup.php');
    exit();
}
unset($_SESSION['signup_success']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KVBS</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="icons/bootstrap-icons.css">
  <style>
    .success-icon {
      font-size: 5rem;
      color: #28a745;
      margin-bottom: 1.5rem;
    }
    .btn-continue {
      background-color: #148ba9;
      border: none;
      border-radius: 50px;
      padding: 10px 30px;
      font-weight: 500;
    }
    .btn-continue:hover {
      background-color: #0e6f8a;
    }
  </style>
</head>

<body>
  <section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="success-container bg-white p-4 p-md-5 rounded shadow mt-4 text-center">
            <div class="success-icon">
              <i class="bi bi-check-circle-fill"></i>
            </div>
            <h2 class="mb-3" style="color: #148ba9;">Account Created Successfully!</h2>
            <p class="mb-4">Thank you for registering with KVBS. Your account has been successfully created.</p>
            <p class="mb-4">You can now login to your account and schedule vaccination appointments for your child.</p>
            
            <div class="d-flex justify-content-center gap-3 mt-4">
              <a href="login.php" class="btn btn-continue text-white fw-bold">
                Proceed to Login
              </a>
              <a href="index.php" class="btn btn-outline-secondary fw-bold">
                Back to Home
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>