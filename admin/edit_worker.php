<?php
session_start(); //starting session
require_once '../includes/db_connection.php'; //icluding db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
//declaring empty var's
$id = '';
$full_name = $email = $phone = $address = $gender = $available_time = $appointment_fee = $specialization = $status = '';
$errorMessage = $successMessage = '';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!isset($_GET["id"])){
        header("Location: manage_workers.php");
        exit;
    }
    $id = $_GET["id"];

//query to show workers data
    $sql = "SELECT * FROM workers WHERE id = $id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row){
        header("Location: manage_workers.php");
        exit;
    }
//displaying workers info
    $full_name = $row["full_name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];
    $gender = $row["gender"];
    $available_time = $row["available_time"];
    $appointment_fee = $row["appointment_fee"];
    $specialization = $row["specialization"];
    $status = $row["status"];
}else{ //submitting the updated worker's info
    $id = $_POST["id"];
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $gender = $_POST["gender"];
    $available_time = $_POST["available_time"];
    $appointment_fee = $_POST["appointment_fee"];
    $specialization = $_POST["specialization"];
    $status = $_POST["status"];

    do{ //appkying do while loop
        //required fields shouldn't be empty
        if(empty($full_name) || empty($email) || empty($phone) || empty($address) || empty($gender) || empty($available_time) || empty($appointment_fee) || empty($specialization) || empty($status)){
            $errorMessage = "All fields are required" . $connection->error;
            break;
        } //query to check worker's email or phone already exists
        $check_sql = "SELECT id FROM workers WHERE (email = '$email' OR phone = '$phone') AND id != $id";
        $check_result = $connection->query($check_sql);

        if($check_result->num_rows > 0){
            $errorMessage = "Email or phone already exists" . $connection->error;
            break;
        }
//query to update the worker's info
        $sql = "UPDATE workers SET full_name = '$full_name', email = '$email', phone = '$phone', address = '$address', gender = '$gender', available_time = '$available_time', appointment_fee = '$appointment_fee', specialization = '$specialization', status = '$status' WHERE id = $id";
        $result = $connection->query($sql);

        if(!$result){
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }
//success message
        $successMessage = "Worker updated successfully";
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
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            background: white;
        }
        .required:after {
            content: " *";
            color: red;
        }
        .sidebar {
            background: #148ba9;
            min-height: 100vh;
            color: white;
        }
        .main-content {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <!-- including sidebar of admin dashboard -->
            <?php include 'admin_sidebar.php'?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Worker</h1>
                    <a href="manage_workers.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Workers
                    </a>
                </div>
<!-- displaying error/ success messages -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?= $errorMessage ?></div>
                <?php elseif (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?= $successMessage ?></div>
                <?php endif; ?>

                <div class="form-container">
                    <!-- edit worker form -->
                <form method="POST">
                        <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($id) ?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Full Name</label>
                                <input type="text" class="form-control" name="full_name" 
                                       value="<?= htmlspecialchars($full_name) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Email</label>
                                <input type="email" class="form-control" name="email" 
                                       value="<?= htmlspecialchars($email) ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Phone</label>
                                <input type="tel" class="form-control" name="phone" 
                                       value="<?= htmlspecialchars($phone) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="Male" <?= $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= $gender == 'Female' ? 'selected' : '' ?>>Female</option>
                                    <option value="Other" <?= $gender == 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Address</label>
                            <textarea class="form-control" name="address" rows="2" required><?= htmlspecialchars($address) ?></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Available Time</label>
                                <input type="text" class="form-control" name="available_time" 
                                       value="<?= htmlspecialchars($available_time) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Appointment Fee (PKR)</label>
                                <input type="number" step="0.01" class="form-control" name="appointment_fee" 
                                       value="<?= htmlspecialchars($appointment_fee) ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Specialization</label>
                                <input type="text" class="form-control" name="specialization" 
                                       value="<?= htmlspecialchars($specialization) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Status</label>
                                <select class="form-select" name="status">
                                    <option value="Active" <?= $status == 'Active' ? 'selected' : '' ?>>Active</option>
                                    <option value="Inactive" <?= $status == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save"></i> Update Worker
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>