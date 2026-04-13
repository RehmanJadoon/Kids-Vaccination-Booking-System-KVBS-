<?php
require_once 'includes/db_connection.php'; //including db connection file

$childName = $parentName = $email = $phone = $city = $comments = '';
$errorMessage = $successMessage = ''; //initialize emtpy error/ success messages
if($_SERVER['REQUEST_METHOD'] === 'POST'){ //if the method of submitting is POST, then submit this data
  $childName = $_POST["child_name"] ?? '';
  $parentName = $_POST["parent_name"] ?? '';
  $email = $_POST["email"] ?? '';
  $phone = $_POST["phone"] ?? '';
  $city = $_POST["city"] ?? '';
  $comments = $_POST["comments"] ?? '';
//applying condition to check fields are not empty
  if(empty($childName) || empty($parentName) || empty($email) || empty($phone) || empty($city) || empty($comments)){
    $errorMessage = "All fields are required";
  } //submitting form details
    $form_submit = "INSERT INTO consult (child_name, parent_name, email, phone, city, comments) VALUES('$childName', '$parentName', '$email', '$phone', '$city', '$comments')";
    $submit_result = $connection->query($form_submit);
      if(!$submit_result){
        $errorMessage = "Invalid query" . $connection->error;
      } //displaying success message of form submission
        $successMessage = "Query submitted successfully, You'll be contacted soon.";
        $childName = $parentName = $email = $phone = $city = $comments = ""; //after submitting fields should be empty
}
?>

<!DOCTYPE html>
<html lang="en">
  <style>
    .error-message {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }

  </style>
</head>

<body>
<?php include 'navbar.php' ?>
    <!-- Hero Slider -->
    <div class="hero-slider">
        <!-- Slide 1 -->
        <div class="slide active" style="background-image: url('images/vaccine21.jpg')">
            <div class="slide-overlay">
                <div class="container slide-content align-items-center">
                    <h1 class="slide-title">CONSULT NOW</h1>
                    <h4 style="font-weight: bold; color: #148ba9;">IT'S FREE</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Consultation Form Section -->
    <section class="consultation-form py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-container bg-white p-4 p-md-5 rounded shadow">
                        <h2 class="form-title mb-4 text-center" style="color: #148ba9;">Consultation Form</h2>
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
                        <form method="POST">
                            <!-- Child Name -->
                            <div class="mb-3">
                                <label for="child_name" class="form-label fw-bold">* Child's Name</label>
                                <input type="text" name="child_name" class="form-control" id="childName" required>
                            </div>

                            <!-- Parent Name -->
                            <div class="mb-3">
                                <label for="parent_name" class="form-label fw-bold">* Parent Name</label>
                                <input type="text" name="parent_name" class="form-control" id="parentName" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">* Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold">* Phone Number</label>
                                <input type="tel" name="phone" class="form-control" id="phone" required>
                            </div>

                            <!-- City -->
                            <div class="mb-3">
                                <label for="city" class="form-label fw-bold">* City</label>
                                <input type="text" name="city" class="form-control" id="city" required>
                            </div>

                            <!-- Comments -->
                            <div class="mb-4">
                                <label for="comments" class="form-label fw-bold">* Comments</label>
                                <textarea name="comments" class="form-control" id="comments" rows="4"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold" style="background-color: #148ba9; border: none; border-radius: 50px;">
                                    <i class="bi bi-send-fill me-2"></i> Submit
                                </button>
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