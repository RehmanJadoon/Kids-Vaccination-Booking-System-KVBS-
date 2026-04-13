<?php
session_start();
require_once '../includes/db_connection.php'; //including db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
//declaring empty var's
$disease = $vaccine_name = $brand = $age_range = $status = $description = '';
$errorMessage = $successMessage = '';
//if the request mehtod is POST then submit the data
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $disease = $_POST["disease"];
    $vaccine_name = $_POST["vaccine_name"];
    $brand = $_POST["brand"];
    $age_range = $_POST["age_range"];
    $status = $_POST["status"];
    $description = $_POST["description"];
//applying do while loop
    do{
        if(empty($disease) || empty($vaccine_name) || empty($brand) || empty($age_range) || empty($status)){ //if required fields are empty, it'll show error
            $errorMessage = "All fields are required" . $connection->error;
            break;
        }
//fetching vaccine info to check vaccine exists or not
        $check_sql = "SELECT id from vaccines WHERE vaccine_name = '$vaccine_name'";
        $check_result = $connection->query($check_sql);
        if($check_result->num_rows > 0){ //if vaccine already exists it will show error
            $errorMessage = "Vaccine already exists" . $connection->error;
            break;
        }
//submitting vaccine data
        $sql = "INSERT INTO vaccines (disease, vaccine_name, brand, age_range, status, description) VALUES('$disease', '$vaccine_name', '$brand', '$age_range', '$status', '$description')";
        $result = $connection->query($sql);

        if(!$result){
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        } //after submission form fields should be emtpy
        $disease = $vaccine_name = $brand = $age_range = $status = $description = '';
        $successMessage = "Vaccine added successfully"; //success message after submission
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
    </style>
</head>
<body>
  
    <div class="container-fluid">
        <div class="row">
            <!-- including sidebar of admin dashboard -->
            <?php include 'admin_sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Add New Vaccine</h1>
                    <a href="manage_vaccines.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Vaccines
                    </a>
                </div>
<!-- dispalying error/ success messages -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?= $errorMessage ?></div>
                <?php elseif (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?= $successMessage ?></div>
                <?php endif; ?>
<!-- add vaccine form -->
                <div class="form-container">
                    <form method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Disease</label>
                                <input type="text" class="form-control" name="disease" 
                                       value="<?= htmlspecialchars($_POST['disease'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Vaccine Name</label>
                                <input type="text" class="form-control" name="vaccine_name" 
                                       value="<?= htmlspecialchars($_POST['vaccine_name'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Brand</label>
                                <input type="text" class="form-control" name="brand" 
                                       value="<?= htmlspecialchars($_POST['brand'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Age Range</label>
                                <input type="text" class="form-control" name="age_range" 
                                       value="<?= htmlspecialchars($_POST['age_range'] ?? '') ?>" 
                                       placeholder="e.g., 0-6 months, 1-2 years" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="Available" selected>Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save"></i> Add Vaccine
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>