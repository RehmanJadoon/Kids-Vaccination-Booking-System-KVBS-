<?php
session_set_cookie_params(0); //setting cookies if user wants to use Remember Me functionality
session_start();
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
} else {
    $email = "";
    $password = "";
}
//if user is valid then redirect to dashboard
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit;
}
//including db connection file
require_once 'includes/db_connection.php';
//initializing empty var's
$errorMessage = $successMessage = '';
if (isset($_POST["login"])) { //if click on login, submit email and password 
    $email = $_POST["email"];
    $password = $_POST["password"];
    //applying condition to check fields are not empty
    if (empty($email) || empty($password)) {
        $errorMessage = "Enter valid credentials to login";
    } else { //verify email
        $check_login_email = "SELECT * FROM users WHERE email = '$email'";
        $check_email_result = $connection->query($check_login_email);
        if ($check_email_result->num_rows > 0) {
            $user = $check_email_result->fetch_assoc();
            //verify password 
            if (password_verify($password, $user["password"])) {
                $_SESSION["user"] = "yes";
                $_SESSION["user_id"] = $user["id"];
                if (isset($_POST['rememberMe'])) { //setting cookie for Remember Me functionality
                    setcookie('email', $_POST['email'], time() + (60 * 60 * 24));
                    setcookie('password', $_POST['password'], time() + (60 * 60 * 24));
                }
                header("Location: dashboard.php");
                exit;
            } else {
                $errorMessage = "Password does not match";
            }
        } else {
            $errorMessage = "Email does not exist";
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

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php' ?>
    <div class="hero-slider">
        <!-- Slide -->
        <div class="slide active" style="background-image: url('images/vaccine22.jpg')">
            <div class="slide-overlay">
                <div class="container slide-content align-items-center">
                    <h1 class="slide-title">LOGIN</h1>
                    <h4 style="font-weight: bold; color: #148ba9;">Login below to get your child vaccinated </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Form Section -->
    <section class="login-section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-container bg-white p-4 p-md-5 rounded shadow">
                        <!-- Login Header -->
                        <div class="text-center mb-4">
                            <h2 style="color: #148ba9;">Login to Book Visit</h2>
                            <p class="text-muted">Enter your valid credentials to continue</p>
                        </div>
                        <!-- displaying messages -->
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

                        <!-- Login Form -->
                        <form method="POST">
                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">* Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter registered email"
                                    value="<?php echo htmlspecialchars($email); ?>">
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">* Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
                                    value="<?php echo htmlspecialchars($password); ?>">
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <a href="forgot_password.php" style="color: #148ba9;">Forgot password?</a>
                            </div>
                            <!-- Login Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" name="login" class="btn btn-primary py-2 fw-bold" style="background-color: #148ba9; border: none; border-radius: 50px;">
                                    Login
                                </button>
                            </div>

                            <!-- Signup Link -->
                            <div class="text-center">
                                <p class="mb-0">Don't have an account?
                                    <a href="signup.php" style="color: #148ba9; font-weight: 500;">Signup here</a>
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