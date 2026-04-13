<?php
session_start();
require_once 'includes/db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; //storing the user's session in var
$id = $firstname = $lastname = $email = $phone = $address = ''; //initializing empty var's
$errorMessage = $successMessage = '';

if($_SERVER['REQUEST_METHOD'] == 'GET'){ //fetching the user's data using GET method
    $fetch_user = "SELECT * FROM users WHERE id = '$user_id'";
    $fetch_result = $connection->query($fetch_user);
    $user = $fetch_result->fetch_assoc();

if(!$user){
    header("Location: /kidsvacc/dashboard.php");
    exit;
} //displaying user's data
$firstname = $user["firstname"];
$lastname = $user["lastname"];
$email = $user["email"];
$phone = $user["phone"];
$address = $user["address"];
}else{ //after updating the data, now submittig the updated data
    $id = $_POST["id"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    do{ //do while loop applying
        if(empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($address)){ //if req fields are empty
            $errorMessage = "All fields are required" . $connection->error; //show error
            break;
        } //checking the user's email/ phone that already exists
        $check_user = "SELECT id from users WHERE (email = '$email' OR phone = '$phone') AND id != '$user_id'";
        $check_result = $connection->query($check_user);

        if($check_result->num_rows > 0){
            $errorMessage = 'Email or Phone already exists' . $connection->error;
            break;
        } //submitting the user's updated data
        $submit_sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', address = '$address' WHERE id = '$user_id'";
        $submit_result = $connection->query($submit_sql);

        if(!$submit_result){
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        } //success message of updating the user profile
        $successMessage = "Profile updated successfully";
    }while(false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .required:after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body>

    <div class="container-fluid mt-4">
        <div class="row">

            <?php include 'dashboard_sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Profile</h1>
                </div> 
                <!-- displaying success/ error messages -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?= $errorMessage ?></div>
                <?php elseif (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?= $successMessage ?></div>
                <?php endif; ?>
                <div class="form-container">
                    <!--display the user's data in form fields for editing, after update, by clicking update btn to update data in database   -->
                <form method="POST">
                        <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($user['id'])?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">First Name</label>
                                <input type="text" class="form-control" name="firstname"
                                    value="<?= htmlspecialchars($firstname) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Last Name</label>
                                <input type="text" class="form-control" name="lastname"
                                    value="<?= htmlspecialchars($lastname) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= htmlspecialchars($email) ?>" required>
                        </div>

                        <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Phone</label>
                            <input type="tel" class="form-control" name="phone"
                                value="<?= htmlspecialchars($phone) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Address</label>
                            <input type="text" class="form-control" name="address"
                                value="<?= htmlspecialchars($address) ?>" required>
                        </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Update Profile
                            </button> 
                            <!-- cancel the operation if not required -->
                            <a href="dashboard.php" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

</html>