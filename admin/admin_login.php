<?php
session_start(); //starting session
//if admin is valid then redirect to dashboard
if (isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_dashboard.php");
    exit;
}
require_once '../includes/db_connection.php'; //including db connection file

$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if(empty($username) || empty($password)){
        $errorMessage = "Enter valid credentials to login";
    }else{
        $check_email = "SELECT * FROM admins WHERE username = '$username'";
        $email_result = $connection->query($check_email);
        if($email_result->num_rows > 0){
            $admin = $email_result->fetch_assoc();

            if(password_verify($password, $admin['password'])){
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                header("Location: admin_dashboard.php");
                exit;
            }else{
                $errorMessage = "Password doesn't match";
            }
        }else{
            $errorMessage = "Username doesn't exist";
        }
    }
}
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVBS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/kidsvacc/css/bootstrap.css">
    <link rel="stylesheet" href="/kidsvacc/css/bootstrap.min.css">
    <link rel="stylesheet" href="/kidsvacc/css/style.css">
    <link rel="stylesheet" href="/kidsvacc/icons/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .admin-login-box {
            max-width: 400px;
            margin: 5% auto;
            padding: 20px;
            border: 2px solid #148ba9;
            border-radius: 10px;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="admin-login-box bg-white shadow">
            <h2 class="text-center mb-4" style="color: #148ba9;">Admin Portal</h2>
             <!-- displaying messages -->
                        <?php if (!empty($errorMessage)): ?>
                            <div class='row mb-3'>
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong><?php echo $errorMessage; ?> </strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' area-label='Close'> </button>
                                </div>
                            </div>
                        <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Admin Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn w-100" style="background-color: #148ba9; color: white;">Login</button>
            </form>
        </div>
    </div>
    
    <script src="/kidsvacc/js/bootstrap.bundle.min.js"></script>
    <script src="/kidsvacc/icons/bootstrap-icons.json"></script>


</body>
</html>