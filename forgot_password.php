<?php
session_start(); //starting session
require_once 'includes/db_connection.php'; //including db connection file

$errorMessage = $successMessage = ''; //initialize the empty error/ success messages

if (isset($_POST['reset_request'])) { //if click on this function
    $email = $_POST['email'];
    
    $check_email = "SELECT * FROM users WHERE email = '$email'"; //auth email 
    $result = $connection->query($check_email);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['reset_email'] = $email; //this stores the email from input field
        $_SESSION['reset_verified'] = true; //this shows the email is verified
        
        $successMessage = "Email verified! Click below button to reset your password.";
        
    } else { //if email not exist then error message will show
        $errorMessage = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVBS</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="icons/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
   <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Reset Password</h4>
                    </div>
                    <div class="card-body">
                        <!-- displaying messages -->
                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert alert-danger"><?= $errorMessage ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($successMessage)): ?>
                            <div class="alert alert-success"><?= $successMessage ?>
                                <hr>
                                <a href="set_new_password.php" class="btn btn-success">Set New Password</a>
                            </div>
                        <?php else: ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Enter your email address</label>
                                    <input type="email" name="email" class="form-control" required>
                                    <div class="form-text">We'll verify your email.</div>
                                </div>
                                <button type="submit" name="reset_request" class="btn btn-primary py-2 fw-bold w-100" style="background-color: #148ba9; border: none; border-radius: 50px;">
                                    Verify Email
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <div class="text-center mt-3">
                            <a href="login.php" >Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="icons/bootstrap-icons.json"></script>

</body>

</html>