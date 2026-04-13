<?php
session_start();
require_once 'includes/db_connection.php';

// Check if user is verified
if (!isset($_SESSION['reset_verified']) || !$_SESSION['reset_verified']) { //the first one check that whether the session var exists or not & the second checks the value if its true or not
    header("Location: forgot_password.php");
    exit;
}
//initialize empty var's for error/ success messages
$errorMessage = $successMessage = '';
//if user click for set new password
if (isset($_POST['set_new_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_SESSION['reset_email'];
    //condition to check that password feilds are not empty
    if (empty($new_password) || empty($confirm_password)) {
        $errorMessage = "Please fill in all fields.";
    } elseif (strlen($new_password) < 8) { //passwor shouldn't be less than 8 chars
        $errorMessage = "Password must be at least 8 characters long.";
    } elseif ($new_password !== $confirm_password) { //show error if password & confirm password not match 
        $errorMessage = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); //save password in hash format
        
        $update_sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'"; //update password in db
        
        if ($connection->query($update_sql)) {
            $successMessage = "Password reset successfully!";
            
            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_verified']);
            
        } else {
            $errorMessage = "Error updating password: " . $connection->error;
        }
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
                        <h4 class="text-center">Set New Password</h4>
                    </div>
                    <!-- displaying error/ success messages -->
                    <div class="card-body">
                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert alert-danger"><?= $errorMessage ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($successMessage)): ?>
                            <div class="alert alert-success"><?= $successMessage ?>
                                <br>
                                <a href="login.php" class="btn btn-primary mt-2">Login Now</a>
                            </div>
                        <?php else: ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" 
                                           required minlength="8" placeholder="Enter new password (min 8 characters)">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control" 
                                           required minlength="8" placeholder="Confirm new password">
                                </div>
                                <button type="submit" name="set_new_password" class="btn btn-success w-100">
                                    Set New Password
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="icons/bootstrap-icons.json"></script>
</body>

</html>