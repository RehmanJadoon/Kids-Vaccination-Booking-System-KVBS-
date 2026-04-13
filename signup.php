<?php
require_once 'includes/db_connection.php'; //including db connection file

$errorMessage = $successMessage = ''; //initialize emtpy error/ success messages
if(isset($_POST["signup"])){ //check if the signup button is clicked, if true then submit data
  $firstname = $_POST["firstname"]; //it will take value from firstname input field
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $address = $_POST["address"];
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirmPassword"];
//applying condition to check fields are not empty
  if(empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirmPassword)){
    $errorMessage = "All fields are required";
  }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //checking email format
    $errorMessage = "Email is not valid";
  }elseif(strlen($password) < 8){ //passwrod shouldn't be less than 8 chars
    $errorMessage = "Password must be 8 characters long";
  }elseif($password !== $confirmPassword){ //if passwrod & confirm password don't match
    $errorMessage = "Password does not match";
  }else{ //checking if email already exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $check_email_result = $connection->query($check_email);
    //checking if phone already exists
    $check_phone = "SELECT * FROM users WHERE phone = '$phone'";
    $check_phone_result = $connection->query($check_phone);

    if($check_email_result->num_rows > 0){
      $errorMessage = "Email already exists";
    }elseif($check_phone_result->num_rows > 0){
      $errorMessage = "Phone already exists";
    }else{ //save passwrod in hash format
      $passwordHash = password_hash($password, PASSWORD_DEFAULT);
      //inserting the data into database
      $register_email = "INSERT INTO users(firstname, lastname, email, phone, address, password, confirm_password) VALUES('$firstname', '$lastname', '$email', '$phone', '$address', '$passwordHash', '$passwordHash')";
      $register_email_result = $connection->query($register_email);
      if(!$register_email_result){
        $errorMessage = "Invalid query" . $connection->error;
      }else{ //displaying success message of account creation
        $successMessage = "Account created successfully";
        $firstname = $lastname = $email = $phone = $address = $password = $confirmPassword = ""; //after submitting fields should be empty
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    .error-message {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }

    .is-invalid {
      border-color: #dc3545 !important;
    }

    .form-control:focus {
      border-color: #148ba9;
      box-shadow: 0 0 0 0.25rem rgba(20, 139, 169, 0.25);
    }
  </style>
</head>

<body>

  <?php include 'navbar.php' ?>
<!-- Slide -->
  <div class="hero-slider">
    <div class="slide active" style="background-image: url('images/vaccine21.jpg')">
      <div class="slide-overlay">
        <div class="container slide-content align-items-center">
          <h1 class="slide-title">SIGN UP</h1>
          <h4 style="font-weight: bold; color: #148ba9;">Create your account using the below form</h4>
        </div>
      </div>
    </div>
  </div>

  <section class="signup-section py-5" style="background-color: #f8f9fa;">
    <!-- Signup Form -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="signup-container bg-white p-4 p-md-5 rounded shadow mt-4">
            <h2 class="text-center mb-4" style="color: #148ba9;">Create Your Account</h2>
            <p class="text-muted text-center mb-4"><small>* Fields are mandatory</small></p>
          <!-- displaying error/ success messages -->
            <?php if (!empty($errorMessage)): ?>
                        <div class='row mb-3'>
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong><?php echo $errorMessage; ?> </strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' area-label='Close'> </button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($successMessage)): ?>
                        <div class='row mb-3'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong><?php echo $successMessage; ?></strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' area-label='Close'> </button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- Sign UP Form -->
            <form action="signup.php" method="POST">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="firstname" class="form-label fw-bold">* First Name</label>
                  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="lastname" class="form-label fw-bold">* Last Name</label>
                  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-bold">* Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
              </div>

              <div class="row">
              <div class="col-md-6 mb-3">
                <label for="phone" class="form-label fw-bold">* Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="address" class="form-label fw-bold">* Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
              </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="password" class="form-label fw-bold">* Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Create password" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="confirmPassword" class="form-label fw-bold">* Confirm Password</label>
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required>
                  </div>
              </div>

              <div class="d-grid mb-3">
                <button type="submit" name="signup" class="btn btn-primary py-2 fw-bold" style="background-color: #148ba9; border: none; border-radius: 50px;">
                  Create Account
                </button>
              </div>

              <div class="text-center">
                <p class="mb-0">Already have an account?
                  <a href="login.php" style="color: #148ba9; font-weight: 500;">Login here</a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php include 'footer.php' ?>
</body>

</html>